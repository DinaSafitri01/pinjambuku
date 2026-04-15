<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }
}

//admin controller//
<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

//auth controller//
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function landing()
    {
        return view('landing');
    }

    public function welcome()
    {
        return view('auth.welcome');
    }

    public function loginSiswa()
    {
        return view('auth.login-siswa');
    }

    public function loginAdmin()
    {
        return view('auth.login-admin');
    }

    public function registerSiswa()
    {
        return view('auth.register-siswa');
    }

    public function registerAdmin()
    {
        return view('auth.register-admin');
    }

    public function storeSiswa(Request $request)
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

        return redirect()->route('login.siswa')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('login.admin')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function authSiswa(Request $request)
    {
        $credentials = $request->validate([
            'nis' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['nis' => $credentials['nis'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended(route('siswa.dashboard'));
        }

        return back()->withErrors(['nis' => 'NIS atau password salah.'])->withInput();
    }

    public function authAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['email' => 'Kredensial tidak cocok.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('welcome');
    }
}

//siswa controller//
<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use App\Notifications\NotifikasiPinjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class SiswaController extends Controller
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
            'tanggal_jatuh_tempo' => now()->addDays(7),
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
            'tanggal_kembali' => now(),
        ]);

        // Kirim notifikasi ke Admin
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NotifikasiPinjam([
            'title' => 'Permintaan Pengembalian',
            'message' => Auth::user()->name . ' meminta konfirmasi pengembalian buku "' . $peminjaman->buku->judul . '".',
            'url' => route('admin.transaksi.index'),
            'icon' => 'bi-clock-history'
        ]));

        return back()->with('success', 'Permintaan pengembalian berhasil dikirim!');
    }

    // --- NOTIFIKASI ---
    public function markAsRead()
    {
        $user = Auth::user();
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }
        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }
}

//rute//
<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// --- GUEST / SHARED ROUTES ---
Route::controller(AuthController::class)->group(function() {
    Route::get('/', 'landing')->name('landing');
    Route::get('/select-role', 'welcome')->name('welcome');
    Route::post('/logout', 'logout')->name('logout');

    // Auth Siswa
    Route::get('/login/siswa', 'loginSiswa')->name('login.siswa');
    Route::post('/login/siswa', 'authSiswa')->name('login.siswa.auth');
    Route::get('/register/siswa', 'registerSiswa')->name('register.siswa');
    Route::post('/register/siswa', 'storeSiswa')->name('register.siswa.store');

    // Auth Admin
    Route::get('/login/admin', 'loginAdmin')->name('login.admin');
    Route::post('/login/admin', 'authAdmin')->name('login.admin.auth');
    Route::get('/register/admin', 'registerAdmin')->name('register.admin');
    Route::post('/register/admin', 'storeAdmin')->name('register.admin.store');
});

Route::get('/login', function() {
    return redirect()->route('welcome');
})->name('login');

// --- SISWA ROUTES ---
Route::group(['prefix' => 'siswa', 'as' => 'siswa.', 'middleware' => 'auth'], function() {
    Route::controller(SiswaController::class)->group(function() {
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/pinjam', 'pinjamIndex')->name('pinjam.index');
        Route::post('/pinjam', 'pinjamStore')->name('pinjam.store');
        Route::get('/riwayat', 'riwayat')->name('riwayat');
        Route::post('/kembali/{peminjaman}', 'kembalikanBuku')->name('kembali');
    });
});

Route::post('/notifications/mark-as-read', [SiswaController::class, 'markAsRead'])->middleware('auth')->name('notifications.markAsRead');

// --- ADMIN ROUTES ---
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function() {
    Route::controller(AdminController::class)->group(function() {
        Route::get('/dashboard', 'index')->name('dashboard');

        // Manajemen Anggota
        Route::get('/anggota', 'anggotaIndex')->name('anggota.index');
        Route::get('/anggota/create', 'anggotaCreate')->name('anggota.create');
        Route::post('/anggota', 'anggotaStore')->name('anggota.store');
        Route::get('/anggota/{anggota}/edit', 'anggotaEdit')->name('anggota.edit');
        Route::put('/anggota/{anggota}', 'anggotaUpdate')->name('anggota.update');
        Route::delete('/anggota/{anggota}', 'anggotaDestroy')->name('anggota.destroy');

        // Manajemen Buku
        Route::get('/buku', 'bukuIndex')->name('buku.index');
        Route::get('/buku/create', 'bukuCreate')->name('buku.create');
        Route::post('/buku', 'bukuStore')->name('buku.store');
        Route::get('/buku/{buku}/edit', 'bukuEdit')->name('buku.edit');
        Route::put('/buku/{buku}', 'bukuUpdate')->name('buku.update');
        Route::delete('/buku/{buku}', 'bukuDestroy')->name('buku.destroy');

        // Transaksi
        Route::get('/transaksi', 'transaksiIndex')->name('transaksi.index');
        Route::post('/konfirmasi-kembali/{peminjaman}', 'transaksiConfirm')->name('konfirmasi-kembali');
    });
});

//notiication ada di dalam app di bawah models//
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifikasiPinjam extends Notification
{
    use Queueable;

    protected $notifData;

    /**
     * Create a new notification instance.
     */
    public function __construct($notifData)
    {
        $this->notifData = $notifData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->notifData['title'],
            'message' => $this->notifData['message'],
            'url' => $this->notifData['url'] ?? '#',
            'icon' => $this->notifData['icon'] ?? 'bi-info-circle',
        ];
    }
}

