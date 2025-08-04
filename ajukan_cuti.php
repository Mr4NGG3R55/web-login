<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'karyawan') {
    header("Location: index.php");
    exit;
}

// Ambil data user berdasarkan sesi
$username = $_SESSION['username'];
$getUser = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
if (!$getUser || mysqli_num_rows($getUser) === 0) {
    die("User tidak ditemukan.");
}
$user = mysqli_fetch_assoc($getUser);
$user_id = $user['id'];

// Simpan data cuti
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    mysqli_query($conn, "INSERT INTO izin_cuti (user_id, tanggal, jenis, keterangan) VALUES ('$user_id', '$tanggal', 'Cuti', '$keterangan')");
    header("Location: dashboard_karyawan.php?status=berhasil");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Pengajuan Cuti</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: #f0f8ff;
      margin: 0;
      padding: 0;
    }
    .navbar {
      background: #2b7a78;
      color: white;
      padding: 16px;
      text-align: center;
      font-size: 22px;
      font-weight: 600;
    }
    .container {
      max-width: 600px;
      margin: 40px auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }
    h2 {
      color: #2b7a78;
      margin-bottom: 20px;
    }
    input, textarea {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
    }
    button {
      background: #2b7a78;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      font-size: 16px;
    }
    button:hover {
      background: #205e5a;
    }
    a.back-link {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      color: #2b7a78;
      font-weight: 500;
    }
  </style>
</head>
<body>

<div class="navbar">Pengajuan Cuti</div>

<div class="container">
  <h2>Form Pengajuan Cuti</h2>
  <form method="post">
    <label for="tanggal">Tanggal Cuti</label>
    <input type="date" name="tanggal" required>

    <label for="keterangan">Keterangan Cuti</label>
    <textarea name="keterangan" rows="4" placeholder="Tulis alasan pengajuan cuti Anda..." required></textarea>

    <button type="submit">Ajukan Cuti</button>
  </form>
  <a href="dashboard_karyawan.php" class="back-link">← Kembali ke Dashboard</a>
</div>

</body>
</html>
