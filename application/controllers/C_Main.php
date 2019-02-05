<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani menu utama dari aplikasi.
class C_Main extends CI_Controller{
	//Method untuk menampilkan tampilan dashboard setelah pengguna melakukan login ke dalam aplikasi.
	//Return : View Dashboard.
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
	//Return : View Periode Akademik
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
}
?>