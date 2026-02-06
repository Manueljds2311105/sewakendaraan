<div class="main-content">
    <div class="topbar">
        <div class="topbar-left">
            <h4><i class="fas fa-car"></i> Detail Kendaraan</h4>
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
                    <i class="fas fa-info-circle"></i> Informasi Kendaraan
                </h3>
            </div>
            
            <div class="card-body">
                <div style="display: grid; grid-template-columns: 350px 1fr; gap: 30px;">
                    <!-- Foto Kendaraan dengan Zoom -->
                    <div>
                        <?php if(!empty($kendaraan['foto'])): ?>
                            <div style="position: relative;">
                                <img src="<?= BASE_URL ?>assets/images/<?= $kendaraan['foto'] ?>" 
                                     alt="<?= $kendaraan['nama_kendaraan'] ?>" 
                                     onclick="showImageModal('<?= BASE_URL ?>assets/images/<?= $kendaraan['foto'] ?>', '<?= addslashes($kendaraan['nama_kendaraan']) ?>')"
                                     style="width: 100%; height: 350px; object-fit: cover; border-radius: 12px; border: 3px solid #e5e7eb; cursor: pointer; transition: all 0.3s;"
                                     onmouseover="this.style.borderColor='#4f46e5'; this.style.transform='scale(1.02)';" 
                                     onmouseout="this.style.borderColor='#e5e7eb'; this.style.transform='scale(1)';">
                                <div style="position: absolute; bottom: 10px; right: 10px; background: rgba(0,0,0,0.6); color: white; padding: 8px 12px; border-radius: 8px; font-size: 12px;">
                                    <i class="fas fa-search-plus"></i> Klik untuk zoom
                                </div>
                            </div>
                        <?php else: ?>
                            <div style="width: 100%; height: 350px; background: #f3f4f6; border-radius: 12px; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 3px solid #e5e7eb;">
                                <i class="fas fa-car" style="color: #9ca3af; font-size: 80px; margin-bottom: 10px;"></i>
                                <span style="color: #6b7280; font-size: 14px;">Foto tidak tersedia</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Detail Info -->
                    <div class="detail-info">
                        <table style="width: 100%;">
                            <tr>
                                <td width="200"><strong>Kode Kendaraan</strong></td>
                                <td><?= $kendaraan['kode_kendaraan'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Nama Kendaraan</strong></td>
                                <td><?= $kendaraan['nama_kendaraan'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Jenis</strong></td>
                                <td><span class="badge badge-info"><?= ucfirst($kendaraan['jenis']) ?></span></td>
                            </tr>
                            <tr>
                                <td><strong>Merk</strong></td>
                                <td><?= $kendaraan['merk'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tahun Produksi</strong></td>
                                <td><?= $kendaraan['tahun_produksi'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Plat Nomor</strong></td>
                                <td><?= $kendaraan['plat_nomor'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Warna</strong></td>
                                <td><?= $kendaraan['warna'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Harga Sewa/Hari</strong></td>
                                <td><strong style="color: var(--primary-color); font-size: 18px;">Rp <?= number_format($kendaraan['harga_sewa_perhari'], 0, ',', '.') ?></strong></td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td>
                                    <?php
                                    $badgeClass = '';
                                    switch($kendaraan['status']) {
                                        case 'tersedia': $badgeClass = 'badge-success'; break;
                                        case 'disewa': $badgeClass = 'badge-warning'; break;
                                        case 'maintenance': $badgeClass = 'badge-danger'; break;
                                    }
                                    ?>
                                    <span class="badge <?= $badgeClass ?>"><?= ucfirst($kendaraan['status']) ?></span>
                                </td>
                            </tr>
                        </table>
                        
                        <div style="margin-top: 30px;">
                            <a href="<?= BASE_URL ?>kendaraan" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <?php if($_SESSION['role'] == 'admin'): ?>
                            <a href="<?= BASE_URL ?>kendaraan/edit/<?= $kendaraan['id'] ?>" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>