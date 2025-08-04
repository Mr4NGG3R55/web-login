<?php
include 'koneksi.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="laporan_kinerja.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['No', 'Nama Karyawan', 'Tanggal', 'Kegiatan', 'Prestasi']);

$query = "SELECT u.username, k.tanggal, k.kegiatan, k.prestasi 
          FROM kerja_karyawan k 
          JOIN users u ON k.user_id = u.id 
          ORDER BY k.tanggal DESC";
$result = mysqli_query($conn, $query);

$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, [$no++, $row['username'], $row['tanggal'], $row['kegiatan'], $row['prestasi']]);
}
fclose($output);
exit;
