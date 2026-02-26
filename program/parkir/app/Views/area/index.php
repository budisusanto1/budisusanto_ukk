<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content') ?>

<style>
.area-container {
    min-height: calc(100vh - 200px);
    padding: 2rem 0;
}

.area-header {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    color: white;
    padding: 2rem;
    border-radius: 15px 15px 0 0;
    margin-bottom: 2rem;
}

.area-body {
    background: white;
    border-radius: 0 0 15px 15px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.btn-add-area {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-add-area:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.table th {
    background: rgba(0, 0, 0, 0.05);
    border-bottom: 2px solid var(--aurora-blue);
}

.progress-bar {
    height: 8px;
    border-radius: 4px;
    background: #e9ecef;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--aurora-blue), var(--aurora-purple));
    transition: width 0.3s ease;
}

.area-status {
    font-size: 0.8rem;
    padding: 5px 10px;
    border-radius: 15px;
}

.status-tersedia { background: #28a745; color: white; }
.status-penuh { background: #ffc107; color: #000; }
.status-penuh-full { background: #dc3545; color: white; }

.btn-action {
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 0.8rem;
    margin: 0 2px;
}

.stats-card {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    color: white;
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 2rem;
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
    .area-container {
        padding: 1rem 0;
    }
    
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .btn-add-area {
        margin-bottom: 1rem;
    }
}
</style>

<div class="area-container">
    <div class="area-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">Manajemen Area Parkir</h2>
                <p class="mb-0 opacity-75">Kelola area parkir dan kapasitas</p>
            </div>
            <a href="<?= site_url('/area/create') ?>" class="btn btn-add-area">
                <i class="fas fa-plus me-2"></i>Tambah Area
            </a>
        </div>
    </div>

    <div class="area-body">
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

        <!-- Statistics Cards -->
        <div class="stats-card">
            <div class="row text-center">
                <div class="col-3">
                    <h4 class="mb-1"><?= $stats['total_area'] ?></h4>
                    <small>Total Area</small>
                </div>
                <div class="col-3">
                    <h4 class="mb-1"><?= $stats['total_kapasitas'] ?></h4>
                    <small>Total Kapasitas</small>
                </div>
                <div class="col-3">
                    <h4 class="mb-1"><?= $stats['total_terisi'] ?></h4>
                    <small>Total Terisi</small>
                </div>
                <div class="col-3">
                    <h4 class="mb-1"><?= $stats['tersedia'] ?></h4>
                    <small>Tersedia</small>
                </div>
            </div>
            <div class="progress-bar mt-3">
                <div class="progress-fill" style="width: <?= $stats['persentase_terisi'] ?>%"></div>
            </div>
            <small class="text-white">Keterisian: <?= $stats['persentase_terisi'] ?>%</small>
        </div>

        <!-- Search Box -->
        <div class="mb-4">
            <form method="GET" action="<?= site_url('/area/search') ?>" class="d-flex">
                <div class="search-box flex-fill">
                    <i class="fas fa-search"></i>
                    <input type="text" name="keyword" class="form-control" placeholder="Cari nama area..." value="<?= old('keyword') ?>">
                </div>
                <button type="submit" class="btn btn-primary ms-2">
                    <i class="fas fa-search"></i>
                </button>
                <a href="<?= site_url('/area') ?>" class="btn btn-secondary ms-2">
                    <i class="fas fa-times"></i> Reset
                </a>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Area</th>
                        <th>Kapasitas</th>
                        <th>Terisi</th>
                        <th>Tersedia</th>
                        <th>Status</th>
                        <th>Persentase</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($areas)): ?>
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="fas fa-map-marked-alt fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data area parkir</p>
                                <a href="<?= site_url('/area/create') ?>" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Tambah Area
                                </a>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; ?>
                        <?php foreach ($areas as $area): ?>
                            <?php 
                            $tersedia = $area['kapasitas'] - $area['terisi'];
                            $persentase = $area['kapasitas'] > 0 ? round(($area['terisi'] / $area['kapasitas']) * 100, 2) : 0;
                            $status = $tersedia > 0 ? 'tersedia' : ($tersedia == 0 ? 'penuh' : 'penuh');
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <strong><?= $area['nama_area'] ?></strong>
                                </td>
                                <td><?= $area['kapasitas'] ?></td>
                                <td><?= $area['terisi'] ?></td>
                                <td>
                                    <span class="text-<?= $tersedia > 0 ? 'success' : 'danger' ?>">
                                        <?= $tersedia ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="area-status status-<?= $status ?>">
                                        <?= ucfirst($status) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="progress-bar" style="width: 100px;">
                                        <div class="progress-fill" style="width: <?= $persentase ?>%"></div>
                                    </div>
                                    <small><?= $persentase ?>%</small>
                                </td>
                                <td>
                                    <a href="<?= site_url('/area/edit/' . $area['id_area']) ?>" 
                                       class="btn btn-sm btn-primary btn-action"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= site_url('/area/reset-terisi/' . $area['id_area']) ?>" 
                                       class="btn btn-sm btn-warning btn-action"
                                       title="Reset Terisi"
                                       onclick="return confirm('Apakah Anda yakin ingin reset terisi area <?= $area['nama_area'] ?> menjadi 0?')">
                                        <i class="fas fa-redo"></i>
                                    </a>
                                    <a href="<?= site_url('/area/delete/' . $area['id_area']) ?>" 
                                       class="btn btn-sm btn-danger btn-action"
                                       title="Hapus"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus area <?= $area['nama_area'] ?>?')">
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
                <h5><i class="fas fa-info-circle me-2"></i>Informasi Area Parkir</h5>
                <ul class="mb-0">
                    <li>Area parkir digunakan untuk mengelompokkan lokasi parkir berdasarkan jenis kendaraan</li>
                    <li>Kapasitas menunjukkan total slot yang tersedia di area tersebut</li>
                    <li>Terisi menunjukkan jumlah kendaraan yang sedang parkir</li>
                    <li>Status akan berubah menjadi "Penuh" jika kapasitas terpenuhi</li>
                    <li>Reset Terisi akan mengubah jumlah terisi menjadi 0</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
