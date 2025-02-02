<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PlayStation</title>
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

      // Query untuk mengambil data playstation berdasarkan semua kolom dengan parameter pencarian
      $sql = "SELECT * FROM playstation WHERE 
              (kd_ps LIKE ? OR tipe LIKE ? OR status LIKE ?)";
      $stmt = $conn->prepare($sql);

      // Menyiapkan parameter pencarian untuk query
      $search_param = "%$search%";
      $stmt->bind_param("sss", $search_param, $search_param, $search_param);
      $stmt->execute();
      $result = $stmt->get_result();

      // Mengecek apakah hasil query kosong
      $row_count = $result->num_rows;
    ?> 

    <!-- Content -->
    <div class="container py-5">
      <div class="text-center">
        <h1 class="mb-4">Daftar PlayStation</h1>
        <p class="mb-5">
          Berikut adalah informasi terkait PlayStation yang terdaftar dalam sistem.
        </p>
      </div>

      <div class="d-flex justify-content-end align-items-center mb-4">
      <!-- <div class="d-flex justify-content-between align-items-center mb-4"> -->
        <!-- Tombol Create -->
        <!-- <a href="../playstation/create.php" class="btn btn-primary d-inline-flex align-items-center" type="button" >
          <img src="../assets/icons/person-plus.svg" alt="Create" class="me-2" style="width: 20px; height: 20px;">
          Create
        </a> -->
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
          Daftar PlayStation lengkap dengan tipe, harga, dan status.
        </caption>
        <thead>
          <tr>
            <th scope="col">NO</th>
            <th scope="col">KODE</th>
            <th scope="col">TIPE</th>
            <th scope="col">HARGA</th>
            <th scope="col">STATUS</th>
            <!-- <th scope="col">AKSI</th> -->
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['kd_ps']}</td>
                    <td>{$row['tipe']}</td>
                    <td>" . number_format($row['harga'], 2, ',', '.') . "</td>
                    <td>{$row['status']}</td>
                    <!-- Edit & Hapus -->
                  </tr>";
            $no++;
          }
          ?>
        </tbody>
      </table>
      <?php endif; ?>
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


<!-- <td>
  <a href='../playstation/update.php?id={$row['id']}' class='btn btn-success d-inline-flex align-items-center' type='button'>
    <img src='../assets/icons/pencil.svg' alt='Update'>
  </a>
  <a href='../playstation/delete.php?id={$row['id']}' class='btn btn-danger d-inline-flex align-items-center' type='button' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>
    <img src='../assets/icons/trash.svg' alt='Delete'>
  </a>
</td> -->