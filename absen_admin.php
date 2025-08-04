<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];
$user_result = mysqli_query($conn, "SELECT id FROM users WHERE username = '$username'");
$user = mysqli_fetch_assoc($user_result);
$user_id = $user['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tanggal = date('Y-m-d');
    $tipe = $_POST['tipe'];
    $status_khusus = $_POST['status_khusus'] ?? 'Masuk';

    $cek = mysqli_query($conn, "SELECT * FROM absensi_admin WHERE user_id = $user_id AND tanggal = '$tanggal'");
    if (mysqli_num_rows($cek) > 0) {
        if ($tipe == "keluar") {
            mysqli_query($conn, "UPDATE absensi_admin SET jam_keluar = CURTIME() WHERE user_id = $user_id AND tanggal = '$tanggal'");
        }
    } else {
        if ($tipe == "masuk") {
            mysqli_query($conn, "INSERT INTO absensi_admin (user_id, tanggal, jam_masuk, status_khusus) VALUES ($user_id, '$tanggal', CURTIME(), '$status_khusus')");
        }
    }
    header("Location: absen_admin.php");
    exit;
}

$data_absen = mysqli_query($conn, "SELECT * FROM absensi_admin WHERE user_id = $user_id ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Absensi Admin</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 40px;
            max-width: 900px;
            margin: auto;
        }
        h2 {
            color: #333;
        }
        form {
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        select, button {
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #007bff;
            border: none;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            box-shadow: 0 0 8px rgba(0,0,0,0.05);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 14px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        td {
            background-color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Absensi Admin - <?php echo htmlspecialchars($username); ?></h2>

        <form method="post">
            <label for="status_khusus">Status Khusus:</label>
            <select name="status_khusus" id="status_khusus">
                <option value="Masuk">Masuk</option>
                <option value="Izin">Izin</option>
                <option value="Cuti">Cuti</option>
                <option value="Tidak Masuk">Tidak Masuk</option>
            </select>
            <button name="tipe" value="masuk">Absen Masuk</button>
            <button name="tipe" value="keluar">Absen Keluar</button>
        </form>

        <table>
            <tr>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Status</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($data_absen)) { ?>
                <tr>
                    <td><?= $row['tanggal']; ?></td>
                    <td><?= $row['jam_masuk'] ?: '-'; ?></td>
                    <td><?= $row['jam_keluar'] ?: '-'; ?></td>
                    <td><?= $row['status_khusus'] ?: 'Masuk'; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
