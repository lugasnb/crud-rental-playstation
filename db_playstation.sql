-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Feb 2025 pada 13.28
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_playstation`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`id`, `username`, `password`) VALUES
(1, 'lugasnb', '$2y$10$1ra9tI5qTC1CfvHCzK5zzeVHPQfCMALxqN/16/L.sjfDAmep6pFRW'),
(2, 'admin', '$2y$10$mJvtSiP9vmNYif0ZW4KR7uW5jgOSAxT7BWLH8aPguYqby9yMXGlN2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `kd_plg` varchar(11) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `jk` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `kd_plg`, `nama`, `jk`, `alamat`, `telepon`, `dibuat`) VALUES
(20, 'PLG001', 'Andi Pratama', 'Laki-laki', 'Jl. Merdeka No.1, Jakarta', '081234567890', '2025-01-31 18:03:04'),
(21, 'PLG002', 'Siti Aminah', 'Perempuan', 'Jl. Sudirman No.5, Bandung', '081234567891', '2025-01-31 18:03:04'),
(22, 'PLG003', 'Budi Santoso', 'Laki-laki', 'Jl. Raya No.10, Surabaya', '081234567892', '2025-01-31 18:03:04'),
(23, 'PLG004', 'Dina Puspita', 'Perempuan', 'Jl. Anggrek No.3, Yogyakarta', '081234567893', '2025-01-31 18:03:04'),
(24, 'PLG005', 'Hendra Wijaya', 'Laki-laki', 'Jl. Kuningan No.8, Medan', '081234567894', '2025-01-31 18:03:04'),
(25, 'PLG006', 'Ratna Dewi', 'Perempuan', 'Jl. Bunga No.6, Makassar', '081234567895', '2025-01-31 18:03:04'),
(26, 'PLG007', 'Fahmi Alamsyah', 'Laki-laki', 'Jl. Cendana No.7, Bali', '081234567896', '2025-01-31 18:03:04'),
(27, 'PLG008', 'Putri Pramudita', 'Perempuan', 'Jl. Melati No.2, Semarang', '081234567897', '2025-01-31 18:03:04'),
(28, 'PLG009', 'Eko Santosa', 'Laki-laki', 'Jl. Pahlawan No.12, Malang', '081234567898', '2025-01-31 18:03:04'),
(29, 'PLG010', 'Lina Mardiana', 'Perempuan', 'Jl. Harapan No.4, Surakarta', '081234567899', '2025-01-31 18:03:04'),
(30, 'PLG011', 'Doni Setiawan', 'Laki-laki', 'Jl. Manggis No.9, Jakarta', '081234567900', '2025-01-31 22:02:37'),
(31, 'PLG012', 'Maya Pratiwi', 'Perempuan', 'Jl. Mawar No.4, Bandung', '081234567901', '2025-01-31 22:02:37'),
(32, 'PLG013', 'Rudi Hartono', 'Laki-laki', 'Jl. Pahlawan No.15, Surabaya', '081234567902', '2025-01-31 22:02:37'),
(33, 'PLG014', 'Lestari Sari', 'Perempuan', 'Jl. Kenanga No.6, Yogyakarta', '081234567903', '2025-01-31 22:02:37'),
(34, 'PLG015', 'Ali Akbar', 'Laki-laki', 'Jl. Raya No.18, Medan', '081234567904', '2025-01-31 22:02:37'),
(35, 'PLG016', 'Yuniar Zainab', 'Perempuan', 'Jl. Anggrek No.10, Makassar', '081234567905', '2025-01-31 22:02:37'),
(36, 'PLG017', 'Taufik Hidayat', 'Laki-laki', 'Jl. Pinang No.8, Bali', '081234567906', '2025-01-31 22:02:37'),
(37, 'PLG018', 'Nina Oktavia', 'Perempuan', 'Jl. Kemuning No.5, Semarang', '081234567907', '2025-01-31 22:02:37'),
(38, 'PLG019', 'Agus Santoso', 'Laki-laki', 'Jl. Pahlawan No.8, Malang', '081234567908', '2025-01-31 22:02:37'),
(39, 'PLG020', 'Rina Apriani', 'Perempuan', 'Jl. Taman No.3, Surakarta', '081234567909', '2025-01-31 22:02:37'),
(40, 'PLG021', 'Lugas Nusa Bakti', 'Laki-laki', 'Pasawahan, Kuningan, Jawa Barat', '083850082592', '2025-02-02 10:35:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `playstation`
--

CREATE TABLE `playstation` (
  `id` int(11) NOT NULL,
  `kd_ps` varchar(11) DEFAULT NULL,
  `tipe` enum('PlayStation 3','PlayStation 4','PlayStation 5') DEFAULT NULL,
  `harga` decimal(10,2) GENERATED ALWAYS AS (case when `tipe` = 'PlayStation 3' then 3000 when `tipe` = 'PlayStation 4' then 5000 when `tipe` = 'PlayStation 5' then 8000 end) STORED,
  `status` enum('Tersedia','Rental') DEFAULT 'Tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `playstation`
--

INSERT INTO `playstation` (`id`, `kd_ps`, `tipe`, `status`) VALUES
(7, 'PS301', 'PlayStation 3', 'Tersedia'),
(8, 'PS302', 'PlayStation 3', 'Tersedia'),
(9, 'PS401', 'PlayStation 4', 'Tersedia'),
(10, 'PS402', 'PlayStation 4', 'Tersedia'),
(11, 'PS501', 'PlayStation 5', 'Tersedia'),
(12, 'PS502', 'PlayStation 5', 'Tersedia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rental`
--

