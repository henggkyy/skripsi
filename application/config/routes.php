<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'C_Login/loadLoginPage';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['proses_login'] = 'C_Login/prosesLogin';
$route['logout'] = 'C_Login/logout';

$route['debug_tiva'] = 'C_Jadwal/loadDebug';
$route['dashboard'] = 'C_Main/loadDashboard';
$route['periode_akademik'] = 'C_Main/loadPeriodeAkademik';

$route['periode_akademik/aktifasi'] = 'C_PeriodeAkademik/aktifkanPeriodeAkademik';
$route['periode_akademik/nonaktif'] = 'C_PeriodeAkademik/nonaktifkanPeriode';

$route['administrasi_matkul'] = 'C_Main/loadViewAdministrasiMatkul';
$route['administrasi_matkul/tambah'] = 'C_Matkul/addMatkul';
$route['administrasi_matkul_detail'] = 'C_Matkul/getDetailMataKuliah';
$route['administrasi_matkul/set_uts'] = 'C_Matkul/insertTanggalUTS';
$route['administrasi_matkul/set_uas'] = 'C_Matkul/insertTanggalUAS';
$route['administrasi_matkul/insert_mhs'] = 'C_Matkul/insertMahasiswa';
$route['administrasi_matkul/insert_kelas'] = 'C_Matkul/insertJadwalKelas';
$route['administrasi_matkul/checker'] = 'C_Matkul/loadPageCekPL';
$route['administrasi_matkul/perangkat_lunak/add'] = 'C_Matkul/insertPL';
$route['administrasi_matkul/perangkat_lunak/delete'] = 'C_Matkul/deletePL';
$route['administrasi_matkul/perangkat_lunak/checker'] = 'C_Matkul/periksaPL';
$route['administrasi_matkul/insert_file_bantuan'] = 'C_Matkul/insertFileBantuan';
$route['administrasi_matkul/file_bantuan/remove'] = 'C_Matkul/deleteFileBantuan';
$route['administrasi_matkul/file_bantuan/accept'] = 'C_Matkul/acceptFileBantuan';
$route['administrasi_matkul/file_bantuan/reject'] = 'C_Matkul/rejectFileBantuan';
$route['administrasi_matkul/checklist_ujian'] = 'C_Matkul/checkListUjian';
$route['administrasi_matkul/add_ruang_uts'] = 'C_Matkul/setRuanganUTS';
$route['administrasi_matkul/add_ruang_uas'] = 'C_Matkul/setRuanganUAS';

$route['kalab'] = 'C_Main/loadPageAdministrasiKalab';
$route['kalab/change'] = 'C_Kalab/changeKalab';

$route['dokumen'] = 'C_Public/loadViewDokumen';
$route['get_dokumen'] = 'C_Public/getSelectedDokumen';

$route['dokumen_sop'] = 'C_Main/loadMenuSOP';
$route['dokumen_sop/add'] = 'C_Sop/inputDokumenSop';
$route['dokumen_sop/add_kategori'] = 'C_Sop/addKategori';
$route['dokumen_sop/delete'] = 'C_Sop/deleteSop';
$route['dokumen_sop/update'] = 'C_Sop/updateSop';

$route['dokumen_saku'] = 'C_Main/loadMenuBukuSaku';
$route['dokumen_saku/add'] = 'C_BukuSaku/inputBukuSaku';
$route['dokumen_saku/delete'] = 'C_BukuSaku/deleteBukuSaku';
$route['dokumen_saku/update'] = 'C_BukuSaku/updateBukuSaku';

$route['tata_usaha'] = 'C_Main/loadDaftarTU';
$route['tata_usaha/add'] = 'C_TataUsaha/addTataUsaha';
$route['tata_usaha/nonactivate'] = 'C_TataUsaha/nonactivateTU';
$route['tata_usaha/activate'] = 'C_TataUsaha/activateTU';


$route['dosen'] = 'C_Main/loadMenuDosen';
$route['dosen/add'] = 'C_Dosen/addDosen';
$route['dosen/nonactivate'] = 'C_Dosen/nonactivateDosen';
$route['dosen/activate'] = 'C_Dosen/activateDosen';

