<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #17a2b8, #ffc107);">
                    <h4 class="mb-0">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard Petugas
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="fas fa-car fa-3x text-info mb-3"></i>
                                    <h5 class="card-title">Kendaraan Aktif</h5>
                                    <h2 class="text-info">0</h2>
                                    <p class="text-muted">Kendaraan yang sedang parkir</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                                    <h5 class="card-title">Transaksi Hari Ini</h5>
                                    <h2 class="text-warning">0</h2>
                                    <p class="text-muted">Transaksi masuk hari ini</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-center mb-4">
                                <i class="fas fa-tasks me-2"></i>Aksi Cepat
                            </h5>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="fas fa-plus-circle fa-2x text-primary mb-3"></i>
                                    <h6 class="card-title">Transaksi Masuk</h6>
                                    <p class="text-muted">Input kendaraan baru</p>
                                    <a href="<?= site_url('/transaksi') ?>" class="btn btn-primary btn-sm">Input Transaksi</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="fas fa-minus-circle fa-2x text-success mb-3"></i>
                                    <h6 class="card-title">Transaksi Keluar</h6>
                                    <p class="text-muted">Proses kendaraan keluar</p>
                                    <a href="<?= site_url('/transaksi/keluar') ?>" class="btn btn-success btn-sm">Proses Keluar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="fas fa-print fa-2x text-info mb-3"></i>
                                    <h6 class="card-title">Daftar Struk</h6>
                                    <p class="text-muted">Cetak struk parkir</p>
                                    <a href="<?= site_url('/cetak-struk') ?>" class="btn btn-info btn-sm">Daftar Struk</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="fas fa-file-alt fa-3x text-info mb-3"></i>
                                    <h6 class="card-title">Rekap Transaksi</h6>
                                    <p class="text-muted">Rekap transaksi per periode</p>
                                    <a href="<?= site_url('/rekap-transaksi') ?>" class="btn btn-primary btn-sm">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
