<?php
session_start();
include 'koneksi.php'; // pastikan file ini terhubung ke DB

// Hanya untuk user dengan role 'karyawan'
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'karyawan') {
    header("Location: index.php");
    exit;
}

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id    = $_SESSION['user_id'];
    $nama       = $_SESSION['username'];
    $jenis      = $_POST['jenis'];
    $tanggal    = $_POST['tanggal'];
    $keterangan = htmlspecialchars($_POST['keterangan']);

    if (!empty($jenis) && !empty($tanggal)) {
        $query = "INSERT INTO pengajuan_izin (user_id, nama, jenis_pengajuan, tanggal_pengajuan, keterangan) 
                  VALUES ('$user_id', '$nama', '$jenis', '$tanggal', '$keterangan')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $success = "Pengajuan berhasil dikirim.";
        } else {
            $error = "Gagal mengirim pengajuan.";
        }
    } else {
        $error = "Harap lengkapi semua data.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Pengajuan Izin / Cuti / Sakit</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 50px;
        }
        .container {
            max-width: 500px;
            background: white;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
        }
        .success { color: green; text-align: center; }
        .error { color: red; text-align: center; }
    </style>
</head>
<body>

<div class="container">
    <h2>Form Pengajuan</h2>

    <?php if ($success): ?>
        <div class="success"><?= $success; ?></div>
    <?php elseif ($error): ?>
        <div class="error"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="jenis">Jenis Pengajuan</label>
        <select name="jenis" id="jenis" required>
            <option value="">-- Pilih Jenis --</option>
            <option value="Izin">Izin</option>
            <option value="Cuti">Cuti</option>
            <option value="Sakit">Sakit</option>
        </select>

        <label for="tanggal">Tanggal Pengajuan</label>
        <input type="date" name="tanggal" id="tanggal" required>

        <label for="keterangan">Keterangan</label>
        <textarea name="keterangan" rows="4" placeholder="Tulis keterangan dengan jelas..." required></textarea>

        <button type="submit">Kirim Pengajuan</button>
    </form>
</div>

</body>
</html>
