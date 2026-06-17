-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Jun 2026 pada 07.22
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
-- Database: `db_tpa`
--

DELIMITER $$
--
-- Fungsi
--
CREATE DEFINER=`root`@`localhost` FUNCTION `hitung_umur` (`tgl` DATE) RETURNS INT(11) DETERMINISTIC BEGIN

RETURN TIMESTAMPDIFF(YEAR,tgl,CURDATE());

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `total_hadir` (`ids` INT) RETURNS INT(11) DETERMINISTIC BEGIN

DECLARE jumlah INT;

SELECT COUNT(*)
INTO jumlah
FROM absensi
WHERE id_santri = ids
AND status='Hadir';

RETURN jumlah;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int(11) NOT NULL,
  `id_santri` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `id_santri`, `tanggal`, `status`) VALUES
(1, 1, '2026-06-01', 'Hadir'),
(2, 2, '2026-06-01', 'Hadir'),
(3, 3, '2026-06-01', 'Izin'),
(4, 4, '2026-06-01', 'Hadir'),
(5, 5, '2026-06-01', 'Sakit');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hafalan`
--

CREATE TABLE `hafalan` (
  `id_hafalan` int(11) NOT NULL,
  `id_santri` int(11) DEFAULT NULL,
  `nama_surat` varchar(100) DEFAULT NULL,
  `ayat` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hafalan`
--

INSERT INTO `hafalan` (`id_hafalan`, `id_santri`, `nama_surat`, `ayat`, `status`) VALUES
(1, 1, 'Al Fatihah', 7, 'Selesai'),
(2, 2, 'An Nas', 6, 'Selesai'),
(3, 3, 'Al Ikhlas', 4, 'Proses'),
(4, 4, 'Al Falaq', 5, 'Selesai'),
(5, 5, 'Al Kautsar', 3, 'Belum');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(50) DEFAULT NULL,
  `jadwal` varchar(100) DEFAULT NULL,
  `ruangan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `jadwal`, `ruangan`) VALUES
(1, 'Iqro Dasar', 'Sabtu 08:00', 'A1'),
(2, 'Iqro Lanjutan', 'Sabtu 09:00', 'A2'),
(3, 'Tahfidz', 'Minggu 08:00', 'B1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id_log` int(11) NOT NULL,
  `aktivitas` varchar(255) DEFAULT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id_log`, `aktivitas`, `waktu`) VALUES
(1, 'Santri baru ditambahkan: Zainab', '2026-06-16 04:29:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `santri`
--

CREATE TABLE `santri` (
  `id_santri` int(11) NOT NULL,
  `nama_santri` varchar(100) DEFAULT NULL,
  `jk` enum('L','P') DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `santri`
--

INSERT INTO `santri` (`id_santri`, `nama_santri`, `jk`, `tanggal_lahir`, `alamat`, `id_kelas`) VALUES
(1, 'Aisyah', 'P', '2015-03-10', 'Yogyakarta', 1),
(2, 'Ahmad', 'L', '2014-07-12', 'Sleman', 1),
(3, 'Fatimah', 'P', '2013-01-20', 'Bantul', 2),
(4, 'Abdullah', 'L', '2012-11-15', 'Sleman', 3),
(5, 'Khadijah', 'P', '2014-09-01', 'Yogyakarta', 2),
(6, 'Zainab', 'P', '2015-08-10', 'Sleman', 1);

--
-- Trigger `santri`
--
DELIMITER $$
CREATE TRIGGER `trg_hapus_santri` BEFORE DELETE ON `santri` FOR EACH ROW BEGIN

INSERT INTO log_aktivitas(aktivitas)
VALUES(
CONCAT('Santri dihapus: ', OLD.nama_santri)
);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_tambah_santri` AFTER INSERT ON `santri` FOR EACH ROW BEGIN

INSERT INTO log_aktivitas(aktivitas)
VALUES(
CONCAT('Santri baru ditambahkan: ', NEW.nama_santri)
);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_hafalan_santri`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_hafalan_santri` (
`nama_santri` varchar(100)
,`nama_surat` varchar(100)
,`ayat` int(11)
,`status` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_santri_kelas`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_santri_kelas` (
`id_santri` int(11)
,`nama_santri` varchar(100)
,`nama_kelas` varchar(50)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `v_hafalan_santri`
--
DROP TABLE IF EXISTS `v_hafalan_santri`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_hafalan_santri`  AS SELECT `s`.`nama_santri` AS `nama_santri`, `h`.`nama_surat` AS `nama_surat`, `h`.`ayat` AS `ayat`, `h`.`status` AS `status` FROM (`santri` `s` join `hafalan` `h` on(`s`.`id_santri` = `h`.`id_santri`)) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_santri_kelas`
--
DROP TABLE IF EXISTS `v_santri_kelas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_santri_kelas`  AS SELECT `s`.`id_santri` AS `id_santri`, `s`.`nama_santri` AS `nama_santri`, `k`.`nama_kelas` AS `nama_kelas` FROM (`santri` `s` join `kelas` `k` on(`s`.`id_kelas` = `k`.`id_kelas`)) ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `id_santri` (`id_santri`);

--
-- Indeks untuk tabel `hafalan`
--
ALTER TABLE `hafalan`
  ADD PRIMARY KEY (`id_hafalan`),
  ADD KEY `id_santri` (`id_santri`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indeks untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id_log`);

--
-- Indeks untuk tabel `santri`
--
ALTER TABLE `santri`
  ADD PRIMARY KEY (`id_santri`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `hafalan`
--
ALTER TABLE `hafalan`
  MODIFY `id_hafalan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `santri`
--
ALTER TABLE `santri`
  MODIFY `id_santri` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`id_santri`) REFERENCES `santri` (`id_santri`);

--
-- Ketidakleluasaan untuk tabel `hafalan`
--
ALTER TABLE `hafalan`
  ADD CONSTRAINT `hafalan_ibfk_1` FOREIGN KEY (`id_santri`) REFERENCES `santri` (`id_santri`);

--
-- Ketidakleluasaan untuk tabel `santri`
--
ALTER TABLE `santri`
  ADD CONSTRAINT `santri_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
