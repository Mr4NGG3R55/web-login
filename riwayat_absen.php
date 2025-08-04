<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'karyawan') {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];
$getUser = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$user = mysqli_fetch_assoc($getUser);
$user_id = $user['id'];

$absensi = mysqli_query($conn, "SELECT * FROM absensi_karyawan WHERE user_id='$user_id' ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Absensi</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background: #f0f2f5;
    }

    .navbar {
      background-color: #007bff;
      padding: 15px;
      color: white;
      text-align: center;
    }

    .container {
      max-width: 900px;
      margin: 40px auto;
      background: #ffffff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }

    h2 {
      margin-top: 0;
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 12px;
      border: 1px solid #ccc;
      text-align: center;
    }

    th {
      background-color: #007bff;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    a.back-btn {
      display: inline-block;
      margin-top: 20px;
      background: #007bff;
      color: white;
      padding: 10px 15px;
      text-decoration: none;
      border-radius: 5px;
    }

    a.back-btn:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>

<div class="navbar">
  <h2>Riwayat Absensi - <?= htmlspecialchars($username) ?></h2>
</div>

<div class="container">
  <table>
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Jam Masuk</th>
        <th>Jam Keluar</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($absensi)) : ?>
        <tr>
          <td><?= htmlspecialchars($row['tanggal']) ?></td>
          <td><?= $row['jam_masuk'] ? $row['jam_masuk'] : '-' ?></td>
          <td><?= $row['jam_keluar'] ? $row['jam_keluar'] : '-' ?></td>
          <td>
            <?php
              if (!$row['jam_masuk']) echo 'Belum Absen';
              elseif (!$row['jam_keluar']) echo 'Masih Bekerja';
              else echo 'Selesai';
            ?>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <a class="back-btn" href="dashboard_karyawan.php">← Kembali ke Dashboard</a>
</div>

</body>
</html>
