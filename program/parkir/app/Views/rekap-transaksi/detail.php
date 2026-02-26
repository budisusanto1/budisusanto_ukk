<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #28a745, #ffc107);">
                    <h4 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Detail Rekap Transaksi
                        <small class="ms-3"><?= date('d-m-Y', strtotime($tanggal_awal)) ?> s/d <?= date('d-m-Y', strtotime($tanggal_akhir)) ?></small>
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-car fa-2x text-info mb-2"></i>
                                    <h6 class="card-title">Total Transaksi</h6>
                                    <h4 class="text-info"><?= $total_transaksi ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-money-bill-wave fa-2x text-success mb-2"></i>
                                    <h6 class="card-title">Total Pendapatan</h6>
                                    <h4 class="text-success">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-chart-line fa-2x text-warning mb-2"></i>
                                    <h6 class="card-title">Rata-rata per Transaksi</h6>
                                    <h4 class="text-warning">Rp <?= number_format($total_transaksi > 0 ? $total_pendapatan / $total_transaksi : 0, 0, ',', '.') ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-clock fa-2x text-primary mb-2"></i>
                                    <h6 class="card-title">Rata-rata Durasi</h6>
                                    <h4 class="text-primary"><?= number_format(array_sum(array_column($transaksi, 'durasi_jam')) / max(1, count($transaksi)), 2) ?> jam</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Form -->
                    <form method="GET" action="<?= site_url('/rekap-transaksi') ?>" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="date" class="form-control" name="tanggal_awal" 
                                       value="<?= $tanggal_awal ?>" max="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-4">
                                <input type="date" class="form-control" name="tanggal_akhir" 
                                       value="<?= $tanggal_akhir ?>" max="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-2"></i>Filter
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Transactions Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
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
                                <?php if (empty($transaksi)): ?>
                                    <tr>
                                        <td colspan="10" class="text-center text-muted">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Tidak ada data transaksi untuk periode yang dipilih.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($transaksi as $t): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= str_pad($t['id_parkir'], 6, '0', STR_PAD_LEFT) ?></td>
                                            <td><?= $t['plat_nomor'] ?? 'N/A' ?></td>
                                            <td><?= ucfirst($t['jenis_kendaraan'] ?? 'N/A') ?></td>
                                            <td><?= date('d-m-Y H:i:s', strtotime($t['waktu_masuk'])) ?></td>
                                            <td><?= $t['waktu_keluar'] ? date('d-m-Y H:i:s', strtotime($t['waktu_keluar'])) : '-' ?></td>
                                            <td><?= $t['durasi_jam'] ?> jam</td>
                                            <td>Rp <?= number_format($t['biaya_total'], 0, ',', '.') ?></td>
                                            <td>
                                                <span class="badge bg-<?= $t['status'] === 'selesai' ? 'success' : ($t['status'] === 'keluar' ? 'warning' : 'primary') ?>">
                                                    <?= ucfirst($t['status']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?= site_url('/transaksi/struk/' . $t['id_parkir']) ?>" 
                                                   class="btn btn-sm btn-<?= $t['status'] === 'selesai' ? 'info' : 'warning' ?>" 
                                                   target="_blank"
                                                   title="Cetak Struk">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            </td>
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
