<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #00c6ff, #7b2ff7);">
                    <h4 class="mb-0">
                        <i class="fas fa-list me-2"></i>Daftar Struk Parkir
                    </h4>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <!-- Debug Info -->
                    <div class="alert alert-info">
                        <strong>Debug Info:</strong><br>
                        Total Transaksi: <?= count($all_transaksi) ?><br>
                        Transaksi Selesai/Keluar: <?= count($transaksi) ?>
                    </div>

                    <?php if (empty($transaksi)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-receipt fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada transaksi selesai</h5>
                            <p class="text-muted">
                                Struk akan muncul setelah kendaraan keluar dan biaya dihitung.<br>
                                <small>Total transaksi di database: <?= count($all_transaksi) ?></small>
                            </p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No. Struk</th>
                                        <th>Plat Nomor</th>
                                        <th>Jenis Kendaraan</th>
                                        <th>Waktu Masuk</th>
                                        <th>Waktu Keluar</th>
                                        <th>Durasi</th>
                                        <th>Total Bayar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($transaksi as $t): ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary">
                                                    <?= str_pad($t['id_parkir'], 6, '0', STR_PAD_LEFT) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <strong><?= $t['plat_nomor'] ?? 'N/A' ?></strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <i class="fas fa-car me-1"></i><?= ucfirst($t['jenis_kendaraan'] ?? 'N/A') ?>
                                                </span>
                                            </td>
                                            <td><?= date('d-m-Y H:i:s', strtotime($t['waktu_masuk'])) ?></td>
                                            <td><?= $t['waktu_keluar'] ? date('d-m-Y H:i:s', strtotime($t['waktu_keluar'])) : '-' ?></td>
                                            <td>
                                                <?php if ($t['durasi_jam']): ?>
                                                    <?= $t['durasi_jam'] ?> jam
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($t['biaya_total']): ?>
                                                    <span class="badge bg-success">
                                                        Rp <?= number_format($t['biaya_total'], 0, ',', '.') ?>
                                                    </span>
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($t['status'] === 'selesai' || $t['status'] === 'keluar'): ?>
                                                    <a href="<?= site_url('/transaksi/struk/' . $t['id_parkir']) ?>" 
                                                       class="btn btn-info btn-sm" target="_blank">
                                                        <i class="fas fa-print me-1"></i>Cetak
                                                    </a>
                                                <?php else: ?>
                                                    <span class="badge bg-warning">Belum Selesai</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                    <div class="mt-3">
                        <a href="<?= site_url('/transaksi/keluar') ?>" class="btn btn-secondary btn-lg px-5">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Transaksi Keluar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
