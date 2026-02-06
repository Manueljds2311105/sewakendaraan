<div class="main-content">
    <div class="topbar">
        <div class="topbar-left">
            <h4><i class="fas fa-home"></i> Dashboard</h4>
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
        <?php
        $flash = $this->getFlash();
        if ($flash):
            ?>
            <div class="alert alert-<?= $flash['type'] ?>">
                <i class="fas fa-<?= $flash['type'] == 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
                <?= $flash['message'] ?>
            </div>
        <?php endif; ?>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-car"></i>
                </div>
                <div class="stat-content">
                    <h3><?= $stats['total_kendaraan'] ?></h3>
                    <p>Total Kendaraan</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3><?= $stats['kendaraan_tersedia'] ?></h3>
                    <p>Kendaraan Tersedia</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h3><?= $stats['kendaraan_disewa'] ?></h3>
                    <p>Sedang Disewa</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon info">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3><?= $stats['total_pelanggan'] ?></h3>
                    <p>Total Pelanggan</p>
                </div>
            </div>
        </div>

        <!-- Welcome Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Selamat Datang!
                </h3>
            </div>
            <div class="card-body">
                <p>Selamat datang di <strong>Sistem Manajemen Sewa Kendaraan</strong>. Anda login sebagai
                    <strong><?= isset($_SESSION['role']) ? ucfirst($_SESSION['role']) : 'User' ?></strong>.</p>
                <p>Sistem ini membantu Anda mengelola data kendaraan, pelanggan, dan transaksi sewa dengan mudah dan
                    efisien.</p>
            </div>
        </div>

        <!-- Active Transactions -->
        <?php if (isset($transaksi_aktif) && !empty($transaksi_aktif)): ?>
            <div class="card">
                <div class="card-header d-flex justify-between align-center">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i> Transaksi Aktif
                    </h3>
                    <span class="badge badge-warning"><?= count($transaksi_aktif) ?> Transaksi</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Pelanggan</th>
                                    <th>Kendaraan</th>
                                    <th>Tanggal Sewa</th>
                                    <th>Harus Kembali</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transaksi_aktif as $t): ?>
                                    <tr>
                                        <td><?= $t['kode_transaksi'] ?></td>
                                        <td><?= $t['nama_pelanggan'] ?></td>
                                        <td><?= $t['nama_kendaraan'] ?> (<?= $t['plat_nomor'] ?>)</td>
                                        <td><?= date('d/m/Y', strtotime($t['tanggal_sewa'])) ?></td>
                                        <td><?= date('d/m/Y', strtotime($t['tanggal_kembali_rencana'])) ?></td>
                                        <td>
                                            <?php if ($t['hari_terlambat'] > 0): ?>
                                                <span class="badge badge-danger">Terlambat <?= $t['hari_terlambat'] ?> hari</span>
                                            <?php else: ?>
                                                <span class="badge badge-success">Aktif</span>
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

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bolt"></i> Quick Actions
                </h3>
            </div>
            <div class="card-body">
                <div class="d-flex gap-2" style="flex-wrap: wrap;">
                    <a href="<?= BASE_URL ?>transaksi/create" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Transaksi Baru
                    </a>
                    <a href="<?= BASE_URL ?>kendaraan" class="btn btn-info">
                        <i class="fas fa-car"></i> Lihat Kendaraan
                    </a>
                    <a href="<?= BASE_URL ?>pelanggan" class="btn btn-success">
                        <i class="fas fa-users"></i> Lihat Pelanggan
                    </a>
                    <a href="<?= BASE_URL ?>laporan" class="btn btn-warning">
                        <i class="fas fa-chart-bar"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>