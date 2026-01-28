<aside class="sidebar">
    <div class="sidebar-header">
        <h3><i class="fas fa-car"></i> Rental Kendaraan</h3>
        <p>Sistem Manajemen Sewa Kendaraan</p>
    </div>
    
    <ul class="sidebar-menu">
        <li class="menu-item">
            <a href="<?= BASE_URL ?>dashboard" class="menu-link <?= (isset($active) && $active == 'dashboard') ? 'active' : '' ?>">
                <i class="fas fa-home menu-icon"></i>
                <span>Dashboard</span>
            </a>
        </li>
        
        <li class="menu-item">
            <a href="<?= BASE_URL ?>kendaraan" class="menu-link <?= (isset($active) && $active == 'kendaraan') ? 'active' : '' ?>">
                <i class="fas fa-car menu-icon"></i>
                <span>Data Kendaraan</span>
            </a>
        </li>
        
        <li class="menu-item">
            <a href="<?= BASE_URL ?>pelanggan" class="menu-link <?= (isset($active) && $active == 'pelanggan') ? 'active' : '' ?>">
                <i class="fas fa-users menu-icon"></i>
                <span>Data Pelanggan</span>
            </a>
        </li>
        
        <li class="menu-item">
            <a href="<?= BASE_URL ?>transaksi" class="menu-link <?= (isset($active) && $active == 'transaksi') ? 'active' : '' ?>">
                <i class="fas fa-exchange-alt menu-icon"></i>
                <span>Transaksi Sewa</span>
            </a>
        </li>
        
        <li class="menu-item">
            <a href="<?= BASE_URL ?>laporan" class="menu-link <?= (isset($active) && $active == 'laporan') ? 'active' : '' ?>">
                <i class="fas fa-chart-bar menu-icon"></i>
                <span>Laporan</span>
            </a>
        </li>
        
        <li class="menu-item" style="margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
            <a href="<?= BASE_URL ?>auth/logout" class="menu-link" onclick="return confirm('Yakin ingin logout?')">
                <i class="fas fa-sign-out-alt menu-icon"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</aside>