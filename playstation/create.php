<?php
// Koneksi ke database
include_once '../database/connect.php';  // Pastikan file db.php berisi koneksi ke database

// Cek jika form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $kd_ps = $_POST['kd_ps'];
    $tipe = $_POST['tipe'];
    $status = $_POST['status'];

    // Validasi input
    if (empty($kd_ps) || empty($tipe) || empty($status)) {
        $error_message = "Semua kolom harus diisi!";
    } else {
        // Cek apakah kode PlayStation sudah ada
        $check_kd_ps_sql = "SELECT COUNT(*) FROM playstation WHERE kd_ps = ?";
        $stmt = $conn->prepare($check_kd_ps_sql);
        $stmt->bind_param("s", $kd_ps);
        $stmt->execute();
        $stmt->bind_result($kd_ps_count);
        $stmt->fetch();
        $stmt->close();

        if ($kd_ps_count > 0) {
            // Jika kode PlayStation sudah ada
            $error_message = "Kode PlayStation '$kd_ps' sudah digunakan. Silakan pilih kode lain.";
        } else {
            // Query untuk menyimpan data PlayStation
            $sql = "INSERT INTO playstation (kd_ps, tipe, status) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $kd_ps, $tipe, $status);

            // Eksekusi query
            if ($stmt->execute()) {
                // Redirect ke halaman daftar PlayStation setelah berhasil disimpan
                header("Location: ../playstation/index.php"); // Ganti dengan URL halaman daftar PlayStation
                exit();  // Menghentikan eksekusi kode setelah redirect
            } else {
                $error_message = "Terjadi kesalahan saat menambahkan PlayStation.";
            }

            // Tutup statement
            $stmt->close();
        }
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah PlayStation</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="../assets/js/bootstrap.bundle.min.js" type="text/javascript"></script>
  </head>

  <body class="p-3 m-0 border-0 bd-example">
    <div class="container">
      <h1 class="text-center mb-4">Tambah PlayStation</h1>
      <p class="text-center mb-5">Silakan isi data di bawah ini untuk menambahkan PlayStation baru ke dalam sistem.</p>

      <?php
      // Menampilkan pesan kesalahan atau keberhasilan
      if (isset($error_message)) {
          echo "<div class='alert alert-danger'>$error_message</div>";
      }
      ?>

      <!-- Form untuk menambahkan PlayStation -->
      <form method="POST" action="">
        <div class="row mb-3">
          <label for="kd_ps" class="col-sm-2 col-form-label">Kode</label>
          <div class="col-sm-10">
            <input type="text" id="kd_ps" class="form-control" placeholder="Kode PlayStation" name="kd_ps" value="<?php echo isset($kd_ps) ? htmlspecialchars($kd_ps) : ''; ?>" required>
          </div>
        </div>

        <div class="row mb-3">
          <label for="tipe" class="col-sm-2 col-form-label">Tipe</label>
          <div class="col-sm-10">
            <select id="tipe" class="form-select" name="tipe" required>
              <option value="" selected>Pilih Tipe</option>
              <option value="PlayStation 3" <?php echo (isset($tipe) && $tipe == 'PlayStation 3') ? 'selected' : ''; ?>>PlayStation 3</option>
              <option value="PlayStation 4" <?php echo (isset($tipe) && $tipe == 'PlayStation 4') ? 'selected' : ''; ?>>PlayStation 4</option>
              <option value="PlayStation 5" <?php echo (isset($tipe) && $tipe == 'PlayStation 5') ? 'selected' : ''; ?>>PlayStation 5</option>
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <label for="status" class="col-sm-2 col-form-label">Status</label>
          <div class="col-sm-10">
            <select id="status" class="form-select" name="status" required>
              <option value="" selected>Pilih Status</option>
              <option value="Tersedia" <?php echo (isset($status) && $status == 'Tersedia') ? 'selected' : ''; ?>>Tersedia</option>
              <option value="Rental" <?php echo (isset($status) && $status == 'Rental') ? 'selected' : ''; ?>>Rental</option>
            </select>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <button class="btn btn-success d-inline-flex align-items-center" type="submit">
            <img src="../assets/icons/floppy.svg" alt="Simpan" class="me-2">
            Simpan
          </button>
          <a href="../playstation/" class="btn btn-warning d-inline-flex align-items-center" type="button">
           <img src="../assets/icons/reply.svg" alt="Kembali" class="me-2">
            Kembali
          </a>
        </div>
      </form>
    </div>
  </body>
</html>
