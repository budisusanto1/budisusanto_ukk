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

.tarif-form {
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

.tarif-preview {
    background: rgba(0, 198, 255, 0.1);
    border: 1px solid rgba(0, 198, 255, 0.2);
    border-radius: 10px;
    padding: 1rem;
    margin-top: 1rem;
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
</style>

<div class="form-container">
    <div class="tarif-form">
        <div class="form-header">
            <h3 class="mb-0">Edit Tarif</h3>
            <p class="mb-0 opacity-75">Ubah tarif parkir</p>
        </div>
        
        <form action="<?= site_url('/tarif/update/' . $tarif['id_tarif']) ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="jenis_kendaraan" class="form-label">
                    <i class="fas fa-car me-2"></i>Jenis Kendaraan
                </label>
                <select class="form-select" id="jenis_kendaraan" name="jenis_kendaraan" required disabled>
                    <option value="">Pilih Jenis Kendaraan</option>
                    <option value="mobil" <?= $tarif['jenis_kendaraan'] === 'mobil' ? 'selected' : '' ?>>🚗 Mobil</option>
                    <option value="motor" <?= $tarif['jenis_kendaraan'] === 'motor' ? 'selected' : '' ?>>🏍️ Motor</option>
                    <option value="truk" <?= $tarif['jenis_kendaraan'] === 'truk' ? 'selected' : '' ?>>🚚 Truk</option>
                    <option value="bus" <?= $tarif['jenis_kendaraan'] === 'bus' ? 'selected' : '' ?>>🚌 Bus</option>
                    <option value="lainnya" <?= $tarif['jenis_kendaraan'] === 'lainnya' ? 'selected' : '' ?>>📦 Lainnya</option>
                </select>
                <small class="text-muted">Jenis kendaraan tidak dapat diubah</small>
            </div>

            <div class="mb-3">
                <label for="tarif_per_jam" class="form-label">
                    <i class="fas fa-tags me-2"></i>Tarif per Jam
                </label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" id="tarif_per_jam" name="tarif_per_jam" 
                           value="<?= $tarif['tarif_per_jam'] ?>" min="0" required>
                </div>
                <small class="text-muted">Masukkan tarif dalam Rupiah (contoh: 5000)</small>
            </div>

            <div class="tarif-preview">
                <h6><i class="fas fa-info-circle me-2"></i>Preview Tarif</h6>
                <div id="preview-content" class="text-muted">
                    <p class="mb-0">
                        <strong>🚗 <?= ucfirst($tarif['jenis_kendaraan']) ?></strong><br>
                        Tarif: <span class="text-primary">Rp <?= number_format($tarif['tarif_per_jam'], 0, ',', '.') ?></span> per jam
                    </p>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-submit flex-fill">
                    <i class="fas fa-save me-2"></i>Update
                </button>
                <a href="<?= site_url('/tarif') ?>" class="btn btn-cancel flex-fill">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tarifInput = document.getElementById('tarif_per_jam');
    const previewContent = document.getElementById('preview-content');

    function updatePreview() {
        const tarif = tarifInput.value;
        const jenis = '<?= $tarif['jenis_kendaraan'] ?>';

        const icons = {
            'mobil': '🚗',
            'motor': '🏍️',
            'truk': '🚚',
            'bus': '🚌',
            'lainnya': '📦'
        };

        previewContent.innerHTML = `
            <p class="mb-0">
                <strong>${icons[jenis] || '🚗'} ${jenis.charAt(0).toUpperCase() + jenis.slice(1)}</strong><br>
                Tarif: <span class="text-primary">Rp ${parseInt(tarif).toLocaleString('id-ID')}</span> per jam
            </p>
        `;
    }

    tarifInput.addEventListener('input', updatePreview);
    updatePreview(); // Initial update
});
</script>

<?= $this->endSection() ?>
