-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql105.infinityfree.com
-- Generation Time: Jan 31, 2026 at 09:32 PM
-- Server version: 11.4.9-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_40980700_db_rental`
--

-- --------------------------------------------------------

--
-- Table structure for table `denda`
--

CREATE TABLE `denda` (
  `id` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `jumlah_hari_terlambat` int(11) NOT NULL,
  `tarif_denda_perhari` decimal(10,2) NOT NULL,
  `total_denda` decimal(10,2) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `denda`
--

INSERT INTO `denda` (`id`, `id_transaksi`, `jumlah_hari_terlambat`, `tarif_denda_perhari`, `total_denda`, `keterangan`, `created_at`) VALUES
(1, 3, 2, '38000.00', '76000.00', 'Keterlambatan 2 hari', '2026-01-28 04:36:07');

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id` int(11) NOT NULL,
  `kode_kendaraan` varchar(20) NOT NULL,
  `nama_kendaraan` varchar(100) NOT NULL,
  `jenis` enum('mobil','motor','truk','bus') NOT NULL,
  `merk` varchar(50) NOT NULL,
  `tahun_produksi` year(4) NOT NULL,
  `plat_nomor` varchar(20) NOT NULL,
  `warna` varchar(30) DEFAULT NULL,
  `harga_sewa_perhari` decimal(10,2) NOT NULL,
  `status` enum('tersedia','disewa','maintenance') DEFAULT 'tersedia',
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kendaraan`
--

INSERT INTO `kendaraan` (`id`, `kode_kendaraan`, `nama_kendaraan`, `jenis`, `merk`, `tahun_produksi`, `plat_nomor`, `warna`, `harga_sewa_perhari`, `status`, `foto`, `created_at`, `updated_at`) VALUES
(1, 'KND001', 'Toyota Avanza', 'mobil', 'Toyota', 2022, 'B 1234 XYZ', 'Putih', '350000.00', 'disewa', 'kendaraan_1769410335_69770f1fea05c.jpg', '2026-01-24 08:30:25', '2026-01-26 06:52:15'),
(2, 'KND002', 'Honda Jazz', 'mobil', 'Honda', 2021, 'B 5678 ABC', 'Hitam', '400000.00', 'tersedia', 'kendaraan_1769427454_697751fe57a42.jfif', '2026-01-24 08:30:25', '2026-01-26 11:37:34'),
(3, 'KND003', 'Mitsubishi Xpander', 'mobil', 'Mitsubishi', 2023, 'B 7890 JKL', 'Silver', '450000.00', 'tersedia', NULL, '2026-01-24 08:30:25', '2026-01-24 08:30:25'),
(4, 'KND004', 'Toyota Fortuner', 'mobil', 'Toyota', 2024, 'B 1999 RFS', 'Hitam', '800000.00', 'tersedia', NULL, '2026-01-24 08:30:25', '2026-01-24 08:30:25'),
(5, 'KND005', 'Daihatsu Terios', 'mobil', 'Daihatsu', 2023, 'B 3333 TER', 'Merah', '380000.00', 'tersedia', '', '2026-01-24 08:30:25', '2026-01-28 04:36:07'),
(6, 'KND006', 'Yamaha NMAX', 'motor', 'Yamaha', 2023, 'B 9012 DEF', 'Merah', '150000.00', 'disewa', 'kendaraan_1769427776_69775340dbcf1.jpg', '2026-01-24 08:30:25', '2026-01-30 06:26:06'),
(7, 'KND007', 'Honda PCX', 'motor', 'Honda', 2022, 'B 3456 GHI', 'Biru', '175000.00', 'tersedia', 'kendaraan_1769427896_697753b891092.jpg', '2026-01-24 08:30:25', '2026-01-26 11:44:56'),
(8, 'KND008', 'Vespa Sprint S', 'motor', 'Piaggio', 2024, 'B 6666 VSP', 'Kuning', '250000.00', 'tersedia', NULL, '2026-01-24 08:30:25', '2026-01-24 08:30:25'),
(9, 'KND009', 'Honda Vario 160', 'motor', 'Honda', 2024, 'B 8888 VAR', 'Putih', '140000.00', 'tersedia', NULL, '2026-01-24 08:30:25', '2026-01-24 08:30:25'),
(10, 'KND010', 'Yamaha Aerox 155', 'motor', 'Yamaha', 2023, 'B 7777 AER', 'Abu-abu', '160000.00', 'tersedia', NULL, '2026-01-24 08:30:25', '2026-01-24 08:30:25'),
(11, 'KND011', 'Isuzu Elf', 'truk', 'Isuzu', 2022, 'B 4444 ELF', 'Putih', '600000.00', 'tersedia', NULL, '2026-01-24 08:30:25', '2026-01-24 08:30:25'),
(12, 'KND012', 'Mitsubishi Colt Diesel', 'truk', 'Mitsubishi', 2021, 'B 5555 COL', 'Hijau', '550000.00', 'tersedia', NULL, '2026-01-24 08:30:25', '2026-01-24 08:30:25'),
(13, 'KND013', 'Hino Dutro', 'truk', 'Hino', 2023, 'B 2222 HIN', 'Putih', '650000.00', 'tersedia', NULL, '2026-01-24 08:30:25', '2026-01-24 08:30:25'),
(14, 'KND014', 'Daihatsu Gran Max PU', 'truk', 'Daihatsu', 2024, 'B 9999 GMX', 'Silver', '400000.00', 'disewa', NULL, '2026-01-24 08:30:25', '2026-01-30 06:00:02'),
(15, 'KND015', 'Isuzu Elf Long', 'bus', 'Isuzu', 2020, 'D 7777 AB', 'Putih', '1200000.00', 'disewa', NULL, '2026-01-24 08:30:25', '2026-01-30 06:24:39'),
(16, 'KND016', 'Mercedes Benz OH 1526', 'bus', 'Mercedes', 2021, 'B 1111 MER', 'Silver', '1500000.00', 'tersedia', NULL, '2026-01-24 08:30:25', '2026-01-24 08:30:25'),
(17, 'KND017', 'Hino RK8', 'bus', 'Hino', 2022, 'B 3333 BUS', 'Biru', '1300000.00', 'maintenance', NULL, '2026-01-24 08:30:25', '2026-01-26 07:01:28'),
(18, 'KND018', 'Mitsubishi FE 84 Bus', 'bus', 'Mitsubishi', 2023, 'B 4444 MIT', 'Putih', '1100000.00', 'maintenance', NULL, '2026-01-24 08:30:25', '2026-01-26 07:00:44');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `kode_pelanggan` varchar(20) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `alamat` text NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `kode_pelanggan`, `nama_lengkap`, `nik`, `alamat`, `no_telepon`, `email`, `created_at`, `updated_at`) VALUES
(1, 'PLG001', 'Budi Santoso', '3201012345678901', 'Jl. Merdeka No. 10, Jakarta', '081234567890', 'budi@email.com', '2026-01-24 08:30:25', '2026-01-24 08:30:25'),
(2, 'PLG002', 'Siti Nurhaliza', '3201012345678902', 'Jl. Sudirman No. 25, Bekasi', '082345678901', 'siti@email.com', '2026-01-24 08:30:25', '2026-01-24 08:30:25'),
(3, 'PLG003', 'Ahmad Zaky', '3201012345678903', 'Jl. Gatot Subroto No. 15, Depok', '083456789012', 'ahmad@email.com', '2026-01-24 08:30:25', '2026-01-24 08:30:25'),
(4, 'PLG004', 'Dewi Lestari', '3201012345678904', 'Jl. Asia Afrika No. 8, Bandung', '081298765432', 'dewi@email.com', '2026-01-24 08:30:25', '2026-01-24 08:30:25'),
(5, 'PLG005', 'Eko Prasetyo', '3201012345678905', 'Jl. Pahlawan No. 45, Surabaya', '081345678901', 'eko@email.com', '2026-01-24 08:30:25', '2026-01-24 08:30:25'),
(6, 'PLG006', 'Rina Wati', '3201012345678906', 'Jl. Diponegoro No. 12, Semarang', '085712345678', 'rina@email.com', '2026-01-24 08:30:25', '2026-01-24 08:30:25'),
(7, 'PLG007', 'Dedi Kurniawan', '3201012345678907', 'Jl. Malioboro No. 99, Yogyakarta', '087812345679', 'dedi@email.com', '2026-01-24 08:30:25', '2026-01-24 08:30:25');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_sewa`
--

