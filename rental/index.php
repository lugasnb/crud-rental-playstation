<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rental</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
  </head>
  <body class="p-3 m-0 border-0 bd-example">

    <?php
      // Memasukkan navbar dan koneksi ke database
      include_once '../includes/navbar.php';
      include_once '../database/connect.php';

      // Pencarian: Inisialisasi variabel pencarian
      $search = '';
      if (isset($_GET['search'])) {
        $search = $_GET['search'];
      }

      // Menentukan jumlah data per halaman
      $limit = 8;

      // Menentukan halaman saat ini
      $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
      $offset = ($page - 1) * $limit;

      // Query untuk menghitung total jumlah data
      $total_sql = "SELECT COUNT(*) AS total FROM rental
                    JOIN pelanggan ON rental.kd_plg = pelanggan.kd_plg
                    JOIN playstation ON rental.kd_ps = playstation.kd_ps
                    WHERE rental.kd_plg LIKE ? OR rental.kd_ps LIKE ? OR pelanggan.nama LIKE ? OR playstation.tipe LIKE ?";
      $stmt_total = $conn->prepare($total_sql);
      $search_param = "%$search%";
      $stmt_total->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
      $stmt_total->execute();
      $total_result = $stmt_total->get_result();
      $total_row = $total_result->fetch_assoc();
      $total_data = $total_row['total'];
      $total_pages = ceil($total_data / $limit);

      // Query untuk mengambil data rental dengan parameter pencarian dan limit
      $sql = "SELECT rental.id, rental.kd_plg, rental.kd_ps, rental.mulai, rental.selesai, rental.durasi, rental.total_bayar,
                     pelanggan.nama AS nama_plg, playstation.tipe AS tipe_ps
              FROM rental
              JOIN pelanggan ON rental.kd_plg = pelanggan.kd_plg
              JOIN playstation ON rental.kd_ps = playstation.kd_ps
              WHERE rental.kd_plg LIKE ? OR rental.kd_ps LIKE ? OR pelanggan.nama LIKE ? OR playstation.tipe LIKE ?
              LIMIT ? OFFSET ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssssii", $search_param, $search_param, $search_param, $search_param, $limit, $offset);
      $stmt->execute();
      $result = $stmt->get_result();

      // Mengecek apakah hasil query kosong
      $row_count = $result->num_rows;
    ?> 

    <!-- Content -->
    <div class="container py-5">
      <div class="text-center">
        <h1 class="mb-4">Daftar Rental</h1>
        <p class="mb-5">
          Berikut adalah informasi terkait transaksi rental yang terdaftar dalam sistem.
        </p>
      </div>

      <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- Tombol Create -->
        <a href="../rental/create.php" class="btn btn-primary d-inline-flex align-items-center" type="button">
          <img src="../assets/icons/person-plus.svg" alt="Create" class="me-2" style="width: 20px; height: 20px;">
          Create
        </a>
        <!-- Tombol Pencarian -->
        <form action="" method="GET" class="d-flex" id="searchForm">
          <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search" id="searchInput" value="<?php echo htmlspecialchars($search); ?>">
            <button class="input-group-text" id="searchIcon">
              <img src="../assets/icons/search.svg" alt="Search">
            </button>
          </div>
        </form>
      </div>

      <!-- Notifikasi jika tidak ada hasil pencarian -->
      <div id="searchErrorMessage" class="invalid-feedback text-end" style="display: none;">
        Tidak ada hasil yang ditemukan untuk pencarian '<strong><?php echo htmlspecialchars($search); ?></strong>'.
      </div>

      <?php if ($row_count > 0): ?>
      <table class="table table-hover">
        <caption class="text-center">
          Daftar rental lengkap dengan pelanggan dan playstation yang digunakan.
        </caption>
        <thead>
          <tr>
            <th scope="col">NO</th>
            <th scope="col">KODE PELANGGAN</th>
            <th scope="col">NAMA</th>
            <th scope="col">TIPE</th>
            <th scope="col">MULAI</th>
            <th scope="col">SELESAI</th>
            <th scope="col">DURASI</th>
            <th scope="col">TOTAL BAYAR</th>
            <th scope="col">AKSI</th>
            <th scope="col">INVOICE</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = $offset + 1;
          while ($row = $result->fetch_assoc()) {
            // Mengatur nilai jika selesai kosong
            $selesai = empty($row['selesai']) ? "NULL" : $row['selesai'];
            $durasi = empty($row['durasi']) ? "NULL" : $row['durasi'] . " Jam";
            $total_bayar = empty($row['total_bayar']) ? "NULL" : "Rp " . number_format($row['total_bayar'], 2, ',', '.');

            echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['kd_plg']}</td>
                    <td>{$row['nama_plg']}</td>
                    <td>{$row['tipe_ps']}</td>
                    <td>{$row['mulai']}</td>
                    <td>{$selesai}</td>
                    <td>{$durasi}</td>
                    <td>{$total_bayar}</td>
                    <td>
                        <a href='../rental/update.php?id={$row['id']}' class='btn btn-success d-inline-flex align-items-center' type='button'>
                            <img src='../assets/icons/pencil.svg' alt='Update'>
                        </a>
                        <a href='../rental/delete.php?id={$row['id']}' class='btn btn-danger d-inline-flex align-items-center' type='button' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>
                            <img src='../assets/icons/trash.svg' alt='Delete'>
                        </a>
                    </td>
                    <td>
                      <a href='../rental/download.php?id={$row['id']}' class='btn btn-info d-inline-flex align-items-center' type='button'>
                          <img src='../assets/icons/file-pdf.svg' alt='Download'>
                          Print
                      </a>
                    </td>
                  </tr>";
            $no++;
          }
          ?>
        </tbody>
      </table>
      <?php endif; ?>

      <!-- Pagination -->
      <div class="d-flex justify-content-end align-items-center mb-4 py-3">
        <nav aria-label="Page navigation example">
          <ul class="pagination">
            <li class="page-item <?php if ($page == 1) echo 'disabled'; ?>">
              <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo htmlspecialchars($search); ?>">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
              <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo htmlspecialchars($search); ?>"><?php echo $i; ?></a>
              </li>
            <?php endfor; ?>
            <li class="page-item <?php if ($page == $total_pages) echo 'disabled'; ?>">
              <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo htmlspecialchars($search); ?>">Next</a>
            </li>
          </ul>
        </nav>
      </div>
    </div>

    <!-- Memanipulasi input dan menampilkan pesan error jika pencarian kosong -->
    <script>
      var searchInput = document.getElementById("searchInput");
      var searchErrorMessage = document.getElementById("searchErrorMessage");
      <?php if ($row_count == 0 && $search != ''): ?>
        searchInput.classList.add("is-invalid");
        searchErrorMessage.style.display = 'block';
      <?php else: ?>
        searchInput.classList.remove("is-invalid");
        searchErrorMessage.style.display = 'none';
      <?php endif; ?>
      searchInput.addEventListener("focus", function() {
        this.select();
      });
    </script>
  </body>
</html>
