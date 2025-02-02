<?php
// Koneksi ke database
include_once '../database/connect.php';

// Cek apakah ada parameter `id` yang dikirimkan
if (!isset($_GET['id'])) {
    die("ID pelanggan tidak ditemukan.");
}

$id = $_GET['id'];

// Query untuk mengambil data pelanggan berdasarkan id
$sql = "SELECT * FROM pelanggan WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Jika pelanggan ditemukan
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $kd_plg = $row['kd_plg'];
    $nama = $row['nama'];
    $jk = $row['jk'];
    $alamat = $row['alamat'];
    $telepon = $row['telepon'];
} else {
    die("Pelanggan tidak ditemukan.");
}

// Cek jika form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $new_kd_plg = $_POST['kd_plg'];
    $new_nama = $_POST['nama'];
    $new_jk = $_POST['jk'];
    $new_alamat = $_POST['alamat'];
    $new_telepon = $_POST['telepon'];

    // Validasi input
    if (empty($new_kd_plg) || empty($new_nama) || empty($new_jk) || empty($new_alamat) || empty($new_telepon)) {
        $error_message = "Semua kolom harus diisi!";
    } else {
        // Cek apakah kode pelanggan sudah ada di database jika kode diubah
        if ($new_kd_plg != $kd_plg) {
            $check_kd_plg = "SELECT id FROM pelanggan WHERE kd_plg = ? AND id != ?";
            $stmt_check_kd_plg = $conn->prepare($check_kd_plg);
            $stmt_check_kd_plg->bind_param("si", $new_kd_plg, $id);
            $stmt_check_kd_plg->execute();
            $kd_plg_result = $stmt_check_kd_plg->get_result();

            if ($kd_plg_result->num_rows > 0) {
                $error_message = "Kode pelanggan sudah digunakan!";
            }
        }

        // Cek apakah nama pelanggan sudah ada di database jika nama diubah
        if ($new_nama != $nama) {
            $check_nama = "SELECT id FROM pelanggan WHERE nama = ? AND id != ?";
            $stmt_check_nama = $conn->prepare($check_nama);
            $stmt_check_nama->bind_param("si", $new_nama, $id);
            $stmt_check_nama->execute();
            $nama_result = $stmt_check_nama->get_result();

            if ($nama_result->num_rows > 0) {
                $error_message = "Nama pelanggan sudah ada di sistem!";
            }
        }

        // Cek apakah kode pelanggan yang diubah digunakan pada tabel rental
        if ($new_kd_plg != $kd_plg) {
            $check_rental = "SELECT id FROM rental WHERE kd_plg = ?";
            $stmt_check_rental = $conn->prepare($check_rental);
            $stmt_check_rental->bind_param("s", $new_kd_plg);
            $stmt_check_rental->execute();
            $rental_result = $stmt_check_rental->get_result();

            if ($rental_result->num_rows > 0) {
                $error_message = "Kode pelanggan tidak dapat diubah karena sudah digunakan dalam transaksi rental!";
            }
        }

        // Jika tidak ada error, lakukan update
        if (!isset($error_message)) {
            // Query untuk memperbarui data pelanggan
            $update_sql = "UPDATE pelanggan SET kd_plg = ?, nama = ?, jk = ?, alamat = ?, telepon = ? WHERE id = ?";
            $stmt_update = $conn->prepare($update_sql);
            $stmt_update->bind_param("sssssi", $new_kd_plg, $new_nama, $new_jk, $new_alamat, $new_telepon, $id);

            // Eksekusi query
            if ($stmt_update->execute()) {
                // Redirect ke halaman daftar pelanggan setelah berhasil diperbarui
                header("Location: ../pelanggan/index.php");
                exit();  // Menghentikan eksekusi kode setelah redirect
            } else {
                $error_message = "Terjadi kesalahan saat memperbarui data pelanggan.";
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
    <title>Update Pelanggan</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="../assets/js/bootstrap.bundle.min.js" type="text/javascript"></script>
  </head>

  <body class="p-3 m-0 border-0 bd-example">
    <div class="container">
      <h1 class="text-center mb-4">Update Pelanggan</h1>
      <p class="text-center mb-5">Silakan ubah data di bawah ini untuk memperbarui informasi pelanggan.</p>

      <!-- Menampilkan pesan error jika ada -->
      <?php if (isset($error_message)) { ?>
        <div class="alert alert-danger">
          <?php echo $error_message; ?>
        </div>
      <?php } ?>

      <!-- Form untuk update data pelanggan -->
      <form method="POST" action="">
        <div class="row mb-3">
          <label for="kd_plg" class="col-sm-2 col-form-label">Kode</label>
          <div class="col-sm-10">
            <input type="text" id="kd_plg" class="form-control" placeholder="Kode Pelanggan" name="kd_plg" value="<?php echo htmlspecialchars($kd_plg); ?>" required>
          </div>
        </div>

        <div class="row mb-3">
          <label for="name" class="col-sm-2 col-form-label">Nama</label>
          <div class="col-sm-10">
            <input type="text" id="name" class="form-control" placeholder="Nama" name="nama" value="<?php echo htmlspecialchars($nama); ?>" required>
          </div>
        </div>

        <div class="row mb-3">
          <label for="gender" class="col-sm-2 col-form-label">Jenis Kelamin</label>
          <div class="col-sm-10">
            <select id="gender" class="form-select" name="jk" required>
              <option value="Laki-laki" <?php echo ($jk == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
              <option value="Perempuan" <?php echo ($jk == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <label for="address" class="col-sm-2 col-form-label">Alamat</label>
          <div class="col-sm-10">
            <textarea id="address" class="form-control" placeholder="Alamat" name="alamat" required><?php echo htmlspecialchars($alamat); ?></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <label for="phone" class="col-sm-2 col-form-label">Telepon</label>
          <div class="col-sm-10">
            <input type="text" id="phone" class="form-control" placeholder="Telepon" name="telepon" value="<?php echo htmlspecialchars($telepon); ?>" required>
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
