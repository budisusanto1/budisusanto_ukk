<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle . ' - ' : '' ?>Sistem Parkir BCS Mall</title>
    
    <!-- Favicon BCS Mall -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico?v=' . time()) ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('favicon.ico?v=' . time()) ?>">
    <link rel="icon" type="image/png" href="<?= base_url('logo-bcs.png?v=' . time()) ?>">
    <link rel="apple-touch-icon" href="<?= base_url('logo-bcs.png?v=' . time()) ?>">
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome untuk icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- reCAPTCHA dengan bahasa Indonesia -->
    <script src="https://www.google.com/recaptcha/api.js?hl=id&onload=recaptchaOnloadCallback" async defer></script>
    
    <style>
        :root {
            --aurora-blue: #00c6ff;
            --aurora-purple: #7b2ff7;
            --aurora-green: #00f5a0;
        }
        
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple), var(--aurora-green));
            background-size: 400% 400%;
            animation: aurora 12s ease infinite;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        @keyframes aurora {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .aurora-header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            margin: 0 10px;
            transition: all 0.3s ease;
            border-radius: 25px;
            padding: 8px 16px !important;
        }
        
        .navbar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white !important;
            transform: translateY(-2px);
        }
        
        .navbar-nav .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white !important;
        }
        
        .user-dropdown {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 8px 16px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .user-dropdown:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        
        .dropdown-menu {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            z-index: 9999 !important;
            position: absolute !important;
        }
        
        .dropdown-menu.show {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
        }
        
        .dropdown-menu:not(.show) {
            display: none !important;
            opacity: 0 !important;
            visibility: hidden !important;
        }
        
        .aurora-header {
            position: relative;
            z-index: 1050;
        }
        
        .dropdown-item {
            color: #333;
            transition: all 0.3s ease;
        }
        
        .dropdown-item:hover {
            background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
            color: white;
        }
        
        .logo-bcs {
            height: 40px;
            margin-right: 10px;
            object-fit: contain;
        }
        
        @media (max-width: 768px) {
            .navbar-nav .nav-link {
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>

<!-- Header dengan Navbar -->
<header class="aurora-header">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?= site_url('/') ?>">
                <img src="<?= base_url('logo-bcs.png') ?>" alt="Logo BCS Mall" class="logo-bcs">
                <span>BCS Mall Parkir</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= (current_url() === site_url('/')) ? 'active' : '' ?>" href="<?= site_url('/') ?>">
                            <i class="fas fa-home me-2"></i>Home
                        </a>
                    </li>
                    
                    <?php if (session()->get('isLoggedIn')): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= (strpos(current_url(), 'dashboard') !== false) ? 'active' : '' ?>" href="<?= site_url('/dashboard') ?>">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        
                        <!-- Menu untuk Petugas -->
                        <?php 
                        $currentRole = session()->get('role');
                        $isLoggedIn = session()->get('isLoggedIn');
                        
                        // Debug: Tampilkan info role (hapus di production)
                        echo "<!-- Debug: Role = " . ($currentRole ?? 'null') . ", LoggedIn = " . ($isLoggedIn ? 'true' : 'false') . " -->";
                        
                        // Debug: Tampilkan menu untuk testing
                        if ($isLoggedIn) {
                            echo "<!-- User is logged in with role: " . $currentRole . " -->";
                        }
                        ?>
                        
                        <?php if ($isLoggedIn && $currentRole === 'petugas'): ?>
                            <!-- Menu Dropdown untuk Petugas -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-car me-2"></i>Parkir
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('/transaksi') ?>">
                                            <i class="fas fa-plus-circle me-2"></i>Transaksi Masuk
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('/transaksi/keluar') ?>">
                                            <i class="fas fa-minus-circle me-2"></i>Transaksi Keluar
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('/cetak-struk') ?>">
                                            <i class="fas fa-print me-2"></i>Daftar Struk
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        
                        <!-- Menu untuk Admin & Superadmin -->
                        <?php if (in_array($currentRole, ['admin', 'superadmin'])): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-cogs me-2"></i>Manajemen
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('/users') ?>">
                                            <i class="fas fa-users me-2"></i>CRUD User
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('/kendaraan') ?>">
                                            <i class="fas fa-car me-2"></i>CRUD Kendaraan
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('/tarif') ?>">
                                            <i class="fas fa-tags me-2"></i>CRUD Tarif Parkir
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('/area') ?>">
                                            <i class="fas fa-map-marked-alt me-2"></i>CRUD Area Parkir
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('/log-aktivitas') ?>">
                                            <i class="fas fa-history me-2"></i>Akses Log Aktivitas
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        
                        <!-- Menu Laporan untuk Admin & Superadmin -->
                        <?php if (in_array($currentRole, ['admin', 'superadmin'])): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-chart-line me-2"></i>Laporan
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('/rekap-transaksi') ?>">
                                            <i class="fas fa-calendar-alt me-2"></i>Rekap Transaksi
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('/laporan/pendapatan') ?>">
                                            <i class="fas fa-money-bill-wave me-2"></i>Laporan Pendapatan
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('/laporan/statistik') ?>">
                                            <i class="fas fa-chart-bar me-2"></i>Statistik Parkir
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        

                        <!-- Menu untuk Owner -->
                        <?php if (session()->get('role') === 'owner'): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-chart-line me-2"></i>Laporan
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('/rekap-transaksi') ?>">
                                            <i class="fas fa-calendar-alt me-2"></i>Rekap Transaksi
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('/laporan/pendapatan') ?>">
                                            <i class="fas fa-money-bill-wave me-2"></i>Laporan Pendapatan
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('/laporan/statistik') ?>">
                                            <i class="fas fa-chart-bar me-2"></i>Statistik Parkir
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        
                        <!-- Menu untuk Superadmin (khusus) -->
                        <?php if (session()->get('role') === 'superadmin'): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-shield-alt me-2"></i>Superadmin
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('/system-settings') ?>">
                                            <i class="fas fa-server me-2"></i>Pengaturan Sistem
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('/backup') ?>">
                                            <i class="fas fa-database me-2"></i>Backup Database
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('/logs') ?>">
                                            <i class="fas fa-file-alt me-2"></i>Log Sistem
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link user-dropdown dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-2"></i>
                                <?= session()->get('nama_lengkap') ?? session()->get('username') ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('/profile') ?>">
                                        <i class="fas fa-user-circle me-2"></i>Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('/settings') ?>">
                                        <i class="fas fa-cog me-2"></i>Pengaturan
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="<?= site_url('/auth/logout') ?>">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('/auth/login') ?>">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('/auth/register') ?>">
                                <i class="fas fa-user-plus me-2"></i>Register
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- Main Content -->
<main class="flex-grow-1">
