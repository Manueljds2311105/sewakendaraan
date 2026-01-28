<div class="main-content">
    <div class="topbar">
        <div class="topbar-left">
            <h4><i class="fas fa-edit"></i> Edit Kendaraan</h4>
        </div>
        <div class="topbar-right">
            <div class="user-info">
                <div class="user-avatar">
                    <?= strtoupper(substr($_SESSION['nama_lengkap'], 0, 1)) ?>
                </div>
                <div class="user-details">
                    <div class="user-name"><?= $_SESSION['nama_lengkap'] ?></div>
                    <div class="user-role"><?= $_SESSION['role'] ?? 'user' ?></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content-area">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-car"></i> Form Edit Kendaraan
                </h3>
            </div>
            
            <div class="card-body">
                <form method="POST" action="<?= BASE_URL ?>kendaraan/edit/<?= $kendaraan['id'] ?>?page=<?= $page ?? 1 ?>&search=<?= $search ?? '' ?>&jenis=<?= $jenis ?? '' ?>&status=<?= $status ?? '' ?>" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Kode Kendaraan</label>
                            <input type="text" name="kode_kendaraan" class="form-control" value="<?= $kendaraan['kode_kendaraan'] ?>" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Nama Kendaraan *</label>
                            <input type="text" name="nama_kendaraan" class="form-control" value="<?= $kendaraan['nama_kendaraan'] ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Jenis *</label>
                            <select name="jenis" class="form-control" required>
                                <option value="">Pilih Jenis</option>
                                <option value="mobil" <?= $kendaraan['jenis'] == 'mobil' ? 'selected' : '' ?>>Mobil</option>
                                <option value="motor" <?= $kendaraan['jenis'] == 'motor' ? 'selected' : '' ?>>Motor</option>
                                <option value="truk" <?= $kendaraan['jenis'] == 'truk' ? 'selected' : '' ?>>Truk</option>
                                <option value="bus" <?= $kendaraan['jenis'] == 'bus' ? 'selected' : '' ?>>Bus</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Merk *</label>
                            <input type="text" name="merk" class="form-control" value="<?= $kendaraan['merk'] ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Tahun Produksi *</label>
                            <input type="number" name="tahun_produksi" class="form-control" value="<?= $kendaraan['tahun_produksi'] ?>" min="1990" max="<?= date('Y') ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Plat Nomor *</label>
                            <input type="text" name="plat_nomor" class="form-control" value="<?= $kendaraan['plat_nomor'] ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Warna</label>
                            <input type="text" name="warna" class="form-control" value="<?= $kendaraan['warna'] ?>">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Harga Sewa Per Hari (Rp) *</label>
                            <input type="text" name="harga_sewa_perhari" class="form-control" value="<?= number_format($kendaraan['harga_sewa_perhari'], 0, ',', '.') ?>" required onkeyup="formatRupiah(this)">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Status *</label>
                            <select name="status" class="form-control" required>
                                <option value="tersedia" <?= $kendaraan['status'] == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                                <option value="disewa" <?= $kendaraan['status'] == 'disewa' ? 'selected' : '' ?>>Disewa</option>
                                <option value="maintenance" <?= $kendaraan['status'] == 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Foto Kendaraan</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                            <?php if(!empty($kendaraan['foto'])): ?>
                            <small>Foto saat ini: <?= $kendaraan['foto'] ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div style="margin-top: 30px; display: flex; gap: 10px;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="<?= BASE_URL ?>kendaraan?page=<?= $page ?? 1 ?>&search=<?= $search ?? '' ?>&jenis=<?= $jenis ?? '' ?>&status=<?= $status ?? '' ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function formatRupiah(input) {
    let value = input.value.replace(/[^0-9]/g, '');
    input.value = new Intl.NumberFormat('id-ID').format(value);
}
</script>