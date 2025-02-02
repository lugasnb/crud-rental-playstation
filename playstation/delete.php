<?php
  include_once "../database/connect.php"; // Gantilah ini dengan path file koneksi database yang sesuai

  // Cek apakah ada parameter 'id' yang dikirimkan melalui URL
  if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eksekusi query untuk menghapus data playstation berdasarkan ID
    $delete = mysqli_query($conn, "DELETE FROM playstation WHERE id='$id'");

    // Cek apakah penghapusan berhasil
    if ($delete) {
      echo "
        <script>
          alert('Data PlayStation Berhasil Dihapus!!');
          location.replace('../playstation/');
        </script>
      ";
    } else {
      echo "
        <script>
          alert('Data PlayStation Gagal Terhapus!!');
          location.replace('../playstation/');
        </script>
      ";
    }
  } else {
      // Jika ID tidak ditemukan, tampilkan pesan error
    echo "
      <script>
        alert('ID PlayStation Tidak Ditemukan!');
        location.replace('../playstation/');
      </script>
    ";
  }
?>
