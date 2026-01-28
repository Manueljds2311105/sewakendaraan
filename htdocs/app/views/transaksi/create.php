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
                        <input type="text" value="<?= $kode ?>" readonly class="form-control">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Pelanggan *</label>
                            <select name="id_pelanggan" class="form-control" required>
                                <option value="">Pilih Pelanggan</option>
                                <?php foreach($pelanggan as $p): ?>
                                <option value="<?= $p['id'] ?>">
                                    <?= $p['nama_lengkap'] ?> (<?= $p['kode_pelanggan'] ?>)
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Kendaraan *</label>
                            <select name="id_kendaraan" class="form-control" required onchange="loadHargaKendaraan(this)">
                                <option value="">Pilih Kendaraan</option>
                                <?php foreach($kendaraan as $k): ?>
                                <option value="<?= $k['id'] ?>" data-harga="<?= $k['harga_sewa_perhari'] ?>">
                                    <?= $k['nama_kendaraan'] ?> - <?= $k['plat_nomor'] ?> (Rp <?= number_format($k['harga_sewa_perhari'], 0, ',', '.') ?>)
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Tanggal Sewa *</label>
                            <input type="date" name="tanggal_sewa" id="tanggal_sewa" class="form-control" required onchange="hitungTotal()">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Lama Sewa (Hari) *</label>
                            <input type="number" name="lama_sewa" id="lama_sewa" class="form-control" min="1" required oninput="hitungTotal()">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Harga Sewa/Hari</label>
                            <input type="text" id="harga_sewa" class="form-control" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Total Biaya</label>
                            <input type="text" name="total_biaya" id="total_biaya" class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Tanggal Kembali Rencana</label>
                        <div id="tanggal_kembali_display" style="padding: 12px; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 8px; font-weight: 600; color: #1f2937;">
                            -
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3" placeholder="Catatan tambahan (opsional)"></textarea>
                    </div>
                    
                    <div style="margin-top: 30px; display: flex; gap: 10px; flex-wrap: wrap;">
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