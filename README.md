# 🎮 PLAYSTATION RENTAL SYSTEM

Sistem ini digunakan untuk mengelola penyewaan PlayStation, data pelanggan, dan administrasi lainnya.
Dengan fitur CRUD (Create, Read, Update, Delete), admin dapat menambah, melihat, mengedit, dan menghapus data PlayStation.

---

## 🚀 **1. Instalasi dan Persiapan**
### **1.1. Persyaratan**
Sebelum menjalankan sistem ini, pastikan sudah memiliki:
- **XAMPP/LAMP/WAMP** → Untuk menjalankan PHP dan MySQL
- **Browser** → Chrome, Firefox, atau Edge
- **Code Editor** (Opsional) → Visual Studio Code atau Sublime Text

### **1.2. Konfigurasi Database**
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
   - Pilih file `database/db_playstation.sql`
   - Klik **Go** untuk mengunggah database

---

## 📂 **2. Struktur Folder CRUD Pelanggan**
Semua fitur CRUD Pelanggan berada dalam folder `/pelanggan`:

```
/pelanggan
  ├── create.php  --> Menambah data Pelanggan
  ├── delete.php  --> Menghapus data Pelanggan
  ├── index.php   --> Menampilkan daftar Pelanggan
  └── update.php  --> Mengedit data Pelanggan
```

---

## 📝 **3. Cara Menggunakan CRUD Pelanggan**
Setelah database terhubung, kamu bisa langsung menggunakan fitur CRUD berikut:

### **📌 3.1. Melihat Daftar Pelanggan (Read)**
1. **Buka browser** dan akses:
   ```
   http://localhost/pelanggan/index.php
   ```
2. Akan muncul daftar Pelanggan yang ada di dalam database.
3. Setiap data memiliki tombol ✏️**Edit** dan 🗑️**Hapus**.

---

### **➕ 3.2. Menambah Data Pelanggan (Create)**
1. Buka halaman:
   ```
   http://localhost/pelanggan/create.php
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

### **✏ 3.3. Mengedit Data Pelanggan (Update)**
1. Pada halaman `index.php`, cari data yang ingin diedit.
2. Klik tombol ✏️**Edit**, sistem akan membuka:
   ```
   http://localhost/playstation/update.php?id=41
   ```
3. Ubah data yang diperlukan dan klik 💾**Simpan**.
4. Jika berhasil, data akan diperbarui.

---

### **🗑 3.4. Menghapus Data Pelanggan (Delete)**
1. Pada halaman `index.php`, cari data yang ingin dihapus.
2. Klik tombol 🗑️**Hapus**, lalu sistem akan meminta konfirmasi.
3. Jika dikonfirmasi, data akan terhapus dari database.

---

## 🛠 **4. Konfigurasi Koneksi Database**
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

## 🏁 **5. Menjalankan Sistem**
1. Pastikan **Apache dan MySQL** aktif di XAMPP/LAMP.
2. Jalankan sistem dengan membuka browser dan akses:
   ```
   http://localhost/playstation/index.php
   ```
3. Sekarang kamu bisa mulai menggunakan CRUD PlayStation!

---

## 📌 **6. Kesimpulan**
Sistem ini memungkinkan admin untuk **menambah, melihat, mengedit, dan menghapus** data PlayStation dengan mudah. Pastikan semua langkah diikuti agar sistem berjalan dengan baik.

Jika ada pertanyaan atau error, silakan periksa konfigurasi database dan koneksi.

💪 **Selesai! Sekarang kamu bisa mengelola PlayStation dengan mudah!** 🚀

