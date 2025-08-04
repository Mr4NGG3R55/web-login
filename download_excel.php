<?php 
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    die("Akses ditolak.");
}

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=rekap_absensi_keseluruhan.xls");

// HTML header Excel
echo "<style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #cce5ff; font-weight: bold; }
        h2 { background-color: #004085; color: white; padding: 10px; }
      </style>";

echo "<h2>Rekap Absensi Karyawan</h2>";
echo "<table>";
echo "<tr>
        <th>ID</th>
        <th>Username</th>
        <th>Tanggal</th>
        <th>Jam Masuk</th>
        <th>Jam Keluar</th>
      </tr>";

$query_karyawan = mysqli_query($conn, "SELECT a.id, u.username, a.tanggal, a.jam_masuk, a.jam_keluar 
    FROM absensi_karyawan a 
    JOIN users u ON a.user_id = u.id 
    ORDER BY a.tanggal DESC");

while ($row = mysqli_fetch_assoc($query_karyawan)) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['username']}</td>
            <td>{$row['tanggal']}</td>
            <td>{$row['jam_masuk']}</td>
            <td>{$row['jam_keluar']}</td>
          </tr>";
}
echo "</table><br><br>";


echo "<h2>Rekap Absensi Admin</h2>";
echo "<table>";
echo "<tr>
        <th>ID</th>
        <th>Username</th>
        <th>Tanggal</th>
        <th>Jam Masuk</th>
        <th>Jam Keluar</th>
      </tr>";

$query_admin = mysqli_query($conn, "SELECT a.id, u.username, a.tanggal, a.jam_masuk, a.jam_keluar 
    FROM absensi_admin a 
    JOIN users u ON a.user_id = u.id 
    ORDER BY a.tanggal DESC");

while ($row = mysqli_fetch_assoc($query_admin)) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['username']}</td>
            <td>{$row['tanggal']}</td>
            <td>{$row['jam_masuk']}</td>
            <td>{$row['jam_keluar']}</td>
          </tr>";
}
echo "</table>";
?>
