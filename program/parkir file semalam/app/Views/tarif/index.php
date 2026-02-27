<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content') ?>

<style>
.tarif-container {
    min-height: calc(100vh - 200px);
    padding: 2rem 0;
}

.tarif-header {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    color: white;
    padding: 2rem;
    border-radius: 15px 15px 0 0;
    margin-bottom: 2rem;
}

.tarif-body {
    background: white;
    border-radius: 0 0 15px 15px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.btn-add-tarif {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-add-tarif:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.table th {
    background: rgba(0, 0, 0, 0.05);
    border-bottom: 2px solid var(--aurora-blue);
}

.tarif-amount {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--aurora-blue);
}

.jenis-kendaraan {
    font-size: 0.8rem;
    padding: 5px 10px;
    border-radius: 15px;
}

.jenis-mobil { background: #007bff; color: white; }
.jenis-motor { background: #28a745; color: white; }
.jenis-truk { background: #fd7e14; color: white; }
.jenis-bus { background: #6f42c1; color: white; }
.jenis-lainnya { background: #6c757d; color: white; }

.btn-action {
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 0.8rem;
    margin: 0 2px;
}

@media (max-width: 768px) {
    .tarif-container {
        padding: 1rem 0;
    }
    
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .btn-add-tarif {
        margin-bottom: 1rem;
    }
}
</style>

<div class="tarif-container">
    <div class="tarif-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">Manajemen Tarif Parkir</h2>
                <p class="mb-0 opacity-75">Kelola tarif parkir per jenis kendaraan</p>
            </div>
            <a href="<?= site_url('/tarif/create') ?>" class="btn btn-add-tarif">
                <i class="fas fa-plus me-2"></i>Tambah Tarif
            </a>
        </div>
    </div>

    <div class="tarif-body">
        <?php if (session()->get('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= session('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php session()->remove('success'); ?>
        <?php endif; ?>

        <?php if (session()->get('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <?= session('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php session()->remove('error'); ?>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Kendaraan</th>
                        <th>Tarif per Jam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tarif)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data tarif</p>
                                <a href="<?= site_url('/tarif/create') ?>" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Tambah Tarif
                                </a>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; ?>
                        <?php foreach ($tarif as $t): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <span class="jenis-kendaraan jenis-<?= $t['jenis_kendaraan'] ?>">
                                        <i class="fas fa-<?= $t['jenis_kendaraan'] === 'mobil' ? 'car' : ($t['jenis_kendaraan'] === 'motor' ? 'motorcycle' : 'truck') ?> me-1"></i>
                                        <?= ucfirst($t['jenis_kendaraan']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="tarif-amount">Rp <?= number_format($t['tarif_per_jam'], 0, ',', '.') ?></span>
                                </td>
                                <td>
                                    <?php if ($t['tarif_per_jam'] > 0): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Tidak Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= site_url('/tarif/edit/' . $t['id_tarif']) ?>" 
                                       class="btn btn-sm btn-primary btn-action"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= site_url('/tarif/delete/' . $t['id_tarif']) ?>" 
                                       class="btn btn-sm btn-danger btn-action"
                                       title="Hapus"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus tarif <?= ucfirst($t['jenis_kendaraan']) ?>?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <div class="alert alert-info">
                <h5><i class="fas fa-info-circle me-2"></i>Informasi Tarif</h5>
                <ul class="mb-0">
                    <li>Tarif akan dikenakan per jam untuk setiap jenis kendaraan</li>
                    <li>Tarif Rp 0 berarti tarif tidak aktif untuk jenis kendaraan tersebut</li>
                    <li>Setiap jenis kendaraan hanya boleh memiliki satu tarif</li>
                    <li>Tarif akan digunakan untuk menghitung biaya parkir otomatis</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
