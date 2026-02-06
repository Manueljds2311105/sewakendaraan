<div class="main-content">
    <div class="topbar">
        <div class="topbar-left">
            <h4><i class="fas fa-exchange-alt"></i> Transaksi Sewa</h4>
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
        <div class="alert alert-<?= $flash['type'] ?>">
            <i class="fas fa-<?= $flash['type'] == 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
            <?= $flash['message'] ?>
        </div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-header d-flex justify-between align-center">
                <h3 class="card-title">
                    <i class="fas fa-list"></i> Daftar Transaksi Sewa
                </h3>
                <a href="<?= BASE_URL ?>transaksi/create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Transaksi Baru
                </a>
            </div>
            
            <div class="card-body">
                <!-- Filter Section -->
                <form method="GET" action="<?= BASE_URL ?>transaksi">
                    <div class="filter-section">
                        <div class="search-box">
                            <input type="text" 
                                   name="search" 
                                   placeholder="Cari kode/pelanggan..." 
                                   value="<?= $search ?>"
                                   class="form-control">
                        </div>
                        
                        <div class="filter-box">
                            <select name="status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="aktif" <?= $status == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="selesai" <?= $status == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                                <option value="batal" <?= $status == 'batal' ? 'selected' : '' ?>>Batal</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        
                        <a href="<?= BASE_URL ?>transaksi" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </form>
                
                <!-- Table -->
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Pelanggan</th>
                                <th>Kendaraan</th>
                                <th>Tanggal Sewa</th>
                                <th>Tanggal Kembali</th>
                                <th>Total Biaya</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($transaksi)): ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data transaksi</td>
                            </tr>
                            <?php else: ?>
                                <?php foreach($transaksi as $t): ?>
                                <tr>
                                    <td><?= $t['kode_transaksi'] ?></td>
                                    <td><strong><?= $t['nama_pelanggan'] ?></strong></td>
                                    <td>
                                        <?= $t['nama_kendaraan'] ?><br>
                                        <small><?= $t['plat_nomor'] ?></small>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($t['tanggal_sewa'])) ?></td>
                                    <td><?= date('d/m/Y', strtotime($t['tanggal_kembali_rencana'])) ?></td>
                                    <td>Rp <?= number_format($t['total_biaya'], 0, ',', '.') ?></td>
                                    <td>
                                        <?php
                                        $badgeClass = '';
                                        switch($t['status']) {
                                            case 'aktif': $badgeClass = 'badge-warning'; break;
                                            case 'selesai': $badgeClass = 'badge-success'; break;
                                            case 'batal': $badgeClass = 'badge-danger'; break;
                                        }
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= ucfirst($t['status']) ?></span>
                                    </td>
                                    <td>
                                        <a href="<?= BASE_URL ?>transaksi/detail/<?= $t['id'] ?>" class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php if($t['status'] == 'aktif'): ?>
                                        <a href="<?= BASE_URL ?>transaksi/pengembalian/<?= $t['id'] ?>" class="btn btn-sm btn-success" title="Pengembalian">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <?php if($totalPages > 1): ?>
                <div class="pagination">
                    <?php if($page > 1): ?>
                    <a href="<?= BASE_URL ?>transaksi?page=<?= $page - 1 ?>&search=<?= $search ?>&status=<?= $status ?>">
                        <i class="fas fa-chevron-left"></i> Prev
                    </a>
                    <?php endif; ?>
                    
                    <?php for($i = 1; $i <= $totalPages; $i++): ?>
                        <?php if($i == $page): ?>
                            <span class="active"><?= $i ?></span>
                        <?php else: ?>
                            <a href="<?= BASE_URL ?>transaksi?page=<?= $i ?>&search=<?= $search ?>&status=<?= $status ?>">
                                <?= $i ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <?php if($page < $totalPages): ?>
                    <a href="<?= BASE_URL ?>transaksi?page=<?= $page + 1 ?>&search=<?= $search ?>&status=<?= $status ?>">
                        Next <i class="fas fa-chevron-right"></i>
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>