<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kasir Santuy')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons"></script>
    <!-- Custom CSS -->
    <style>
        /* Sidebar styles */
        #sidebarMenu {
            height: 100vh;
            width: 250px;
            background-color: rgb(27, 43, 58);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            text-align: center;
            padding: 15px;
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff;
            border-bottom: 1px solid #34495e;
        }

        .sidebar-header i {
            margin-right: 10px;
        }

        .nav-item {
            margin-bottom: 10px;
        }

        .nav-link {
            color: #ecf0f1;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: #2980b9;
            color: white;
        }

        .nav-box {
            display: flex;
            align-items: center;
        }

        .nav-box i {
            font-size: 20px;
            margin-right: 15px;
        }

        .nav-text {
            font-size: 1.1rem;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            padding: 10px;
        }

        .btn-light {
            background-color: #34495e;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-light:hover {
            background-color: #16a085;
        }

        /* Main content styles */
        main {
            margin-left: 250px;
            padding: 20px;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            #sidebarMenu {
                width: 200px;
            }
            main {
                margin-left: 200px;
            }
        }

        @media (max-width: 576px) {
            #sidebarMenu {
                width: 100%;
                position: relative;
            }
            main {
                margin-left: 0;
            }
        }

        .navbar-soft {
            background-color: #f0f8ff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .navbar-soft .navbar-brand,
        .navbar-soft .nav-link {
            color: #001f3f;
        }

        .navbar-soft .nav-link:hover {
            color: #004080;
        }

        .dropdown-menu {
            background-color: #f0f8ff;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #e0efff;
            color: #001f3f;
        }
    </style>
</head>
<body>
    <div id="content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-soft">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto">
                        <!-- Dropdown Menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->nama }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person"></i> Profile
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="sidebar">
            <div class="sidebar-header">
                <h4><i data-feather="shopping-cart"></i> Kasir Santuy</h4>
            </div>
            <ul class="nav flex-column mt-4">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <div class="nav-box">
                            <i data-feather="home"></i>
                            <span class="nav-text">Dashboard</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                        <div class="nav-box">
                            <i data-feather="user"></i>
                            <span class="nav-text">Profil</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('toko.edit') ? 'active' : '' }}" href="{{ route('toko.edit') }}">
                        <div class="nav-box">
                            <i data-feather="globe"></i> 
                            <span class="nav-text">Toko</span>
                        </div>
                    </a>
                </li>
                <!-- Kelola Produk (Dropdown) -->
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center justify-content-between" data-bs-toggle="collapse" href="#kelolaProdukMenu" role="button" aria-expanded="false" aria-controls="kelolaProdukMenu" data-bs-auto-close="outside">
                        <div class="nav-box">
                            <i data-feather="package"></i>
                            <span class="nav-text">Kelola Produk</span>
                        </div>
                        <i data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="kelolaProdukMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('produk.index') ? 'active' : '' }}" href="{{ route('produk.index') }}">
                                    <div class="nav-box">
                                        <i data-feather="box"></i>
                                        <span class="nav-text">Produk</span>
                                    </div>
                                </a>
                            </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kategori.index') ? 'active' : '' }}" href="{{ route('kategori.index') }}">
                            <div class="nav-box">
                                <i data-feather="grid"></i>
                                <span class="nav-text">Kategori</span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('stok.index') ? 'active' : '' }}" href="{{ route('stok.index') }}">
                            <div class="nav-box">
                                <i data-feather="layers"></i>
                                <span class="nav-text">Manajemen Stok</span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('diskon.index') ? 'active' : '' }}" href="{{ route('diskon.index') }}">
                            <div class="nav-box">
                                <i data-feather="percent"></i>
                                <span class="nav-text">Diskon</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('staff.index') ? 'active' : '' }}" href="{{ route('staff.index') }}">
                <div class="nav-box">
                    <i data-feather="users"></i>
                    <span class="nav-text">Data Staff</span>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('transaksi.index') ? 'active' : '' }}" href="{{ route('transaksi.index') }}">
                <div class="nav-box">
                    <i data-feather="file-text"></i>
                    <span class="nav-text">Transaksi</span>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('laporan-transaksi.index') ? 'active' : '' }}" href="{{ route('laporan-transaksi.index') }}">
                <div class="nav-box">
                    <i data-feather="bar-chart-2"></i>
                    <span class="nav-text">Laporan Transaksi</span>
                </div>
            </a>
        </li>
            </ul>
            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-light">
                        <i data-feather="log-out"></i> Logout
                    </button>
                </form>
            </div>
        </nav>
        
        <!-- Main Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Feather Icons -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        feather.replace();
    </script>
</body>
</html>
