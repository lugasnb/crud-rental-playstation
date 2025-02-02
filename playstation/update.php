<?php
// Koneksi ke database
include_once '../database/connect.php';

// Cek apakah ada parameter `id` yang dikirimkan
if (!isset($_GET['id'])) {
    die("ID PlayStation tidak ditemukan.");
}

$id = $_GET['id'];

// Query untuk mengambil data PlayStation berdasarkan id
$sql = "SELECT * FROM playstation WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Jika PlayStation ditemukan
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $kd_ps = $row['kd_ps'];
    $tipe = $row['tipe'];
    $status = $row['status'];
} else {
    die("PlayStation tidak ditemukan.");
}

// Cek jika form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $new_kd_ps = $_POST['kd_ps'];
    $new_tipe = $_POST['tipe'];
    $new_status = $_POST['status'];

    // Validasi input
    if (empty($new_kd_ps) || empty($new_tipe) || empty($new_status)) {
        $error_message = "Semua kolom harus diisi!";
    } else {
        // Cek apakah kode PlayStation sudah ada di database jika kode diubah
        if ($new_kd_ps != $kd_ps) {
            $check_kd_ps = "SELECT id FROM playstation WHERE kd_ps = ? AND id != ?";
            $stmt_check_kd_ps = $conn->prepare($check_kd_ps);
            $stmt_check_kd_ps->bind_param("si", $new_kd_ps, $id);
            $stmt_check_kd_ps->execute();
            $kd_ps_result = $stmt_check_kd_ps->get_result();

            if ($kd_ps_result->num_rows > 0) {
                $error_message = "Kode PlayStation sudah digunakan!";
            }
        }

        // Jika tidak ada error, lakukan update
        if (!isset($error_message)) {
            // Query untuk memperbarui data PlayStation
            $update_sql = "UPDATE playstation SET kd_ps = ?, tipe = ?, status = ? WHERE id = ?";
            $stmt_update = $conn->prepare($update_sql);
            $stmt_update->bind_param("sssi", $new_kd_ps, $new_tipe, $new_status, $id);

            // Eksekusi query
            if ($stmt_update->execute()) {
                // Redirect ke halaman daftar PlayStation setelah berhasil diperbarui
                header("Location: ../playstation/index.php");
                exit();  // Menghentikan eksekusi kode setelah redirect
            } else {
                $error_message = "Terjadi kesalahan saat memperbarui data PlayStation.";
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
    <title>Update PlayStation</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="../assets/js/bootstrap.bundle.min.js" type="text/javascript"></script>
</head>

<body class="p-3 m-0 border-0 bd-example">
    <div class="container">
        <h1 class="text-center mb-4">Update PlayStation</h1>
        <p class="text-center mb-5">Silakan ubah data di bawah ini untuk memperbarui informasi PlayStation.</p>

        <!-- Menampilkan pesan error jika ada -->
        <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
            </div>
        <?php } ?>

        <!-- Form untuk update data PlayStation -->
        <form method="POST" action="">
            <div class="row mb-3">
                <label for="kd_ps" class="col-sm-2 col-form-label">Kode PlayStation</label>
                <div class="col-sm-10">
                    <input type="text" id="kd_ps" class="form-control" placeholder="Kode PlayStation" name="kd_ps"
                        value="<?php echo htmlspecialchars($kd_ps); ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="tipe" class="col-sm-2 col-form-label">Tipe</label>
                <div class="col-sm-10">
                    <select id="tipe" class="form-select" name="tipe" required>
                        <option value="PlayStation 3" <?php echo ($tipe == 'PlayStation 3') ? 'selected' : ''; ?>>PlayStation 3</option>
                        <option value="PlayStation 4" <?php echo ($tipe == 'PlayStation 4') ? 'selected' : ''; ?>>PlayStation 4</option>
                        <option value="PlayStation 5" <?php echo ($tipe == 'PlayStation 5') ? 'selected' : ''; ?>>PlayStation 5</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="status" class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-10">
                    <select id="status" class="form-select" name="status" required>
                        <option value="Tersedia" <?php echo ($status == 'Tersedia') ? 'selected' : ''; ?>>Tersedia</option>
                        <option value="Rental" <?php echo ($status == 'Rental') ? 'selected' : ''; ?>>Rental</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button class="btn btn-success d-inline-flex align-items-center" type="submit">
                    <img src="../assets/icons/floppy.svg" alt="Simpan" class="me-2"> Simpan
                </button>
                <a href="../playstation/" class="btn btn-warning d-inline-flex align-items-center" type="button">
                    <img src="../assets/icons/reply.svg" alt="Kembali" class="me-2"> Kembali
                </a>
            </div>
        </form>
    </div>
</body>

</html>
