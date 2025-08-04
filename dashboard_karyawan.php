<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'karyawan') {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];
$getUser = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$user = mysqli_fetch_assoc($getUser);
$user_id = $user['id'];

// Absen Masuk
if (isset($_POST['absen_masuk'])) {
    $tanggal = date('Y-m-d');
    $jam = date('H:i:s');
    $cek = mysqli_query($conn, "SELECT * FROM absensi_karyawan WHERE user_id='$user_id' AND tanggal='$tanggal'");
    if (mysqli_num_rows($cek) == 0) {
        mysqli_query($conn, "INSERT INTO absensi_karyawan (user_id, tanggal, jam_masuk) VALUES ('$user_id', '$tanggal', '$jam')");
    }
}

// Absen Keluar
if (isset($_POST['absen_keluar'])) {
    $tanggal = date('Y-m-d');
    $jam = date('H:i:s');
    mysqli_query($conn, "UPDATE absensi_karyawan SET jam_keluar='$jam' WHERE user_id='$user_id' AND tanggal='$tanggal'");
}

// Upload hasil kerja
if (isset($_POST['submit_kerja'])) {
    $tanggal = date('Y-m-d');
    $pekerjaan = mysqli_real_escape_string($conn, $_POST['pekerjaan']);
    $gambar = '';

    if (!empty($_FILES['gambar']['name'])) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);

        $file_name = time() . "_" . basename($_FILES["gambar"]["name"]);
        $file_path = $target_dir . $file_name;
        $file_type = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_type, $allowed_types)) {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $file_path)) {
                $gambar = $file_name;
            }
        }
    }

    mysqli_query($conn, "INSERT INTO kerja_karyawan (user_id, tanggal, pekerjaan, gambar) VALUES ('$user_id', '$tanggal', '$pekerjaan', '$gambar')");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Karyawan</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f1f3f5; margin: 0; padding: 0; }
    .navbar { background: #007bff; padding: 15px; color: white; text-align: center; }
    .menu { background: #343a40; padding: 10px; display: flex; justify-content: space-around; flex-wrap: wrap; }
    .menu a { color: white; text-decoration: none; padding: 8px 15px; border-radius: 5px; }
    .menu a:hover { background: #007bff; }
    .container { background: white; width: 90%; max-width: 700px; margin: 30px auto; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px #bbb; }
    textarea, input[type="file"] { width: 100%; padding: 10px; margin-top: 10px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #ccc; }
    button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
    .btn-secondary { background: #28a745; }
  </style>
</head>
<body>

<div class="navbar">
  <h2>Dashboard Karyawan - <?= htmlspecialchars($username) ?></h2>
</div>

<div class="menu">
  <a href="dashboard_karyawan.php">Dashboard</a>
  <a href="#absensiForm">Absen</a>
  <a href="#kerjaForm">Input Kerja</a>
  <a href="ajukan_izin.php">Ajukan Izin</a>
  <a href="ajukan_cuti.php">Ajukan Cuti</a>
  <a href="ajukan_sakit.php">Ajukan Sakit</a>
  <a href="riwayat_absen.php">Riwayat Absensi</a>
  <a href="riwayat_kerja.php">Riwayat Kerja</a>
  <a href="logout.php">Logout</a>
</div>

<div class="container" id="absensiForm">
  <h3>Form Absensi Hari Ini</h3>
  <form method="post">
    <button name="absen_masuk">Absen Masuk</button>
    <button name="absen_keluar" class="btn-secondary">Absen Keluar</button>
  </form>
</div>

<div class="container" id="kerjaForm">
  <h3>Form Input Hasil Kerja</h3>
  <form method="post" enctype="multipart/form-data">
    <textarea name="pekerjaan" placeholder="Deskripsi pekerjaan hari ini..." required></textarea>
    <input type="file" name="gambar" accept="image/*" required />
    <button type="submit" name="submit_kerja">Upload Hasil Kerja</button>
  </form>
</div>

</body>
</html>
