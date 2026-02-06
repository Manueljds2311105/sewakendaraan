<div class="main-content">
    <div class="topbar">
        <div class="topbar-left">
            <h4><i class="fas fa-users"></i> Data Pelanggan</h4>
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

        <div class="card">
            <div class="card-header d-flex justify-between align-center">
                <h3 class="card-title">
                    <i class="fas fa-list"></i> Daftar Pelanggan
                </h3>
                <!-- Admin & User bisa tambah pelanggan (staff input data customer yang datang) -->
                <a href="<?= BASE_URL ?>pelanggan/create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Pelanggan
                </a>
            </div>

            <div class="card-body">
                <!-- Filter Section -->
                <form method="GET" action="<?= BASE_URL ?>pelanggan">
                    <div class="filter-section">
                        <div class="search-box">
                            <input type="text" name="search" placeholder="Cari nama/NIK/telepon..."
                                value="<?= $search ?>" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-search"></i> Cari
                        </button>

                        <a href="<?= BASE_URL ?>pelanggan" class="btn btn-secondary">
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
                                <th>Nama Lengkap</th>
                                <th>NIK</th>
                                <th>Alamat</th>
                                <th>No. Telepon</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($pelanggan)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data pelanggan</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($pelanggan as $p): ?>
                                    <tr>
                                        <td><?= $p['kode_pelanggan'] ?></td>
                                        <td><strong><?= $p['nama_lengkap'] ?></strong></td>
                                        <td><?= $p['nik'] ?></td>
                                        <td><?= $p['alamat'] ?></td>
                                        <td><?= $p['no_telepon'] ?></td>
                                        <td><?= $p['email'] ?></td>
                                        <td>
                                            <!-- Admin & User bisa edit pelanggan -->
                                            <a href="<?= BASE_URL ?>pelanggan/edit/<?= $p['id'] ?>"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- HANYA Admin yang bisa hapus pelanggan -->
                                            <?php if ($_SESSION['role'] == 'admin'): ?>
                                                <a href="<?= BASE_URL ?>pelanggan/delete/<?= $p['id'] ?>"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus pelanggan <?= $p['nama_lengkap'] ?>?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            <?php else: ?>
                                                <button class="btn btn-sm btn-secondary" disabled
                                                    title="Hanya admin yang bisa hapus">
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="<?= BASE_URL ?>pelanggan?page=<?= $page - 1 ?>&search=<?= $search ?>">
                                <i class="fas fa-chevron-left"></i> Prev
                            </a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <?php if ($i == $page): ?>
                                <span class="active"><?= $i ?></span>
                            <?php else: ?>
                                <a href="<?= BASE_URL ?>pelanggan?page=<?= $i ?>&search=<?= $search ?>">
                                    <?= $i ?>
                                </a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <a href="<?= BASE_URL ?>pelanggan?page=<?= $page + 1 ?>&search=<?= $search ?>">
                                Next <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>