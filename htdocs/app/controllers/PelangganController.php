<?php
class PelangganController extends Controller {
    
    public function index() {
        $this->checkAuth();
        
        $pelangganModel = $this->model('Pelanggan');
        
        // Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        // Filter
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        
        $totalData = $pelangganModel->countPelanggan($search);
        $totalPages = ceil($totalData / $limit);
        
        $data = [
            'title' => 'Data Pelanggan',
            'active' => 'pelanggan',
            'role' => $_SESSION['role'] ?? 'user',
            'pelanggan' => $pelangganModel->getAllPelanggan($search, $limit, $offset),
            'page' => $page,
            'totalPages' => $totalPages,
            'search' => $search
        ];
        
        $this->view('layouts/header', $data);
        $this->view('layouts/sidebar', $data);
        $this->view('pelanggan/index', $data);
        $this->view('layouts/footer');
    }
    
    public function create() {
        $this->checkAuth();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pelangganModel = $this->model('Pelanggan');
            
            $data = [
                'kode_pelanggan' => $pelangganModel->generateKodePelanggan(),
                'nama_lengkap' => $_POST['nama_lengkap'],
                'nik' => $_POST['nik'],
                'alamat' => $_POST['alamat'],
                'no_telepon' => $_POST['no_telepon'],
                'email' => $_POST['email']
            ];
            
            if($pelangganModel->createPelanggan($data)) {
                $this->setFlash('success', 'Data pelanggan berhasil ditambahkan!');
                $this->redirect('pelanggan');
            } else {
                $this->setFlash('danger', 'Gagal menambahkan data pelanggan!');
            }
        }
        
        $pelangganModel = $this->model('Pelanggan');
        $data = [
            'title' => 'Tambah Pelanggan',
            'active' => 'pelanggan',
            'role' => $_SESSION['role'] ?? 'user',
            'kode' => $pelangganModel->generateKodePelanggan()
        ];
        
        $this->view('layouts/header', $data);
        $this->view('layouts/sidebar', $data);
        $this->view('pelanggan/create', $data);
        $this->view('layouts/footer');
    }
    
    public function edit($id) {
        $this->checkAuth();
        
        $pelangganModel = $this->model('Pelanggan');
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'kode_pelanggan' => $_POST['kode_pelanggan'],
                'nama_lengkap' => $_POST['nama_lengkap'],
                'nik' => $_POST['nik'],
                'alamat' => $_POST['alamat'],
                'no_telepon' => $_POST['no_telepon'],
                'email' => $_POST['email']
            ];
            
            if($pelangganModel->updatePelanggan($id, $data)) {
                $this->setFlash('success', 'Data pelanggan berhasil diupdate!');
                $this->redirect('pelanggan');
            } else {
                $this->setFlash('danger', 'Gagal mengupdate data pelanggan!');
            }
        }
        
        $data = [
            'title' => 'Edit Pelanggan',
            'active' => 'pelanggan',
            'role' => $_SESSION['role'] ?? 'user',
            'pelanggan' => $pelangganModel->getPelangganById($id)
        ];
        
        $this->view('layouts/header', $data);
        $this->view('layouts/sidebar', $data);
        $this->view('pelanggan/edit', $data);
        $this->view('layouts/footer');
    }
    
    public function delete($id) {
        $this->checkAdmin(); // Hanya admin yang bisa hapus pelanggan
        
        $pelangganModel = $this->model('Pelanggan');
        
        if($pelangganModel->deletePelanggan($id)) {
            $this->setFlash('success', 'Data pelanggan berhasil dihapus!');
        } else {
            $this->setFlash('danger', 'Gagal menghapus data pelanggan!');
        }
        
        $this->redirect('pelanggan');
    }
}
?>