<div class="main-content">
    <div class="topbar">
        <div class="topbar-left">
            <h4><i class="fas fa-plus-circle"></i> Transaksi Sewa Baru</h4>
        </div>
        <div class="topbar-right">
            <div class="user-info">
                <div class="user-avatar">
                    <?= strtoupper(substr($_SESSION['nama_lengkap'], 0, 1)) ?>
                </div>
                <div class="user-details">
                    <div class="user-name"><?= $_SESSION['nama_lengkap'] ?></div>
                    <div class="user-role"><?= ucfirst($_SESSION['role']) ?></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content-area">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-file-invoice"></i> Form Transaksi Sewa
                </h3>
            </div>
            
            <div class="card-body">
                <form method="POST" action="<?= BASE_URL ?>transaksi/create">
                    <div class="form-group">
                        <label class="form-label">Kode Transaksi</label>
                        <input type="text" value="<?= $kode ?>" readonly class="form-control" style="background: #f3f4f6; font-weight: 700; color: var(--primary-color);">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user"></i> Pelanggan *
                            </label>
                            <select name="id_pelanggan" 
                                    class="form-control select2-pelanggan" 
                                    required>
                                <option value="">-- Pilih Pelanggan --</option>
                                <?php foreach($pelanggan as $p): ?>
                                <option value="<?= $p['id'] ?>">
                                    <?= $p['nama_lengkap'] ?> (<?= $p['kode_pelanggan'] ?>)
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="select-info">
                                <i class="fas fa-info-circle"></i> 
                                Ketik nama atau kode untuk mencari
                            </small>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-car"></i> Kendaraan *
                            </label>
                            <select name="id_kendaraan" 
                                    class="form-control select2-kendaraan" 
                                    required 
                                    onchange="loadHargaKendaraan(this)">
                                <option value="">-- Pilih Kendaraan --</option>
                                <?php foreach($kendaraan as $k): ?>
                                <option value="<?= $k['id'] ?>" 
                                        data-harga="<?= $k['harga_sewa_perhari'] ?>">
                                    <?= $k['nama_kendaraan'] ?> - <?= $k['plat_nomor'] ?> (Rp <?= number_format($k['harga_sewa_perhari'], 0, ',', '.') ?>)
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="select-info">
                                <i class="fas fa-info-circle"></i> 
                                Ketik nama, plat, atau merk untuk mencari
                            </small>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="far fa-calendar"></i> Tanggal Sewa *
                            </label>
                            <input type="date" name="tanggal_sewa" id="tanggal_sewa" class="form-control" required onchange="hitungTotal()">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-clock"></i> Lama Sewa (Hari) *
                            </label>
                            <input type="number" name="lama_sewa" id="lama_sewa" class="form-control" min="1" required oninput="hitungTotal()" placeholder="Contoh: 3">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-tag"></i> Harga Sewa/Hari
                            </label>
                            <input type="text" id="harga_sewa" class="form-control" readonly style="background: #f3f4f6; font-weight: 600;">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-money-bill-wave"></i> Total Biaya
                            </label>
                            <input type="text" name="total_biaya" id="total_biaya" class="form-control" readonly style="background: #e0e7ff; font-weight: 700; color: var(--primary-color); font-size: 16px;">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="far fa-calendar-check"></i> Tanggal Kembali Rencana
                        </label>
                        <div id="tanggal_kembali_display" style="padding: 15px; background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); border: 2px solid var(--border-color); border-radius: 10px; font-weight: 600; color: #1f2937; text-align: center; font-size: 16px;">
                            <i class="far fa-calendar"></i> -
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-sticky-note"></i> Catatan
                        </label>
                        <textarea name="catatan" class="form-control" rows="3" placeholder="Catatan tambahan (opsional) - misal: kondisi kendaraan, perlengkapan tambahan, dll"></textarea>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Transaksi
                        </button>
                        <a href="<?= BASE_URL ?>transaksi" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 Custom Styling -->
<style>
/* Select2 Container */
.select2-container--default .select2-selection--single {
    height: 48px;
    border: 2px solid var(--border-color);
    border-radius: 10px;
    padding: 10px 15px;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 26px;
    padding-left: 0;
    font-size: 14px;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 46px;
    right: 10px;
}

/* Select2 Dropdown */
.select2-container--default .select2-results__option {
    padding: 12px 15px;
    font-size: 14px;
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: var(--primary-color);
    color: white;
}

/* Select2 Search */
.select2-search--dropdown {
    padding: 10px;
}

.select2-search--dropdown .select2-search__field {
    border: 2px solid var(--border-color);
    border-radius: 8px;
    padding: 10px 15px;
    font-size: 14px;
}

.select2-search--dropdown .select2-search__field:focus {
    border-color: var(--primary-color);
    outline: none;
}

/* Select2 Dropdown Container */
.select2-dropdown {
    border: 2px solid var(--border-color);
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

/* Info text */
.select-info {
    display: block;
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
}

.select-info i {
    margin-right: 5px;
}

/* Focus state */
.select2-container--default.select2-container--focus .select2-selection--single {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

/* FORCE: Form Actions - Buttons Side by Side */
.form-actions {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 2px solid var(--border-color);
    display: flex !important;
    flex-direction: row !important;
    gap: 10px;
    align-items: center;
}

.form-actions .btn {
    display: inline-block !important;
    width: auto !important;
    min-width: auto !important;
    white-space: nowrap;
}

/* Override any responsive CSS that might stack buttons */
@media (max-width: 768px) {
    .form-actions {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: wrap;
    }
    
    .form-actions .btn {
        flex: 0 0 auto;
        width: auto !important;
    }
}

</style>

<!-- jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Initialize Select2 -->
<script>
$(document).ready(function() {
    // Initialize Select2 for Pelanggan
    $('.select2-pelanggan').select2({
        placeholder: 'Ketik untuk mencari pelanggan...',
        allowClear: true,
        width: '100%',
        language: {
            noResults: function() {
                return "Pelanggan tidak ditemukan";
            },
            searching: function() {
                return "Mencari...";
            }
        }
    });
    
    // Initialize Select2 for Kendaraan
    $('.select2-kendaraan').select2({
        placeholder: 'Ketik untuk mencari kendaraan...',
        allowClear: true,
        width: '100%',
        language: {
            noResults: function() {
                return "Kendaraan tidak ditemukan";
            },
            searching: function() {
                return "Mencari...";
            }
        }
    });
});
</script>