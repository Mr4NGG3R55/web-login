<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'karyawan') {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Karyawan - IdeTrust</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }
    body {
      background-color: #f4f7fa;
      margin: 0;
      padding: 0;
      color: #333;
    }
    .container {
      max-width: 900px;
      margin: 40px auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    h2 {
      color: #2b6cb0;
      margin-bottom: 20px;
    }
    section {
      margin-bottom: 40px;
    }
    label {
      display: block;
      margin-top: 10px;
      font-weight: 600;
    }
    input, select, textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }
    textarea {
      resize: vertical;
    }
    button {
      margin-top: 20px;
      padding: 12px 20px;
      background-color: #2b6cb0;
      color: white;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
    }
    button:hover {
      background-color: #1e4d8b;
    }
    ul {
      padding-left: 20px;
    }
    .divider {
      border-bottom: 2px solid #e2e8f0;
      margin: 30px 0;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>👷 Dashboard Karyawan - Selamat Datang, <?= htmlspecialchars($_SESSION['username']) ?></h2>

    <section>
      <h3>📅 Absensi Hari Ini</h3>
      <form action="proses_absen.php" method="POST">
        <input type="hidden" name="user" value="<?= $_SESSION['username'] ?>">
        <button name="absen" value="masuk">Absen Masuk</button>
        <button name="absen" value="keluar">Absen Keluar</button>
      </form>
    </section>

    <div class="divider"></div>

    <section>
      <h3>📝 Daftar Kerja Hari Ini</h3>
      <ul>
        <li>1. Instalasi jaringan komputer di lantai 2</li>
        <li>2. Setting printer wireless</li>
        <li>3. Dokumentasi hasil pekerjaan</li>
      </ul>
    </section>

    <div class="divider"></div>

    <section>
      <h3>🛠️ Input Detail Pekerjaan</h3>
      <form action="upload_kerja.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="user" value="<?= $_SESSION['username'] ?>">

        <label for="judul_pekerjaan">Judul Pekerjaan</label>
        <input type="text" name="judul_pekerjaan" id="judul_pekerjaan" required placeholder="Contoh: Instalasi Kabel LAN">

        <label for="waktu_mulai">Waktu Mulai</label>
        <input type="time" name="waktu_mulai" id="waktu_mulai" required>

        <label for="waktu_selesai">Waktu Selesai</label>
        <input type="time" name="waktu_selesai" id="waktu_selesai" required>

        <label for="deskripsi">Deskripsi Pekerjaan</label>
        <textarea name="deskripsi" id="deskripsi" rows="4" placeholder="Tuliskan detail pekerjaan secara singkat..."></textarea>

        <label for="bukti_gambar">Upload Bukti Gambar</label>
        <input type="file" name="bukti_gambar" id="bukti_gambar" accept="image/*" required>

        <button type="submit">Kirim Laporan Kerja</button>
      </form>
    </section>
  </div>
</body>
</html>
