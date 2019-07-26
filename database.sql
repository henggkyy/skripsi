-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 26, 2019 at 08:37 AM
-- Server version: 10.1.40-MariaDB-cll-lve
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apayamyid_skripsi_lab`
--

-- --------------------------------------------------------

--
-- Table structure for table `alat_lab`
--

CREATE TABLE `alat_lab` (
  `ID` int(11) NOT NULL,
  `NAMA_ALAT` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `checklist_ujian`
--

CREATE TABLE `checklist_ujian` (
  `ID` int(11) NOT NULL,
  `ID_MATKUL` int(11) NOT NULL,
  `TIPE_UJIAN` int(11) NOT NULL COMMENT '0: UTS, 1: UAS',
  `CHECKLIST_01` varchar(32) DEFAULT NULL,
  `CHECKLIST_02` varchar(32) DEFAULT NULL,
  `CHECKLIST_03` varchar(32) DEFAULT NULL,
  `CHECKLIST_04` varchar(32) DEFAULT NULL,
  `CHECKLIST_05` varchar(32) DEFAULT NULL,
  `CHECKLIST_06` varchar(32) DEFAULT NULL,
  `CHECKLIST_07` varchar(32) DEFAULT NULL,
  `CHECKLIST_08` varchar(32) DEFAULT NULL,
  `CHECKLIST_09` varchar(32) DEFAULT NULL,
  `CHECKLIST_10` varchar(32) DEFAULT NULL,
  `LAST_UPDATE` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `daftar_lab`
--

CREATE TABLE `daftar_lab` (
  `ID` int(11) NOT NULL,
  `NAMA_LAB` varchar(128) NOT NULL,
  `LOKASI` varchar(128) NOT NULL,
  `KAPASITAS` int(11) NOT NULL,
  `BG_COLOR` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_buku_saku`
--

