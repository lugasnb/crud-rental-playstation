<?php
// Koneksi ke database
include_once '../database/connect.php';

// Cek apakah ada parameter `id` yang dikirimkan
if (!isset($_GET['id'])) {
    die("ID rental tidak ditemukan.");
}

$id = $_GET['id'];

// Query untuk mengambil data rental berdasarkan id
$sql = "SELECT * FROM rental WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Jika rental ditemukan
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $kd_plg = $row['kd_plg'];
    $kd_ps = $row['kd_ps'];
    $mulai = $row['mulai'];
    $selesai = $row['selesai'];
} else {
    die("Rental tidak ditemukan.");
}

// Cek jika form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $new_kd_plg = $_POST['kd_plg'];
    $new_kd_ps = $_POST['kd_ps'];
    $new_mulai = $_POST['mulai'];
    $new_selesai = $_POST['selesai'];

    // Validasi input
    if (empty($new_kd_plg) || empty($new_kd_ps) || empty($new_mulai) || empty($new_selesai)) {
        $error_message = "Semua kolom harus diisi!";
    } else {
        // Cek apakah kode pelanggan sudah ada di database jika kode diubah
        if ($new_kd_plg != $kd_plg) {
            $check_kd_plg = "SELECT id FROM pelanggan WHERE kd_plg = ?";
            $stmt_check_kd_plg = $conn->prepare($check_kd_plg);
            $stmt_check_kd_plg->bind_param("s", $new_kd_plg);
            $stmt_check_kd_plg->execute();
            $kd_plg_result = $stmt_check_kd_plg->get_result();

            if ($kd_plg_result->num_rows == 0) {
                $error_message = "Kode pelanggan tidak valid!";
            }
        }

        // Cek apakah kode playstation sudah ada di database jika kode diubah
        if ($new_kd_ps != $kd_ps) {
            $check_kd_ps = "SELECT id FROM playstation WHERE kd_ps = ?";
            $stmt_check_kd_ps = $conn->prepare($check_kd_ps);
            $stmt_check_kd_ps->bind_param("s", $new_kd_ps);
            $stmt_check_kd_ps->execute();
            $kd_ps_result = $stmt_check_kd_ps->get_result();

            if ($kd_ps_result->num_rows == 0) {
                $error_message = "Kode Playstation tidak valid!";
            }
        }

        // Jika tidak ada error, lakukan update
        if (!isset($error_message)) {
            // Query untuk memperbarui data rental
            $update_sql = "UPDATE rental SET kd_plg = ?, kd_ps = ?, mulai = ?, selesai = ? WHERE id = ?";
            $stmt_update = $conn->prepare($update_sql);
            $stmt_update->bind_param("ssssi", $new_kd_plg, $new_kd_ps, $new_mulai, $new_selesai, $id);

            // Eksekusi query
            if ($stmt_update->execute()) {
                // Redirect ke halaman daftar rental setelah berhasil diperbarui
                header("Location: ../rental/index.php");
                exit();  // Menghentikan eksekusi kode setelah redirect
            } else {
                $error_message = "Terjadi kesalahan saat memperbarui data rental.";
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
    <title>Update Rental</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="../assets/js/bootstrap.bundle.min.js" type="text/javascript"></script>
  </head>

  <body class="p-3 m-0 border-0 bd-example">
    <div class="container">
      <h1 class="text-center mb-4">Update Rental</h1>
      <p class="text-center mb-5">Silakan ubah data di bawah ini untuk memperbarui informasi rental.</p>

      <!-- Menampilkan pesan error jika ada -->
      <?php if (isset($error_message)) { ?>
        <div class="alert alert-danger">
          <?php echo $error_message; ?>
        </div>
      <?php } ?>

      <!-- Form untuk update data rental -->
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
                  echo "<option value='{$row['kd_plg']}' " . ($kd_plg == $row['kd_plg'] ? 'selected' : '') . ">{$row['kd_plg']} - {$row['nama']}</option>";
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
              // Query untuk mendapatkan daftar kode Playstation
              $kd_ps_sql = "SELECT kd_ps, tipe FROM playstation";
              $result_kd_ps = $conn->query($kd_ps_sql);

              // Menampilkan pilihan Playstation
              while ($row = $result_kd_ps->fetch_assoc()) {
                  echo "<option value='{$row['kd_ps']}' " . ($kd_ps == $row['kd_ps'] ? 'selected' : '') . ">{$row['kd_ps']} - {$row['tipe']}</option>";
              }
              ?>
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <label for="mulai" class="col-sm-2 col-form-label">Waktu Mulai</label>
          <div class="col-sm-10">
            <input type="datetime-local" id="mulai" class="form-control" name="mulai" value="<?php echo htmlspecialchars($mulai); ?>" required>
          </div>
        </div>

        <div class="row mb-3">
          <label for="selesai" class="col-sm-2 col-form-label">Waktu Selesai</label>
          <div class="col-sm-10">
            <input type="datetime-local" id="selesai" class="form-control" name="selesai" value="<?php echo htmlspecialchars($selesai); ?>" required>
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
