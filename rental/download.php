<?php
require_once('../assets/libs/fpdf/fpdf.php');
include_once '../database/connect.php';

// Cek apakah ada parameter `id` yang dikirimkan
if (!isset($_GET['id'])) {
    die("ID rental tidak ditemukan.");
}

$id = $_GET['id'];

// Query untuk mengambil data rental berdasarkan id
$sql = "SELECT rental.id, rental.kd_plg, rental.kd_ps, rental.mulai, rental.selesai, rental.durasi, rental.total_bayar,
                pelanggan.nama AS nama_plg, pelanggan.jk, pelanggan.alamat, pelanggan.telepon,
                playstation.tipe AS tipe_ps, playstation.harga
        FROM rental
        JOIN pelanggan ON rental.kd_plg = pelanggan.kd_plg
        JOIN playstation ON rental.kd_ps = playstation.kd_ps
        WHERE rental.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Mengecek apakah data ditemukan
if ($result->num_rows == 0) {
    die("Rental tidak ditemukan.");
}

$row = $result->fetch_assoc();

// Membuat objek FPDF
$pdf = new FPDF();
$pdf->AddPage();


$pdf->Ln(5);

// Header Invoice
$pdf->Image('../assets/images/PlayStation_logo.png', 20, 13, 15, 0); // Gambar di posisi (10,10) dengan lebar 30mm

$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(200, 10, 'INVOICE RENTAL PLAYSTATION', 0, 1, 'C');
$pdf->Ln(5);

// Garis Pemisah
$pdf->SetDrawColor(0, 0, 0);
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY()); // Garis horizontal
$pdf->Ln(10);

// Menambahkan tanggal dibuat di pojok kanan bawah setelah garis
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, 'Tanggal Dibuat: ' . date('d/m/Y H:i'), 0, 1, 'R');

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(200, 10, 'PELANGGAN', 0, 1, 'L');
$pdf->Ln(5);

// Data Pelanggan
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Kode Pelanggan', 0, 0);
$pdf->Cell(10, 10, ':', 0, 0); // Memberikan sedikit jarak antara label dan titik dua
$pdf->SetFont('Arial', '', 12); // Mengubah font untuk isi
$pdf->Cell(150, 10, $row['kd_plg'], 0, 1); // Menampilkan nilai Kode Pelanggan

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Nama Pelanggan', 0, 0);
$pdf->Cell(10, 10, ':', 0, 0);
$pdf->SetFont('Arial', '', 12); // Mengubah font untuk isi
$pdf->Cell(150, 10, $row['nama_plg'], 0, 1); // Menampilkan nilai Nama Pelanggan

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Jenis Kelamin', 0, 0);
$pdf->Cell(10, 10, ':', 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, 10, $row['jk'], 0, 1); // Menampilkan nilai Jenis Kelamin

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Alamat', 0, 0);
$pdf->Cell(10, 10, ':', 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(150, 10, $row['alamat'], 0, 1); // Menampilkan nilai Alamat

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Telepon', 0, 0);
$pdf->Cell(10, 10, ':', 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, 10, $row['telepon'], 0, 1); // Menampilkan nilai Telepon

// Spasi sebelum tabel rental
$pdf->Ln(20);

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(200, 10, 'PlayStation', 0, 1, 'C');
$pdf->Ln(5);

// Menentukan lebar kolom untuk tabel
$total_width = 190; // Lebar halaman A4 (210mm) dikurangi margin kiri (10mm) dan kanan (10mm)
$kolom1 = 30; // Kode
$kolom2 = 40; // Tipe
$kolom3 = 45; // Mulai
$kolom4 = 45; // Selesai
$kolom5 = 30; // Durasi
$kolom6 = 40; // Harga

// Menghitung total lebar untuk memastikan tidak melebihi lebar kertas
$total_column_width = $kolom1 + $kolom2 + $kolom3 + $kolom4 + $kolom5 + $kolom6;
$adjustment = $total_width / $total_column_width; // Menghitung faktor penyesuaian

// Mengatur lebar kolom agar total lebar tabel sesuai dengan lebar halaman
$kolom1 *= $adjustment;
$kolom2 *= $adjustment;
$kolom3 *= $adjustment;
$kolom4 *= $adjustment;
$kolom5 *= $adjustment;
$kolom6 *= $adjustment;

// Tabel untuk Detail Rental
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell($kolom1, 10, 'Kode', 1, 0, 'C');
$pdf->Cell($kolom2, 10, 'Tipe', 1, 0, 'C');
$pdf->Cell($kolom3, 10, 'Mulai', 1, 0, 'C');
$pdf->Cell($kolom4, 10, 'Selesai', 1, 0, 'C');
$pdf->Cell($kolom5, 10, 'Durasi', 1, 0, 'C');
$pdf->Cell($kolom6, 10, 'Harga', 1, 1, 'C');

// Mengisi tabel dengan data rental
$pdf->SetFont('Arial', '', 11);
$pdf->Cell($kolom1, 10, $row['kd_ps'], 1, 0, 'C');
$pdf->Cell($kolom2, 10, $row['tipe_ps'], 1, 0, 'C');
$pdf->Cell($kolom3, 10, date('d/m/Y H:i', strtotime($row['mulai'])), 1, 0, 'C');
$pdf->Cell($kolom4, 10, date('d/m/Y H:i', strtotime($row['selesai'])), 1, 0, 'C');
$pdf->Cell($kolom5, 10, $row['durasi'], 1, 0, 'C');
$pdf->Cell($kolom6, 10, "Rp " . number_format($row['harga'], 2, ',', '.'), 1, 1, 'C');

// Spasi untuk Total Bayar
$pdf->Ln(5);

// Total Bayar
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(150, 10, 'Total Bayar', 0, 0, 'R');
$pdf->Cell(40, 10, "Rp " . number_format($row['total_bayar'], 2, ',', '.'), 0, 1, 'R');

// Garis Pemisah
$pdf->Ln(20);
$pdf->SetDrawColor(0, 0, 0);
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY()); // Garis horizontal
$pdf->Ln(5);

// Footer
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, 'Terima kasih telah melakukan transaksi dengan kami.', 0, 0, 'C');

// Output PDF
$pdf->Output('D', 'invoice_' . $row['id'] . '.pdf');
exit();
?>
