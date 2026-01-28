<?php
class LaporanController extends Controller {
    
    public function index() {
        $this->checkAuth();
        
        $transaksiModel = $this->model('Transaksi');
        $dendaModel = $this->model('Denda');
        
        // Default date range (current month)
        $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
        $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
        
        $data = [
            'title' => 'Laporan',
            'active' => 'laporan',
            'role' => $_SESSION['role'] ?? 'user',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'transaksi' => $transaksiModel->getLaporanByDate($startDate, $endDate),
            'transaksi_aktif' => $transaksiModel->getTransaksiAktif(),
            'denda' => $dendaModel->getAllDenda()
        ];
        
        $this->view('layouts/header', $data);
        $this->view('layouts/sidebar', $data);
        $this->view('laporan/index', $data);
        $this->view('layouts/footer');
    }
}
?>