<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #28a745, #ffc107);">
                    <h4 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Rekap Transaksi
                    </h4>
                </div>
                <div class="card-body">
                    <form method="GET" action="<?= site_url('/rekap-transaksi') ?>">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                                <input type="date" class="form-control" name="tanggal_awal" 
                                       value="<?= $tanggal_awal ?? date('Y-m-d') ?>" 
                                       max="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                                <input type="date" class="form-control" name="tanggal_akhir" 
                                       value="<?= $tanggal_akhir ?? date('Y-m-d') ?>" 
                                       max="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i>Tampilkan Rekap
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Quick Stats -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-car fa-3x text-info mb-3"></i>
                                    <h5 class="card-title">Total Transaksi Hari Ini</h5>
                                    <h2 class="text-info">0</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-money-bill-wave fa-3x text-success mb-3"></i>
                                    <h5 class="card-title">Pendapatan Hari Ini</h5>
                                    <h2 class="text-success">Rp 0</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                                    <h5 class="card-title">Durasi Rata-rata</h5>
                                    <h2 class="text-warning">0 jam</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Transactions -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Struk</th>
                                    <th>Plat Nomor</th>
                                    <th>Jenis Kendaraan</th>
                                    <th>Waktu Masuk</th>
                                    <th>Waktu Keluar</th>
                                    <th>Durasi</th>
                                    <th>Total Bayar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="9" class="text-center text-muted">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Pilih tanggal untuk menampilkan rekap transaksi. Data akan muncul setelah ada transaksi yang selesai.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
