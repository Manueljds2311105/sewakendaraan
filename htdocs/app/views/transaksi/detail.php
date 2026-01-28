<div class="main-content">
    <div class="topbar">
        <div class="topbar-left">
            <h4><i class="fas fa-file-invoice"></i> Detail Transaksi</h4>
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
        if ($flash):
            ?>
            <div class="alert alert-<?= $flash['type'] ?>">
                <i class="fas fa-<?= $flash['type'] == 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
                <?= $flash['message'] ?>
            </div>
        <?php endif; ?>

        <!-- Header Card -->
        <div class="card">
            <div class="card-header d-flex justify-between align-center">
                <h3 class="card-title">
                    <i class="fas fa-receipt"></i> <?= $transaksi['kode_transaksi'] ?>
                </h3>
                <div>
                    <?php if ($transaksi['status'] == 'aktif'): ?>
                        <span class="badge badge-warning">Status: Aktif</span>
                    <?php elseif ($transaksi['status'] == 'selesai'): ?>
                        <span class="badge badge-success">Status: Selesai</span>
                    <?php else: ?>
                        <span class="badge badge-danger">Status: Batal</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Informasi Pelanggan -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user"></i> Informasi Pelanggan
                </h3>
            </div>
            <div class="card-body">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td style="width: 200px; padding: 10px 0; border: none;"><strong>Nama Lengkap</strong></td>
                        <td style="padding: 10px 0; border: none;">: <?= $transaksi['nama_pelanggan'] ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; border: none;"><strong>No. Telepon</strong></td>
                        <td style="padding: 10px 0; border: none;">: <?= $transaksi['no_telepon'] ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; border: none;"><strong>Alamat</strong></td>
                        <td style="padding: 10px 0; border: none;">: <?= $transaksi['alamat'] ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Informasi Kendaraan -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-car"></i> Informasi Kendaraan
                </h3>
            </div>
            <div class="card-body">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td style="width: 200px; padding: 10px 0; border: none;"><strong>Nama Kendaraan</strong></td>
                        <td style="padding: 10px 0; border: none;">: <?= $transaksi['nama_kendaraan'] ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; border: none;"><strong>Plat Nomor</strong></td>
                        <td style="padding: 10px 0; border: none;">: <?= $transaksi['plat_nomor'] ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; border: none;"><strong>Harga Sewa</strong></td>
                        <td style="padding: 10px 0; border: none;">: Rp
                            <?= number_format($transaksi['harga_sewa_perhari'], 0, ',', '.') ?> / hari</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Detail Transaksi -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i> Detail Transaksi
                </h3>
            </div>
            <div class="card-body">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td style="width: 200px; padding: 10px 0; border: none;"><strong>Tanggal Sewa</strong></td>
                        <td style="padding: 10px 0; border: none;">:
                            <?= date('d F Y', strtotime($transaksi['tanggal_sewa'])) ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; border: none;"><strong>Tanggal Kembali (Rencana)</strong></td>
                        <td style="padding: 10px 0; border: none;">:
                            <?= date('d F Y', strtotime($transaksi['tanggal_kembali_rencana'])) ?></td>
                    </tr>
                    <?php if ($transaksi['tanggal_kembali_aktual']): ?>
                        <tr>
                            <td style="padding: 10px 0; border: none;"><strong>Tanggal Kembali (Aktual)</strong></td>
                            <td style="padding: 10px 0; border: none;">:
                                <?= date('d F Y', strtotime($transaksi['tanggal_kembali_aktual'])) ?></td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td style="padding: 10px 0; border: none;"><strong>Lama Sewa</strong></td>
                        <td style="padding: 10px 0; border: none;">: <?= $transaksi['lama_sewa'] ?> hari</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; border: none;"><strong>Total Biaya Sewa</strong></td>
                        <td style="padding: 10px 0; border: none;">
                            : <strong style="color: var(--primary-color);">Rp
                                <?= number_format($transaksi['total_biaya'], 0, ',', '.') ?></strong>
                        </td>
                    </tr>
                    <?php if ($transaksi['denda'] > 0): ?>
                        <tr>
                            <td style="padding: 10px 0; border: none;"><strong>Denda Keterlambatan</strong></td>
                            <td style="padding: 10px 0; border: none;">
                                : <strong style="color: var(--danger-color);">Rp
                                    <?= number_format($transaksi['denda'], 0, ',', '.') ?></strong>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($transaksi['catatan']): ?>
                        <tr>
                            <td style="padding: 10px 0; border: none;"><strong>Catatan</strong></td>
                            <td style="padding: 10px 0; border: none;">: <?= $transaksi['catatan'] ?></td>
                        </tr>
                    <?php endif; ?>
                </table>

                <!-- Grand Total -->
                <?php
                $grandTotal = $transaksi['total_biaya'] + $transaksi['denda'];
                if ($transaksi['denda'] > 0):
                    ?>
                    <div
                        style="margin-top: 20px; padding: 15px; background: #f3f4f6; border-radius: 8px; border-left: 4px solid var(--primary-color);">
                        <table style="width: 100%; border: none;">
                            <tr>
                                <td style="width: 200px; border: none; font-size: 18px;"><strong>GRAND TOTAL</strong></td>
                                <td style="border: none; font-size: 18px;">
                                    : <strong style="color: var(--primary-color);">Rp
                                        <?= number_format($grandTotal, 0, ',', '.') ?></strong>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Informasi Denda (Jika Ada) -->
        <?php if (isset($denda) && $denda): ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-exclamation-triangle"></i> Detail Denda
                    </h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle"></i> Kendaraan dikembalikan terlambat
                    </div>
                    <table style="width: 100%; border: none;">
                        <tr>
                            <td style="width: 200px; padding: 10px 0; border: none;"><strong>Jumlah Hari Terlambat</strong>
                            </td>
                            <td style="padding: 10px 0; border: none;">: <?= $denda['jumlah_hari_terlambat'] ?> hari</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0; border: none;"><strong>Tarif Denda</strong></td>
                            <td style="padding: 10px 0; border: none;">: Rp
                                <?= number_format($denda['tarif_denda_perhari'], 0, ',', '.') ?> / hari</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0; border: none;"><strong>Total Denda</strong></td>
                            <td style="padding: 10px 0; border: none;">
                                : <strong style="color: var(--danger-color);">Rp
                                    <?= number_format($denda['total_denda'], 0, ',', '.') ?></strong>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0; border: none;"><strong>Keterangan</strong></td>
                            <td style="padding: 10px 0; border: none;">: <?= $denda['keterangan'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        <?php endif; ?>

        <!-- Action Buttons -->
        <div class="card">
            <div class="card-body">
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="<?= BASE_URL ?>transaksi" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>

                    <?php if ($transaksi['status'] == 'aktif'): ?>
                        <a href="<?= BASE_URL ?>transaksi/pengembalian/<?= $transaksi['id'] ?>" class="btn btn-success">
                            <i class="fas fa-undo"></i> Proses Pengembalian
                        </a>
                    <?php endif; ?>

                    <button onclick="window.print()" class="btn btn-info">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
    @media print {

        .sidebar,
        .topbar,
        .btn,
        .alert {
            display: none !important;
        }

        .main-content {
            margin-left: 0 !important;
            width: 100% !important;
        }

        .card {
            box-shadow: none !important;
            page-break-inside: avoid;
        }

        .card-header {
            background: #f3f4f6 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>