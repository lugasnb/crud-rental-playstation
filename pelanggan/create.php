<?php
// Koneksi ke database
include_once '../database/connect.php';  // Pastikan file db.php berisi koneksi ke database

// Cek jika form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $kd_plg = $_POST['kd_plg'];
    $nama = $_POST['nama'];
    $jk = $_POST['jk'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];

    // Validasi input
    if (empty($kd_plg) || empty($nama) || empty($jk) || empty($alamat) || empty($telepon)) {
        $error_message = "Semua kolom harus diisi!";
    } else {
        // Cek apakah kode pelanggan sudah ada
        $check_kd_plg_sql = "SELECT COUNT(*) FROM pelanggan WHERE kd_plg = ?";
        $stmt = $conn->prepare($check_kd_plg_sql);
        $stmt->bind_param("s", $kd_plg);
        $stmt->execute();
        $stmt->bind_result($kd_plg_count);
        $stmt->fetch();
        $stmt->close();

        if ($kd_plg_count > 0) {
            // Jika kode pelanggan sudah ada
            $error_message = "Kode pelanggan '$kd_plg' sudah digunakan. Silakan pilih kode lain.";
        } else {
            // Query untuk menyimpan data pelanggan
            $sql = "INSERT INTO pelanggan (kd_plg, nama, jk, alamat, telepon) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $kd_plg, $nama, $jk, $alamat, $telepon);

            // Eksekusi query
            if ($stmt->execute()) {
                // Redirect ke halaman daftar pelanggan setelah berhasil disimpan
                header("Location: ../pelanggan/index.php"); // Ganti dengan URL halaman daftar pelanggan
                exit();  // Menghentikan eksekusi kode setelah redirect
            } else {
                $error_message = "Terjadi kesalahan saat menambahkan pelanggan.";
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
    <title>Tambah Pelanggan</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="../assets/js/bootstrap.bundle.min.js" type="text/javascript"></script>
  </head>

  <body class="p-3 m-0 border-0 bd-example">
    <div class="container">
      <h1 class="text-center mb-4">Tambah Pelanggan</h1>
      <p class="text-center mb-5">Silakan isi data di bawah ini untuk menambahkan pelanggan baru ke dalam sistem.</p>

      <?php
      // Menampilkan pesan kesalahan atau keberhasilan
      if (isset($error_message)) {
          echo "<div class='alert alert-danger'>$error_message</div>";
      }
      ?>

      <!-- Form untuk menambahkan pelanggan -->
      <form method="POST" action="">
        <div class="row mb-3">
          <label for="kd_plg" class="col-sm-2 col-form-label">Kode</label>
          <div class="col-sm-10">
            <input type="text" id="kd_plg" class="form-control" placeholder="Kode Pelanggan" name="kd_plg" value="<?php echo isset($kd_plg) ? htmlspecialchars($kd_plg) : ''; ?>" required>
          </div>
        </div>

        <div class="row mb-3">
          <label for="name" class="col-sm-2 col-form-label">Nama</label>
          <div class="col-sm-10">
            <input type="text" id="name" class="form-control" placeholder="Nama" name="nama" value="<?php echo isset($nama) ? htmlspecialchars($nama) : ''; ?>" required>
          </div>
        </div>

        <div class="row mb-3">
          <label for="gender" class="col-sm-2 col-form-label">Jenis Kelamin</label>
          <div class="col-sm-10">
            <select id="gender" class="form-select" name="jk" required>
              <option value="" selected>Pilih Jenis Kelamin</option>
              <option value="Laki-laki" <?php echo (isset($jk) && $jk == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
              <option value="Perempuan" <?php echo (isset($jk) && $jk == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <label for="address" class="col-sm-2 col-form-label">Alamat</label>
          <div class="col-sm-10">
            <textarea type="text" id="address" class="form-control" placeholder="Alamat" name="alamat" required><?php echo isset($alamat) ? htmlspecialchars($alamat) : ''; ?></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <label for="phone" class="col-sm-2 col-form-label">Telepon</label>
          <div class="col-sm-10">
            <input type="text" id="phone" class="form-control" placeholder="Telepon" name="telepon" value="<?php echo isset($telepon) ? htmlspecialchars($telepon) : ''; ?>" required>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <button class="btn btn-success d-inline-flex align-items-center" type="submit">
            <img src="../assets/icons/floppy.svg" alt="Simpan" class="me-2">
            Simpan
          </button>
          <a href="../pelanggan/" class="btn btn-warning d-inline-flex align-items-center" type="button">
           <img src="../assets/icons/reply.svg" alt="Kembali" class="me-2">
            Kembali
          </a>
        </div>
      </form>
    </div>
  </body>
</html>
