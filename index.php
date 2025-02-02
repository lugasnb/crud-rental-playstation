<?php
session_start(); // Memulai sesi

// Cek apakah pengguna sudah login
if (isset($_SESSION['logged_in'])) {
    header('Location: includes/navbar.php'); // Arahkan ke navbar jika sudah login
    exit();
}

// Koneksi database
include_once 'database/connect.php';

// Inisialisasi variabel error
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mengambil data login admin
    $sql = "SELECT * FROM login WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Mengambil data login
        $login_data = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $login_data['password'])) {
            // Jika login berhasil, simpan informasi dalam session
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $login_data['username'];

            // Redirect ke halaman navbar
            header('Location: includes/navbar.php');
            exit();
        } else {
            $error = 'Username atau password salah!';
        }
    } else {
        $error = 'Username atau password salah!';
    }
}
?>

<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/login.css" rel="stylesheet">
    <title>Form Login</title>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
  </head>
  <body class="d-flex justify-content-center align-items-center vh-100">

    <!-- Card Container -->
    <div class="card" style="max-width: 400px; width: 100%;">
      <div class="card-body">
        <div class="text-center mb-5">
          <h1 class="h3">SELAMAT DATANG</h1>
          <p>CRUD Untuk Rental PlayStation</p>
        </div>
        
        <!-- Form Login -->
        <form method="POST" action="">
          <!-- Username Input -->
          <div class="mb-2">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
          </div>

          <!-- Password Input -->
          <div class="mb-5">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
          </div>

          <!-- Error Message -->
          <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
          <?php endif; ?>

          <!-- Login Button -->
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
      </div>
    </div>

  </body>
</html>
