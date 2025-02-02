<?php
// Database connection
include_once '../database/connect.php';

// Fetch total number of customers (Jumlah Pelanggan)
$sql_pelanggan = "SELECT COUNT(*) AS total_pelanggan FROM pelanggan";
$result_pelanggan = $conn->query($sql_pelanggan);
$row_pelanggan = $result_pelanggan->fetch_assoc();
$total_pelanggan = $row_pelanggan['total_pelanggan'];

// Fetch total number of available PlayStations (Jumlah PlayStation Tersedia)
$sql_ps_tersedia = "SELECT COUNT(*) AS tersedia FROM playstation WHERE status = 'Tersedia'";
$result_ps_tersedia = $conn->query($sql_ps_tersedia);
$row_ps_tersedia = $result_ps_tersedia->fetch_assoc();
$ps_tersedia = $row_ps_tersedia['tersedia'];

// Fetch total rental transactions this month (Total Sewa Bulan Ini)
$sql_rental_month = "SELECT COUNT(*) AS rental_month FROM rental WHERE MONTH(mulai) = MONTH(CURDATE()) AND YEAR(mulai) = YEAR(CURDATE())";
$result_rental_month = $conn->query($sql_rental_month);
$row_rental_month = $result_rental_month->fetch_assoc();
$rental_month = $row_rental_month['rental_month'];

// Fetch total revenue from rentals this month (Pendapatan Bulan Ini)
$sql_revenue_month = "SELECT SUM(total_bayar) AS total_revenue FROM rental WHERE MONTH(mulai) = MONTH(CURDATE()) AND YEAR(mulai) = YEAR(CURDATE())";
$result_revenue_month = $conn->query($sql_revenue_month);
$row_revenue_month = $result_revenue_month->fetch_assoc();
$total_revenue_month = $row_revenue_month['total_revenue'];

// Close connection
$conn->close();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/datetime.css" rel="stylesheet">
    <title>Dashboard Pelanggan</title>
    <script type="text/javascript" src="../assets/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../assets/js/datetime.js" defer></script>
  </head>
  <body class="p-3 m-0 border-0">

    <?php include_once '../includes/navbar.php'; ?>
    
    <div class="container text-center mb-5">
      <h1 class="mb-4">PELANGGAN</h1>
      <p>Statistik terkait jumlah pelanggan, status PlayStation, dan transaksi rental bulan ini.</p>
    </div>

    <div class="container text-center">
      <div class="row justify-content-center">
        <div class="col-md-3">
          <div class="card shadow-lg hover-card">
            <div class="card-body">
              <h2 class="card-title"><?php echo $total_pelanggan; ?></h2>
              <p class="card-text text-muted">Jumlah Pelanggan</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card shadow-lg hover-card">
            <div class="card-body">
              <h2 class="card-title"><?php echo $ps_tersedia; ?></h2>
              <p class="card-text text-muted">PlayStation Tersedia</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card shadow-lg hover-card">
            <div class="card-body">
              <h2 class="card-title"><?php echo $rental_month; ?></h2>
              <p class="card-text text-muted">Transaksi Sewa Bulan Ini</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card shadow-lg hover-card">
            <div class="card-body">
              <h2 class="card-title"><?php echo 'Rp. ' . number_format($total_revenue_month, 0, ',', '.'); ?></h2>
              <p class="card-text text-muted">Pendapatan Bulan Ini</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <!-- Jam Digital Card -->
          <div class="card shadow-lg" id="time-card">
            <div class="card-body">
              <h3 class="card-title" id="time"></h3>
              <p class="card-text" id="date"></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
