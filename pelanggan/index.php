<?php
// Menghubungkan dengan database dan navbar
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
$total_sql = "SELECT COUNT(*) AS total FROM pelanggan WHERE 
              (kd_plg LIKE ? OR nama LIKE ? OR jk LIKE ? OR alamat LIKE ? OR telepon LIKE ? OR DATE(dibuat) LIKE ?)";
$stmt_total = $conn->prepare($total_sql);
$search_param = "%$search%";
$stmt_total->bind_param("ssssss", $search_param, $search_param, $search_param, $search_param, $search_param, $search_param);
$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_row = $total_result->fetch_assoc();
$total_data = $total_row['total'];
$total_pages = ceil($total_data / $limit);

// Query untuk mengambil data pelanggan berdasarkan pencarian dan batasan
$sql = "SELECT * FROM pelanggan WHERE 
        (kd_plg LIKE ? OR nama LIKE ? OR jk LIKE ? OR alamat LIKE ? OR telepon LIKE ? OR DATE(dibuat) LIKE ?) 
        LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssii", $search_param, $search_param, $search_param, $search_param, $search_param, $search_param, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

$row_count = $result->num_rows;
?>

<!-- Content -->
<div class="container py-5">
  <div class="text-center">
    <h1 class="mb-4">Daftar Pelanggan</h1>
    <p class="mb-5">Berikut adalah informasi terkait pelanggan yang terdaftar dalam sistem.</p>
  </div>

  <!-- Tombol Create dan Pencarian -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <a href="../pelanggan/create.php" class="btn btn-primary d-inline-flex align-items-center" type="button">
      <img src="../assets/icons/person-plus.svg" alt="Create" class="me-2" style="width: 20px; height: 20px;"> Create
    </a>
    <form action="" method="GET" class="d-flex" id="searchForm">
      <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search" id="searchInput" value="<?php echo htmlspecialchars($search); ?>">
        <button class="input-group-text" id="searchIcon">
          <img src="../assets/icons/search.svg" alt="Search">
        </button>
      </div>
    </form>
  </div>

  <!-- Notifikasi Pencarian Tidak Ditemukan -->
  <div id="searchErrorMessage" class="invalid-feedback text-end" style="display: none;">
    Tidak ada hasil yang ditemukan untuk pencarian '<strong><?php echo htmlspecialchars($search); ?></strong>'.
  </div>

  <?php if ($row_count > 0): ?>
  <table class="table table-hover">
    <caption class="text-center">Daftar pelanggan lengkap dengan alamat dan telepon.</caption>
    <thead>
      <tr>
        <th scope="col">NO</th>
        <th scope="col">KODE</th>
        <th scope="col">NAMA</th>
        <th scope="col">JENIS KELAMIN</th>
        <th scope="col">ALAMAT</th>
        <th scope="col">TELEPON</th>
        <th scope="col">DIBUAT</th>
        <th scope="col">AKSI</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = $offset + 1;
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$no}</td>
                <td>{$row['kd_plg']}</td>
                <td>{$row['nama']}</td>
                <td>{$row['jk']}</td>
                <td>{$row['alamat']}</td>
                <td>{$row['telepon']}</td>
                <td>{$row['dibuat']}</td>
                <td>
                  <a href='../pelanggan/update.php?id={$row['id']}' class='btn btn-success d-inline-flex align-items-center' type='button'>
                    <img src='../assets/icons/pencil.svg' alt='Update'>
                  </a>
                  <a href='../pelanggan/delete.php?id={$row['id']}' class='btn btn-danger d-inline-flex align-items-center' type='button' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>
                    <img src='../assets/icons/trash.svg' alt='Delete'>
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

<!-- JavaScript untuk error message pencarian -->
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
