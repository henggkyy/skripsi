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

$route['dashboard'] = 'C_Main/loadDashboard';
$route['periode_akademik'] = 'C_Main/loadPeriodeAkademik';

$route['periode_akademik/aktifasi'] = 'C_PeriodeAkademik/aktifkanPeriodeAkademik';
$route['periode_akademik/nonaktif'] = 'C_PeriodeAkademik/nonaktifkanPeriode';

$route['administrasi_matkul'] = 'C_Main/loadViewAdministrasiMatkul';
$route['administrasi_matkul/tambah'] = 'C_Matkul/addMatkul';
$route['administrasi_matkul/set_jadwal'] = 'C_Matkul/insertUjian';
$route['administrasi_matkul_detail'] = 'C_Matkul/getDetailMataKuliah';
$route['administrasi_matkul/set_uts'] = 'C_Matkul/insertTanggalUTS';
$route['administrasi_matkul/set_uas'] = 'C_Matkul/insertTanggalUAS';
$route['administrasi_matkul/insert_mhs'] = 'C_Matkul/insertMahasiswa';
$route['administrasi_matkul/insert_jadwal'] = 'C_Matkul/insertJadwalPerkuliahan';
$route['administrasi_matkul/insert_kelas'] = 'C_Jadwal_Lab/checkKetersediaan';
$route['administrasi_matkul/checker'] = 'C_Matkul/loadPageCekPL';
$route['administrasi_matkul/perangkat_lunak/add'] = 'C_Matkul/insertPL';
$route['administrasi_matkul/perangkat_lunak/delete'] = 'C_Matkul/deletePL';
$route['administrasi_matkul/perangkat_lunak/checker'] = 'C_Matkul/periksaPL';

$route['user'] = 'C_Main/loadMenuUser';
$route['user/tambah_user'] = 'C_User/addUser';
$route['user/change_status'] = 'C_User/changeStatus';

$route['dokumen'] = 'C_Public/loadViewDokumen';
$route['get_dokumen'] = 'C_Public/getSelectedDokumen';

$route['dokumen_sop'] = 'C_Main/loadMenuSOP';
$route['dokumen_sop/add'] = 'C_Sop/inputDokumenSop';
$route['dokumen_sop/delete'] = 'C_Sop/deleteSop';
$route['dokumen_sop/update'] = 'C_Sop/updateSop';

$route['dokumen_saku'] = 'C_Main/loadMenuBukuSaku';
$route['dokumen_saku/add'] = 'C_BukuSaku/inputBukuSaku';
$route['dokumen_saku/delete'] = 'C_BukuSaku/deleteBukuSaku';
$route['dokumen_saku/update'] = 'C_BukuSaku/updateBukuSaku';

$route['dosen'] = 'C_Main/loadMenuDosen';
$route['dosen/add'] = 'C_Dosen/addDosen';
$route['dosen/nonactivate'] = 'C_Dosen/nonactivateDosen';
$route['dosen/activate'] = 'C_Dosen/activateDosen';

$route['admin_lab'] = 'C_Main/loadMenuAdmin';
$route['admin_lab/add'] = 'C_Admin/insertAdmin';
$route['admin_lab/nonactivate'] = 'C_Admin/nonactivateAdmin';
$route['admin_lab/activate'] = 'C_Admin/activateAdmin';

$route['alat_lab'] = 'C_Main/loadMenuAlatLab';
$route['alat_lab/add'] = 'C_Alat/insertAlat';
$route['alat_lab/delete'] = 'C_Alat/deleteAlat';

$route['peminjaman'] = 'C_Peminjaman/loadHomePeminjaman';
$route['peminjaman/add'] = 'C_Peminjaman/insertPeminjaman';
$route['peminjaman/tindakan'] = 'C_Peminjaman/tindaklanjutiPinjaman';

$route['peminjaman_lab'] = 'C_Main/loadDaftarPeminjamanLaboratorium';

$route['peminjaman_alat'] = 'C_Main/loadDaftarPeminjamanAlat';

$route['jadwal_lab'] = 'C_Main/loadJadwalPemakaianLaboratorium';

$route['download/template_insertMhs'] = 'C_Download/downloadTemplateInsertMhs';
$route['download/checker'] = 'C_Download/downloadChecker';

$route['ketersediaan_lab'] = 'C_Jadwal_Lab/checkKetersediaanPeminjaman';