<?php
class Pelanggan {
    private $conn;
    private $table = 'pelanggan';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAllPelanggan($search = '', $limit = 10, $offset = 0) {
        $query = "SELECT * FROM " . $this->table . " WHERE 1=1";
        
        if(!empty($search)) {
            $query .= " AND (nama_lengkap LIKE :search OR nik LIKE :search OR no_telepon LIKE :search)";
        }
        
        // UBAH ORDER BY dari created_at ke kode_pelanggan
        $query .= " ORDER BY CAST(SUBSTRING(kode_pelanggan, 4) AS UNSIGNED) ASC LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($query);
        
        if(!empty($search)) {
            $searchParam = "%$search%";
            $stmt->bindParam(':search', $searchParam);
        }
        
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function countPelanggan($search = '') {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE 1=1";
        
        if(!empty($search)) {
            $query .= " AND (nama_lengkap LIKE :search OR nik LIKE :search OR no_telepon LIKE :search)";
        }
        
        $stmt = $this->conn->prepare($query);
        
        if(!empty($search)) {
            $searchParam = "%$search%";
            $stmt->bindParam(':search', $searchParam);
        }
        
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }

    public function getPelangganById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function createPelanggan($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (kode_pelanggan, nama_lengkap, nik, alamat, no_telepon, email) 
                  VALUES (:kode_pelanggan, :nama_lengkap, :nik, :alamat, :no_telepon, :email)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':kode_pelanggan', $data['kode_pelanggan']);
        $stmt->bindParam(':nama_lengkap', $data['nama_lengkap']);
        $stmt->bindParam(':nik', $data['nik']);
        $stmt->bindParam(':alamat', $data['alamat']);
        $stmt->bindParam(':no_telepon', $data['no_telepon']);
        $stmt->bindParam(':email', $data['email']);
        
        return $stmt->execute();
    }

    public function updatePelanggan($id, $data) {
        $query = "UPDATE " . $this->table . " 
                  SET kode_pelanggan = :kode_pelanggan, nama_lengkap = :nama_lengkap, 
                      nik = :nik, alamat = :alamat, no_telepon = :no_telepon, email = :email 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':kode_pelanggan', $data['kode_pelanggan']);
        $stmt->bindParam(':nama_lengkap', $data['nama_lengkap']);
        $stmt->bindParam(':nik', $data['nik']);
        $stmt->bindParam(':alamat', $data['alamat']);
        $stmt->bindParam(':no_telepon', $data['no_telepon']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    public function deletePelanggan($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function generateKodePelanggan() {
        // Hitung jumlah total pelanggan yang ada
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $result = $stmt->fetch();
        $total = $result['total'];
        
        // Nomor baru = total + 1
        $number = $total + 1;
        return 'PLG' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}
?>