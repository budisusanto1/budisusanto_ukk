<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content') ?>

<style>
.user-container {
    min-height: calc(100vh - 200px);
    padding: 2rem 0;
}

.user-header {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    color: white;
    padding: 2rem;
    border-radius: 15px 15px 0 0;
    margin-bottom: 2rem;
}

.user-body {
    background: white;
    border-radius: 0 0 15px 15px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.btn-add-user {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-add-user:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.table th {
    background: rgba(0, 0, 0, 0.05);
    border-bottom: 2px solid var(--aurora-blue);
}

.badge-role {
    font-size: 0.8rem;
    padding: 5px 10px;
    border-radius: 15px;
}

.role-superadmin { background: #dc3545; }
.role-admin { background: #fd7e14; }
.role-owner { background: #ffc107; color: #000; }
.role-petugas { background: #28a745; }

.btn-action {
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 0.8rem;
    margin: 0 2px;
}

@media (max-width: 768px) {
    .user-container {
        padding: 1rem 0;
    }
    
    .table-responsive {
        font-size: 0.9rem;
    }
}
</style>

<div class="user-container">
    <div class="user-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">Manajemen User</h2>
                <p class="mb-0 opacity-75">Kelola pengguna sistem parkir</p>
            </div>
            <a href="<?= site_url('/users/create') ?>" class="btn btn-add-user">
                <i class="fas fa-plus me-2"></i>Tambah User
            </a>
        </div>
    </div>

    <div class="user-body">
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
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $user['username'] ?></td>
                            <td><?= $user['nama_lengkap'] ?? '-' ?></td>
                            <td>
                                <span class="badge badge-role role-<?= $user['role'] ?>">
                                    <?= ucfirst($user['role']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-success">Aktif</span>
                            </td>
                            <td>
                                <a href="<?= site_url('/users/edit/' . $user['id_user']) ?>" 
                                   class="btn btn-sm btn-primary btn-action">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= site_url('/users/delete/' . $user['id_user']) ?>" 
                                   class="btn btn-sm btn-danger btn-action"
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