CREATE TABLE `data_buku_saku` (
  `ID` int(11) NOT NULL,
  `JUDUL` varchar(512) NOT NULL,
  `PATH_FILE` varchar(512) NOT NULL,
  `VISIBILITY` int(11) NOT NULL COMMENT '1: Public. 0: Private',
  `LAST_UPDATE` varchar(64) NOT NULL,
  `USER` int(11) NOT NULL
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
  `ID_KATEGORI` int(11) NOT NULL,
  `LAST_UPDATE` varchar(64) NOT NULL,
  `USER` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_software`
--

CREATE TABLE `data_software` (
  `ID` int(11) NOT NULL,
  `DATA_SOFTWARE` longtext,
  `UNIQ_ID` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detail_user`
--

CREATE TABLE `detail_user` (
  `ID` int(11) NOT NULL,
  `ID_USER` int(11) NOT NULL,
  `ANGKATAN` int(11) NOT NULL,
  `AWAL_KONTRAK` date NOT NULL,
  `AKHIR_KONTRAK` date NOT NULL,
  `ID_GAJI` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `file_bantuan_ujian`
--

CREATE TABLE `file_bantuan_ujian` (
  `ID` int(11) NOT NULL,
  `PATH_FILE` varchar(256) NOT NULL,
  `NAMA_FILE_USER` varchar(256) NOT NULL,
  `TIPE_UJIAN` int(11) NOT NULL COMMENT '0 : UTS, 1: UAS',
  `ID_MATKUL` int(11) NOT NULL,
  `LAST_UPDATE` varchar(64) NOT NULL,
  `USER_UPLOAD` int(11) NOT NULL,
  `STATUS` int(11) NOT NULL COMMENT '0 : pending, 1 : accept, 2:ditolak'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_bertugas_admin`
--

CREATE TABLE `jadwal_bertugas_admin` (
  `ID` int(11) NOT NULL,
  `HARI` varchar(32) NOT NULL,
  `TANGGAL` date NOT NULL,
  `JAM_MULAI` time NOT NULL,
  `JAM_SELESAI` time NOT NULL,
  `TIPE_BERTUGAS` varchar(32) NOT NULL,
  `NUM_DAY` int(11) NOT NULL,
  `TIPE_BERTUGAS_INT` int(11) NOT NULL COMMENT '0 : Masa Perkuliahan, 1 : Masa UTS, 2 : Masa UAS',
  `ID_PERIODE` int(11) NOT NULL,
  `ID_ADMIN` int(11) NOT NULL,
  `INSERT_DATE` varchar(32) NOT NULL,
  `IS_UPDATE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_lab`
--

CREATE TABLE `jadwal_lab` (
  `ID` int(11) NOT NULL,
  `ID_LAB` int(11) NOT NULL,
  `TITLE` varchar(128) NOT NULL,
  `START_EVENT` varchar(64) NOT NULL,
  `END_EVENT` varchar(64) NOT NULL,
  `STATUS` int(11) NOT NULL COMMENT '0 : pending, 1:show'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_matkul`
--

CREATE TABLE `jadwal_matkul` (
  `ID` int(11) NOT NULL,
  `ID_MATKUL` int(11) NOT NULL,
  `HARI` varchar(64) NOT NULL,
  `JAM_MULAI` time NOT NULL,
  `JAM_SELESAI` time NOT NULL,
  `KODE_KELAS` varchar(64) NOT NULL,
  `ID_LAB` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_sop`
--

CREATE TABLE `kategori_sop` (
  `ID` int(11) NOT NULL,
  `NAMA_KATEGORI` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kebutuhan_pl`
--

CREATE TABLE `kebutuhan_pl` (
  `ID` int(11) NOT NULL,
  `NAMA_PL` varchar(256) NOT NULL,
  `ID_MATKUL` int(11) NOT NULL,
  `STATUS` int(11) NOT NULL COMMENT '0 : belum diperiksa, 1: sudah terinstall, 2 : belum terinstall',
  `LAST_CHECKED` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `konfigurasi_gaji`
--

CREATE TABLE `konfigurasi_gaji` (
  `ID` int(11) NOT NULL,
  `NAMA_GOLONGAN` varchar(128) NOT NULL,
  `JAM_MAX` varchar(150) NOT NULL,
  `TARIF` varchar(9000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `laporan_gaji_admin`
--

CREATE TABLE `laporan_gaji_admin` (
  `ID` int(11) NOT NULL,
  `UNIQ` varchar(10) NOT NULL,
  `ID_PERIODE` int(11) NOT NULL,
  `ID_ADMIN` int(11) NOT NULL,
  `HARI` varchar(64) NOT NULL,
  `TANGGAL_MASUK` date NOT NULL,
  `JAM_MASUK` time NOT NULL,
  `JAM_KELUAR` time NOT NULL,
  `TOTAL_JAM` varchar(5) NOT NULL,
  `ISTIRAHAT` varchar(5) NOT NULL,
  `TARIF_AKTIF` int(11) NOT NULL,
  `WAKTU_MAKS_AKTIF` int(11) NOT NULL,
  `WAKTU_REAL` varchar(10) NOT NULL,
  `BIAYA` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `list_mata_kuliah`
--

CREATE TABLE `list_mata_kuliah` (
  `ID` int(11) NOT NULL,
  `KODE_MATKUL` varchar(128) NOT NULL,
  `NAMA_MATKUL` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `JAM_MULAI_UTS` varchar(64) DEFAULT NULL,
  `JAM_SELESAI_UTS` varchar(64) DEFAULT NULL,
  `TANGGAL_UAS` varchar(32) DEFAULT NULL,
  `JAM_MULAI_UAS` varchar(64) DEFAULT NULL,
  `JAM_SELESAI_UAS` varchar(64) DEFAULT NULL,
  `ID_DOSEN` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_lab`
--

CREATE TABLE `peminjaman_lab` (
  `ID` int(11) NOT NULL,
  `EMAIL_PEMINJAM` varchar(256) DEFAULT NULL,
  `NAMA_PEMINJAM` varchar(256) NOT NULL,
  `KEPERLUAN` varchar(256) NOT NULL,
  `LAB` int(11) DEFAULT NULL,
  `ID_ALAT` int(11) DEFAULT NULL,
  `TANGGAL_PINJAM` date NOT NULL,
  `JAM_MULAI` time NOT NULL,
  `JAM_SELESAI` time NOT NULL,
  `KETERANGAN_PEMINJAM` varchar(1024) NOT NULL,
  `DISETUJUI` int(11) NOT NULL COMMENT '1 : Disetujui, 0 : Pending, 2 : Ditolak',
  `KETERANGAN_KALAB` varchar(1024) NOT NULL,
  `TANGGAL_REQUEST` datetime NOT NULL,
  `ID_JADWAL` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_jadwal_bertugas`
--

CREATE TABLE `pengajuan_jadwal_bertugas` (
  `ID` int(11) NOT NULL,
  `ID_ADMIN` int(11) NOT NULL,
  `ID_PERIODE` int(11) NOT NULL,
  `HARI` varchar(64) NOT NULL,
  `TANGGAL` date DEFAULT NULL,
  `NUM_DAY` int(11) NOT NULL,
  `JAM_MULAI` time NOT NULL,
  `JAM_SELESAI` time NOT NULL,
  `JAM_MULAI_DISETUJUI` time DEFAULT NULL,
  `JAM_SELESAI_DISETUJUI` time DEFAULT NULL,
  `TIPE_BERTUGAS` int(11) NOT NULL COMMENT '0: Kuliah. 1: UTS. 2: UAS',
  `STATUS` int(11) NOT NULL COMMENT '0: Pending. 1 : Approved, 2: Reject',
  `DATE_SUBMITTED` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `periode_akademik`
--

CREATE TABLE `periode_akademik` (
  `ID` int(11) NOT NULL,
  `NAMA` varchar(128) NOT NULL COMMENT 'Cth : Genap 2018/2019',
  `START_PERIODE` varchar(64) NOT NULL,
  `END_PERIODE` varchar(64) NOT NULL,
  `START_UTS` varchar(64) NOT NULL,
  `END_UTS` varchar(64) NOT NULL,
  `START_UAS` varchar(64) NOT NULL,
  `END_UAS` varchar(64) NOT NULL,
  `STATUS` int(11) NOT NULL COMMENT '1: Aktif. 0 : Nonaktif',
  `CREATED_ON` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATED_BY` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `periode_gaji`
--

CREATE TABLE `periode_gaji` (
  `ID` int(11) NOT NULL,
  `START_PERIODE` varchar(64) NOT NULL,
  `END_PERIODE` varchar(64) NOT NULL,
  `KETERANGAN` varchar(128) NOT NULL,
  `STATUS` int(11) NOT NULL COMMENT '1: Aktif. 0 : Nonaktif'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ruangan_ujian`
--

CREATE TABLE `ruangan_ujian` (
  `ID` int(11) NOT NULL,
  `ID_MATKUL` int(11) NOT NULL,
  `ID_LAB` int(11) NOT NULL,
  `TIPE_UJIAN` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `surat_tugas_admin`
--

CREATE TABLE `surat_tugas_admin` (
  `ID` int(11) NOT NULL,
  `ID_ADMIN` int(11) NOT NULL,
  `AWAL_KONTRAK` date NOT NULL,
  `AKHIR_KONTRAK` date NOT NULL,
  `PATH_FILE` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(10) NOT NULL,
  `ID_ROLE` int(10) NOT NULL,
  `NAMA` varchar(128) NOT NULL,
  `INISIAL` varchar(64) DEFAULT NULL,
  `COLOR` varchar(128) DEFAULT NULL,
  `EMAIL` varchar(128) NOT NULL,
  `NIK` int(11) NOT NULL,
  `STATUS` int(11) NOT NULL COMMENT 'Status Aktivitas. 1 : Aktif. 2 : Nonaktif',
  `IS_DOSEN` int(11) NOT NULL COMMENT '1 : Dosen. 2 : Non Dosen',
  `LAST_LOGIN` varchar(64) DEFAULT NULL,
  `LAST_IP` varchar(64) DEFAULT NULL
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
-- Indexes for dumped tables
--

--
-- Indexes for table `alat_lab`
--
ALTER TABLE `alat_lab`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `checklist_ujian`
--
ALTER TABLE `checklist_ujian`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_MATKUL` (`ID_MATKUL`);

--
-- Indexes for table `daftar_lab`
--
ALTER TABLE `daftar_lab`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `data_buku_saku`
--
ALTER TABLE `data_buku_saku`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `USER` (`USER`);

--
-- Indexes for table `data_file_sop`
--
ALTER TABLE `data_file_sop`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_KATEGORI` (`ID_KATEGORI`),
  ADD KEY `USER` (`USER`);

--
-- Indexes for table `data_software`
--
ALTER TABLE `data_software`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `detail_user`
--
ALTER TABLE `detail_user`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_USER` (`ID_USER`),
  ADD KEY `ID_GAJI` (`ID_GAJI`);

--
-- Indexes for table `file_bantuan_ujian`
--
ALTER TABLE `file_bantuan_ujian`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_MATKUL` (`ID_MATKUL`),
  ADD KEY `USER_UPLOAD` (`USER_UPLOAD`);

--
-- Indexes for table `jadwal_bertugas_admin`
--
ALTER TABLE `jadwal_bertugas_admin`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_ADMIN` (`ID_ADMIN`),
  ADD KEY `ID_PERIODE` (`ID_PERIODE`);

--
-- Indexes for table `jadwal_lab`
--
ALTER TABLE `jadwal_lab`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_LAB` (`ID_LAB`);

--
-- Indexes for table `jadwal_matkul`
--
ALTER TABLE `jadwal_matkul`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_MATKUL` (`ID_MATKUL`),
  ADD KEY `ID_LAB` (`ID_LAB`);

--
-- Indexes for table `kategori_sop`
--
ALTER TABLE `kategori_sop`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `kebutuhan_pl`
--
ALTER TABLE `kebutuhan_pl`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_MATKUL` (`ID_MATKUL`);

--
-- Indexes for table `konfigurasi_gaji`
--
ALTER TABLE `konfigurasi_gaji`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `laporan_gaji_admin`
--
ALTER TABLE `laporan_gaji_admin`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_PERIODE` (`ID_PERIODE`),
  ADD KEY `ID_ADMIN` (`ID_ADMIN`);

--
-- Indexes for table `list_mata_kuliah`
--
ALTER TABLE `list_mata_kuliah`
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
  ADD KEY `ID_ALAT` (`ID_ALAT`),
  ADD KEY `ID_JADWAL` (`ID_JADWAL`);

--
-- Indexes for table `pengajuan_jadwal_bertugas`
--
ALTER TABLE `pengajuan_jadwal_bertugas`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_ADMIN` (`ID_ADMIN`),
  ADD KEY `ID_PERIODE` (`ID_PERIODE`);

--
-- Indexes for table `periode_akademik`
--
ALTER TABLE `periode_akademik`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CREATED_BY` (`CREATED_BY`);

--
-- Indexes for table `periode_gaji`
--
ALTER TABLE `periode_gaji`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ruangan_ujian`
--
ALTER TABLE `ruangan_ujian`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_LAB` (`ID_LAB`),
  ADD KEY `ID_MATKUL` (`ID_MATKUL`);

--
-- Indexes for table `surat_tugas_admin`
--
ALTER TABLE `surat_tugas_admin`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_ADMIN` (`ID_ADMIN`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `checklist_ujian`
--
ALTER TABLE `checklist_ujian`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daftar_lab`
--
ALTER TABLE `daftar_lab`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_buku_saku`
--
ALTER TABLE `data_buku_saku`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_file_sop`
--
ALTER TABLE `data_file_sop`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_software`
--
ALTER TABLE `data_software`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_user`
--
ALTER TABLE `detail_user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_bantuan_ujian`
--
ALTER TABLE `file_bantuan_ujian`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_bertugas_admin`
--
ALTER TABLE `jadwal_bertugas_admin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_lab`
--
ALTER TABLE `jadwal_lab`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_matkul`
--
ALTER TABLE `jadwal_matkul`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori_sop`
--
ALTER TABLE `kategori_sop`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kebutuhan_pl`
--
ALTER TABLE `kebutuhan_pl`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `konfigurasi_gaji`
--
ALTER TABLE `konfigurasi_gaji`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laporan_gaji_admin`
--
ALTER TABLE `laporan_gaji_admin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `list_mata_kuliah`
--
ALTER TABLE `list_mata_kuliah`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mhs_peserta`
--
ALTER TABLE `mhs_peserta`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peminjaman_lab`
--
ALTER TABLE `peminjaman_lab`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengajuan_jadwal_bertugas`
--
ALTER TABLE `pengajuan_jadwal_bertugas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `periode_akademik`
--
ALTER TABLE `periode_akademik`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `periode_gaji`
--
ALTER TABLE `periode_gaji`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ruangan_ujian`
--
ALTER TABLE `ruangan_ujian`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_tugas_admin`
--
ALTER TABLE `surat_tugas_admin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checklist_ujian`
--
ALTER TABLE `checklist_ujian`
  ADD CONSTRAINT `checklist_ujian_ibfk_1` FOREIGN KEY (`ID_MATKUL`) REFERENCES `mata_kuliah` (`ID`);

--
-- Constraints for table `data_buku_saku`
--
ALTER TABLE `data_buku_saku`
  ADD CONSTRAINT `data_buku_saku_ibfk_1` FOREIGN KEY (`USER`) REFERENCES `users` (`ID`);

--
-- Constraints for table `data_file_sop`
--
ALTER TABLE `data_file_sop`
  ADD CONSTRAINT `data_file_sop_ibfk_1` FOREIGN KEY (`ID_KATEGORI`) REFERENCES `kategori_sop` (`ID`),
  ADD CONSTRAINT `data_file_sop_ibfk_2` FOREIGN KEY (`USER`) REFERENCES `users` (`ID`);

--
-- Constraints for table `detail_user`
--
ALTER TABLE `detail_user`
  ADD CONSTRAINT `detail_user_ibfk_1` FOREIGN KEY (`ID_USER`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `detail_user_ibfk_2` FOREIGN KEY (`ID_GAJI`) REFERENCES `konfigurasi_gaji` (`ID`);

--
-- Constraints for table `file_bantuan_ujian`
--
ALTER TABLE `file_bantuan_ujian`
  ADD CONSTRAINT `file_bantuan_ujian_ibfk_1` FOREIGN KEY (`ID_MATKUL`) REFERENCES `mata_kuliah` (`ID`),
  ADD CONSTRAINT `file_bantuan_ujian_ibfk_2` FOREIGN KEY (`USER_UPLOAD`) REFERENCES `users` (`ID`);

--
-- Constraints for table `jadwal_bertugas_admin`
--
ALTER TABLE `jadwal_bertugas_admin`
  ADD CONSTRAINT `jadwal_bertugas_admin_ibfk_1` FOREIGN KEY (`ID_ADMIN`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `jadwal_bertugas_admin_ibfk_2` FOREIGN KEY (`ID_PERIODE`) REFERENCES `periode_akademik` (`ID`);

--
-- Constraints for table `jadwal_lab`
--
ALTER TABLE `jadwal_lab`
  ADD CONSTRAINT `jadwal_lab_ibfk_1` FOREIGN KEY (`ID_LAB`) REFERENCES `daftar_lab` (`ID`);

--
-- Constraints for table `jadwal_matkul`
--
ALTER TABLE `jadwal_matkul`
  ADD CONSTRAINT `jadwal_matkul_ibfk_1` FOREIGN KEY (`ID_MATKUL`) REFERENCES `mata_kuliah` (`ID`),
  ADD CONSTRAINT `jadwal_matkul_ibfk_2` FOREIGN KEY (`ID_LAB`) REFERENCES `daftar_lab` (`ID`);

--
-- Constraints for table `kebutuhan_pl`
--
ALTER TABLE `kebutuhan_pl`
  ADD CONSTRAINT `kebutuhan_pl_ibfk_1` FOREIGN KEY (`ID_MATKUL`) REFERENCES `mata_kuliah` (`ID`);

--
-- Constraints for table `laporan_gaji_admin`
--
ALTER TABLE `laporan_gaji_admin`
  ADD CONSTRAINT `laporan_gaji_admin_ibfk_1` FOREIGN KEY (`ID_PERIODE`) REFERENCES `periode_gaji` (`ID`),
  ADD CONSTRAINT `laporan_gaji_admin_ibfk_2` FOREIGN KEY (`ID_ADMIN`) REFERENCES `users` (`ID`);

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
  ADD CONSTRAINT `peminjaman_lab_ibfk_2` FOREIGN KEY (`ID_ALAT`) REFERENCES `alat_lab` (`ID`),
  ADD CONSTRAINT `peminjaman_lab_ibfk_3` FOREIGN KEY (`ID_JADWAL`) REFERENCES `jadwal_lab` (`ID`);

--
-- Constraints for table `pengajuan_jadwal_bertugas`
--
ALTER TABLE `pengajuan_jadwal_bertugas`
  ADD CONSTRAINT `pengajuan_jadwal_bertugas_ibfk_1` FOREIGN KEY (`ID_ADMIN`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `pengajuan_jadwal_bertugas_ibfk_2` FOREIGN KEY (`ID_PERIODE`) REFERENCES `periode_akademik` (`ID`);

--
-- Constraints for table `periode_akademik`
--
ALTER TABLE `periode_akademik`
  ADD CONSTRAINT `periode_akademik_ibfk_1` FOREIGN KEY (`CREATED_BY`) REFERENCES `users` (`ID`);

--
-- Constraints for table `ruangan_ujian`
--
ALTER TABLE `ruangan_ujian`
  ADD CONSTRAINT `ruangan_ujian_ibfk_1` FOREIGN KEY (`ID_LAB`) REFERENCES `daftar_lab` (`ID`),
  ADD CONSTRAINT `ruangan_ujian_ibfk_2` FOREIGN KEY (`ID_MATKUL`) REFERENCES `mata_kuliah` (`ID`);

--
-- Constraints for table `surat_tugas_admin`
--
ALTER TABLE `surat_tugas_admin`
  ADD CONSTRAINT `surat_tugas_admin_ibfk_1` FOREIGN KEY (`ID_ADMIN`) REFERENCES `users` (`ID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`ID_ROLE`) REFERENCES `user_role` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
