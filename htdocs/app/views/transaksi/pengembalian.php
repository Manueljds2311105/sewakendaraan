<div class="main-content">
    <div class="topbar">
        <div class="topbar-left">
            <h4><i class="fas fa-undo-alt"></i> Pengembalian Kendaraan</h4>
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
                    <i class="fas fa-info-circle"></i> Informasi Transaksi
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th width="250">Kode Transaksi</th>
                                <td><strong><?= $transaksi['kode_transaksi'] ?></strong></td>
                            </tr>
                            <tr>
                                <th>Pelanggan</th>
                                <td><?= $transaksi['nama_pelanggan'] ?></td>
                            </tr>
                            <tr>
                                <th>Kendaraan</th>
                                <td>
                                    <?= $transaksi['nama_kendaraan'] ?><br>
                                    <small class="badge badge-info"><?= $transaksi['plat_nomor'] ?></small>
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal Sewa</th>
                                <td><?= date('d/m/Y', strtotime($transaksi['tanggal_sewa'])) ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Kembali Rencana</th>
                                <td>
                                    <strong><?= date('d/m/Y', strtotime($transaksi['tanggal_kembali_rencana'])) ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Lama Sewa</th>
                                <td><?= $transaksi['lama_sewa'] ?> Hari</td>
                            </tr>
                            <tr>
                                <th>Harga Sewa/Hari</th>
                                <td>Rp <?= number_format($transaksi['harga_sewa_perhari'], 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <th>Total Biaya Sewa</th>
                                <td>
                                    <strong style="color: var(--primary-color); font-size: 18px;">
                                        Rp <?= number_format($transaksi['total_biaya'], 0, ',', '.') ?>
                                    </strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i> Form Pengembalian
                </h3>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= BASE_URL ?>transaksi/pengembalian/<?= $transaksi['id'] ?>">
                    <input type="hidden" id="tanggal_kembali_rencana" value="<?= $transaksi['tanggal_kembali_rencana'] ?>">
                    <input type="hidden" id="harga_sewa_perhari" value="<?= $transaksi['harga_sewa_perhari'] ?>">
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="far fa-calendar-check"></i> Tanggal Pengembalian Aktual *
                        </label>
                        <input type="date" 
                               name="tanggal_kembali_aktual" 
                               id="tanggal_kembali_aktual" 
                               class="form-control" 
                               required 
                               onchange="hitungDenda()">
                        <small style="color: #6b7280; display: block; margin-top: 5px;">
                            <i class="fas fa-info-circle"></i> Pilih tanggal pengembalian kendaraan
                        </small>
                    </div>
                    
                    <div id="denda_display" style="margin-top: 20px;"></div>
                    <input type="hidden" id="denda_value" name="denda" value="0">
                    
                    <div style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #e5e7eb; display: flex; gap: 10px; flex-wrap: wrap;">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check-circle"></i> Proses Pengembalian
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