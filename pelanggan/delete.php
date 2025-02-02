<?php
  include_once "../database/connect.php"; // Gantilah ini dengan path file koneksi database yang sesuai

  // Cek apakah ada parameter 'id' yang dikirimkan melalui URL
  if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eksekusi query untuk menghapus data pelanggan berdasarkan ID
    $delete = mysqli_query($conn, "DELETE FROM pelanggan WHERE id='$id'");

    // Cek apakah penghapusan berhasil
    if ($delete) {
      echo "
        <script>
          alert('Data Pelanggan Berhasil Dihapus!!');
          location.replace('../pelanggan/');
        </script>
      ";
    } else {
      echo "
        <script>
          alert('Data Pelanggan Gagal Terhapus!!');
          location.replace('../pelanggan/');
        </script>
      ";
    }
  } else {
      // Jika ID tidak ditemukan, tampilkan pesan error
    echo "
      <script>
        alert('ID Pelanggan Tidak Ditemukan!');
        location.replace('../pelanggan/');
      </script>
    ";
  }
?>