CREATE TABLE `transaksi_sewa` (
  `id` int(11) NOT NULL,
  `kode_transaksi` varchar(30) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_kendaraan` int(11) NOT NULL,
  `tanggal_sewa` date NOT NULL,
  `tanggal_kembali_rencana` date NOT NULL,
  `tanggal_kembali_aktual` date DEFAULT NULL,
  `lama_sewa` int(11) NOT NULL,
  `total_biaya` decimal(12,2) NOT NULL,
  `denda` decimal(10,2) DEFAULT 0.00,
  `status` enum('aktif','selesai','batal') DEFAULT 'aktif',
  `catatan` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_sewa`
--

INSERT INTO `transaksi_sewa` (`id`, `kode_transaksi`, `id_pelanggan`, `id_kendaraan`, `tanggal_sewa`, `tanggal_kembali_rencana`, `tanggal_kembali_aktual`, `lama_sewa`, `total_biaya`, `denda`, `status`, `catatan`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'TRX20260124001', 2, 1, '2026-01-25', '2026-02-01', NULL, 7, '2450000.00', '0.00', 'aktif', '', 1, '2026-01-24 08:46:38', '2026-01-24 08:46:38'),
(2, 'TRX20260124002', 1, 2, '2026-01-24', '2026-01-25', '2026-01-25', 1, '400000.00', '0.00', 'selesai', '', 1, '2026-01-24 10:07:22', '2026-01-25 00:43:44'),
(3, 'TRX20260125001', 3, 5, '2026-01-25', '2026-01-26', '2026-01-28', 1, '380000.00', '76000.00', 'selesai', '', 1, '2026-01-25 00:43:12', '2026-01-28 04:36:07'),
(4, 'TRX20260130001', 5, 14, '2026-01-30', '2026-02-19', NULL, 20, '8000000.00', '0.00', 'aktif', '', 1, '2026-01-30 06:00:02', '2026-01-30 06:00:02'),
(5, 'TRX20260130002', 4, 15, '2026-01-30', '2026-02-01', NULL, 2, '2400000.00', '0.00', 'aktif', '', 1, '2026-01-30 06:24:39', '2026-01-30 06:24:39'),
(6, 'TRX20260130003', 6, 6, '2026-01-31', '2026-02-05', NULL, 5, '750000.00', '0.00', 'aktif', '', 1, '2026-01-30 06:26:06', '2026-01-30 06:26:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `email`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$n1JedbzyaP23nZtPaYmT4O.BtSBk3rTjFPAL9MCrtXchwlYrB7Hqa', 'Administrator', 'admin@rental.com', 'admin', '2026-01-24 08:30:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `denda`
--
ALTER TABLE `denda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- Indexes for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_kendaraan` (`kode_kendaraan`),
  ADD UNIQUE KEY `plat_nomor` (`plat_nomor`),
  ADD KEY `idx_kendaraan_status` (`status`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_pelanggan` (`kode_pelanggan`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD KEY `idx_pelanggan_nama` (`nama_lengkap`);

--
-- Indexes for table `transaksi_sewa`
--
ALTER TABLE `transaksi_sewa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_transaksi` (`kode_transaksi`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_kendaraan` (`id_kendaraan`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `idx_transaksi_status` (`status`),
  ADD KEY `idx_transaksi_tanggal` (`tanggal_sewa`,`tanggal_kembali_rencana`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `denda`
--
ALTER TABLE `denda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transaksi_sewa`
--
ALTER TABLE `transaksi_sewa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `denda`
--
ALTER TABLE `denda`
  ADD CONSTRAINT `denda_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi_sewa` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi_sewa`
--
ALTER TABLE `transaksi_sewa`
  ADD CONSTRAINT `transaksi_sewa_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id`),
  ADD CONSTRAINT `transaksi_sewa_ibfk_2` FOREIGN KEY (`id_kendaraan`) REFERENCES `kendaraan` (`id`),
  ADD CONSTRAINT `transaksi_sewa_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
