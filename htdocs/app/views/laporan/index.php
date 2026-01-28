<div class="main-content">
    <div class="topbar">
        <div class="topbar-left">
            <h4><i class="fas fa-chart-bar"></i> Laporan</h4>
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
        <!-- Filter Laporan -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-filter"></i> Filter Periode Laporan
                </h3>
            </div>
            <div class="card-body">
                <form method="GET" action="<?= BASE_URL ?>laporan">
                    <div class="filter-section">
                        <div class="form-group" style="flex: 1; min-width: 200px;">
                            <label class="form-label">Dari Tanggal</label>
                            <input type="date" name="start_date" class="form-control" value="<?= $start_date ?>">
                        </div>
                        <div class="form-group" style="flex: 1; min-width: 200px;">
                            <label class="form-label">Sampai Tanggal</label>
                            <input type="date" name="end_date" class="form-control" value="<?= $end_date ?>">
                        </div>
                        <div class="form-group" style="display: flex; align-items: flex-end;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Tampilkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Riwayat Transaksi -->
        <div class="card">
            <div class="card-header d-flex justify-between align-center">
                <h3 class="card-title">
                    <i class="fas fa-history"></i> Riwayat Transaksi
                </h3>
                <div style="display: flex; gap: 10px;">
                    <button onclick="printReport()" class="btn btn-info">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <button onclick="exportTableToExcel('table-transaksi', 'Laporan_Transaksi_<?= date('Ymd') ?>')" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Excel
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-transaksi">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Kendaraan</th>
                                <th>Lama</th>
                                <th>Total</th>
                                <th>Denda</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($transaksi)): ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data transaksi pada periode ini</td>
                            </tr>
                            <?php else: ?>
                                <?php 
                                $totalBiaya = 0;
                                $totalDenda = 0;
                                foreach($transaksi as $t): 
                                    $totalBiaya += $t['total_biaya'];
                                    $totalDenda += $t['denda'];
                                ?>
                                <tr>
                                    <td><?= $t['kode_transaksi'] ?></td>
                                    <td><?= date('d/m/Y', strtotime($t['tanggal_sewa'])) ?></td>
                                    <td><?= $t['nama_pelanggan'] ?></td>
                                    <td>
                                        <?= $t['nama_kendaraan'] ?><br>
                                        <small><?= $t['plat_nomor'] ?></small>
                                    </td>
                                    <td><?= $t['lama_sewa'] ?> hari</td>
                                    <td>Rp <?= number_format($t['total_biaya'], 0, ',', '.') ?></td>
                                    <td>
                                        <?php if($t['denda'] > 0): ?>
                                        <span style="color: var(--danger-color); font-weight: 600;">
                                            Rp <?= number_format($t['denda'], 0, ',', '.') ?>
                                        </span>
                                        <?php else: ?>
                                        <span style="color: #9ca3af;">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $badgeClass = $t['status'] == 'selesai' ? 'badge-success' : ($t['status'] == 'aktif' ? 'badge-warning' : 'badge-danger');
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= ucfirst($t['status']) ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <!-- Total Row -->
                                <tr style="background: #f9fafb; font-weight: 700;">
                                    <td colspan="5" class="text-right"><strong>TOTAL</strong></td>
                                    <td><strong>Rp <?= number_format($totalBiaya, 0, ',', '.') ?></strong></td>
                                    <td><strong style="color: var(--danger-color);">Rp <?= number_format($totalDenda, 0, ',', '.') ?></strong></td>
                                    <td><strong>Rp <?= number_format($totalBiaya + $totalDenda, 0, ',', '.') ?></strong></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Kendaraan Sedang Disewa -->
        <?php if(!empty($transaksi_aktif)): ?>
        <div class="card">
            <div class="card-header d-flex justify-between align-center">
                <h3 class="card-title">
                    <i class="fas fa-clock"></i> Kendaraan Sedang Disewa
                </h3>
                <span class="badge badge-warning"><?= count($transaksi_aktif) ?> Kendaraan</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Kode Transaksi</th>
                                <th>Kendaraan</th>
                                <th>Pelanggan</th>
                                <th>Tanggal Sewa</th>
                                <th>Harus Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($transaksi_aktif as $t): ?>
                            <tr>
                                <td><?= $t['kode_transaksi'] ?></td>
                                <td>
                                    <?= $t['nama_kendaraan'] ?><br>
                                    <small><?= $t['plat_nomor'] ?></small>
                                </td>
                                <td><?= $t['nama_pelanggan'] ?></td>
                                <td><?= date('d/m/Y', strtotime($t['tanggal_sewa'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($t['tanggal_kembali_rencana'])) ?></td>
                                <td>
                                    <?php if($t['hari_terlambat'] > 0): ?>
                                        <span class="badge badge-danger">
                                            <i class="fas fa-exclamation-triangle"></i> Terlambat <?= $t['hari_terlambat'] ?> hari
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle"></i> Aktif
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Laporan Denda -->
        <?php if(!empty($denda)): ?>
        <div class="card">
            <div class="card-header d-flex justify-between align-center">
                <h3 class="card-title">
                    <i class="fas fa-exclamation-triangle"></i> Laporan Denda
                </h3>
                <span class="badge badge-danger"><?= count($denda) ?> Denda</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Kode Transaksi</th>
                                <th>Pelanggan</th>
                                <th>Kendaraan</th>
                                <th>Terlambat</th>
                                <th>Tarif/Hari</th>
                                <th>Total Denda</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $totalSemuaDenda = 0;
                            foreach($denda as $d): 
                                $totalSemuaDenda += $d['total_denda'];
                            ?>
                            <tr>
                                <td><?= $d['kode_transaksi'] ?></td>
                                <td><?= $d['nama_pelanggan'] ?></td>
                                <td>
                                    <?= $d['nama_kendaraan'] ?><br>
                                    <small><?= $d['plat_nomor'] ?? '-' ?></small>
                                </td>
                                <td>
                                    <span class="badge badge-danger">
                                        <?= $d['jumlah_hari_terlambat'] ?> hari
                                    </span>
                                </td>
                                <td>Rp <?= number_format($d['tarif_denda_perhari'], 0, ',', '.') ?></td>
                                <td>
                                    <strong style="color: var(--danger-color);">
                                        Rp <?= number_format($d['total_denda'], 0, ',', '.') ?>
                                    </strong>
                                </td>
                                <td><?= $d['keterangan'] ?? '-' ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <tr style="background: #fee2e2; font-weight: 700;">
                                <td colspan="5" class="text-right"><strong>TOTAL DENDA</strong></td>
                                <td colspan="2">
                                    <strong style="color: var(--danger-color); font-size: 16px;">
                                        Rp <?= number_format($totalSemuaDenda, 0, ',', '.') ?>
                                    </strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>