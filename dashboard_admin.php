<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Simpan absensi admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['absen_admin'])) {
    $user_id = $_SESSION['user_id'];
    $tanggal = date('Y-m-d');
    $jam_masuk = $_POST['jam_masuk'];
    $jam_keluar = $_POST['jam_keluar'];

    mysqli_query($conn, "INSERT INTO absensi_admin (user_id, tanggal, jam_masuk, jam_keluar) 
        VALUES ('$user_id', '$tanggal', '$jam_masuk', '$jam_keluar')");
}

// Hapus absensi admin
if (isset($_GET['hapus_absen_admin'])) {
    $id_hapus = intval($_GET['hapus_absen_admin']);
    mysqli_query($conn, "DELETE FROM absensi_admin WHERE id = '$id_hapus'");
    header("Location: dashboard_admin.php#absen-admin-list");
    exit;
}

// Hapus absensi karyawan
if (isset($_GET['hapus_absen_karyawan'])) {
    $id_hapus = intval($_GET['hapus_absen_karyawan']);
    mysqli_query($conn, "DELETE FROM absensi_karyawan WHERE id = '$id_hapus'");
    header("Location: dashboard_admin.php#absen-karyawan");
    exit;
}

// Update status kerja karyawan
if (isset($_POST['update_status'])) {
    $id_kerja = $_POST['id_kerja'];
    $status_baru = $_POST['status'];
    mysqli_query($conn, "UPDATE kerja_karyawan SET status='$status_baru' WHERE id='$id_kerja'");
}

// Ambil data kerja karyawan
$query_kerja = mysqli_query($conn, "SELECT k.id, u.username, k.pekerjaan, k.tanggal, k.gambar AS foto, k.status 
    FROM kerja_karyawan k 
    JOIN users u ON k.user_id = u.id 
    ORDER BY k.tanggal DESC");

// Ambil data absensi karyawan
$query_absen_karyawan = mysqli_query($conn, "SELECT a.id, u.username, a.tanggal, a.jam_masuk, a.jam_keluar 
    FROM absensi_karyawan a 
    JOIN users u ON a.user_id = u.id 
    ORDER BY a.tanggal DESC");

// Ambil data absensi admin
$query_absen_admin = mysqli_query($conn, "SELECT a.id, u.username, a.tanggal, a.jam_masuk, a.jam_keluar 
    FROM absensi_admin a 
    JOIN users u ON a.user_id = u.id 
    ORDER BY a.tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f6f8; margin: 0; }
        header { background: #2c3e50; color: white; padding: 20px; text-align: center; }
        nav { background: #34495e; padding: 15px; display: flex; justify-content: center; gap: 30px; }
        nav a { color: white; text-decoration: none; font-weight: bold; }
        .container { padding: 30px; }
        table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 50px; }
        th, td { padding: 14px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background-color: #2980b9; color: white; }
        h2 { margin-top: 40px; color: #2c3e50; }
        img.preview { width: 100px; border-radius: 4px; }
        form.absen-admin { background: #ecf0f1; padding: 20px; margin-bottom: 30px; border-left: 4px solid #2980b9; }
        input[type="time"], input[type="submit"], select { padding: 8px; margin: 10px 0; }
        form.inline { display: inline; }
        .hapus-link { color: red; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <header>
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, <strong><?php echo $_SESSION['username']; ?></strong></p>
    </header>

    <nav>
        <a href="#absen-admin">Absensi Admin</a>
        <a href="#kerja">Progress Kerja</a>
        <a href="#absen-karyawan">Absensi Karyawan</a>
        <a href="#absen-admin-list">Absensi Admin</a>
        <a href="rekap_absensi_keseluruhan.php">Download Rekap Keseluruhan</a>
        <a href="dashboard_pengajuan.php">Pengajuan Izin/Cuti</a>
        <a href="logout.php">Logout</a>
    </nav>

    <div class="container">
        <h2 id="absen-admin">Form Absensi Admin</h2>
        <form method="POST" class="absen-admin">
            <input type="hidden" name="absen_admin" value="1">
            <label>Jam Masuk:</label><br>
            <input type="time" name="jam_masuk" required><br>
            <label>Jam Keluar:</label><br>
            <input type="time" name="jam_keluar" required><br>
            <input type="submit" value="Simpan Absensi Admin">
        </form>

        <h2 id="kerja">Progress Kerja Karyawan</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Pekerjaan</th>
                    <th>Tanggal</th>
                    <th>Foto</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($query_kerja)) { ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['pekerjaan'] ?></td>
                        <td><?= $row['tanggal'] ?></td>
                        <td>
                            <?php if ($row['foto']) { ?>
                                <img src="uploads/<?= htmlspecialchars($row['foto']) ?>" class="preview">
                            <?php } else { echo '-'; } ?>
                        </td>
                        <td>
                            <form method="post" class="inline">
                                <input type="hidden" name="id_kerja" value="<?= $row['id'] ?>">
                                <select name="status">
                                    <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="Disetujui" <?= $row['status'] == 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
                                    <option value="Ditolak" <?= $row['status'] == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                                </select>
                                <button type="submit" name="update_status">Simpan</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h2 id="absen-karyawan">Rekap Absensi Karyawan</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($query_absen_karyawan)) { ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['tanggal'] ?></td>
                        <td><?= $row['jam_masuk'] ?></td>
                        <td><?= $row['jam_keluar'] ?></td>
                        <td>
                            <a href="?hapus_absen_karyawan=<?= $row['id'] ?>" class="hapus-link" onclick="return confirm('Yakin ingin menghapus absensi ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h2 id="absen-admin-list">Rekap Absensi Admin</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($query_absen_admin)) { ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['tanggal'] ?></td>
                        <td><?= $row['jam_masuk'] ?></td>
                        <td><?= $row['jam_keluar'] ?></td>
                        <td>
                            <a href="?hapus_absen_admin=<?= $row['id'] ?>" class="hapus-link" onclick="return confirm('Yakin ingin menghapus absensi ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>