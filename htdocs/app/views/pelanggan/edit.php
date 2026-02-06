<div class="main-content">
    <div class="topbar">
        <div class="topbar-left">
            <h4><i class="fas fa-edit"></i> Edit Pelanggan</h4>
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
                    <i class="fas fa-user-edit"></i> Form Edit Pelanggan
                </h3>
            </div>

            <div class="card-body">
                <form method="POST" action="<?= BASE_URL ?>pelanggan/edit/<?= $pelanggan['id'] ?>">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Kode Pelanggan</label>
                            <input type="text" name="kode_pelanggan" class="form-control"
                                value="<?= $pelanggan['kode_pelanggan'] ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nama Lengkap *</label>
                            <input type="text" name="nama_lengkap" class="form-control"
                                value="<?= $pelanggan['nama_lengkap'] ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">NIK *</label>
                            <input type="text" name="nik" class="form-control" value="<?= $pelanggan['nik'] ?>"
                                maxlength="16" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">No. Telepon *</label>
                            <input type="text" name="no_telepon" class="form-control"
                                value="<?= $pelanggan['no_telepon'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Alamat Lengkap *</label>
                        <textarea name="alamat" class="form-control" rows="3"
                            required><?= $pelanggan['alamat'] ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= $pelanggan['email'] ?>">
                    </div>

                    <div style="margin-top: 30px; display: flex; gap: 10px;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="<?= BASE_URL ?>pelanggan" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>