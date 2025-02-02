// Fungsi untuk memperbarui jam dan tanggal secara real-time
function updateTime() {
  const now = new Date();

  // Format jam, menit, detik
  const hours = String(now.getHours()).padStart(2, '0');
  const minutes = String(now.getMinutes()).padStart(2, '0');
  const seconds = String(now.getSeconds()).padStart(2, '0');

  // Menentukan hari, bulan, tanggal, dan tahun
  const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
  const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

  const dayName = dayNames[now.getDay()];
  const monthName = monthNames[now.getMonth()];
  const date = now.getDate();
  const year = now.getFullYear();

  // Format tampilan jam digital
  const timeString = `${hours}:${minutes}:${seconds}`;
  const dateString = `${dayName}, ${monthName} ${date}, ${year}`;

  // Update elemen HTML
  document.getElementById('time').textContent = timeString;
  document.getElementById('date').textContent = dateString;
}

// Memperbarui waktu setiap detik
setInterval(updateTime, 1000);
