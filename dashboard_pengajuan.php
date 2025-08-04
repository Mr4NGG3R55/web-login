<?php
session_start();
include 'koneksi.php';

// Pastikan hanya admin yang bisa mengakses
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Proses update status jika form disubmit
if (isset($_POST['update_status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $query = "UPDATE pengajuan_izin SET status = '$status' WHERE id = $id";
    mysqli_query($conn, $query);
    header("Location: daftar_pengajuan.php");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM pengajuan_izin ORDER BY tanggal_pengajuan DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pengajuan Izin/Cuti</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background: #f8f9fa;
        }
        .container {
            padding: 30px;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 16px;
            border-bottom: 1px solid #e0e0e0;
        }
        th {
            background: #007bff;
            color: white;
            text-align: left;
        }
        tr:hover {
            background: #f1f1f1;
        }
        .status-menunggu { color: orange; font-weight: bold; }
        .status-disetujui { color: green; font-weight: bold; }
        .status-ditolak { color: red; font-weight: bold; }
        form.inline-form {
            display: inline;
        }
        .btn {
            border: none;
            padding: 6px 12px;
            margin-left: 4px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-approve {
            background-color: #28a745;
            color: white;
        }
        .btn-reject {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Daftar Pengajuan Izin / Cuti / Sakit</h2>
    <table>
        <tr>
            <th>Nama Karyawan</th>
            <th>Jenis</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($data)) { ?>
            <tr>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['jenis_pengajuan']) ?></td>
                <td><?= htmlspecialchars($row['tanggal_pengajuan']) ?></td>
                <td><?= htmlspecialchars($row['keterangan']) ?></td>
                <td class="status-<?= strtolower($row['status']) ?>"><?= $row['status'] ?></td>
                <td>
                    <?php if ($row['status'] === 'Menunggu') { ?>
                        <form method="post" class="inline-form">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <input type="hidden" name="status" value="Disetujui">
                            <button type="submit" name="update_status" class="btn btn-approve">Setujui</button>
                        </form>
                        <form method="post" class="inline-form">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <input type="hidden" name="status" value="Ditolak">
                            <button type="submit" name="update_status" class="btn btn-reject">Tolak</button>
                        </form>
                    <?php } else {
                        echo '-';
                    } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
