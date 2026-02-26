<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content') ?>

<style>
.register-container {
    min-height: calc(100vh - 200px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 0;
}

.register-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 25px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    max-width: 450px;
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

.register-header {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    color: white;
    padding: 2.5rem;
    text-align: center;
}

.register-header h3 {
    margin-bottom: 0.5rem;
    font-weight: 700;
}

.register-header p {
    margin-bottom: 0;
    opacity: 0.9;
}

.register-form {
    padding: 2.5rem;
}

.form-control:focus {
    border-color: var(--aurora-blue);
    box-shadow: 0 0 0 0.2rem rgba(0, 198, 255, 0.25);
}

.btn-register {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    border: none;
    padding: 12px;
    font-weight: 600;
    border-radius: 50px;
    transition: all 0.3s ease;
}

.btn-register:hover {
    background: linear-gradient(135deg, #00a8e6, #6a1fc7);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.text-center a {
    color: var(--aurora-blue);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.text-center a:hover {
    color: var(--aurora-purple);
    text-decoration: underline;
}

@media (max-width: 768px) {
    .register-card {
        margin: 1rem;
    }
    
    .register-header,
    .register-form {
        padding: 2rem;
    }
}
</style>

<div class="register-container">
    <div class="register-card">
        <div class="register-header">
            <h3>Daftar Akun Baru</h3>
            <p>Sistem Manajemen Parkir</p>
        </div>
        
        <div class="register-form">
            <?php if (session()->has('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= session('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('auth/register') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label for="username" class="form-label">
                        <i class="fas fa-user me-2"></i>Username
                    </label>
                    <input type="text" class="form-control" id="username" name="username" 
                           value="<?= old('username') ?? '' ?>" required>
                    <?php if (isset($validation) && $validation->getError('username')): ?>
                        <div class="text-danger small mt-1">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            <?= $validation->getError('username') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">
                        <i class="fas fa-id-card me-2"></i>Nama Lengkap
                    </label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" 
                           value="<?= old('nama_lengkap') ?? '' ?>" placeholder="Opsional">
                    <?php if (isset($validation) && $validation->getError('nama_lengkap')): ?>
                        <div class="text-danger small mt-1">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            <?= $validation->getError('nama_lengkap') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock me-2"></i>Password
                    </label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <?php if (isset($validation) && $validation->getError('password')): ?>
                        <div class="text-danger small mt-1">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            <?= $validation->getError('password') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary btn-register w-100 mb-3">
                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                </button>
            </form>

            <div class="text-center">
                <p class="mb-0">Sudah punya akun? <a href="<?= site_url('auth/login') ?>">Login di sini</a></p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
