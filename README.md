# 🎮 PLAYSTATION RENTAL SYSTEM

Sistem ini digunakan untuk mengelola penyewaan PlayStation, data pelanggan, dan administrasi lainnya.
Dengan fitur CRUD (Create, Read, Update, Delete), admin dapat menambah, melihat, mengedit, dan menghapus data PlayStation.

---

## 🚀 **1. Konfigurasi Database**
1. **Buka phpMyAdmin** di browser:
   ```
   http://localhost/phpmyadmin/
   ```
2. **Buat database baru** dengan nama:
   ```
   db_playstation
   ```
3. **Import database**:
   - Masuk ke tab **Import**
   - Pilih file `db_playstation.sql`
   - Klik **Go** untuk mengunggah database

---

## 🛠 **2. Konfigurasi Koneksi Database**
Jika terjadi error koneksi, pastikan file `connect.php` diubah sesuai dengan pengaturan database lokal:

```php
<?php
$servername = "localhost";
$username = "root";             // nama user
$password = "";                 // password
$dbname = "db_playstation";     // nama database

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
```

---

## 🔐 **3. Sistem Login**
Sebelum mengakses fitur CRUD, pengguna harus login terlebih dahulu.

1. **Buka halaman login**:
   ```
   http://localhost/PLAYSTATION/
   ```
2. **Masukkan kredensial**:
   - **Username**: admin
   - **Password**: 12345
3. Jika berhasil, pengguna akan diarahkan ke halaman dashboard.

### **👤 Logout**
1. Untuk keluar dari sistem, klik tombol logout atau akses:
   ```
   http://localhost/PLAYSTATION/logout.php
   ```
2. Pengguna akan dikembalikan ke halaman login.

---

## 📂 **4. Struktur Folder CRUD Pelanggan**
Semua fitur CRUD Pelanggan berada dalam folder `/pelanggan`:

```
/pelanggan
  ├── create.php  --> Menambah data Pelanggan
  ├── delete.php  --> Menghapus data Pelanggan
  ├── index.php   --> Menampilkan daftar Pelanggan
  └── update.php  --> Mengedit data Pelanggan
```

---

## 📝 **5. Cara Menggunakan CRUD Pelanggan**
Setelah database terhubung, kamu bisa langsung menggunakan fitur CRUD berikut:

### **📌 5.1. Melihat Daftar Pelanggan (Read)**
1. **Buka browser** dan akses:
   ```
   http://localhost/PLAYSTATION/pelanggan/
   ```
2. Akan muncul daftar Pelanggan yang ada di dalam database.
3. Setiap data memiliki tombol ✏️**Edit** dan 🗑️**Hapus**.

---

### **➕ 5.2. Menambah Data Pelanggan (Create)**
1. Buka halaman:
   ```
   http://localhost/PLAYSTATION/pelanggan/create.php
   ```
2. Isi form dengan informasi Pelanggan:
   - **Kode Pelanggan**: PLG022
   - **Nama**: Budi
   - **Jenis Kelamin**: Laki-laki (Pilih Antara Laki-laki atau Perempuan)
   - **Alamat**: Jl. Manggis No.9, Jakarta
   - **Telepon**: 081234567900
3. Klik tombol 💾**Simpan**.
4. Jika berhasil, data akan muncul di daftar Pelanggan.

---

### **✏ 5.3. Mengedit Data Pelanggan (Update)**
1. Pada halaman `index.php`, cari data yang ingin diedit.
2. Klik tombol ✏️**Edit**, sistem akan membuka:
   ```
   http://localhost/PLAYSTATION/pelanggan/update.php?id=41
   ```
3. Ubah data yang diperlukan dan klik 💾**Simpan**.
4. Jika berhasil, data akan diperbarui.

---

### **🗑 5.4. Menghapus Data Pelanggan (Delete)**
1. Pada halaman `index.php`, cari data yang ingin dihapus.
2. Klik tombol 🗑️**Hapus**, lalu sistem akan meminta konfirmasi.
3. Jika dikonfirmasi, data akan terhapus dari database.

---

## 🏁 **6. Menjalankan Sistem**
1. Pastikan **Apache dan MySQL** aktif di XAMPP/LAMP.
2. Jalankan sistem dengan membuka browser dan akses:
   ```
   http://localhost/PLAYSTATION/
   ```
3. Sekarang kamu bisa mulai menggunakan sistem rental Pelanggan!

---

## 📌 **7. Kesimpulan**
Sistem ini memungkinkan admin untuk **login, menambah, melihat, mengedit, dan menghapus** data Pelanggan dengan mudah. Pastikan semua langkah diikuti agar sistem berjalan dengan baik.

Jika ada pertanyaan atau error, silakan periksa konfigurasi database dan koneksi.

💪 **Selesai! Sekarang kamu bisa mengelola PlayStation dengan mudah!** 🚀

