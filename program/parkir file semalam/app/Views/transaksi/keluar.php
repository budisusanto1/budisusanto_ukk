<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #00c6ff, #7b2ff7);">
                    <h4 class="mb-0">
                        <i class="fas fa-minus-circle me-2"></i>Transaksi Keluar
                    </h4>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (empty($transaksi)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-car fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak ada transaksi aktif</h5>
                            <p class="text-muted">Belum ada kendaraan yang parkir saat ini</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No. Plat</th>
                                        <th>Jenis Kendaraan</th>
                                        <th>Waktu Masuk</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($transaksi as $t): ?>
                                        <?php if ($t['status'] === 'masuk'): ?>
                                        <tr>
                                            <td>
                                                <strong><?= $t['plat_nomor'] ?></strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <i class="fas fa-car me-1"></i><?= ucfirst($t['jenis_kendaraan']) ?>
                                                </span>
                                            </td>
                                            <td><?= date('d-m-Y H:i:s', strtotime($t['waktu_masuk'])) ?></td>
                                            <td>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i>Aktif
                                                </span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#paymentModal<?= $t['id_parkir'] ?>"
                                                        data-id="<?= $t['id_parkir'] ?>"
                                                        data-plat="<?= $t['plat_nomor'] ?>">
                                                    <i class="fas fa-sign-out-alt me-1"></i>Proses Keluar
                                                </button>
                                                <a href="<?= site_url('/transaksi/struk-masuk/' . $t['id_parkir']) ?>" 
                                                   target="_blank" class="btn btn-info btn-sm ms-1" title="Cetak Tiket Masuk">
                                                    <i class="fas fa-print me-1"></i>Masuk
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                    <!-- Transaksi Selesai Section -->
                    <?php if (!empty($transaksi_selesai)): ?>
                    <div class="mt-4">
                        <div class="card shadow-lg border-0">
                            <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #dc3545, #fd7e14);">
                                <h5 class="mb-0">
                                    <i class="fas fa-check-circle me-2"></i>Transaksi Selesai
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>No. Plat</th>
                                                <th>Jenis Kendaraan</th>
                                                <th>Waktu Masuk</th>
                                                <th>Waktu Keluar</th>
                                                <th>Biaya</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach (array_slice($transaksi_selesai, 0, 10) as $t): ?>
                                            <tr>
                                                <td>
                                                    <strong><?= $t['plat_nomor'] ?></strong>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-car me-1"></i><?= ucfirst($t['jenis_kendaraan']) ?>
                                                    </span>
                                                </td>
                                                <td><?= date('d-m-Y H:i:s', strtotime($t['waktu_masuk'])) ?></td>
                                                <td><?= $t['waktu_keluar'] ? date('d-m-Y H:i:s', strtotime($t['waktu_keluar'])) : '-' ?></td>
                                                <td>
                                                    <span class="badge bg-success">
                                                        Rp <?= number_format($t['biaya_total'] ?? 0, 0, ',', '.') ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="<?= site_url('/transaksi/struk-masuk/' . $t['id_parkir']) ?>" 
                                                       target="_blank" class="btn btn-info btn-sm me-1" title="Cetak Tiket Masuk">
                                                        <i class="fas fa-print me-1"></i>Masuk
                                                    </a>
                                                    <a href="<?= site_url('/transaksi/struk/' . $t['id_parkir']) ?>" 
                                                       target="_blank" class="btn btn-success btn-sm" title="Cetak Struk Keluar">
                                                        <i class="fas fa-receipt me-1"></i>Keluar
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Modal Pembayaran -->
                    <?php foreach ($transaksi as $t): ?>
                        <?php if ($t['status'] === 'masuk'): ?>
                        <div class="modal fade" id="paymentModal<?= $t['id_parkir'] ?>" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-white">
                                        <h5 class="modal-title" id="paymentModalLabel">
                                            <i class="fas fa-credit-card me-2"></i>Pilih Metode Pembayaran
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= site_url('/transaksi/keluar/' . $t['id_parkir']) ?>" method="post">
                                        <?= csrf_field() ?>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">No. Plat Kendaraan:</label>
                                                <input type="text" class="form-control" value="<?= $t['plat_nomor'] ?>" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Jenis Kendaraan:</label>
                                                <input type="text" class="form-control" value="<?= ucfirst($t['jenis_kendaraan']) ?>" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Waktu Masuk:</label>
                                                <input type="text" class="form-control" value="<?= date('d-m-Y H:i:s', strtotime($t['waktu_masuk'])) ?>" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="metode_pembayaran" class="form-label fw-bold">
                                                    <i class="fas fa-wallet me-1"></i>Metode Pembayaran <span class="text-danger">*</span>
                                                </label>
                                                <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                                                    <option value="">-- Pilih Metode Pembayaran --</option>
                                                    <option value="tunai">
                                                        <i class="fas fa-money-bill-wave"></i> Tunai
                                                    </option>
                                                    <option value="transfer">
                                                        <i class="fas fa-exchange-alt"></i> Transfer Bank
                                                    </option>
                                                    <option value="ewallet">
                                                        <i class="fas fa-mobile-alt"></i> E-Wallet
                                                    </option>
                                                    <option value="kartu_kredit">
                                                        <i class="fas fa-credit-card"></i> Kartu Kredit
                                                    </option>
                                                    <option value="kartu_debit">
                                                        <i class="fas fa-debit-card"></i> Kartu Debit
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="fas fa-times me-1"></i>Batal
                                            </button>
                                            <button type="submit" class="btn btn-warning">
                                                <i class="fas fa-sign-out-alt me-1"></i>Proses Keluar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <div class="mt-3">
                        <a href="<?= site_url('/dashboard') ?>" class="btn btn-secondary btn-lg px-5">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto refresh setiap 30 detik
setInterval(function() {
    window.location.reload();
}, 30000);
</script>

<?= $this->endSection() ?>