CREATE TABLE `rental` (
  `id` int(11) NOT NULL,
  `kd_plg` varchar(11) DEFAULT NULL,
  `kd_ps` varchar(11) DEFAULT NULL,
  `mulai` datetime DEFAULT current_timestamp(),
  `selesai` datetime DEFAULT NULL,
  `durasi` int(11) GENERATED ALWAYS AS (timestampdiff(HOUR,`mulai`,`selesai`)) VIRTUAL,
  `total_bayar` decimal(10,2) GENERATED ALWAYS AS (case when `kd_ps` = 'PS301' then timestampdiff(HOUR,`mulai`,`selesai`) * 3000 when `kd_ps` = 'PS302' then timestampdiff(HOUR,`mulai`,`selesai`) * 3000 when `kd_ps` = 'PS401' then timestampdiff(HOUR,`mulai`,`selesai`) * 5000 when `kd_ps` = 'PS402' then timestampdiff(HOUR,`mulai`,`selesai`) * 5000 when `kd_ps` = 'PS501' then timestampdiff(HOUR,`mulai`,`selesai`) * 8000 when `kd_ps` = 'PS502' then timestampdiff(HOUR,`mulai`,`selesai`) * 8000 end) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rental`
--

INSERT INTO `rental` (`id`, `kd_plg`, `kd_ps`, `mulai`, `selesai`) VALUES
(4, 'PLG001', 'PS301', '2025-01-31 10:00:00', '2025-01-31 14:00:00'),
(5, 'PLG002', 'PS302', '2025-01-31 11:00:00', '2025-01-31 14:00:00'),
(6, 'PLG003', 'PS401', '2025-01-31 12:00:00', '2025-01-31 13:00:00'),
(7, 'PLG004', 'PS402', '2025-01-31 13:00:00', '2025-01-31 15:00:00'),
(8, 'PLG005', 'PS501', '2025-01-31 14:00:00', '2025-01-31 18:00:00'),
(9, 'PLG006', 'PS502', '2025-01-31 15:00:00', '2025-01-31 20:00:00'),
(10, 'PLG007', 'PS301', '2025-01-31 16:00:00', '2025-01-31 21:00:00'),
(11, 'PLG008', 'PS401', '2025-01-31 17:00:00', '2025-01-31 23:00:00'),
(12, 'PLG009', 'PS501', '2025-01-31 18:00:00', '2025-01-31 20:00:00'),
(13, 'PLG010', 'PS301', '2025-02-01 09:00:00', '2025-02-01 12:00:00'),
(14, 'PLG011', 'PS302', '2025-02-01 10:00:00', '2025-02-01 13:00:00'),
(15, 'PLG012', 'PS401', '2025-02-01 11:00:00', '2025-02-01 14:00:00'),
(16, 'PLG013', 'PS402', '2025-02-01 12:00:00', '2025-02-01 15:00:00'),
(17, 'PLG014', 'PS501', '2025-02-01 13:00:00', '2025-02-01 17:00:00'),
(18, 'PLG015', 'PS502', '2025-02-01 14:00:00', '2025-02-01 19:00:00'),
(19, 'PLG016', 'PS301', '2025-02-01 15:00:00', '2025-02-01 19:00:00'),
(20, 'PLG017', 'PS401', '2025-02-01 16:00:00', '2025-02-01 20:00:00'),
(21, 'PLG018', 'PS502', '2025-02-01 17:00:00', '2025-02-01 22:00:00'),
(22, 'PLG019', 'PS301', '2025-02-01 18:00:00', '2025-02-01 22:00:00'),
(23, 'PLG020', 'PS402', '2025-02-01 19:00:00', '2025-02-01 23:00:00'),
(24, 'PLG011', 'PS501', '2025-02-01 06:14:00', '2025-02-01 11:15:00'),
(25, 'PLG002', 'PS302', '2025-02-01 06:18:00', '2025-02-02 13:09:00'),
(26, 'PLG021', 'PS501', '2025-02-02 17:36:00', '2025-02-04 17:36:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kd_plg` (`kd_plg`);

--
-- Indeks untuk tabel `playstation`
--
ALTER TABLE `playstation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kd_ps` (`kd_ps`);

--
-- Indeks untuk tabel `rental`
--
ALTER TABLE `rental`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kd_plg` (`kd_plg`),
  ADD KEY `kd_ps` (`kd_ps`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `playstation`
--
ALTER TABLE `playstation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `rental`
--
ALTER TABLE `rental`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `rental`
--
ALTER TABLE `rental`
  ADD CONSTRAINT `rental_ibfk_1` FOREIGN KEY (`kd_plg`) REFERENCES `pelanggan` (`kd_plg`),
  ADD CONSTRAINT `rental_ibfk_2` FOREIGN KEY (`kd_ps`) REFERENCES `playstation` (`kd_ps`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
