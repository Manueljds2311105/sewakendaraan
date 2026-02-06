<?php
class Transaksi {
    private $conn;
    private $table = 'transaksi_sewa';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAllTransaksi($search = '', $status = '', $limit = 10, $offset = 0) {
        $query = "SELECT t.*, p.nama_lengkap as nama_pelanggan, p.no_telepon, 
                  k.nama_kendaraan, k.plat_nomor, k.harga_sewa_perhari
                  FROM " . $this->table . " t
                  JOIN pelanggan p ON t.id_pelanggan = p.id
                  JOIN kendaraan k ON t.id_kendaraan = k.id
                  WHERE 1=1";
        
        if(!empty($search)) {
            $query .= " AND (t.kode_transaksi LIKE :search OR p.nama_lengkap LIKE :search)";
        }
        
        if(!empty($status)) {
            $query .= " AND t.status = :status";
        }
        
        // URUT BERDASARKAN KODE TRANSAKSI ASCENDING (TRX20260124001 -> 002 -> 003)
        // Yang baru ada di bawah
        $query .= " ORDER BY t.kode_transaksi ASC LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($query);
        
        if(!empty($search)) {
            $searchParam = "%$search%";
            $stmt->bindParam(':search', $searchParam);
        }
        
        if(!empty($status)) {
            $stmt->bindParam(':status', $status);
        }
        
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function countTransaksi($search = '', $status = '') {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " t
                  JOIN pelanggan p ON t.id_pelanggan = p.id
                  WHERE 1=1";
        
        if(!empty($search)) {
            $query .= " AND (t.kode_transaksi LIKE :search OR p.nama_lengkap LIKE :search)";
        }
        
        if(!empty($status)) {
            $query .= " AND t.status = :status";
        }
        
        $stmt = $this->conn->prepare($query);
        
        if(!empty($search)) {
            $searchParam = "%$search%";
            $stmt->bindParam(':search', $searchParam);
        }
        
        if(!empty($status)) {
            $stmt->bindParam(':status', $status);
        }
        
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }

    public function getTransaksiById($id) {
        $query = "SELECT t.*, p.nama_lengkap as nama_pelanggan, p.no_telepon, p.alamat,
                  k.nama_kendaraan, k.plat_nomor, k.harga_sewa_perhari, k.id as id_kendaraan
                  FROM " . $this->table . " t
                  JOIN pelanggan p ON t.id_pelanggan = p.id
                  JOIN kendaraan k ON t.id_kendaraan = k.id
                  WHERE t.id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getTransaksiAktif() {
        $query = "SELECT t.*, p.nama_lengkap as nama_pelanggan, 
                  k.nama_kendaraan, k.plat_nomor,
                  DATEDIFF(CURDATE(), t.tanggal_kembali_rencana) as hari_terlambat
                  FROM " . $this->table . " t
                  JOIN pelanggan p ON t.id_pelanggan = p.id
                  JOIN kendaraan k ON t.id_kendaraan = k.id
                  WHERE t.status = 'aktif'
                  ORDER BY t.kode_transaksi ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function createTransaksi($data) {
        try {
            $this->conn->beginTransaction();
            
            // Insert transaksi
            $query = "INSERT INTO " . $this->table . " 
                      (kode_transaksi, id_pelanggan, id_kendaraan, tanggal_sewa, 
                       tanggal_kembali_rencana, lama_sewa, total_biaya, status, catatan, created_by) 
                      VALUES (:kode_transaksi, :id_pelanggan, :id_kendaraan, :tanggal_sewa, 
                              :tanggal_kembali_rencana, :lama_sewa, :total_biaya, :status, :catatan, :created_by)";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':kode_transaksi', $data['kode_transaksi']);
            $stmt->bindParam(':id_pelanggan', $data['id_pelanggan']);
            $stmt->bindParam(':id_kendaraan', $data['id_kendaraan']);
            $stmt->bindParam(':tanggal_sewa', $data['tanggal_sewa']);
            $stmt->bindParam(':tanggal_kembali_rencana', $data['tanggal_kembali_rencana']);
            $stmt->bindParam(':lama_sewa', $data['lama_sewa']);
            $stmt->bindParam(':total_biaya', $data['total_biaya']);
            $stmt->bindParam(':status', $data['status']);
            $stmt->bindParam(':catatan', $data['catatan']);
            $stmt->bindParam(':created_by', $data['created_by']);
            
            $stmt->execute();
            
            // Update status kendaraan
            $updateKendaraan = "UPDATE kendaraan SET status = 'disewa' WHERE id = :id_kendaraan";
            $stmtUpdate = $this->conn->prepare($updateKendaraan);
            $stmtUpdate->bindParam(':id_kendaraan', $data['id_kendaraan']);
            $stmtUpdate->execute();
            
            $this->conn->commit();
            return true;
            
        } catch(Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function prosesKembali($id, $tanggal_kembali, $denda = 0) {
        try {
            $this->conn->beginTransaction();
            
            // Get transaksi data
            $transaksi = $this->getTransaksiById($id);
            
            // Update transaksi
            $query = "UPDATE " . $this->table . " 
                      SET tanggal_kembali_aktual = :tanggal_kembali, 
                          denda = :denda, 
                          status = 'selesai' 
                      WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':tanggal_kembali', $tanggal_kembali);
            $stmt->bindParam(':denda', $denda);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            // Update status kendaraan
            $updateKendaraan = "UPDATE kendaraan SET status = 'tersedia' WHERE id = :id_kendaraan";
            $stmtUpdate = $this->conn->prepare($updateKendaraan);
            $stmtUpdate->bindParam(':id_kendaraan', $transaksi['id_kendaraan']);
            $stmtUpdate->execute();
            
            // Insert denda jika ada
            if($denda > 0) {
                $hariTerlambat = (strtotime($tanggal_kembali) - strtotime($transaksi['tanggal_kembali_rencana'])) / (60 * 60 * 24);
                $tarifDenda = $transaksi['harga_sewa_perhari'] * 0.1; // 10% dari harga sewa
                
                $queryDenda = "INSERT INTO denda (id_transaksi, jumlah_hari_terlambat, tarif_denda_perhari, total_denda, keterangan) 
                               VALUES (:id_transaksi, :hari_terlambat, :tarif_denda, :total_denda, :keterangan)";
                $stmtDenda = $this->conn->prepare($queryDenda);
                $stmtDenda->bindParam(':id_transaksi', $id);
                $stmtDenda->bindParam(':hari_terlambat', $hariTerlambat);
                $stmtDenda->bindParam(':tarif_denda', $tarifDenda);
                $stmtDenda->bindParam(':total_denda', $denda);
                $keterangan = "Keterlambatan $hariTerlambat hari";
                $stmtDenda->bindParam(':keterangan', $keterangan);
                $stmtDenda->execute();
            }
            
            $this->conn->commit();
            return true;
            
        } catch(Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function generateKodeTransaksi() {
        $date = date('Ymd');
        $query = "SELECT kode_transaksi FROM " . $this->table . " 
                  WHERE kode_transaksi LIKE 'TRX$date%' 
                  ORDER BY kode_transaksi DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            $lastCode = $row['kode_transaksi'];
            $number = intval(substr($lastCode, -3)) + 1;
            return 'TRX' . $date . str_pad($number, 3, '0', STR_PAD_LEFT);
        }
        
        return 'TRX' . $date . '001';
    }

    public function getLaporanByDate($startDate, $endDate) {
        $query = "SELECT t.*, p.nama_lengkap as nama_pelanggan, 
                  k.nama_kendaraan, k.plat_nomor
                  FROM " . $this->table . " t
                  JOIN pelanggan p ON t.id_pelanggan = p.id
                  JOIN kendaraan k ON t.id_kendaraan = k.id
                  WHERE t.tanggal_sewa BETWEEN :start_date AND :end_date
                  ORDER BY t.kode_transaksi ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':start_date', $startDate);
        $stmt->bindParam(':end_date', $endDate);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
}
?>