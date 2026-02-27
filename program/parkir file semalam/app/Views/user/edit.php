<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content') ?>

<style>
.form-container {
    min-height: calc(100vh - 200px);
    padding: 2rem 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.user-form {
    background: white;
    border-radius: 15px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    padding: 2.5rem;
    max-width: 500px;
    width: 100%;
}

.form-header {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    color: white;
    padding: 2rem;
    margin: -2.5rem -2.5rem 2rem -2.5rem;
    border-radius: 15px 15px 0 0;
    text-align: center;
}

.form-control:focus {
    border-color: var(--aurora-blue);
    box-shadow: 0 0 0 0.2rem rgba(0, 198, 255, 0.25);
}

.btn-submit {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    border: none;
    color: white;
    padding: 12px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.btn-cancel {
    background: #6c757d;
    border: none;
    color: white;
    padding: 12px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: #5a6268;
}
</style>

<div class="form-container">
    <div class="user-form">
        <div class="form-header">
            <h3 class="mb-0">Edit User</h3>
            <p class="mb-0 opacity-75">Ubah data user</p>
        </div>
        
        <form action="<?= site_url('/users/update/' . $user['id_user']) ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label for="username">Username Baru:</label>
                <input type="text" class="form-control" id="username" name="username" required minlength="3" maxlength="100" 
                       value="<?= $user['username'] ?>">
                <small>Minimal 3 karakter, harus unique</small>
            </div>
            
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap Baru:</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" maxlength="255" 
                       value="<?= $user['nama_lengkap'] ?? '' ?>" placeholder="Opsional">
                <small>Maksimal 255 karakter, boleh kosong</small>
            </div>
            
            <div class="form-group">
                <label for="password">Password Baru:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                <small>Kosongkan jika tidak ingin mengubah password</small>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">Update User</button>
                <a href="<?= site_url('/users') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
