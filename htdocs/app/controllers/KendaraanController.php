<?php
class KendaraanController extends Controller {
    
    public function index() {
        $this->checkAuth();
        
        $kendaraanModel = $this->model('Kendaraan');
        
        // Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        // Filter
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $jenis = isset($_GET['jenis']) ? $_GET['jenis'] : '';
        $status = isset($_GET['status']) ? $_GET['status'] : '';
        
        $totalData = $kendaraanModel->countKendaraan($search, $jenis, $status);
        $totalPages = ceil($totalData / $limit);
        
        $data = [
            'title' => 'Data Kendaraan',
            'active' => 'kendaraan',
            'role' => $_SESSION['role'] ?? 'user',
            'kendaraan' => $kendaraanModel->getAllKendaraan($search, $jenis, $status, $limit, $offset),
            'page' => $page,
            'totalPages' => $totalPages,
            'search' => $search,
            'jenis' => $jenis,
            'status' => $status
        ];
        
        $this->view('layouts/header', $data);
        $this->view('layouts/sidebar', $data);
        $this->view('kendaraan/index', $data);
        $this->view('layouts/footer');
    }
    
    public function create() {
        $this->checkAdmin();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $kendaraanModel = $this->model('Kendaraan');
            
            // Handle file upload dengan error handling lengkap
            $foto = '';
            $uploadError = '';
            
            if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                // Validasi tipe file
                $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                $fileType = $_FILES['foto']['type'];
                
                if(!in_array($fileType, $allowedTypes)) {
                    $uploadError = 'Format file tidak didukung. Gunakan JPG, PNG, atau GIF.';
                } else {
                    // Validasi ukuran file (max 2MB)
                    $maxSize = 2 * 1024 * 1024; // 2MB
                    if($_FILES['foto']['size'] > $maxSize) {
                        $uploadError = 'Ukuran file terlalu besar. Maksimal 2MB.';
                    } else {
                        // Path relatif untuk InfinityFree (assets langsung di htdocs)
                        $targetDir = __DIR__ . '/../../assets/images/';
                        
                        // Buat folder jika belum ada
                        if(!is_dir($targetDir)) {
                            mkdir($targetDir, 0755, true);
                        }
                        
                        // Generate nama file unik
                        $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                        $fileName = 'kendaraan_' . time() . '_' . uniqid() . '.' . $extension;
                        $targetFile = $targetDir . $fileName;
                        
                        // Upload file
                        if(move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
                            $foto = $fileName;
                        } else {
                            $uploadError = 'Gagal mengupload file. Periksa permission folder.';
                        }
                    }
                }
            }
            
            // Jika ada error upload, tampilkan pesan
            if(!empty($uploadError)) {
                $this->setFlash('danger', $uploadError);
                // Redirect kembali ke form dengan error
                $this->redirect('kendaraan/create');
                return;
            }
            
            $data = [
                'kode_kendaraan' => $kendaraanModel->generateKodeKendaraan(),
                'nama_kendaraan' => $_POST['nama_kendaraan'],
                'jenis' => $_POST['jenis'],
                'merk' => $_POST['merk'],
                'tahun_produksi' => $_POST['tahun_produksi'],
                'plat_nomor' => $_POST['plat_nomor'],
                'warna' => $_POST['warna'],
                'harga_sewa_perhari' => str_replace(['.', ','], '', $_POST['harga_sewa_perhari']),
                'status' => $_POST['status'],
                'foto' => $foto
            ];
            
