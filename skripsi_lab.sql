-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2019 at 03:15 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skripsi_lab`
--

-- --------------------------------------------------------

--
-- Table structure for table `alat_lab`
--

CREATE TABLE `alat_lab` (
  `ID` int(11) NOT NULL,
  `NAMA_ALAT` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alat_lab`
--

INSERT INTO `alat_lab` (`ID`, `NAMA_ALAT`) VALUES
(1, 'Tespen');

-- --------------------------------------------------------

--
-- Table structure for table `daftar_lab`
--

CREATE TABLE `daftar_lab` (
  `ID` int(11) NOT NULL,
  `NAMA_LAB` varchar(128) NOT NULL,
  `LOKASI` varchar(128) NOT NULL,
  `KAPASITAS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `daftar_lab`
--

INSERT INTO `daftar_lab` (`ID`, `NAMA_LAB`, `LOKASI`, `KAPASITAS`) VALUES
(1, '9017', 'SB Gedung 9', 40),
(2, '9018', 'SB Gedung 9', 40);

-- --------------------------------------------------------

--
-- Table structure for table `data_buku_saku`
--

CREATE TABLE `data_buku_saku` (
  `ID` int(11) NOT NULL,
  `JUDUL` varchar(512) NOT NULL,
  `PATH_FILE` varchar(512) NOT NULL,
  `VISIBILITY` int(11) NOT NULL COMMENT '1: Public. 0: Private'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_file_sop`
--

CREATE TABLE `data_file_sop` (
  `ID` int(11) NOT NULL,
  `JUDUL` varchar(512) NOT NULL,
  `PATH_FILE` varchar(512) NOT NULL,
  `VISIBILITY` int(11) NOT NULL COMMENT '1 : public, 0: private',
  `ID_KATEGORI` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_file_sop`
--

INSERT INTO `data_file_sop` (`ID`, `JUDUL`, `PATH_FILE`, `VISIBILITY`, `ID_KATEGORI`) VALUES
(1, 'SOP coba', '61770944976424268686.pdf', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `detail_user`
--

CREATE TABLE `detail_user` (
  `ID` int(11) NOT NULL,
  `ID_USER` int(11) NOT NULL,
  `ANGKATAN` int(11) NOT NULL,
  `AWAL_KONTRAK` varchar(128) NOT NULL,
  `AKHIR_KONTRAK` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_user`
--

INSERT INTO `detail_user` (`ID`, `ID_USER`, `ANGKATAN`, `AWAL_KONTRAK`, `AKHIR_KONTRAK`) VALUES
(1, 3, 2015, '02/28/2019', '04/16/2019');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_sop`
--

CREATE TABLE `kategori_sop` (
  `ID` int(11) NOT NULL,
  `NAMA_KATEGORI` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori_sop`
--

INSERT INTO `kategori_sop` (`ID`, `NAMA_KATEGORI`) VALUES
(1, 'Perkuliahan'),
(2, 'Ujian');

-- --------------------------------------------------------

--
-- Table structure for table `mata_kuliah`
--

CREATE TABLE `mata_kuliah` (
  `ID` int(11) NOT NULL,
  `ID_PERIODE` int(11) NOT NULL,
  `KD_MATKUL` varchar(128) NOT NULL,
  `NAMA_MATKUL` varchar(128) NOT NULL,
  `TANGGAL_UTS` varchar(32) DEFAULT NULL,
  `TANGGAL_UAS` varchar(32) DEFAULT NULL,
  `ID_DOSEN` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mata_kuliah`
--

INSERT INTO `mata_kuliah` (`ID`, `ID_PERIODE`, `KD_MATKUL`, `NAMA_MATKUL`, `TANGGAL_UTS`, `TANGGAL_UAS`, `ID_DOSEN`) VALUES
(2, 2, 'AIF183346', 'Topik Khusus Sistem Informasi 2', '03/05/2019', '03/27/2019', 1),
(3, 2, 'AIF - 111', 'Tester', '03/06/2019', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `mhs_peserta`
--

CREATE TABLE `mhs_peserta` (
  `ID` int(11) NOT NULL,
  `ID_MATKUL` int(11) NOT NULL,
  `NPM_MHS` int(11) NOT NULL,
  `NAMA_MHS` varchar(250) NOT NULL,
  `RUANG_UTS` varchar(200) DEFAULT NULL,
  `RUANG_UAS` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mhs_peserta`
--

INSERT INTO `mhs_peserta` (`ID`, `ID_MATKUL`, `NPM_MHS`, `NAMA_MHS`, `RUANG_UTS`, `RUANG_UAS`) VALUES
(1, 3, 2015730051, 'Hengky', NULL, NULL),
(2, 3, 2014730073, 'Kevin Pratama', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_lab`
--

CREATE TABLE `peminjaman_lab` (
  `ID` int(11) NOT NULL,
  `DATE_SUBMITTED` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `USER_PEMINJAM` varchar(256) DEFAULT NULL,
  `LAB` int(11) DEFAULT NULL,
  `ID_ALAT` int(11) DEFAULT NULL,
  `TANGGAL_PINJAM` varchar(128) NOT NULL,
  `JAM_MULAI` varchar(128) NOT NULL,
  `JAM_SELESAI` varchar(128) NOT NULL,
  `KETERANGAN_PEMINJAM` varchar(1024) NOT NULL,
  `DISETUJUI` int(11) NOT NULL COMMENT '1 : Disetujui, 0 : Pending, 2 : Ditolak',
  `KETERANGAN_KALAB` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `peminjaman_lab`
--

INSERT INTO `peminjaman_lab` (`ID`, `DATE_SUBMITTED`, `USER_PEMINJAM`, `LAB`, `ID_ALAT`, `TANGGAL_PINJAM`, `JAM_MULAI`, `JAM_SELESAI`, `KETERANGAN_PEMINJAM`, `DISETUJUI`, `KETERANGAN_KALAB`) VALUES
(1, '2019-03-24 11:03:19', NULL, 1, NULL, '2019-03-24', '09:30', '11:30', 'Untuk les', 2, 'Tidak dapat disetujui karena dipakai kelas.'),
(2, '2019-03-24 14:38:01', '7315051@student.unpar.ac.id', 1, NULL, '2019-03-22', '09:30', '09:40', '00', 0, ''),
(3, '2019-03-24 14:47:27', '7315051@student.unpar.ac.id', NULL, 1, '2019-03-20', '09:30', '09:30', 'pinjem aja iseng', 1, 'ff');

-- --------------------------------------------------------

--
-- Table structure for table `periode_akademik`
--

CREATE TABLE `periode_akademik` (
  `ID` int(11) NOT NULL,
  `NAMA` varchar(128) NOT NULL COMMENT 'Cth : Genap 2018/2019',
  `STATUS` int(11) NOT NULL COMMENT '1: Aktif. 0 : Nonaktif',
  `CREATED_ON` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `periode_akademik`
--

INSERT INTO `periode_akademik` (`ID`, `NAMA`, `STATUS`, `CREATED_ON`, `CREATED_BY`) VALUES
(1, 'Semester Genap 2018/2019', 0, '2019-02-05 15:25:53', 1),
(2, 'Semester Genap 2018/2019', 1, '2019-02-06 07:00:20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(10) NOT NULL,
  `ID_ROLE` int(10) NOT NULL,
  `NAMA` varchar(128) NOT NULL,
  `EMAIL` varchar(128) NOT NULL,
  `NIK` int(11) NOT NULL,
  `STATUS` int(11) NOT NULL COMMENT 'Status Aktivitas. 1 : Aktif. 2 : Nonaktif',
  `IS_DOSEN` int(11) NOT NULL COMMENT '1 : Dosen. 2 : Non Dosen'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `ID_ROLE`, `NAMA`, `EMAIL`, `NIK`, `STATUS`, `IS_DOSEN`) VALUES
(1, 1, 'Hengky Surya', '7315051@student.unpar.ac.id', 0, 1, 1),
(2, 2, 'Pascal Alfadian', 'pascal@unpar.ac.id', 20180014, 1, 1),
(3, 4, 'Adrian Stefanus', '7315014@student.unpar.ac.id', 2018000, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_permission`
--

CREATE TABLE `user_permission` (
  `ID` int(11) NOT NULL,
  `ID_ROLE` int(11) NOT NULL,
  `PERMISSION_LINK` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `ID` int(11) NOT NULL,
  `NAMA_ROLE` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`ID`, `NAMA_ROLE`) VALUES
(1, 'Kepala Laboratorium'),
(2, 'Dosen'),
(3, 'Tata Usaha'),
(4, 'Admin'),
(5, 'Mahasiswa'),
(6, 'Staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alat_lab`
--
ALTER TABLE `alat_lab`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `daftar_lab`
--
ALTER TABLE `daftar_lab`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `data_buku_saku`
--
ALTER TABLE `data_buku_saku`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `data_file_sop`
--
ALTER TABLE `data_file_sop`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_KATEGORI` (`ID_KATEGORI`);

--
-- Indexes for table `detail_user`
--
ALTER TABLE `detail_user`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_USER` (`ID_USER`);

--
-- Indexes for table `kategori_sop`
--
ALTER TABLE `kategori_sop`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_PERIODE` (`ID_PERIODE`),
  ADD KEY `ID_DOSEN` (`ID_DOSEN`);

--
-- Indexes for table `mhs_peserta`
--
ALTER TABLE `mhs_peserta`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_MATKUL` (`ID_MATKUL`);

--
-- Indexes for table `peminjaman_lab`
--
ALTER TABLE `peminjaman_lab`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `LAB` (`LAB`),
  ADD KEY `ID_ALAT` (`ID_ALAT`);

--
-- Indexes for table `periode_akademik`
--
ALTER TABLE `periode_akademik`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CREATED_BY` (`CREATED_BY`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_ROLE` (`ID_ROLE`);

--
-- Indexes for table `user_permission`
--
ALTER TABLE `user_permission`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_ROLE` (`ID_ROLE`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alat_lab`
--
ALTER TABLE `alat_lab`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `daftar_lab`
--
ALTER TABLE `daftar_lab`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `data_buku_saku`
--
ALTER TABLE `data_buku_saku`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_file_sop`
--
ALTER TABLE `data_file_sop`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_user`
--
ALTER TABLE `detail_user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kategori_sop`
--
ALTER TABLE `kategori_sop`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mhs_peserta`
--
ALTER TABLE `mhs_peserta`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `peminjaman_lab`
--
ALTER TABLE `peminjaman_lab`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `periode_akademik`
--
ALTER TABLE `periode_akademik`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_permission`
--
ALTER TABLE `user_permission`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_file_sop`
--
ALTER TABLE `data_file_sop`
  ADD CONSTRAINT `data_file_sop_ibfk_1` FOREIGN KEY (`ID_KATEGORI`) REFERENCES `kategori_sop` (`ID`);

--
-- Constraints for table `detail_user`
--
ALTER TABLE `detail_user`
  ADD CONSTRAINT `detail_user_ibfk_1` FOREIGN KEY (`ID_USER`) REFERENCES `users` (`ID`);

--
-- Constraints for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  ADD CONSTRAINT `mata_kuliah_ibfk_1` FOREIGN KEY (`ID_PERIODE`) REFERENCES `periode_akademik` (`ID`),
  ADD CONSTRAINT `mata_kuliah_ibfk_2` FOREIGN KEY (`ID_DOSEN`) REFERENCES `users` (`ID`);

--
-- Constraints for table `mhs_peserta`
--
ALTER TABLE `mhs_peserta`
  ADD CONSTRAINT `mhs_peserta_ibfk_1` FOREIGN KEY (`ID_MATKUL`) REFERENCES `mata_kuliah` (`ID`);

--
-- Constraints for table `peminjaman_lab`
--
ALTER TABLE `peminjaman_lab`
  ADD CONSTRAINT `peminjaman_lab_ibfk_1` FOREIGN KEY (`LAB`) REFERENCES `daftar_lab` (`ID`),
  ADD CONSTRAINT `peminjaman_lab_ibfk_2` FOREIGN KEY (`ID_ALAT`) REFERENCES `alat_lab` (`ID`);

--
-- Constraints for table `periode_akademik`
--
ALTER TABLE `periode_akademik`
  ADD CONSTRAINT `periode_akademik_ibfk_1` FOREIGN KEY (`CREATED_BY`) REFERENCES `users` (`ID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`ID_ROLE`) REFERENCES `user_role` (`ID`);

--
-- Constraints for table `user_permission`
--
ALTER TABLE `user_permission`
  ADD CONSTRAINT `user_permission_ibfk_1` FOREIGN KEY (`ID_ROLE`) REFERENCES `user_role` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
