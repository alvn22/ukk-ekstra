-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Feb 2024 pada 07.57
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbekstra`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id_buat_absensi` int(11) NOT NULL,
  `id_ekstra` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`id_buat_absensi`, `id_ekstra`, `id_user`, `tanggal`) VALUES
(10, 13, 4, '2024-02-25'),
(11, 2, 2, '2024-02-27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi_siswa`
--

CREATE TABLE `absensi_siswa` (
  `id_absensi` int(11) NOT NULL,
  `id_buat_absensi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_ekstra` int(11) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `waktu_absen` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `absensi_siswa`
--

INSERT INTO `absensi_siswa` (`id_absensi`, `id_buat_absensi`, `id_user`, `id_kelas`, `id_ekstra`, `keterangan`, `waktu_absen`) VALUES
(8, 6, 1, 1, 2, 'Izin', '2024-02-25 13:25:06'),
(9, 8, 1, 1, 13, 'Hadir', '2024-02-25 18:18:57'),
(11, 11, 1, 1, 2, 'Hadir', '2024-02-27 09:35:42'),
(12, 10, 1, 1, 13, 'Hadir', '2024-02-27 10:00:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ekstra`
--

CREATE TABLE `ekstra` (
  `id_ekstra` int(11) NOT NULL,
  `nama_ekstra` varchar(100) NOT NULL,
  `hari` varchar(150) NOT NULL,
  `waktu` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `ekstra`
--

INSERT INTO `ekstra` (`id_ekstra`, `nama_ekstra`, `hari`, `waktu`) VALUES
(2, 'Futsal', 'Senin', '09:34:00'),
(13, 'Voli', 'Senin', '15:10:00'),
(14, 'Basket', 'Selasa', '15:10:00'),
(36, 'Karawitan', 'Senin', '10:22:00'),
(38, 'Tari', 'Sabtu', '16:23:00'),
(39, 'Musik', 'Sabtu', '15:00:00'),
(40, 'PMR', 'Kamis', '16:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ekstra_diikuti`
--

CREATE TABLE `ekstra_diikuti` (
  `id` int(11) NOT NULL,
  `id_ekstra` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_jurusan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `ekstra_diikuti`
--

INSERT INTO `ekstra_diikuti` (`id`, `id_ekstra`, `id_user`, `id_jurusan`) VALUES
(4, 2, 1, 1),
(7, 13, 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnal`
--

CREATE TABLE `jurnal` (
  `id_jurnal` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_ekstra` int(11) NOT NULL,
  `ekstrakulikuler` varchar(100) NOT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `judul` varchar(150) NOT NULL,
  `deskripsi` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jurnal`
--

INSERT INTO `jurnal` (`id_jurnal`, `id_user`, `id_ekstra`, `ekstrakulikuler`, `tanggal`, `judul`, `deskripsi`) VALUES
(29, 2, 2, 'Futsal', '2024-02-19', 'abcd', 'abcde'),
(30, 4, 13, 'Voli', '2024-02-19', 'voli', 'voli'),
(31, 5, 14, 'Basket', '2024-02-19', 'basket', 'basket'),
(34, 2, 2, 'Futsal', '2024-02-21', 'futsal', 'pass');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `jurusan` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`id_jurusan`, `jurusan`) VALUES
(1, 'X RPL A'),
(2, 'X RPL B'),
(3, 'X RPL C');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelatih_ekstra`
--

CREATE TABLE `pelatih_ekstra` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_ekstra` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelatih_ekstra`
--

INSERT INTO `pelatih_ekstra` (`id`, `id_user`, `id_ekstra`) VALUES
(1, 2, 2),
(37, 4, 13),
(38, 5, 14),
(53, 14, 38),
(54, 15, 36),
(59, 16, 39);

--
-- Trigger `pelatih_ekstra`
--
DELIMITER $$
CREATE TRIGGER `sebelum_insert_pelatih` BEFORE INSERT ON `pelatih_ekstra` FOR EACH ROW BEGIN
IF EXISTS (
    SELECT 1
    FROM pelatih_ekstra p
    WHERE p.id_ekstra = NEW.id_ekstra
    LIMIT 1
  ) THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'Pelatih sudah terdaftar';
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `password`, `role`) VALUES
(1, 'Alvian Dwiky Putra', 'alvian', 'alvian', 'Siswa'),
(2, 'Bagas Kahfi Pratama', 'bagas', 'bagas', 'Pelatih'),
(3, 'Bagus Kahfi Pratama', 'bagus', 'bagus', 'Kesiswaan'),
(4, 'Rehan Pratama', 'rehan', 'rehan', 'Pelatih'),
(5, 'Revan Pratama', 'revan', 'revan', 'Pelatih'),
(8, 'Ernando Ari', 'ernando', 'ernando', 'Pelatih'),
(9, 'Alan Herva', 'alan', 'alan', 'Siswa'),
(14, 'Alya Ridha', 'ridha', '824', 'Pelatih'),
(15, 'Dwi Lestari', 'dwi', '719', 'Pelatih'),
(16, 'Annisa ', 'nisa', '123', 'Pelatih');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_buat_absensi`),
  ADD KEY `id_ekstra` (`id_ekstra`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `absensi_siswa`
--
ALTER TABLE `absensi_siswa`
  ADD PRIMARY KEY (`id_absensi`);

--
-- Indeks untuk tabel `ekstra`
--
ALTER TABLE `ekstra`
  ADD PRIMARY KEY (`id_ekstra`);

--
-- Indeks untuk tabel `ekstra_diikuti`
--
ALTER TABLE `ekstra_diikuti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `jurusan` (`id_jurusan`),
  ADD KEY `id_jurusan` (`id_jurusan`),
  ADD KEY `id_ekstra` (`id_ekstra`);

--
-- Indeks untuk tabel `jurnal`
--
ALTER TABLE `jurnal`
  ADD PRIMARY KEY (`id_jurnal`),
  ADD KEY `id_ekstra` (`id_ekstra`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indeks untuk tabel `pelatih_ekstra`
--
ALTER TABLE `pelatih_ekstra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ekstra` (`id_ekstra`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_buat_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `absensi_siswa`
--
ALTER TABLE `absensi_siswa`
  MODIFY `id_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `ekstra`
--
ALTER TABLE `ekstra`
  MODIFY `id_ekstra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `ekstra_diikuti`
--
ALTER TABLE `ekstra_diikuti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `jurnal`
--
ALTER TABLE `jurnal`
  MODIFY `id_jurnal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pelatih_ekstra`
--
ALTER TABLE `pelatih_ekstra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`id_ekstra`) REFERENCES `ekstra` (`id_ekstra`) ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `ekstra_diikuti`
--
ALTER TABLE `ekstra_diikuti`
  ADD CONSTRAINT `ekstra_diikuti_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `ekstra_diikuti_ibfk_4` FOREIGN KEY (`id_jurusan`) REFERENCES `jurusan` (`id_jurusan`) ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `jurnal`
--
ALTER TABLE `jurnal`
  ADD CONSTRAINT `jurnal_ibfk_1` FOREIGN KEY (`id_ekstra`) REFERENCES `ekstra` (`id_ekstra`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `jurnal_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
