<?php
// Koneksi ke database
include_once '../database/connect.php';  // Pastikan file db.php berisi koneksi ke database

// Cek jika form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $kd_plg = $_POST['kd_plg'];
    $kd_ps = $_POST['kd_ps'];
    $mulai = $_POST['mulai'];
    $selesai = $_POST['selesai'] ?: NULL; // Jika selesai kosong, set NULL

    // Validasi input
    if (empty($kd_plg) || empty($kd_ps) || empty($mulai)) {
        $error_message = "Semua kolom harus diisi kecuali Waktu Selesai!";
    } else {
        // Cek apakah kode pelanggan valid
        $check_kd_plg_sql = "SELECT COUNT(*) FROM pelanggan WHERE kd_plg = ?";
        $stmt = $conn->prepare($check_kd_plg_sql);
        $stmt->bind_param("s", $kd_plg);
        $stmt->execute();
        $stmt->bind_result($kd_plg_count);
        $stmt->fetch();
        $stmt->close();

        if ($kd_plg_count == 0) {
            // Jika kode pelanggan tidak ditemukan
            $error_message = "Kode pelanggan '$kd_plg' tidak valid. Silakan pilih pelanggan yang ada.";
        } else {
            // Cek apakah kode playstation valid
            $check_kd_ps_sql = "SELECT COUNT(*) FROM playstation WHERE kd_ps = ?";
            $stmt = $conn->prepare($check_kd_ps_sql);
            $stmt->bind_param("s", $kd_ps);
            $stmt->execute();
            $stmt->bind_result($kd_ps_count);
            $stmt->fetch();
            $stmt->close();

            if ($kd_ps_count == 0) {
                // Jika kode playstation tidak ditemukan
                $error_message = "Kode Playstation '$kd_ps' tidak valid. Silakan pilih playstation yang ada.";
            } else {
                // Query untuk menyimpan data rental
                $sql = "INSERT INTO rental (kd_plg, kd_ps, mulai, selesai) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $kd_plg, $kd_ps, $mulai, $selesai);

                // Eksekusi query
                if ($stmt->execute()) {
                    // Redirect ke halaman daftar rental setelah berhasil disimpan
                    header("Location: ../rental/index.php"); // Ganti dengan URL halaman daftar rental
                    exit();  // Menghentikan eksekusi kode setelah redirect
                } else {
                    $error_message = "Terjadi kesalahan saat menambahkan rental.";
                }

                // Tutup statement
                $stmt->close();
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Rental</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="../assets/js/bootstrap.bundle.min.js" type="text/javascript"></script>
  </head>

  <body class="p-3 m-0 border-0 bd-example">
    <div class="container">
      <h1 class="text-center mb-4">Tambah Rental</h1>
      <p class="text-center mb-5">Silakan isi data di bawah ini untuk menambahkan rental baru ke dalam sistem.</p>

      <?php
      // Menampilkan pesan kesalahan atau keberhasilan
      if (isset($error_message)) {
          echo "<div class='alert alert-danger'>$error_message</div>";
      }
      ?>

      <!-- Form untuk menambahkan rental -->
      <form method="POST" action="">
        <div class="row mb-3">
          <label for="kd_plg" class="col-sm-2 col-form-label">Kode Pelanggan</label>
          <div class="col-sm-10">
            <select id="kd_plg" class="form-select" name="kd_plg" required>
              <option value="" selected>Pilih Kode Pelanggan</option>
              <?php
              // Query untuk mendapatkan daftar kode pelanggan
              $kd_plg_sql = "SELECT kd_plg, nama FROM pelanggan";
              $result_kd_plg = $conn->query($kd_plg_sql);

              // Menampilkan pilihan pelanggan
              while ($row = $result_kd_plg->fetch_assoc()) {
                  echo "<option value='{$row['kd_plg']}' " . (isset($kd_plg) && $kd_plg == $row['kd_plg'] ? 'selected' : '') . ">{$row['kd_plg']} - {$row['nama']}</option>";
              }
              ?>
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <label for="kd_ps" class="col-sm-2 col-form-label">Kode Playstation</label>
          <div class="col-sm-10">
            <select id="kd_ps" class="form-select" name="kd_ps" required>
              <option value="" selected>Pilih Kode Playstation</option>
              <?php
              // Query untuk mendapatkan daftar kode playstation
              $kd_ps_sql = "SELECT kd_ps, tipe FROM playstation";
              $result_kd_ps = $conn->query($kd_ps_sql);

              // Menampilkan pilihan playstation
              while ($row = $result_kd_ps->fetch_assoc()) {
                  echo "<option value='{$row['kd_ps']}' " . (isset($kd_ps) && $kd_ps == $row['kd_ps'] ? 'selected' : '') . ">{$row['kd_ps']} - {$row['tipe']}</option>";
              }
              ?>
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <label for="mulai" class="col-sm-2 col-form-label">Waktu Mulai</label>
          <div class="col-sm-10">
            <input type="datetime-local" id="mulai" class="form-control" name="mulai" value="<?php echo isset($mulai) ? htmlspecialchars($mulai) : ''; ?>" required>
          </div>
        </div>

        <div class="row mb-3">
          <label for="selesai" class="col-sm-2 col-form-label">Waktu Selesai</label>
          <div class="col-sm-10">
            <input type="datetime-local" id="selesai" class="form-control" name="selesai" value="<?php echo isset($selesai) ? htmlspecialchars($selesai) : ''; ?>" placeholder="NULL (Jika tidak ada)" />
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <button class="btn btn-success d-inline-flex align-items-center" type="submit">
            <img src="../assets/icons/floppy.svg" alt="Simpan" class="me-2">
            Simpan
          </button>
          <a href="../rental/" class="btn btn-warning d-inline-flex align-items-center" type="button">
           <img src="../assets/icons/reply.svg" alt="Kembali" class="me-2">
            Kembali
          </a>
        </div>
      </form>
    </div>
  </body>
</html>
