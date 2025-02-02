CREATE DATABASE db_playstation
  DEFAULT CHARACTER SET = 'utf8mb4';

USE db_playstation;

-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

SELECT COUNT(*) AS rental_month 
FROM rental 
WHERE YEAR(mulai) = YEAR(CURDATE()) 
AND MONTH(mulai) = MONTH(CURDATE());

SELECT SUM(total_bayar) AS total_revenue 
FROM rental 
WHERE YEAR(mulai) = YEAR(CURDATE()) 
AND MONTH(mulai) = MONTH(CURDATE());

-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE login (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL
);

INSERT INTO `login` (`id`, `username`, `password`) VALUES (NULL, 'lugasnb', '$2y$10$1ra9tI5qTC1CfvHCzK5zzeVHPQfCMALxqN/16/L.sjfDAmep6pFRW');
echo password_hash('12345', PASSWORD_DEFAULT);

-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE pelanggan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kd_plg VARCHAR(11) UNIQUE,
  nama VARCHAR(50),
  jk ENUM('Laki-laki', 'Perempuan'),
  alamat TEXT,
  telepon VARCHAR(15)
);

ALTER TABLE pelanggan
ADD COLUMN dibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE playstation (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kd_ps VARCHAR(11) UNIQUE,
  tipe ENUM('PlayStation 3', 'PlayStation 4', 'PlayStation 5'),
  harga DECIMAL(10, 2) GENERATED ALWAYS AS (
    CASE 
      WHEN tipe = 'PlayStation 3' THEN 3000 
      WHEN tipe = 'PlayStation 4' THEN 5000 
      WHEN tipe = 'PlayStation 5' THEN 8000 
    END
  ) STORED,
  status ENUM('Tersedia', 'Rental') DEFAULT 'Tersedia'
);

-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE rental (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kd_plg VARCHAR(11),
  kd_ps VARCHAR(11),
  mulai DATETIME DEFAULT CURRENT_TIMESTAMP,
  selesai DATETIME,
  durasi INT GENERATED ALWAYS AS (TIMESTAMPDIFF(HOUR, mulai, selesai)) VIRTUAL,
  total_bayar DECIMAL(10, 2) GENERATED ALWAYS AS (
    CASE 
      WHEN kd_ps = 'PS301' THEN (TIMESTAMPDIFF(HOUR, mulai, selesai) * 3000) 
      WHEN kd_ps = 'PS302' THEN (TIMESTAMPDIFF(HOUR, mulai, selesai) * 3000)
      WHEN kd_ps = 'PS401' THEN (TIMESTAMPDIFF(HOUR, mulai, selesai) * 5000) 
      WHEN kd_ps = 'PS402' THEN (TIMESTAMPDIFF(HOUR, mulai, selesai) * 5000) 
      WHEN kd_ps = 'PS501' THEN (TIMESTAMPDIFF(HOUR, mulai, selesai) * 8000) 
      WHEN kd_ps = 'PS502' THEN (TIMESTAMPDIFF(HOUR, mulai, selesai) * 8000) 
    END
  ) STORED,
  FOREIGN KEY (kd_plg) REFERENCES pelanggan(kd_plg),
  FOREIGN KEY (kd_ps) REFERENCES playstation(kd_ps)
);

-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

ALTER TABLE rental 
MODIFY COLUMN total_bayar DECIMAL(10, 2) GENERATED ALWAYS AS (
  CASE 
    WHEN kd_ps = 'PS301' THEN (TIMESTAMPDIFF(HOUR, mulai, selesai) * 3000) 
    WHEN kd_ps = 'PS302' THEN (TIMESTAMPDIFF(HOUR, mulai, selesai) * 3000)
    WHEN kd_ps = 'PS401' THEN (TIMESTAMPDIFF(HOUR, mulai, selesai) * 5000) 
    WHEN kd_ps = 'PS402' THEN (TIMESTAMPDIFF(HOUR, mulai, selesai) * 5000) 
    WHEN kd_ps = 'PS501' THEN (TIMESTAMPDIFF(HOUR, mulai, selesai) * 8000) 
    WHEN kd_ps = 'PS502' THEN (TIMESTAMPDIFF(HOUR, mulai, selesai) * 8000) 
  END
) STORED;


-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

