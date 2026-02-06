<?php
class Denda {
    private $conn;
    private $table = 'denda';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getDendaByTransaksi($id_transaksi) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_transaksi = :id_transaksi LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_transaksi', $id_transaksi);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAllDenda() {
        $query = "SELECT d.*, t.kode_transaksi, p.nama_lengkap as nama_pelanggan, k.nama_kendaraan
                  FROM " . $this->table . " d
                  JOIN transaksi_sewa t ON d.id_transaksi = t.id
                  JOIN pelanggan p ON t.id_pelanggan = p.id
                  JOIN kendaraan k ON t.id_kendaraan = k.id
                  ORDER BY d.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function createDenda($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (id_transaksi, jumlah_hari_terlambat, tarif_denda_perhari, total_denda, keterangan) 
                  VALUES (:id_transaksi, :jumlah_hari_terlambat, :tarif_denda_perhari, :total_denda, :keterangan)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id_transaksi', $data['id_transaksi']);
        $stmt->bindParam(':jumlah_hari_terlambat', $data['jumlah_hari_terlambat']);
        $stmt->bindParam(':tarif_denda_perhari', $data['tarif_denda_perhari']);
        $stmt->bindParam(':total_denda', $data['total_denda']);
        $stmt->bindParam(':keterangan', $data['keterangan']);
        
        return $stmt->execute();
    }

    public function calculateDenda($harga_sewa, $hari_terlambat) {
        // Denda = 10% dari harga sewa per hari x jumlah hari terlambat
        $tarif_denda = $harga_sewa * 0.1;
        $total_denda = $tarif_denda * $hari_terlambat;
        
        return [
            'tarif_denda_perhari' => $tarif_denda,
            'total_denda' => $total_denda
        ];
    }

    public function getTotalDenda() {
        $query = "SELECT SUM(total_denda) as total FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
}
?>