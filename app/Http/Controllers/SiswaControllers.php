<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use App\Notifications\NotifikasiPinjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class SiswaControllers extends Controller
{
    // --- DASHBOARD ---
    public function index()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login.siswa');

        $recentActivities = Peminjaman::with('buku')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $currentLoansCount = Peminjaman::where('user_id', $user->id)
            ->where('status', 'dipinjam')
            ->count();

        return view('siswa.dashboard', compact('recentActivities', 'currentLoansCount'));
    }

    // --- PEMINJAMAN ---
    public function pinjamIndex(Request $request)
    {
        $query = Buku::query();

        if ($request->has('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('penulis', 'like', '%' . $request->search . '%');
        }

        $buku = $query->latest()->get();
        return view('siswa.pinjam.index', compact('buku'));
    }

    public function pinjamStore(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',

        ]);

        $user = Auth::user();
        $buku = Buku::findOrFail($request->buku_id);

        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku ini sudah habis.');
        }

        $existingLoan = Peminjaman::where('user_id', $user->id)
            ->where('buku_id', $buku->id)
            ->where('status', 'dipinjam')
            ->first();

        if ($existingLoan) {
            return back()->with('error', 'Anda masih meminjam buku ini. Silakan kembalikan terlebih dahulu.');
        }

        $buku->decrement('stok');

        Peminjaman::create([
            'user_id' => $user->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => now(),
            'tanggal_jatuh_tempo' => now()->addDays(10),
            'status' => 'dipinjam',
        ]);

        // Kirim notifikasi ke Admin
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NotifikasiPinjam([
            'title' => 'Peminjaman Baru',
            'message' => $user->name . ' telah meminjam buku "' . $buku->judul . '".',
            'url' => route('admin.transaksi.index'),
            'icon' => 'bi-journal-plus'
        ]));

        return redirect()->route('siswa.riwayat')->with('success', 'Buku berhasil dipinjam!');
    }

    // --- RIWAYAT & PENGEMBALIAN ---
    public function riwayat()
    {
        $history = Peminjaman::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('siswa.riwayat.index', compact('history'));
    }

    public function kembalikanBuku(Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id !== Auth::id()) abort(403);

        if (in_array($peminjaman->status, ['dikembalikan', 'menunggu_konfirmasi'])) {
            return back()->with('error', 'Buku ini sudah dikembalikan atau sedang menunggu konfirmasi.');
        }

        $peminjaman->update([
            'status' => 'menunggu_konfirmasi',
            'tanggal_kembali' => now()->addDays(10),
        ]);
    }
}
