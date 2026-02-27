<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content') ?>

<style>
.log-container {
    min-height: calc(100vh - 200px);
    padding: 2rem 0;
}

.log-header {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    color: white;
    padding: 2rem;
    border-radius: 15px 15px 0 0;
    margin-bottom: 2rem;
}

.log-body {
    background: white;
    border-radius: 0 0 15px 15px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.btn-export {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-export:hover {
    transform: translateY(-2px);
    log-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.table th {
    background: rgba(0, 0, 0, 0.05);
    border-bottom: 2px solid var(--aurora-blue);
}

.log-activity {
    font-size: 0.9rem;
    max-width: 300px;
    word-break: break-word;
}

.log-time {
    font-family: monospace;
    font-size: 0.8rem;
    color: #666;
}

.log-user {
    font-weight: 600;
    color: var(--aurora-blue);
}

.log-ip {
    font-family: monospace;
    font-size: 0.8rem;
    color: #dc3545;
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

.filter-form {
    background: rgba(0, 198, 255, 0.1);
    border: 1px solid rgba(0, 198, 255, 0.2);
    border-radius: 10px;
    padding: 1rem;
    margin-bottom: 2rem;
}

@media (max-width: 768px) {
    .log-container {
        padding: 1rem 0;
    }
    
    .table-responsive {
        font-size: 0.8rem;
    }
    
    .btn-export {
        margin-bottom: 1rem;
    }
}
</style>

<div class="log-container">
    <div class="log-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">Log Aktivitas Sistem</h2>
                <p class="mb-0 opacity-75">Riwayat aktivitas pengguna sistem</p>
                <?php if (isset($total_logs)): ?>
                    <small class="text-white">Total: <?= $total_logs ?> aktivitas</small>
                <?php endif; ?>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= site_url('/log-aktivitas/export') ?>" class="btn btn-export">
                    <i class="fas fa-download me-2"></i>Export CSV
                </a>
                <a href="<?= site_url('/log-aktivitas/statistics') ?>" class="btn btn-outline-primary">
                    <i class="fas fa-chart-bar me-2"></i>Statistik
                </a>
            </div>
        </div>
    </div>

    <div class="log-body">
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

        <!-- Filter Form -->
        <div class="filter-form">
            <h5><i class="fas fa-filter me-2"></i>Filter Log</h5>
            <form method="POST" action="<?= site_url('/log-aktivitas/filter') ?>" class="row g-3">
                <div class="col-md-5">
                    <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                    <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" 
                           value="<?= old('tanggal_awal') ?? date('Y-m-d', strtotime('-7 days')) ?>" required>
                </div>
                <div class="col-md-5">
                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" 
                           value="<?= old('tanggal_akhir') ?? date('Y-m-d') ?>" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Search Box -->
        <div class="mb-4">
            <form method="GET" action="<?= site_url('/log-aktivitas/search') ?>" class="d-flex">
                <div class="search-box flex-fill">
                    <i class="fas fa-search"></i>
                    <input type="text" name="keyword" class="form-control" placeholder="Cari aktivitas, username, atau IP..." value="<?= old('keyword') ?>">
                </div>
                <button type="submit" class="btn btn-primary ms-2">
                    <i class="fas fa-search"></i>
                </button>
                <a href="<?= site_url('/log-aktivitas') ?>" class="btn btn-secondary ms-2">
                    <i class="fas fa-times"></i> Reset
                </a>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Aktivitas</th>
                        <th>IP Address</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data log aktivitas</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <div class="log-time"><?= date('d M Y H:i:s', strtotime($log['waktu_aktivitas'])) ?></div>
                                </td>
                                <td>
                                    <div class="log-user">
                                        <?= $log['nama_lengkap'] ?: $log['username'] ?>
                                    </div>
                                    <small class="text-muted">@<?= $log['username'] ?></small>
                                </td>
                                <td>
                                    <div class="log-activity"><?= $log['aktivitas'] ?></div>
                                </td>
                                <td>
                                    <div class="log-ip"><?= $log['ip_address'] ?></div>
                                </td>
                                <td>
                                    <a href="<?= site_url('/log-aktivitas/detail/' . $log['id_log']) ?>" 
                                       class="btn btn-sm btn-primary btn-action"
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Menampilkan 100 log terbaru</small>
                <a href="<?= site_url('/log-aktivitas/cleanup') ?>" class="btn btn-sm btn-outline-danger" 
                   onclick="return confirm('Apakah Anda yakin menghapus log aktivitas lebih dari 90 hari?')">
                    <i class="fas fa-trash me-2"></i>Cleanup Log Lama
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
