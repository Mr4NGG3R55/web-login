-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Agu 2025 pada 04.00
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_login`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi_admin`
--

CREATE TABLE `absensi_admin` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi_karyawan`
--

CREATE TABLE `absensi_karyawan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `izin_cuti`
--

CREATE TABLE `izin_cuti` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jenis` enum('Izin','Cuti') NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('Menunggu','Disetujui','Ditolak') DEFAULT 'Menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `izin_cuti`
--

INSERT INTO `izin_cuti` (`id`, `user_id`, `tanggal`, `jenis`, `keterangan`, `status`) VALUES
(1, 2, '2025-08-08', '', 'dadada', 'Menunggu'),
(2, 2, '2025-08-12', '', 'test', 'Menunggu'),
(3, 2, '2025-08-04', 'Izin', 'izin test', 'Menunggu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kerja_karyawan`
--

CREATE TABLE `kerja_karyawan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pekerjaan` text DEFAULT NULL,
  `tanggal` date NOT NULL,
  `kegiatan` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'Menunggu',
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kerja_karyawan`
--

INSERT INTO `kerja_karyawan` (`id`, `user_id`, `pekerjaan`, `tanggal`, `kegiatan`, `gambar`, `created_at`, `status`, `foto`) VALUES
(5, 2, 'dadadadada', '2025-08-03', '', '1754258288_Screenshot 2025-02-07 191625.png', '2025-08-03 21:58:08', 'Menunggu', NULL),
(6, 2, 'sshshhshss', '2025-08-04', '', '1754258677_Screenshot 2025-05-14 204634.png', '2025-08-03 22:04:37', 'Menunggu', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan_izin`
--

CREATE TABLE `pengajuan_izin` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jenis_pengajuan` enum('Izin','Cuti','Sakit') NOT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('Menunggu','Disetujui','Ditolak') DEFAULT 'Menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengajuan_izin`
--

INSERT INTO `pengajuan_izin` (`id`, `user_id`, `nama`, `jenis_pengajuan`, `tanggal_pengajuan`, `keterangan`, `status`) VALUES
(1, 2, 'karyawan', 'Izin', '2025-08-08', 'testts\r\n', 'Menunggu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_kerja`
--

CREATE TABLE `riwayat_kerja` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `aktivitas` enum('Masuk','Izin','Tanpa') NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_absen_karyawan`
--

CREATE TABLE `status_absen_karyawan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` enum('Izin','Cuti','Tidak Masuk') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','karyawan') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', '07142c5501c3ea09303d899012e2b47d', 'admin', '2025-08-03 20:46:48'),
(2, 'karyawan', '07142c5501c3ea09303d899012e2b47d', 'karyawan', '2025-08-03 20:46:48'),
(3, 'admin1', '07142c5501c3ea09303d899012e2b47d', 'admin', '2025-08-03 20:51:42'),
(4, 'karyawan1', '07142c5501c3ea09303d899012e2b47d', 'karyawan', '2025-08-03 20:51:42'),
(5, 'fadil', 'cdbe4bcf269f3c1c63598be0bb8b8851', 'karyawan', '2025-08-04 01:14:40'),
(7, 'rizki', '8a7dce4eed1a3893c24b4450c420d08c', 'karyawan', '2025-08-04 01:16:55'),
(8, 'saddam', '01c96bdff8518a860c8bdbb3ddd727b0', 'karyawan', '2025-08-04 01:18:05'),
(9, 'ridho', 'a30267aadf40cde7cc949c36bc9de449', 'karyawan', '2025-08-04 01:19:37');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi_admin`
--
ALTER TABLE `absensi_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `absensi_karyawan`
--
ALTER TABLE `absensi_karyawan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `izin_cuti`
--
ALTER TABLE `izin_cuti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `kerja_karyawan`
--
ALTER TABLE `kerja_karyawan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengajuan_izin`
--
ALTER TABLE `pengajuan_izin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat_kerja`
--
ALTER TABLE `riwayat_kerja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `status_absen_karyawan`
--
ALTER TABLE `status_absen_karyawan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi_admin`
--
ALTER TABLE `absensi_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `absensi_karyawan`
--
ALTER TABLE `absensi_karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `izin_cuti`
--
ALTER TABLE `izin_cuti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `kerja_karyawan`
--
ALTER TABLE `kerja_karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pengajuan_izin`
--
ALTER TABLE `pengajuan_izin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `riwayat_kerja`
--
ALTER TABLE `riwayat_kerja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `status_absen_karyawan`
--
ALTER TABLE `status_absen_karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi_admin`
--
ALTER TABLE `absensi_admin`
  ADD CONSTRAINT `absensi_admin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `absensi_karyawan`
--
ALTER TABLE `absensi_karyawan`
  ADD CONSTRAINT `absensi_karyawan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `izin_cuti`
--
ALTER TABLE `izin_cuti`
  ADD CONSTRAINT `izin_cuti_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `riwayat_kerja`
--
ALTER TABLE `riwayat_kerja`
  ADD CONSTRAINT `riwayat_kerja_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `status_absen_karyawan`
--
ALTER TABLE `status_absen_karyawan`
  ADD CONSTRAINT `status_absen_karyawan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
