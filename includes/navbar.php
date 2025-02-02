<?php
session_start(); // Memulai sesi

// Cek apakah pengguna sudah login
if (!isset($_SESSION['logged_in'])) {
    header('Location: ../index.php'); // Jika belum login, arahkan ke halaman login
    exit();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <title>Dashboard</title>
    <script type="text/javascript" src="../assets/js/bootstrap.bundle.min.js"></script>
  </head>
  <body class="p-3 m-0 border-0 bd-example">
    <nav class="navbar">
      <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="#">
          <img src="../assets/icons/playstation.svg" alt="Logo" width="40" height="34" class="d-inline-block align-text-top">
          PlayStation
        </a>

        <!-- Navigation Tabs -->
        <div class="col">
          <ul class="nav nav-tabs justify-content-center">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="../includes/dashboard.php">
                <img src="../assets/icons/house.svg" alt="Home">
                Home
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../pelanggan/">
                <img src="../assets/icons/people.svg" alt="Pelanggan">
                Pelanggan
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../playstation/">
                <img src="../assets/icons/controller.svg" alt="PlayStation">
                PlayStation
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../rental/">
                <img src="../assets/icons/stopwatch.svg" alt="Rental">
                Rental
              </a>
            </li>
          </ul>
        </div>
        <div>
          <ul class="nav justify-content-center">
            <li class="nav-item">
              <a class="nav-link" href="../logout.php">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </body>
</html>