            if($kendaraanModel->createKendaraan($data)) {
                $this->setFlash('success', 'Data kendaraan berhasil ditambahkan!');
                $this->redirect('kendaraan');
            } else {
                $this->setFlash('danger', 'Gagal menambahkan data kendaraan!');
            }
        }
        
        $kendaraanModel = $this->model('Kendaraan');
        $data = [
            'title' => 'Tambah Kendaraan',
            'active' => 'kendaraan',
            'kode' => $kendaraanModel->generateKodeKendaraan()
        ];
        
        $this->view('layouts/header', $data);
        $this->view('layouts/sidebar', $data);
        $this->view('kendaraan/create', $data);
        $this->view('layouts/footer');
    }
    
    public function detail($id) {
        $this->checkAuth();
        
        $kendaraanModel = $this->model('Kendaraan');
        
        $data = [
            'title' => 'Detail Kendaraan',
            'active' => 'kendaraan',
            'role' => $_SESSION['role'] ?? 'user',
            'kendaraan' => $kendaraanModel->getKendaraanById($id)
        ];
        
        $this->view('layouts/header', $data);
        $this->view('layouts/sidebar', $data);
        $this->view('kendaraan/detail', $data);
        $this->view('layouts/footer');
    }
    
    public function edit($id) {
        $this->checkAdmin();
        
        $kendaraanModel = $this->model('Kendaraan');
        
        // Ambil parameter dari URL untuk redirect nanti
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $jenis = isset($_GET['jenis']) ? $_GET['jenis'] : '';
        $status = isset($_GET['status']) ? $_GET['status'] : '';
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $kendaraan = $kendaraanModel->getKendaraanById($id);
            $foto = $kendaraan['foto'];
            
            // Handle file upload dengan error handling
            $uploadError = '';
            
            if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                // Validasi tipe file
                $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                $fileType = $_FILES['foto']['type'];
                
                if(!in_array($fileType, $allowedTypes)) {
                    $uploadError = 'Format file tidak didukung. Gunakan JPG, PNG, atau GIF.';
                } else {
                    // Validasi ukuran file (max 2MB)
                    $maxSize = 2 * 1024 * 1024;
                    if($_FILES['foto']['size'] > $maxSize) {
                        $uploadError = 'Ukuran file terlalu besar. Maksimal 2MB.';
                    } else {
                        // Path relatif untuk InfinityFree
                        $targetDir = __DIR__ . '/../../assets/images/';
                        
                        // Buat folder jika belum ada
                        if(!is_dir($targetDir)) {
                            mkdir($targetDir, 0755, true);
                        }
                        
                        // Generate nama file unik
                        $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                        $fileName = 'kendaraan_' . time() . '_' . uniqid() . '.' . $extension;
                        $targetFile = $targetDir . $fileName;
                        
                        if(move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
                            // Hapus foto lama jika ada
                            if(!empty($kendaraan['foto']) && file_exists($targetDir . $kendaraan['foto'])) {
                                unlink($targetDir . $kendaraan['foto']);
                            }
                            $foto = $fileName;
                        } else {
                            $uploadError = 'Gagal mengupload file.';
                        }
                    }
                }
            }
            
            if(!empty($uploadError)) {
                $this->setFlash('danger', $uploadError);
                $this->redirect('kendaraan/edit/' . $id . '?page=' . $page . '&search=' . $search . '&jenis=' . $jenis . '&status=' . $status);
                return;
            }
            
            $data = [
                'kode_kendaraan' => $_POST['kode_kendaraan'],
                'nama_kendaraan' => $_POST['nama_kendaraan'],
                'jenis' => $_POST['jenis'],
                'merk' => $_POST['merk'],
                'tahun_produksi' => $_POST['tahun_produksi'],
                'plat_nomor' => $_POST['plat_nomor'],
                'warna' => $_POST['warna'],
                'harga_sewa_perhari' => str_replace(['.', ','], '', $_POST['harga_sewa_perhari']),
                'status' => $_POST['status'],
                'foto' => $foto
            ];
            
            if($kendaraanModel->updateKendaraan($id, $data)) {
                $this->setFlash('success', 'Data kendaraan berhasil diupdate!');
                // Redirect kembali ke page yang sama dengan filter
                $this->redirect('kendaraan?page=' . $page . '&search=' . $search . '&jenis=' . $jenis . '&status=' . $status);
            } else {
                $this->setFlash('danger', 'Gagal mengupdate data kendaraan!');
                $this->redirect('kendaraan/edit/' . $id . '?page=' . $page . '&search=' . $search . '&jenis=' . $jenis . '&status=' . $status);
            }
        }
        
        $data = [
            'title' => 'Edit Kendaraan',
            'active' => 'kendaraan',
            'kendaraan' => $kendaraanModel->getKendaraanById($id),
            'page' => $page,
            'search' => $search,
            'jenis' => $jenis,
            'status' => $status
        ];
        
        $this->view('layouts/header', $data);
        $this->view('layouts/sidebar', $data);
        $this->view('kendaraan/edit', $data);
        $this->view('layouts/footer');
    }
    
    public function delete($id) {
        $this->checkAdmin();
        
        // Ambil parameter untuk redirect
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $jenis = isset($_GET['jenis']) ? $_GET['jenis'] : '';
        $status = isset($_GET['status']) ? $_GET['status'] : '';
        
        $kendaraanModel = $this->model('Kendaraan');
        
        // Hapus foto jika ada
        $kendaraan = $kendaraanModel->getKendaraanById($id);
        if(!empty($kendaraan['foto'])) {
            $targetDir = __DIR__ . '/../../assets/images/';
            $fotoPath = $targetDir . $kendaraan['foto'];
            if(file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }
        
        if($kendaraanModel->deleteKendaraan($id)) {
            $this->setFlash('success', 'Data kendaraan berhasil dihapus!');
        } else {
            $this->setFlash('danger', 'Gagal menghapus data kendaraan!');
        }
        
        // Redirect kembali ke page yang sama
        $this->redirect('kendaraan?page=' . $page . '&search=' . $search . '&jenis=' . $jenis . '&status=' . $status);
    }
}
?>