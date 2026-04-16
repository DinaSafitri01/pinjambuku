<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // --- DASHBOARD ---
    public function index()
    {
        $totalBuku = Buku::count();
        $transaksiHariIni = Peminjaman::whereDate('tanggal_pinjam', today())->count();
        $totalAnggota = User::where('role', 'siswa')->count();
        $pendingConfirmation = Peminjaman::where('status', 'menunggu_konfirmasi')->count();

        return view('admin.dashboard', compact('totalBuku', 'transaksiHariIni', 'totalAnggota', 'pendingConfirmation'));
    }

    // --- MANAJEMEN ANGGOTA (SISWA) ---
    public function anggotaIndex()
    {
        $anggota = User::where('role', 'siswa')->orderBy('nis', 'asc')->get();
        return view('admin.anggota.index', compact('anggota'));
    }

    public function anggotaCreate()
    {
        return view('admin.anggota.create');
    }

    public function anggotaStore(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:users,nis',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ], [
            'nis.unique' => 'NIS sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
        ]);

        User::create([
            'nis' => $request->nis,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'role' => 'siswa',
        ]);

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota (Siswa) berhasil ditambahkan!');
    }

    public function anggotaEdit(User $anggota)
    {
        if ($anggota->role !== 'siswa') abort(403);
        return view('admin.anggota.edit', compact('anggota'));
    }

    public function anggotaUpdate(Request $request, User $anggota)
    {
        if ($anggota->role !== 'siswa') abort(403);

        $request->validate([
            'nis' => 'required|unique:users,nis,' . $anggota->id,
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $anggota->id,
        ]);

        $data = [
            'nis' => $request->nis,
            'name' => $request->name,
            'email' => $request->email,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $data['password'] = Hash::make($request->password);
        }

        $anggota->update($data);
        return redirect()->route('admin.anggota.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function anggotaDestroy(User $anggota)
    {
        if ($anggota->role !== 'siswa') abort(403);
        $anggota->delete();
        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil dihapus!');
    }

    // --- MANAJEMEN BUKU ---
    public function bukuIndex()
    {
        $buku = Buku::latest()->get();
        return view('admin.buku.index', compact('buku'));
    }

    public function bukuCreate()
    {
        return view('admin.buku.create');
    }

    public function bukuStore(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|numeric',
            'stok' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('books', $filename, 'public');
            $data['foto'] = $filename;
        }

        Buku::create($data);
        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function bukuEdit(Buku $buku)
    {
        return view('admin.buku.edit', compact('buku'));
    }

    public function bukuUpdate(Request $request, Buku $buku)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|numeric',
            'stok' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('foto')) {
            if ($buku->foto) Storage::disk('public')->delete('books/' . $buku->foto);
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('books', $filename, 'public');
            $data['foto'] = $filename;
        }

        $buku->update($data);
        return redirect()->route('admin.buku.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    public function bukuDestroy(Buku $buku)
    {
        if ($buku->foto) Storage::disk('public')->delete('books/' . $buku->foto);
        $buku->delete();
        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus!');
    }

    // --- MANAJEMEN TRANSAKSI ---
    public function transaksiIndex()
    {
        $loans = Peminjaman::with(['user', 'buku'])->latest()->get();
        return view('admin.transaksi.index', compact('loans'));
    }

    public function transaksiConfirm(Peminjaman $peminjaman)
    {
        if ($peminjaman->status === 'dikembalikan') {
            return back()->with('error', 'Buku ini sudah diverifikasi.');
        }

        $peminjaman->update(['status' => 'dikembalikan']);
        $peminjaman->buku->increment('stok');

        return back()->with('success', 'Pengembalian buku berhasil dikonfirmasi!');
    }
}
