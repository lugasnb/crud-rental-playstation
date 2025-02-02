<?php
  include_once "../database/connect.php"; // Gantilah ini dengan path file koneksi database yang sesuai

  // Cek apakah ada parameter 'id' yang dikirimkan melalui URL
  if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eksekusi query untuk menghapus data rental berdasarkan ID
    $delete = mysqli_query($conn, "DELETE FROM rental WHERE id='$id'");

    // Cek apakah penghapusan berhasil
    if ($delete) {
      echo "
        <script>
          alert('Data Rental Berhasil Dihapus!!');
          location.replace('../rental/');
        </script>
      ";
    } else {
      echo "
        <script>
          alert('Data Rental Gagal Terhapus!!');
          location.replace('../rental/');
        </script>
      ";
    }
  } else {
      // Jika ID tidak ditemukan, tampilkan pesan error
    echo "
      <script>
        alert('ID Rental Tidak Ditemukan!');
        location.replace('../rental/');
      </script>
    ";
  }
?>
