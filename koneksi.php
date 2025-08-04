<?php
$host = "localhost";   // IP server MySQL
$user = "root";           // Username
$pass = "#Kemayoran406";         // Password
$db   = "db_login";       // Nama database

// Koneksi ke MySQL
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
