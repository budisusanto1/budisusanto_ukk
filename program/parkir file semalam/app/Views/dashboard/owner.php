<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #28a745, #ffc107);">
                    <h4 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>Dashboard Owner
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-money-bill-wave fa-3x text-success mb-3"></i>
                                    <h5 class="card-title">Total Pendapatan Hari Ini</h5>
                                    <h2 class="text-success">Rp 0</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-car fa-3x text-info mb-3"></i>
                                    <h5 class="card-title">Total Kendaraan</h5>
                                    <h2 class="text-info">0</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                                    <h5 class="card-title">Durasi Rata-rata</h5>
                                    <h2 class="text-warning">0 jam</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-center mb-4">
                                <i class="fas fa-chart-bar me-2"></i>Laporan & Statistik
                            </h5>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="fas fa-calendar-alt fa-2x text-primary mb-3"></i>
                                    <h6 class="card-title">Rekap Transaksi</h6>
                                    <p class="text-muted">Laporan transaksi per periode</p>
                                    <a href="<?= site_url('/rekap-transaksi') ?>" class="btn btn-primary btn-sm">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="fas fa-money-bill-wave fa-2x text-success mb-3"></i>
                                    <h6 class="card-title">Laporan Pendapatan</h6>
                                    <p class="text-muted">Laporan pendapatan harian/mingguan</p>
                                    <a href="<?= site_url('/laporan/pendapatan') ?>" class="btn btn-success btn-sm">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="fas fa-chart-bar fa-2x text-info mb-3"></i>
                                    <h6 class="card-title">Statistik Parkir</h6>
                                    <p class="text-muted">Statistik penggunaan parkir</p>
                                    <a href="<?= site_url('/laporan/statistik') ?>" class="btn btn-info btn-sm">Lihat Detail</a>
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
