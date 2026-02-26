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
            <h3 class="mb-0">Tambah Tarif Baru</h3>
            <p class="mb-0 opacity-75">Form pengaturan tarif parkir</p>
        </div>
        
        <form action="<?= site_url('/tarif/store') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="jenis_kendaraan" class="form-label">
                    <i class="fas fa-car me-2"></i>Jenis Kendaraan
                </label>
                <select class="form-select" id="jenis_kendaraan" name="jenis_kendaraan" required>
                    <option value="">Pilih Jenis Kendaraan</option>
                    <option value="mobil">🚗 Mobil</option>
                    <option value="motor">🏍️ Motor</option>
                    <option value="truk">🚚 Truk</option>
                    <option value="bus">🚌 Bus</option>
                    <option value="lainnya">📦 Lainnya</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="tarif_per_jam" class="form-label">
                    <i class="fas fa-tags me-2"></i>Tarif per Jam
                </label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" id="tarif_per_jam" name="tarif_per_jam" 
                           placeholder="0" min="0" required>
                </div>
                <small class="text-muted">Masukkan tarif dalam Rupiah (contoh: 5000)</small>
            </div>

            <div class="tarif-preview">
                <h6><i class="fas fa-info-circle me-2"></i>Preview Tarif</h6>
                <div id="preview-content" class="text-muted">
                    <p class="mb-0">Pilih jenis kendaraan dan masukkan tarif untuk melihat preview</p>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-submit flex-fill">
                    <i class="fas fa-save me-2"></i>Simpan
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
    const jenisSelect = document.getElementById('jenis_kendaraan');
    const tarifInput = document.getElementById('tarif_per_jam');
    const previewContent = document.getElementById('preview-content');

    function updatePreview() {
        const jenis = jenisSelect.value;
        const tarif = tarifInput.value;

        if (jenis && tarif) {
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
        } else {
            previewContent.innerHTML = '<p class="mb-0">Pilih jenis kendaraan dan masukkan tarif untuk melihat preview</p>';
        }
    }

    jenisSelect.addEventListener('change', updatePreview);
    tarifInput.addEventListener('input', updatePreview);
});
</script>

<?= $this->endSection() ?>