$route['admin_lab'] = 'C_Main/loadMenuAdmin';
$route['admin_lab/add'] = 'C_Admin/insertAdmin';
$route['admin_lab/nonactivate'] = 'C_Admin/nonactivateAdmin';
$route['admin_lab/activate'] = 'C_Admin/activateAdmin';
$route['admin_lab/detail'] = 'C_Admin/loadDetailAdmin';
$route['admin_lab/update_kontrak'] = 'C_Admin/updateMasaKontrak';
$route['admin_lab/insert_jadwal_manual'] = 'C_Admin/insertJadwalBertugasManual';
$route['admin_lab/insert_jadwal_auto'] = 'C_Admin/insertJadwalBertugasAuto';
$route['admin_lab/delete_jadwal'] = 'C_Admin/deleteJadwalAdmin';
$route['admin_lab/get_jadwal_bertugas'] = 'C_Admin/getIndividualJadwalAdmin';
$route['admin_lab/update_jadwal'] = 'C_Admin/updateJadwalBertugasAdmin';
$route['admin_lab/update_golongan'] = 'C_Admin/editKonfigurasiGolonganGaji';
$route['admin_lab/jadwal_bertugas'] = 'C_Admin/loadJadwalBertugasAdmin';
$route['admin_lab/pengajuan_masa_ujian'] = 'C_Admin/pengajuanJadwalMasaUjian';
$route['admin_lab/pengajuan_masa_kuliah'] = 'C_Admin/pengajuanJadwalMasaKuliah';
$route['admin_lab/accept_pengajuan_kuliah'] = 'C_Admin/acceptJadwalMasaKuliah';
$route['admin_lab/accept_pengajuan_ujian'] = 'C_Admin/acceptJadwalMasaUjian';
$route['admin_lab/reject_pengajuan'] = 'C_Admin/rejectPengajuanJadwal';
$route['admin_lab/rekapitulasi_pengajuan'] = 'C_Admin/loadRekapitulasiPengajuanJadwal';
$route['admin_lab/rekapitulasi_jadwal'] = 'C_Admin/loadRekapitulasiJadwalBertugas';
$route['admin_lab/get_pengajuan'] = 'C_Admin/loadDataPengajuan';
$route['admin_lab/jadwal/cetak'] = 'C_Admin/cetakJadwalAdmin';

$route['laporan_gaji'] = 'C_Gaji_Admin/loadDaftarGajiAdmin';
$route['laporan_gaji/periode'] = 'C_Gaji_Admin/loadSetPeriode';
$route['laporan_gaji/periode/add'] = 'C_Gaji_Admin/setPeriodeGaji';
$route['laporan_gaji/periode/nonactivate'] = 'C_Gaji_Admin/nonaktifkanPeriode';
$route['laporan_gaji/edit_konfigurasi'] = 'C_Gaji_Admin/editKonfigurasi';
$route['laporan_gaji/input'] = 'C_Gaji_Admin/insertAbsensi';
$route['laporan_gaji/proses_input_gaji'] = 'C_Gaji_Admin/prosesInputGaji';
$route['laporan_gaji/report'] = 'C_Gaji_Admin/loadHalamanLaporan';
$route['laporan_gaji/cetak'] = 'C_Gaji_Admin/cetakLaporanAdmin';
$route['laporan_gaji/cetak_laporan'] = 'C_Gaji_Admin/cetakLaporanGajiAdmin';
$route['laporan_gaji/detail'] = 'C_Gaji_Admin/getDaftarLaporan';
$route['laporan_gaji/get_laporan'] = 'C_Gaji_Admin/getInputLaporan';
$route['laporan_gaji/update'] = 'C_Gaji_Admin/editLaporanGaji';
$route['laporan_gaji/delete'] = 'C_Gaji_Admin/hapusLaporanGaji';

$route['konfigurasi_gaji/add'] = 'C_Konfigurasi/addKonfigurasi';

$route['alat_lab'] = 'C_Main/loadMenuAlatLab';
$route['alat_lab/add'] = 'C_Alat/insertAlat';
$route['alat_lab/delete'] = 'C_Alat/deleteAlat';

$route['peminjaman'] = 'C_Peminjaman/loadHomePeminjaman';
$route['peminjaman/add'] = 'C_Peminjaman/insertPeminjaman';
$route['peminjaman/tindakan'] = 'C_Peminjaman/tindaklanjutiPinjaman';
$route['peminjaman/form'] = 'C_Peminjaman/loadFormPeminjaman';
$route['peminjaman/ajuan'] = 'C_Peminjaman/insertPeminjamanInAdmin';

$route['peminjaman_lab'] = 'C_Main/loadDaftarPeminjamanLaboratorium';

$route['peminjaman_alat'] = 'C_Main/loadDaftarPeminjamanAlat';

$route['jadwal'] = 'C_Jadwal/loadJadwalPublic';
$route['insert_data_software'] = 'C_Api/insertDataSoftware';

$route['jadwal_lab'] = 'C_Main/loadJadwalPemakaianLaboratorium';
$route['jadwal_lab/add'] = 'C_Jadwal_Lab/insertJadwalPemakaian';
$route['jadwal_lab/get_data'] = 'C_Jadwal_Lab/loadDataPemakaian';
$route['jadwal_lab/updatePemakaian'] = 'C_Jadwal_Lab/updateJadwalPemakaian';
$route['jadwal_lab/delete'] = 'C_Jadwal_Lab/deleteJadwalPemakaian';
$route['jadwal_lab/cetak'] = 'C_Jadwal_Lab/cetakJadwalLab';

$route['download/template_insertMhs'] = 'C_Download/downloadTemplateInsertMhs';
$route['download/checker'] = 'C_Download/downloadChecker';
$route['download/file_bantuan/(:any)'] = 'C_Download/downloadFileBantuan/$1';

$route['ketersediaan_lab'] = 'C_Jadwal_Lab/checkKetersediaanPeminjaman';

$route['jadwal/json_all_admin'] = 'C_Jadwal/getJadwalAllAdmin';
$route['jadwal/json_all_ruangan'] = 'C_Jadwal/getAllJadwalRuangan';
$route['jadwal/json_jadwal_bertugas'] = 'C_Admin/getDataBertugasAdminForTimeTables';
$route['jadwal/json_individual_admin'] = 'C_Admin/getDataBertugasByIdAdminForTimeTables';