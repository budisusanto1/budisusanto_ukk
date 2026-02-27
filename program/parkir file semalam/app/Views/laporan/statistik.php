<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #28a745, #ffc107);">
                    <h4 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Statistik Parkir
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Filter Tanggal -->
                    <form method="GET" action="<?= site_url('/laporan/statistik') ?>">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                                <input type="date" class="form-control" name="tanggal_awal" 
                                       value="<?= $tanggal_awal ?>" 
                                       max="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                                <input type="date" class="form-control" name="tanggal_akhir" 
                                       value="<?= $tanggal_akhir ?>" 
                                       max="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i>Tampilkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Ringkasan Statistik -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-car fa-3x text-info mb-3"></i>
                                    <h5 class="card-title">Total Transaksi</h5>
                                    <h2 class="text-info"><?= $total_transaksi ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-money-bill-wave fa-3x text-success mb-3"></i>
                                    <h5 class="card-title">Total Pendapatan</h5>
                                    <h2 class="text-success">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                                    <h5 class="card-title">Rata-rata Durasi</h5>
                                    <h2 class="text-warning"><?= number_format(array_sum(array_column($transaksi, 'durasi_jam')) / max(1, count($transaksi)), 2) ?> jam</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Statistik per Jenis Kendaraan -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Jenis Kendaraan</th>
                                    <th>Total Transaksi</th>
                                    <th>Total Pendapatan</th>
                                    <th>Rata-rata Durasi</th>
                                    <th>Rata-rata per Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($statistik_kendaraan)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            Tidak ada data transaksi untuk periode yang dipilih.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($statistik_kendaraan as $stat): ?>
                                        <tr>
                                            <td><?= ucfirst($stat['jenis_kendaraan']) ?></td>
                                            <td><?= $stat['total_transaksi'] ?></td>
                                            <td>Rp <?= number_format($stat['total_pendapatan'], 0, ',', '.') ?></td>
                                            <td><?= number_format($stat['rata_durasi'], 2) ?> jam</td>
                                            <td>Rp <?= number_format($stat['total_transaksi'] > 0 ? $stat['total_pendapatan'] / $stat['total_transaksi'] : 0, 0, ',', '.') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
