<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content') ?>

<style>
.dashboard-container {
    background: white;
    border-radius: 15px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    margin: 2rem auto;
    max-width: 800px;
}
.header-section {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    color: white;
    padding: 2rem;
    border-radius: 15px 15px 0 0;
}
.role-badge {
    font-size: 0.9rem;
}
.logo-dashboard {
    width: 50px;
    height: 50px;
    object-fit: contain;
    margin-right: 15px;
}
</style>

<?php if (session()->get('success')): ?>
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
        <div class="toast show align-items-center text-white bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session()->get('success') ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    <?php session()->remove('success'); ?>
<?php endif; ?>

<?php if (session()->get('error')): ?>
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
        <div class="toast show align-items-center text-white bg-danger border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= session()->get('error') ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    <?php session()->remove('error'); ?>
<?php endif; ?>

<div class="dashboard-container">
    <div class="header-section">
        <h2 class="mb-3">Dashboard</h2>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1"><?= $user['nama_lengkap'] ?? $user['username'] ?></h4>
                <p class="mb-0 opacity-75">@<?= $user['username'] ?></p>
            </div>
            <div>
                <span class="badge bg-light text-dark role-badge"><?= ucfirst($user['role']) ?></span>
            </div>
        </div>
    </div>
    
    <div class="p-4">
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">User ID</h5>
                        <p class="card-text display-6"><?= session()->get('id_user') ?? 'Tidak ada' ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Role</h5>
                        <p class="card-text display-6"><?= session()->get('role') ?? 'Tidak ada' ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Status</h5>
                        <p class="card-text display-6"><?= session()->get('isLoggedIn') ? '🟢 Online' : '🔴 Offline' ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <h5>Selamat datang di Dashboard!</h5>
            <p class="text-muted">Anda login sebagai <strong><?= ucfirst(session()->get('role')) ?></strong> dengan username <strong><?= session()->get('username') ?></strong>.</p>
            
            <?php if (session()->get('role') === 'petugas'): ?>
                <p class="text-muted">Anda dapat mengakses menu Transaksi Parkir dan Cetak Struk Parkir.</p>
            <?php elseif (in_array(session()->get('role'), ['admin', 'superadmin'])): ?>
                <p class="text-muted">Anda dapat mengakses semua menu CRUD dan Log Aktivitas.</p>
            <?php elseif (session()->get('role') === 'owner'): ?>
                <p class="text-muted">Anda dapat melihat Rekap Transaksi dan Statistik Pendapatan.</p>
            <?php endif; ?>
            
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5>Menu Tersedia</h5>
                            <p class="card-text">Berdasarkan role Anda:</p>
                            <span class="badge bg-primary"><?= ucfirst(session()->get('role')) ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5>Aktivitas Terakhir</h5>
                            <p class="card-text">Menampilkan log aktivitas terakhir</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <?php if ($user['role'] === 'petugas'): ?>
                <div class="alert alert-info">
                    <strong>Fitur Petugas:</strong> Manajemen parkir, input data kendaraan, dll.
                </div>
            <?php elseif ($user['role'] === 'admin'): ?>
                <div class="alert alert-success">
                    <strong>Fitur Admin:</strong> Manajemen user, laporan, konfigurasi sistem.
                </div>
            <?php elseif ($user['role'] === 'owner'): ?>
                <div class="alert alert-warning">
                    <strong>Fitur Owner:</strong> Akses penuh, laporan keuangan, manajemen bisnis.
                </div>
            <?php elseif ($user['role'] === 'superadmin'): ?>
                <div class="alert alert-danger">
                    <strong>Fitur Super Admin:</strong> Kontrol penuh sistem, pengaturan global.
                </div>
            <?php endif; ?>
        </div>
        
        <div class="mt-4">
            <a href="/" class="btn btn-secondary me-2">Kembali ke Home</a>
            <a href="/auth/logout" class="btn btn-danger">Logout</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
