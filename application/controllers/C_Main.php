<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani menu utama dari aplikasi.
class C_Main extends CI_Controller{
	//Method untuk menampilkan halaman administrasi kepala laboratorium
	function loadPageAdministrasiKalab(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1){
				redirect('/dashboard');
			}
			$data['admin_kalab'] = true;
			$data['title'] = 'Administrasi Kepala Laboratorium | SI Operasional Lab. Komputasi TIF UNPAR';
			$this->load->model('Users');
			$this->load->model('Peminjaman_lab');
			$this->load->model('Periode_akademik');
			$data['count_lab'] = $this->Peminjaman_lab->countPeminjamanLabPending();
			$data['count_alat'] = $this->Peminjaman_lab->countPeminjamanAlatPending();
			$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();
			$data['data_dosen'] = $this->Users->getAllDosen();
			$this->load->view('template/Header', $data);
			$this->load->view('template/Sidebar', $data);
			$this->load->view('template/Topbar');
			$this->load->view('template/Notification');
			$this->load->view('pages_user/V_Administrasi_Kalab', $data);
			$this->load->view('template/Footer');
		}
		else{
			redirect('/');
		}
	}
	//Method untuk menampilkan daftar pengguna Tata Usaha
	function loadDaftarTU(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1){
				redirect('/dashboard');
			}
			$data['title'] = 'Daftar Pengguna Tata Usaha | SI Operasional Lab. Komputasi TIF UNPAR';
			$this->load->model('Periode_akademik');
			$this->load->model('Users');
			$this->load->model('Peminjaman_lab');
			$data['count_lab'] = $this->Peminjaman_lab->countPeminjamanLabPending();
			$data['count_alat'] = $this->Peminjaman_lab->countPeminjamanAlatPending();
			$data['tata_usaha'] = true;
			$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();
			$data['data_tu'] = $this->Users->getAllUserByRole(3);
			$this->load->view('template/Header', $data);
			$this->load->view('template/Sidebar', $data);
			$this->load->view('template/Topbar');
			$this->load->view('template/Notification');
			$this->load->view('pages_user/V_Daftar_TU', $data);
			$this->load->view('template/Footer');
		}
		else{
			redirect('/');
		}
	}
	//Method untuk menampilkan jadwal pemakaian laboratorium dengan menggunakan library FullCalendar
	function loadJadwalPemakaianLaboratorium(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1){
				redirect('/dashboard');
			}
			$data['title'] = 'Jadwal Pemakaian Laboratorium | SI Operasional Lab. Komputasi TIF UNPAR';
			$this->load->model('Periode_akademik');
			$this->load->model('Jadwal_lab');
			$this->load->model('Peminjaman_lab');
			$data['count_lab'] = $this->Peminjaman_lab->countPeminjamanLabPending();
			$data['count_alat'] = $this->Peminjaman_lab->countPeminjamanAlatPending();
			$data['jadwal_lab'] = true;
			$data['pemakaian_lab'] = $this->Jadwal_lab->getJadwalPemakaianLabDataTables();
			$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();
			$this->load->view('template/Header', $data);
			$this->load->view('template/Sidebar', $data);
			$this->load->view('template/Topbar');
			$this->load->view('template/Notification');
			$this->load->view('pages_user/V_Jadwal_Lab', $data);
			$this->load->view('template/Footer');
		}
		else{
			redirect('/');
		}
	}
	//Method untuk menampilkan halaman daftar peminjaman alat laboratorium
	function loadDaftarPeminjamanAlat(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1){
				redirect('/dashboard');
			}
			$data['title'] = 'Daftar Peminjaman Alat | SI Operasional Lab. Komputasi TIF UNPAR';
			$this->load->model('Periode_akademik');
			$this->load->model('Peminjaman_lab');
			$data['peminjaman_alat'] = true;
			$data['count_lab'] = $this->Peminjaman_lab->countPeminjamanLabPending();
			$data['count_alat'] = $this->Peminjaman_lab->countPeminjamanAlatPending();
			$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();
			$data['daftar_peminjaman'] = $this->Peminjaman_lab->getAllDataPeminjamanAlat();
			$this->load->view('template/Header', $data);
			$this->load->view('template/Sidebar', $data);
			$this->load->view('template/Topbar');
			$this->load->view('template/Notification');
			$this->load->view('pages_user/V_Daftar_Peminjaman_Alat', $data);
			$this->load->view('template/Footer');
		}
		else{
			redirect('/');
		}
	}

	//Method untuk menampilkan halaman daftar peminjaman laboratorium
	function loadDaftarPeminjamanLaboratorium(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1){
				redirect('/dashboard');
			}
			$data['title'] = 'Daftar Peminjaman Laboratorium | SI Operasional Lab. Komputasi TIF UNPAR';
			$this->load->model('Periode_akademik');
			$this->load->model('Peminjaman_lab');
			$data['peminjaman_lab'] = true;
			$data['count_lab'] = $this->Peminjaman_lab->countPeminjamanLabPending();
			$data['count_alat'] = $this->Peminjaman_lab->countPeminjamanAlatPending();
			$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();
			$data['daftar_peminjaman'] = $this->Peminjaman_lab->getAllDataPeminjamanLab();
			$this->load->view('template/Header', $data);
			$this->load->view('template/Sidebar', $data);
			$this->load->view('template/Topbar');
			$this->load->view('template/Notification');
			$this->load->view('pages_user/V_Daftar_Peminjaman_Laboratorium', $data);
			$this->load->view('template/Footer');
		}
		else{
			redirect('/');
		}
	}
	//Method untuk menampilkan halaman utama mengenai daftar alat laboratorium
	function loadMenuAlatLab(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 4){
				redirect('/dashboard');
			}
			$data['title'] = 'Alat Laboratorium | SI Operasional Lab. Komputasi TIF UNPAR';
			$this->load->model('Periode_akademik');
			$this->load->model('Alat_lab');
			$data['alat_lab'] = true;
			$this->load->model('Peminjaman_lab');
			$data['count_lab'] = $this->Peminjaman_lab->countPeminjamanLabPending();
			$data['count_alat'] = $this->Peminjaman_lab->countPeminjamanAlatPending();
			$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();
			$data['data_alat'] = $this->Alat_lab->getAllAlat();
			$this->load->view('template/Header', $data);
			$this->load->view('template/Sidebar', $data);
			$this->load->view('template/Topbar');
			$this->load->view('template/Notification');
			$this->load->view('pages_user/V_Alat_Lab', $data);
			$this->load->view('template/Footer');
		}
		else{
			redirect('/');
		}
	}
	//Method untuk menampilkan halaman utama dari administrasi admin laboratorium
	function loadMenuAdmin(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 3){
				redirect('/dashboard');
			}
			$data['title'] = 'Administrasi Admin Laboratorium | SI Operasional Lab. Komputasi TIF UNPAR';
			$this->load->model('Periode_akademik');
			$this->load->model('Users');
			$this->load->model('Konfigurasi_gaji');
			$this->load->model('Peminjaman_lab');
			$data['count_lab'] = $this->Peminjaman_lab->countPeminjamanLabPending();
			$data['count_alat'] = $this->Peminjaman_lab->countPeminjamanAlatPending();
			$data['admin_lab'] = true;
			$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();
			$data['data_admin'] = $this->Users->getAllUserByRole(4);
			$data['konfigurasi_gaji'] = $this->Konfigurasi_gaji->getKonfigurasi();
			$this->load->view('template/Header', $data);
			$this->load->view('template/Sidebar', $data);
			$this->load->view('template/Topbar');
			$this->load->view('template/Notification');
			$this->load->view('pages_user/V_Admin', $data);
			$this->load->view('template/Footer');
		}
		else{
			redirect('/');
		}
	}
	//Method untuk menampilkan halaman utama administrasi dosen.
	function loadMenuDosen(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 3){
				redirect('/dashboard');
			}
			$data['title'] = 'Administrasi Dosen | SI Operasional Lab. Komputasi TIF UNPAR';
			$data['admin_dosen'] = true;
			$this->load->model('Periode_akademik');
			$this->load->model('Users');
			$this->load->model('Peminjaman_lab');
			$data['count_lab'] = $this->Peminjaman_lab->countPeminjamanLabPending();
			$data['count_alat'] = $this->Peminjaman_lab->countPeminjamanAlatPending();
			$data['data_dosen'] = $this->Users->getAllDosen();
			$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();
			$this->load->view('template/Header', $data);
			$this->load->view('template/Sidebar', $data);
			$this->load->view('template/Topbar');
			$this->load->view('template/Notification');
			$this->load->view('pages_user/V_Dosen', $data);
			$this->load->view('template/Footer');
		}
		else{
			redirect('/');
		}
	}

	//Method untuk menampilkan halaman utama dari buku saku
	function loadMenuBukuSaku(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 4){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
			$data['title'] = 'Dokumen Buku Saku | SI Operasional Lab. Komputasi TIF UNPAR';
			$data['dokumen_saku'] = true;
			$this->load->model('Peminjaman_lab');
			$data['count_lab'] = $this->Peminjaman_lab->countPeminjamanLabPending();
			$data['count_alat'] = $this->Peminjaman_lab->countPeminjamanAlatPending();
			$this->load->model('Periode_akademik');
			$this->load->model('Data_buku_saku');
			$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();
			$data['file_saku'] = $this->Data_buku_saku->getAllBukuSaku();
			$this->load->view('template/Header', $data);
			$this->load->view('template/Sidebar', $data);
			$this->load->view('template/Topbar');
			$this->load->view('template/Notification');
			$this->load->view('pages_user/V_Dokumen_Buku_Saku', $data);
			$this->load->view('template/Footer');
		}
		else{
			redirect('/');
		}
	}

	//Method untuk menampilkan halaman utama dokumen SOP
	function loadMenuSOP(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 4){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
			$data['title'] = 'Dokumen SOP | SI Operasional Lab. Komputasi TIF UNPAR';
			$data['dokumen_sop'] = true;
			$this->load->model('Peminjaman_lab');
			$data['count_lab'] = $this->Peminjaman_lab->countPeminjamanLabPending();
			$data['count_alat'] = $this->Peminjaman_lab->countPeminjamanAlatPending();
			$this->load->model('Periode_akademik');
			$this->load->model('Data_file_sop');
			$this->load->model('Kategori_sop');
			$data['file_sop'] = $this->Data_file_sop->getAllSOP();
			$data['kategori_sop'] = $this->Kategori_sop->getAllKategori();
			$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();
			$this->load->view('template/Header', $data);
			$this->load->view('template/Sidebar', $data);
			$this->load->view('template/Topbar');
			$this->load->view('template/Notification');
			$this->load->view('pages_user/V_Dokumen_SOP', $data);
			$this->load->view('template/Footer');
		}
		else{
			redirect('/');
		}
	}

	
	//Method untuk menampilkan tampilan dashboard setelah pengguna melakukan login ke dalam aplikasi.
	//Return : View V_Dashboard.php.
	function loadDashboard(){
		if($this->session->userdata('logged_in')){
			$data['title'] = 'Dashboard | SI Operasional Lab. Komputasi TIF UNPAR';
			$data['dashboard'] = true;
			$this->load->model('Periode_akademik');
			$this->load->model('Users');
			$this->load->model('Peminjaman_lab');
			$data['data_login'] = $this->Users->getDataLogin();
			$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();
			$data['count_lab'] = $this->Peminjaman_lab->countPeminjamanLabPending();
			$data['count_alat'] = $this->Peminjaman_lab->countPeminjamanAlatPending();
			$this->load->view('template/Header', $data);
			$this->load->view('template/Sidebar', $data);
			$this->load->view('template/Topbar', $data);
			$this->load->view('template/Notification');
			$this->load->view('pages_user/V_Dashboard', $data);
			$this->load->view('template/Footer');
		}
		else{
			redirect('/');
		}
	}

	//Method untuk melakukan load halaman periode akademik.
	//Return : View V_PeriodeAkademik.php
	function loadPeriodeAkademik(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') == 1 || $this->session->userdata('id_role') == 3){
				$data['title'] = 'Periode Akademik | SI Operasional Lab. Komputasi TIF UNPAR';
				$data['periode'] = true;
				$this->load->model('Peminjaman_lab');
				$data['count_lab'] = $this->Peminjaman_lab->countPeminjamanLabPending();
				$data['count_alat'] = $this->Peminjaman_lab->countPeminjamanAlatPending();
				$this->load->model('Periode_akademik');
				$data['info_periode'] = $this->Periode_akademik->getPeriodeAktif();
				$data['data_periode'] = $this->Periode_akademik->getAllPeriode();
				$this->load->view('template/Header', $data);
				$this->load->view('template/Sidebar', $data);
				$this->load->view('template/Topbar');
				$this->load->view('template/Notification');
				$this->load->view('pages_user/V_PeriodeAkademik', $data);
				$this->load->view('template/Footer');
			}
			else{
				redirect('/dashboard');
			}
		}
		else{
			redirect('/');
		}
	}

	//Method untuk melakukan load halaman inisiasi & administrasi mata kuliah.
	//Return : View V_InisiasisMatkul.php
	function loadViewAdministrasiMatkul(){
		if($this->session->userdata('logged_in')){
			$data['title'] = 'Inisiasi & Administrasi Mata Kuliah | SI Akademik Lab. Komputasi TIF UNPAR';
			$data['matkul'] = true;
			$this->load->model('Mata_kuliah');
			$this->load->model('Periode_akademik');
			$this->load->model('Users');
			$this->load->model('Peminjaman_lab');
			$this->load->model('List_mata_kuliah');
			$data['count_lab'] = $this->Peminjaman_lab->countPeminjamanLabPending();
			$data['count_alat'] = $this->Peminjaman_lab->countPeminjamanAlatPending();
			$data['list_matkul'] = $this->List_mata_kuliah->getAllMatkul();
			$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();
			$data['daftar_periode'] = $this->Periode_akademik->getAllPeriode();
			$id_periode =  $this->Periode_akademik->getIDPeriodeAktif();
			$data['data_dosen'] = $this->Users->getDosenAktif();
				
			$id_periode = $this->Periode_akademik->getIDPeriodeAktif();
			if(isset($_GET['id_periode'])){
				$id_periode = $_GET['id_periode'];
				if($id_periode != ""){
					$data['id_periode_aktif'] = $id_periode;
				}
			}
			else{
				if(!$id_periode){
					$data['id_periode_aktif'] = $this->Periode_akademik->getLastActiveId();
				}
				else{
					$data['id_periode_aktif'] = $id_periode;
				}
			}
			if($this->session->userdata('id_role') == 2){
				$data['matkul'] = $this->Mata_kuliah->getMatkulByDosen($data['id_periode_aktif'], $this->session->userdata('id'));
			}
			else{
				$data['matkul'] = $this->Mata_kuliah->getMatkul($data['id_periode_aktif']);
			}
			$this->load->view('template/Header', $data);
			$this->load->view('template/Sidebar', $data);
			$this->load->view('template/Topbar');
			$this->load->view('template/Notification');
			$this->load->view('pages_user/V_InisiasiMatkul', $data);
			$this->load->view('template/Footer');
		}
		else{
			redirect('/');
		}
	}
}
?>