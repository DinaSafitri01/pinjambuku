<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PINAKU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        :root {
            --sidebar-width: 280px;
            --primary-color: #0e9a7e;
            --primary-dark: #076d59;
            --bg-light: #f8fafc;
            --sidebar-bg: #1f5f59;
        }

        body, h1, h2, h3, h4, h5, h6, p, label, .form-control {
            color: #1B5E58;
        }

        body {
            font-family: 'Josefin Sans', sans-serif;
            background-color: var(--bg-light);
            overflow-x: hidden;
        }

        /* SIDEBAR */
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: var(--sidebar-bg);
            color: white;
            transition: all 0.3s;
            z-index: 1000;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding-bottom: 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 2rem;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.7);
            padding: 0.8rem 1.2rem;
            border-radius: 12px;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }

        .nav-link.active {
            background: var(--primary-color);
            box-shadow: 0 4px 15px rgba(14, 154, 126, 0.3);
        }

        .nav-link i {
            font-size: 1.2rem;
        }

        /* MAIN CONTENT */
        #main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
            transition: all 0.3s;
        }

        .top-navbar {
            background: white;
            padding: 1rem 2rem;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
            color: #1B5E58;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-weight: bold;
        }

        .no-caret::after {
            display: none;
        }

        .hover-primary:hover {
            color: var(--primary-color) !important;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        @media (max-width: 991.98px) {
            #sidebar {
                left: calc(-1 * var(--sidebar-width));
            }
            #sidebar.active {
                left: 0;
            }
            #main-content {
                margin-left: 0;
            }
        }

    </style>
</head>
<body>

    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h4 class="fw-bold mb-0">PINAKU</h4>
            
        </div>

        <div class="nav flex-column flex-grow-1">
            <a href="{{ Request::is('admin/*') ? route('admin.dashboard') : route('siswa.dashboard') }}" class="nav-link {{ Request::is('*/dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i>
                Dashboard
            </a>

            @if(Request::is('admin/*'))
                <a href="{{ route('admin.buku.index') }}" class="nav-link {{ Request::is('admin/buku*') ? 'active' : '' }}">
                    <i class="bi bi-book-half"></i>
                    Data Buku
                </a>
                <a href="{{ route('admin.transaksi.index') }}" class="nav-link {{ Request::is('admin/transaksi*') ? 'active' : '' }}">
                    <i class="bi bi-arrow-left-right"></i>
                    Transaksi
                </a>
                <a href="{{ route('admin.anggota.index') }}" class="nav-link {{ Request::is('admin/anggota*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    Data Anggota
                </a>
            @else
                <a href="{{ route('siswa.pinjam.index') }}" class="nav-link {{ Request::is('siswa/pinjam*') ? 'active' : '' }}">
                    <i class="bi bi-journal-plus"></i>
                    Pinjam Buku
                </a>
                <a href="{{ route('siswa.riwayat') }}" class="nav-link {{ Request::is('siswa/riwayat*') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i>
                    Riwayat
                </a>
            @endif

            <div class="mt-auto">
                <form action="{{ route('logout') }}" method="POST" id="logout-form" class="d-none">
                    @csrf
                </form>
                <a href="#" class="nav-link text-danger mt-4" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-left"></i>
                    Keluar
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div id="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <button class="btn d-lg-none" onclick="document.getElementById('sidebar').classList.toggle('active')">
                <i class="bi bi-list"></i>
            </button>
            <div class="ms-auto d-flex align-items-center gap-4">
                <!-- Notification Bell -->
                <div class="dropdown">
                    <a href="#" class="position-relative text-decoration-none dropdown-toggle no-caret" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell fs-5 text-muted hover-primary"></i>
                        @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
                        @if($unreadCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 p-0" style="width: 320px; border-radius: 15px; overflow: hidden;">
                        <li class="px-3 py-3 border-bottom d-flex justify-content-between align-items-center bg-light">
                            <h6 class="mb-0 fw-bold">Notifikasi</h6>
                            @if($unreadCount > 0)
                                <form action="{{ route('notifications.markAsRead') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm p-0 text-primary small" style="font-size: 11px;">Tandai dibaca</button>
                                </form>
                            @endif
                        </li>
                        <div style="max-height: 350px; overflow-y: auto;">
                            @forelse(auth()->user()->notifications->take(10) as $notification)
                                <li>
                                    <a class="dropdown-item px-3 py-3 border-bottom d-flex gap-3 {{ $notification->unread() ? 'bg-light' : '' }}" href="{{ $notification->data['url'] ?? '#' }}">
                                        <div class="flex-shrink-0">
                                            <div class="avatar bg-opacity-10 {{ $notification->unread() ? 'bg-primary text-primary' : 'bg-secondary text-secondary' }}" style="width: 35px; height: 35px; font-size: 0.9rem;">
                                                <i class="bi {{ $notification->data['icon'] ?? 'bi-bell' }}"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 min-w-0">
                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                <span class="fw-bold small text-dark text-truncate">{{ $notification->data['title'] }}</span>
                                                <span class="text-muted" style="font-size: 10px;">{{ $notification->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="mb-0 small text-muted text-wrap line-clamp-2" style="font-size: 11px; line-height: 1.4;">
                                                {{ $notification->data['message'] }}
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li class="px-3 py-5 text-center" style="color: #1B5E58;">
                                    <i class="bi bi-bell-slash fs-2 d-block mb-2 opacity-25"></i>
                                    <span class="small">Tidak ada notifikasi</span>
                                </li>
                            @endforelse
                        </div>
                        @if(auth()->user()->notifications->count() > 0)
                            <li class="bg-light">
                                <a class="dropdown-item text-center py-2 small text-muted" href="#">Lihat Semua</a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="user-profile">
                    <div class="text-end d-none d-sm-block">
                        <p class="mb-0 fw-bold small text-truncate" style="max-width: 150px;">{{ Auth::user()->name ?? (Request::is('admin/*') ? 'Administrator' : 'Siswa') }}</p>
                        <small class="text-muted" style="font-size: 10px;">{{ Auth::user()->role == 'admin' ? 'Admin' : 'Siswa' }}</small>
                    </div>
                    <div class="avatar">
                        {{ strtoupper(substr(Auth::user()->name ?? (Request::is('admin/*') ? 'A' : 'S'), 0, 1)) }}
                    </div>
                </div>
            </div>
        </div>

        <!-- View Content -->
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('modals')
    @yield('scripts')
</body>
</html>
