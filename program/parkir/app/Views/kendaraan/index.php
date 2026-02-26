<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content') ?>

<style>
.kendaraan-container {
    min-height: calc(100vh - 200px);
    padding: 2rem 0;
}

.kendaraan-header {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    color: white;
    padding: 2rem;
    border-radius: 15px 15px 0 0;
    margin-bottom: 2rem;
}

.kendaraan-body {
    background: white;
    border-radius: 0 0 15px 15px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.btn-add-kendaraan {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-add-kendaraan:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.table th {
    background: rgba(0, 0, 0, 0.05);
    border-bottom: 2px solid var(--aurora-blue);
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

.search-box {
    position: relative;
    max-width: 300px;
}

.search-box input {
    padding-left: 35px;
    border-radius: 25px;
    border: 1px solid #ddd;
}

.search-box i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
}

@media (max-width: 768px) {
    .kendaraan-container {
        padding: 1rem 0;
    }
    
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .btn-add-kendaraan {
        margin-bottom: 1rem;
    }
}
</style>

<div class="kendaraan-container">
    <div class="kendaraan-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">Manajemen Kendaraan</h2>
                <p class="mb-0 opacity-75">Kelola data kendaraan sistem parkir</p>
            </div>
            <a href="<?= site_url('/kendaraan/create') ?>" class="btn btn-add-kendaraan">
                <i class="fas fa-plus me-2"></i>Tambah Kendaraan
            </a>
        </div>
    </div>

    <div class="kendaraan-body">
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

        <!-- Search Box -->
        <div class="mb-4">
            <form method="GET" action="<?= site_url('/kendaraan/search') ?>" class="d-flex">
                <div class="search-box flex-fill">
                    <i class="fas fa-search"></i>
                    <input type="text" name="keyword" class="form-control" placeholder="Cari plat nomor, pemilik, atau warna..." value="<?= old('keyword') ?>">
                </div>
                <button type="submit" class="btn btn-primary ms-2">
                    <i class="fas fa-search"></i>
                </button>
                <a href="<?= site_url('/kendaraan') ?>" class="btn btn-secondary ms-2">
                    <i class="fas fa-times"></i> Reset
                </a>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Plat Nomor</th>
                        <th>Jenis Kendaraan</th>
                        <th>Warna</th>
                        <th>Pemilik</th>
                        <th>User</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($kendaraan)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-car fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data kendaraan</p>
                                <a href="<?= site_url('/kendaraan/create') ?>" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Tambah Kendaraan
                                </a>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; ?>
                        <?php foreach ($kendaraan as $k): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <strong><?= $k['plat_nomor'] ?></strong>
                                </td>
                                <td>
                                    <span class="jenis-kendaraan jenis-<?= $k['jenis_kendaraan'] ?>">
                                        <i class="fas fa-<?= $k['jenis_kendaraan'] === 'mobil' ? 'car' : ($k['jenis_kendaraan'] === 'motor' ? 'motorcycle' : 'truck') ?> me-1"></i>
                                        <?= ucfirst($k['jenis_kendaraan']) ?>
                                    </span>
                                </td>
                                <td><?= $k['warna'] ?: '-' ?></td>
                                <td><?= $k['pemilik'] ?: '-' ?></td>
                                <td>
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i>
                                        <?= $k['username'] ?>
                                    </small>
                                </td>
                                <td>
                                    <a href="<?= site_url('/kendaraan/edit/' . $k['id_kendaraan']) ?>" 
                                       class="btn btn-sm btn-primary btn-action"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= site_url('/kendaraan/delete/' . $k['id_kendaraan']) ?>" 
                                       class="btn btn-sm btn-danger btn-action"
                                       title="Hapus"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus kendaraan dengan plat nomor <?= $k['plat_nomor'] ?>?')">
                                        <i class="fas fa-trash"></i>
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

<?= $this->endSection() ?>
