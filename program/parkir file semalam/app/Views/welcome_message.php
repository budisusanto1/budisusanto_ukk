<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content') ?>

<style>
.welcome-container {
    min-height: calc(100vh - 200px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 0;
}

.welcome-card {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 25px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    padding: 3rem;
    text-align: center;
    max-width: 500px;
    width: 100%;
    animation: fadeInUp 0.8s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.logo-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 2rem;
}

.logo-bcs {
    width: 120px;
    height: 120px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    object-fit: contain;
    background: rgba(255, 255, 255, 0.1);
    padding: 10px;
    max-width: 100%;
    height: auto;
}

@media (max-width: 768px) {
    .logo-bcs {
        width: 100px;
        height: 100px;
    }
}

@media (max-width: 480px) {
    .logo-bcs {
        width: 80px;
        height: 80px;
    }
}

.welcome-card h1 {
    color: white;
    font-weight: 700;
    margin-bottom: 1rem;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.welcome-card p {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

.btn-custom {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50px;
    padding: 12px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    margin: 0 10px;
}

.btn-custom:hover {
    background: rgba(255, 255, 255, 0.3);
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.btn-danger-custom {
    background: rgba(220, 53, 69, 0.8);
    border-color: rgba(220, 53, 69, 0.9);
}

.btn-danger-custom:hover {
    background: rgba(220, 53, 69, 1);
}

.role-badge {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 0.9rem;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.user-info {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.user-info h2 {
    color: white;
    font-size: 1.8rem;
    margin-bottom: 0.5rem;
}

.user-info p {
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 0.5rem;
}

@media (max-width: 768px) {
    .welcome-card {
        margin: 1rem;
        padding: 2rem;
    }
    
    .btn-custom {
        display: block;
        margin: 10px auto;
        width: 200px;
    }
}
</style>

<div class="welcome-container">
    <div class="welcome-card">
        <div class="logo-container">
            <img src="<?= base_url('logo-bcs.png') ?>" alt="Logo BCS Mall" class="logo-bcs">
        </div>

        <?php if (session()->get('isLoggedIn')): ?>
            <div class="user-info">
                <h2>Selamat Datang, <?= session()->get('nama_lengkap') ?? session()->get('username') ?>!</h2>
                <p>di Sistem Parkiran BCS Mall</p>
                <span class="role-badge">
                    <i class="fas fa-user-tag me-2"></i><?= ucfirst(session()->get('role')) ?>
                </span>
            </div>

            <div class="mt-4">
                <a href="<?= site_url('/dashboard') ?>" class="btn btn-custom">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
                <a href="<?= site_url('/auth/logout') ?>" class="btn btn-custom btn-danger-custom">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
            </div>
        <?php else: ?>
            <h1>Selamat Datang</h1>
            <p>di Sistem Parkiran BCS Mall</p>

            <div class="mt-4">
                <a href="<?= site_url('/auth/login') ?>" class="btn btn-custom">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </a>
                <a href="<?= site_url('/auth/register') ?>" class="btn btn-custom">
                    <i class="fas fa-user-plus me-2"></i>Register
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if (session()->get('success')): ?>
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
        <div class="toast show align-items-center text-white bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session()->get('success') ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    <?php session()->remove('success'); ?>
<?php endif; ?>

<?php if (session()->get('error')): ?>
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
        <div class="toast show align-items-center text-white bg-danger border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= session()->get('error') ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    <?php session()->remove('error'); ?>
<?php endif; ?>

<?= $this->endSection() ?>