INSERT INTO pelanggan (kd_plg, nama, jk, alamat, telepon) VALUES
('PLG001', 'Andi Pratama', 'Laki-laki', 'Jl. Merdeka No.1, Jakarta', '081234567890'),
('PLG002', 'Siti Aminah', 'Perempuan', 'Jl. Sudirman No.5, Bandung', '081234567891'),
('PLG003', 'Budi Santoso', 'Laki-laki', 'Jl. Raya No.10, Surabaya', '081234567892'),
('PLG004', 'Dina Puspita', 'Perempuan', 'Jl. Anggrek No.3, Yogyakarta', '081234567893'),
('PLG005', 'Hendra Wijaya', 'Laki-laki', 'Jl. Kuningan No.8, Medan', '081234567894'),
('PLG006', 'Ratna Dewi', 'Perempuan', 'Jl. Bunga No.6, Makassar', '081234567895'),
('PLG007', 'Fahmi Alamsyah', 'Laki-laki', 'Jl. Cendana No.7, Bali', '081234567896'),
('PLG008', 'Putri Pramudita', 'Perempuan', 'Jl. Melati No.2, Semarang', '081234567897'),
('PLG009', 'Eko Santosa', 'Laki-laki', 'Jl. Pahlawan No.12, Malang', '081234567898'),
('PLG010', 'Lina Mardiana', 'Perempuan', 'Jl. Harapan No.4, Surakarta', '081234567899');

INSERT INTO pelanggan (kd_plg, nama, jk, alamat, telepon) VALUES
('PLG011', 'Doni Setiawan', 'Laki-laki', 'Jl. Manggis No.9, Jakarta', '081234567900'),
('PLG012', 'Maya Pratiwi', 'Perempuan', 'Jl. Mawar No.4, Bandung', '081234567901'),
('PLG013', 'Rudi Hartono', 'Laki-laki', 'Jl. Pahlawan No.15, Surabaya', '081234567902'),
('PLG014', 'Lestari Sari', 'Perempuan', 'Jl. Kenanga No.6, Yogyakarta', '081234567903'),
('PLG015', 'Ali Akbar', 'Laki-laki', 'Jl. Raya No.18, Medan', '081234567904'),
('PLG016', 'Yuniar Zainab', 'Perempuan', 'Jl. Anggrek No.10, Makassar', '081234567905'),
('PLG017', 'Taufik Hidayat', 'Laki-laki', 'Jl. Pinang No.8, Bali', '081234567906'),
('PLG018', 'Nina Oktavia', 'Perempuan', 'Jl. Kemuning No.5, Semarang', '081234567907'),
('PLG019', 'Agus Santoso', 'Laki-laki', 'Jl. Pahlawan No.8, Malang', '081234567908'),
('PLG020', 'Rina Apriani', 'Perempuan', 'Jl. Taman No.3, Surakarta', '081234567909');

-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

INSERT INTO playstation (kd_ps, tipe) VALUES
('PS301', 'PlayStation 3'),
('PS302', 'PlayStation 3'),
('PS401', 'PlayStation 4'),
('PS402', 'PlayStation 4'),
('PS501', 'PlayStation 5'),
('PS502', 'PlayStation 5');

-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

INSERT INTO rental (kd_plg, kd_ps, mulai, selesai) VALUES
('PLG001', 'PS301', '2025-01-31 10:00:00', '2025-01-31 14:00:00'),
('PLG002', 'PS302', '2025-01-31 11:00:00', '2025-01-31 14:00:00'),
('PLG003', 'PS401', '2025-01-31 12:00:00', '2025-01-31 13:00:00'),
('PLG004', 'PS402', '2025-01-31 13:00:00', '2025-01-31 15:00:00'),
('PLG005', 'PS501', '2025-01-31 14:00:00', '2025-01-31 18:00:00'),
('PLG006', 'PS502', '2025-01-31 15:00:00', '2025-01-31 20:00:00'),
('PLG007', 'PS301', '2025-01-31 16:00:00', '2025-01-31 21:00:00'),
('PLG008', 'PS401', '2025-01-31 17:00:00', '2025-01-31 23:00:00'),
('PLG009', 'PS501', '2025-01-31 18:00:00', '2025-01-31 20:00:00');

INSERT INTO rental (kd_plg, kd_ps, mulai, selesai) VALUES
('PLG010', 'PS301', '2025-02-01 09:00:00', '2025-02-01 12:00:00'),
('PLG011', 'PS302', '2025-02-01 10:00:00', '2025-02-01 13:00:00'),
('PLG012', 'PS401', '2025-02-01 11:00:00', '2025-02-01 14:00:00'),
('PLG013', 'PS402', '2025-02-01 12:00:00', '2025-02-01 15:00:00'),
('PLG014', 'PS501', '2025-02-01 13:00:00', '2025-02-01 17:00:00'),
('PLG015', 'PS502', '2025-02-01 14:00:00', '2025-02-01 19:00:00'),
('PLG016', 'PS301', '2025-02-01 15:00:00', '2025-02-01 19:00:00'),
('PLG017', 'PS401', '2025-02-01 16:00:00', '2025-02-01 20:00:00'),
('PLG018', 'PS502', '2025-02-01 17:00:00', '2025-02-01 22:00:00'),
('PLG019', 'PS301', '2025-02-01 18:00:00', '2025-02-01 22:00:00'),
('PLG020', 'PS402', '2025-02-01 19:00:00', '2025-02-01 23:00:00');
