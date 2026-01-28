<?php
class DashboardController extends Controller {
    
    public function index() {
        $this->checkAuth();
        
        // Load models
        $kendaraanModel = $this->model('Kendaraan');
        $pelangganModel = $this->model('Pelanggan');
        $transaksiModel = $this->model('Transaksi');
        
        // Get statistics
        $statusCount = $kendaraanModel->countByStatus();
        
        $data = [
            'title' => 'Dashboard',
            'active' => 'dashboard',
            'role' => $_SESSION['role'] ?? 'user',
            'stats' => [
                'total_kendaraan' => $kendaraanModel->countKendaraan(),
                'kendaraan_tersedia' => $statusCount['tersedia'] ?? 0,
                'kendaraan_disewa' => $statusCount['disewa'] ?? 0,
                'total_pelanggan' => $pelangganModel->countPelanggan(),
                'transaksi_aktif' => $transaksiModel->countTransaksi('', 'aktif'),
                'transaksi_selesai' => $transaksiModel->countTransaksi('', 'selesai')
            ],
            'transaksi_aktif' => $transaksiModel->getTransaksiAktif()
        ];
        
        $this->view('layouts/header', $data);
        $this->view('layouts/sidebar', $data);
        $this->view('dashboard/index', $data);
        $this->view('layouts/footer');
    }
}
?>