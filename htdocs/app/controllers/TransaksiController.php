<?php
class TransaksiController extends Controller {
    
    public function index() {
        $this->checkAuth();
        
        $transaksiModel = $this->model('Transaksi');
        
        // Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        // Filter
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $status = isset($_GET['status']) ? $_GET['status'] : '';
        
        $totalData = $transaksiModel->countTransaksi($search, $status);
        $totalPages = ceil($totalData / $limit);
        
        $data = [
            'title' => 'Data Transaksi',
            'active' => 'transaksi',
            'role' => $_SESSION['role'] ?? 'user',
            'transaksi' => $transaksiModel->getAllTransaksi($search, $status, $limit, $offset),
            'page' => $page,
            'totalPages' => $totalPages,
            'search' => $search,
            'status' => $status
        ];
        
        $this->view('layouts/header', $data);
        $this->view('layouts/sidebar', $data);
        $this->view('transaksi/index', $data);
        $this->view('layouts/footer');
    }
    
    public function create() {
        $this->checkAuth();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $transaksiModel = $this->model('Transaksi');
            
            // Calculate dates
            $tanggalSewa = $_POST['tanggal_sewa'];
            $lamaSewa = $_POST['lama_sewa'];
            $tanggalKembali = date('Y-m-d', strtotime($tanggalSewa . " + $lamaSewa days"));
            
            $data = [
                'kode_transaksi' => $transaksiModel->generateKodeTransaksi(),
                'id_pelanggan' => $_POST['id_pelanggan'],
                'id_kendaraan' => $_POST['id_kendaraan'],
                'tanggal_sewa' => $tanggalSewa,
                'tanggal_kembali_rencana' => $tanggalKembali,
                'lama_sewa' => $lamaSewa,
                'total_biaya' => str_replace(['.', ','], '', $_POST['total_biaya']),
                'status' => 'aktif',
                'catatan' => $_POST['catatan'] ?? '',
                'created_by' => $_SESSION['user_id']
            ];
            
            if($transaksiModel->createTransaksi($data)) {
                $this->setFlash('success', 'Transaksi sewa berhasil dibuat!');
                $this->redirect('transaksi');
            } else {
                $this->setFlash('danger', 'Gagal membuat transaksi sewa!');
            }
        }
        
        $transaksiModel = $this->model('Transaksi');
        $pelangganModel = $this->model('Pelanggan');
        $kendaraanModel = $this->model('Kendaraan');
        
        $data = [
            'title' => 'Transaksi Sewa Baru',
            'active' => 'transaksi',
            'role' => $_SESSION['role'] ?? 'user',
            'kode' => $transaksiModel->generateKodeTransaksi(),
            'pelanggan' => $pelangganModel->getAllPelanggan('', 1000, 0),
            'kendaraan' => $kendaraanModel->getKendaraanTersedia()
        ];
        
        $this->view('layouts/header', $data);
        $this->view('layouts/sidebar', $data);
        $this->view('transaksi/create', $data);
        $this->view('layouts/footer');
    }
    
    public function detail($id) {
        $this->checkAuth();
        
        $transaksiModel = $this->model('Transaksi');
        $dendaModel = $this->model('Denda');
        
        $data = [
            'title' => 'Detail Transaksi',
            'active' => 'transaksi',
            'role' => $_SESSION['role'] ?? 'user',
            'transaksi' => $transaksiModel->getTransaksiById($id),
            'denda' => $dendaModel->getDendaByTransaksi($id)
        ];
        
        $this->view('layouts/header', $data);
        $this->view('layouts/sidebar', $data);
        $this->view('transaksi/detail', $data);
        $this->view('layouts/footer');
    }
    
    public function pengembalian($id) {
        $this->checkAuth();
        
        $transaksiModel = $this->model('Transaksi');
        $transaksi = $transaksiModel->getTransaksiById($id);
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tanggalKembali = $_POST['tanggal_kembali_aktual'];
            
            // Calculate denda
            $denda = 0;
            $hariTerlambat = (strtotime($tanggalKembali) - strtotime($transaksi['tanggal_kembali_rencana'])) / (60 * 60 * 24);
            
            if($hariTerlambat > 0) {
                $dendaModel = $this->model('Denda');
                $dendaCalc = $dendaModel->calculateDenda($transaksi['harga_sewa_perhari'], $hariTerlambat);
                $denda = $dendaCalc['total_denda'];
            }
            
            if($transaksiModel->prosesKembali($id, $tanggalKembali, $denda)) {
                $this->setFlash('success', 'Pengembalian kendaraan berhasil diproses!');
                $this->redirect('transaksi');
            } else {
                $this->setFlash('danger', 'Gagal memproses pengembalian!');
            }
        }
        
        $data = [
            'title' => 'Pengembalian Kendaraan',
            'active' => 'transaksi',
            'role' => $_SESSION['role'] ?? 'user',
            'transaksi' => $transaksi
        ];
        
        $this->view('layouts/header', $data);
        $this->view('layouts/sidebar', $data);
        $this->view('transaksi/pengembalian', $data);
        $this->view('layouts/footer');
    }
}
?>