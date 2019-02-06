<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani menu utama dari aplikasi.
class C_Main extends CI_Controller{
	//Method untuk menampilkan tampilan administrasi user.
	//Return : View V_User.php
	function loadMenuUser(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') == 1){
				$data['title'] = 'Administrasi User | SI Akademik Lab. Komputasi TIF UNPAR';
				$data['user'] = true;
				$this->load->model('Users');
				$this->load->model('User_role');
				$data['role'] = $this->User_role->getUserRole();
				$data['data_user'] = $this->Users->getUser();
				$this->load->view('template/Header', $data);
				$this->load->view('template/Sidebar', $data);
				$this->load->view('template/Topbar');
				$this->load->view('template/Notification');
				$this->load->view('pages_user/V_User', $data);
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

	//Method untuk menampilkan tampilan dashboard setelah pengguna melakukan login ke dalam aplikasi.
	//Return : View V_Dashboard.php.
	function loadDashboard(){
		if($this->session->userdata('logged_in')){
			$data['title'] = 'Dashboard | SI Akademik Lab. Komputasi TIF UNPAR';
			$data['dashboard'] = true;
			$this->load->model('Periode_akademik');
			$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();
			$this->load->view('template/Header', $data);
			$this->load->view('template/Sidebar', $data);
			$this->load->view('template/Topbar');
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
			if($this->session->userdata('id_role') == 1){
				$data['title'] = 'Periode Akademik | SI Akademik Lab. Komputasi TIF UNPAR';
				$data['periode_akademik'] = true;

				$this->load->model('Periode_akademik');
				$data['info_periode'] = $this->Periode_akademik->getPeriodeAktif();

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
			if($this->session->userdata('id_role') == 1){
				$data['title'] = 'Inisiasi & Administrasi Mata Kuliah | SI Akademik Lab. Komputasi TIF UNPAR';
				$data['inisiasi_matkul'] = true;

				$this->load->model('Mata_kuliah');
				$this->load->model('Periode_akademik');
				$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();
				$id_periode =  $this->Periode_akademik->getIDPeriodeAktif();

				$data['matkul'] = $this->Mata_kuliah->getMatkul($id_periode);
				
				$this->load->view('template/Header', $data);
				$this->load->view('template/Sidebar', $data);
				$this->load->view('template/Topbar');
				$this->load->view('template/Notification');
				$this->load->view('pages_user/V_InisiasiMatkul', $data);
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
}
?>