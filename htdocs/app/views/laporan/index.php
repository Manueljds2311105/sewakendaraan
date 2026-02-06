<div class="main-content">
    <div class="topbar no-print">
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
        <?php
        $flash = $this->getFlash();
        if($flash):
        ?>
        <div class="alert alert-<?= $flash['type'] ?> no-print">
            <i class="fas fa-<?= $flash['type'] == 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
            <?= $flash['message'] ?>
        </div>
        <?php endif; ?>
        
        <!-- Filter Periode -->
        <div class="card no-print">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-filter"></i> Filter Periode Laporan
                </h3>
            </div>
            <div class="card-body">
                <form method="GET" action="<?= BASE_URL ?>laporan">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Dari Tanggal</label>
                            <input type="date" name="start_date" class="form-control" value="<?= $start_date ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Sampai Tanggal</label>
                            <input type="date" name="end_date" class="form-control" value="<?= $end_date ?>" required>
                        </div>
                        <div class="form-group" style="display: flex; align-items: flex-end; gap: 10px;">
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-search"></i> Tampilkan
                            </button>
                            <button type="button" onclick="window.print()" class="btn btn-success">
                                <i class="fas fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Header Print Only -->
        <div class="print-header">
            <h2 style="text-align: center; margin-bottom: 5px;">LAPORAN TRANSAKSI RENTAL KENDARAAN</h2>
            <h3 style="text-align: center; margin-bottom: 20px; font-weight: normal;">
                Periode: <?= date('d/m/Y', strtotime($start_date)) ?> - <?= date('d/m/Y', strtotime($end_date)) ?>
            </h3>
        </div>
        
        <!-- Riwayat Transaksi -->
        <div class="card page-break-inside">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-history"></i> Riwayat Transaksi
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="print-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Transaksi</th>
                                <th>Tanggal Sewa</th>
                                <th>Pelanggan</th>
                                <th>Kendaraan</th>
                                <th>Lama Sewa</th>
                                <th>Total Biaya</th>
                                <th>Denda</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($transaksi)): ?>
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada data transaksi pada periode ini</td>
                            </tr>
                            <?php else: ?>
                                <?php 
                                $no = 1;
                                $totalBiaya = 0;
                                $totalDenda = 0;
                                foreach($transaksi as $t): 
                                    $totalBiaya += $t['total_biaya'];
                                    $totalDenda += $t['denda'];
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $t['kode_transaksi'] ?></td>
                                    <td><?= date('d/m/Y', strtotime($t['tanggal_sewa'])) ?></td>
                                    <td><?= $t['nama_pelanggan'] ?></td>
                                    <td>
                                        <?= $t['nama_kendaraan'] ?><br>
                                        <small style="color: #6b7280;">(<?= $t['plat_nomor'] ?>)</small>
                                    </td>
                                    <td><?= $t['lama_sewa'] ?> hari</td>
                                    <td>Rp <?= number_format($t['total_biaya'], 0, ',', '.') ?></td>
                                    <td>
                                        <?php if($t['denda'] > 0): ?>
                                            <span style="color: #dc2626; font-weight: 600;">
                                                Rp <?= number_format($t['denda'], 0, ',', '.') ?>
                                            </span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?= $t['status'] == 'aktif' ? 'warning' : ($t['status'] == 'selesai' ? 'success' : 'danger') ?>">
                                            <?= strtoupper($t['status']) ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                
                                <!-- Total Row -->
                                <tr style="background-color: #f3f4f6; font-weight: 700;">
                                    <td colspan="6" style="text-align: right; padding-right: 15px;">TOTAL:</td>
                                    <td>Rp <?= number_format($totalBiaya, 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format($totalDenda, 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format($totalBiaya + $totalDenda, 0, ',', '.') ?></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Kendaraan Sedang Disewa -->
        <div class="card page-break-before page-break-inside">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-car"></i> Kendaraan Sedang Disewa
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="print-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Transaksi</th>
                                <th>Kendaraan</th>
                                <th>Pelanggan</th>
                                <th>Tanggal Sewa</th>
                                <th>Harus Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($transaksi_aktif)): ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada kendaraan yang sedang disewa</td>
                            </tr>
                            <?php else: ?>
                                <?php 
                                $no = 1;
                                foreach($transaksi_aktif as $ta): 
                                    $terlambat = (strtotime(date('Y-m-d')) - strtotime($ta['tanggal_kembali_rencana'])) / (60*60*24);
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $ta['kode_transaksi'] ?></td>
                                    <td>
                                        <strong><?= $ta['nama_kendaraan'] ?></strong><br>
                                        <small style="color: #6b7280;"><?= $ta['plat_nomor'] ?></small>
                                    </td>
                                    <td><?= $ta['nama_pelanggan'] ?></td>
                                    <td><?= date('d/m/Y', strtotime($ta['tanggal_sewa'])) ?></td>
                                    <td><?= date('d/m/Y', strtotime($ta['tanggal_kembali_rencana'])) ?></td>
                                    <td>
                                        <?php if($terlambat > 0): ?>
                                            <span class="badge badge-danger">TERLAMBAT <?= (int)$terlambat ?> HARI</span>
                                        <?php else: ?>
                                            <span class="badge badge-success">AKTIF</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Laporan Denda -->
        <?php if(!empty($denda)): ?>
        <div class="card page-break-before page-break-inside">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-exclamation-triangle"></i> Laporan Denda
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="print-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Transaksi</th>
                                <th>Pelanggan</th>
                                <th>Kendaraan</th>
                                <th>Hari Terlambat</th>
                                <th>Tarif/Hari</th>
                                <th>Total Denda</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            $grandTotalDenda = 0;
                            foreach($denda as $d): 
                                $grandTotalDenda += $d['total_denda'];
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $d['kode_transaksi'] ?></td>
                                <td><?= $d['nama_pelanggan'] ?></td>
                                <td><?= $d['nama_kendaraan'] ?></td>
                                <td><?= $d['jumlah_hari_terlambat'] ?> hari</td>
                                <td>Rp <?= number_format($d['tarif_denda_perhari'], 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($d['total_denda'], 0, ',', '.') ?></td>
                                <td><?= $d['keterangan'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <!-- Total Denda -->
                            <tr style="background-color: #fee2e2; font-weight: 700;">
                                <td colspan="6" style="text-align: right; padding-right: 15px;">TOTAL DENDA:</td>
                                <td colspan="2" style="color: #dc2626;">
                                    Rp <?= number_format($grandTotalDenda, 0, ',', '.') ?>
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

<!-- Print Styles -->
<style>
@media print {
    /* Hide elements saat print */
    .no-print {
        display: none !important;
    }
    
    .sidebar,
    .topbar,
    .btn,
    .alert,
    .pagination {
        display: none !important;
    }
    
    body {
        margin: 0 !important;
        padding: 0 !important;
    }
    
    /* Show print header */
    .print-header {
        display: block !important;
        margin-bottom: 30px;
    }
    
    /* Reset main content */
    .main-content {
        margin-left: 0 !important;
        padding: 20px !important;
        background: white !important;
    }
    
    .content-area {
        padding: 0 !important;
    }
    
    /* Card styles for print */
    .card {
        box-shadow: none !important;
        border: 1px solid #000 !important;
        margin-bottom: 20px !important;
        page-break-inside: avoid !important; /* Cegah card terpotong */
    }
    
    /* Page break classes */
    .page-break-before {
        page-break-before: always !important; /* Paksa mulai halaman baru */
    }
    
    .page-break-inside {
        page-break-inside: avoid !important; /* Jangan potong di tengah */
    }
    
    .card-header {
        background: #f3f4f6 !important;
        border-bottom: 2px solid #000 !important;
        padding: 10px 15px !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    
    .card-title {
        font-size: 16px !important;
        font-weight: bold !important;
    }
    
    .card-body {
        padding: 15px !important;
    }
    
    /* Table styles */
    .print-table {
        width: 100% !important;
        border-collapse: collapse !important;
        font-size: 11px !important;
        page-break-inside: auto !important; /* Allow break di dalam tabel kalo kepanjangan */
    }
    
    .print-table thead {
        display: table-header-group !important; /* Repeat header di setiap halaman */
    }
    
    .print-table tbody {
        display: table-row-group !important;
    }
    
    .print-table tr {
        page-break-inside: avoid !important; /* Jangan potong row di tengah */
        page-break-after: auto !important;
    }
    
    .print-table th,
    .print-table td {
        border: 1px solid #000 !important;
        padding: 8px 10px !important;
        text-align: left !important;
    }
    
    .print-table th {
        background-color: #e5e7eb !important;
        font-weight: bold !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    
    .print-table tbody tr:nth-child(even) {
        background-color: #f9fafb !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    
    /* Badge styles */
    .badge {
        padding: 3px 8px !important;
        border-radius: 3px !important;
        font-size: 10px !important;
        font-weight: bold !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    
    .badge-success {
        background-color: #d1fae5 !important;
        color: #065f46 !important;
        border: 1px solid #065f46 !important;
    }
    
    .badge-warning {
        background-color: #fef3c7 !important;
        color: #92400e !important;
        border: 1px solid #92400e !important;
    }
    
    .badge-danger {
        background-color: #fee2e2 !important;
        color: #991b1b !important;
        border: 1px solid #991b1b !important;
    }
    
    /* Page break */
    .page-break {
        page-break-before: always;
    }
    
    /* Prevent orphan/widow */
    h3, .card-header {
        page-break-after: avoid !important;
    }
    
    /* Text alignment */
    .text-center {
        text-align: center !important;
    }
}

/* Hide print header on screen */
.print-header {
    display: none;
}
</style>