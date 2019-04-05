<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani proses input dan menampilkan halaman yang berhubungan dengan sistem penggajian dan absensi admin
class C_Gaji_Admin extends CI_Controller {
	//Method untuk menonaktifkan periode gaji
	function nonaktifkanPeriode(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_periode_gaji', 'ID Periode Gaji', 'required');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required fields!');
				redirect('/laporan_gaji/periode');
			}
			else{
				$id_periode = $this->input->post('id_periode_gaji');
				$this->load->model('Periode_gaji');
				$is_id_aktif = $this->Periode_gaji->checkIDPeriodeAktif($id_periode);
				if(!$is_id_aktif){
					$this->session->set_flashdata('error', 'Error! Tidak dapat menonaktifkan periode gaji karena bukan merupakan periode yang sdg aktif!');
					redirect('/laporan_gaji/periode');
				}
				$data = array(
					'STATUS' => 0
				);
				$res = $this->Periode_gaji->nonaktifkanPeriode($data, $id_periode);
				if($res){
					$this->session->set_flashdata('success', 'Berhasil menonaktifkan periode gaji admin!');
					redirect('/laporan_gaji/periode');
				}
				else{
					$this->session->set_flashdata('error', 'Gagal menonaktifkan periode gaji admin!');
					redirect('/laporan_gaji/periode');
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk melakukan set periode gaji admin
	function setPeriodeGaji(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('ket_periode', 'Keterangan Periode Gaji', 'required');
			$this->form_validation->set_rules('start_periode', 'Tanggal Periode Awal', 'required');
			$this->form_validation->set_rules('end_periode', 'Tanggal Periode Akhir', 'required');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required fields!');
				redirect('/laporan_gaji/periode');
			}
			else{
				$this->load->model('Periode_gaji');
				$is_periode_aktif = $this->Periode_gaji->checkPeriodeAktif();
				if($is_periode_aktif){
					$this->session->set_flashdata('error', 'Error! Tidak dapat set periode gaji karena masih terdapat periode yang masih aktif!');
					redirect('/laporan_gaji/periode');
				}
				$ket_periode = $this->input->post('ket_periode');
				$start_periode = $this->input->post('start_periode');
				$end_periode = $this->input->post('end_periode');

				$start_periode = date("Y-m-d", strtotime($this->input->post('start_periode')));
				$end_periode = date("Y-m-d", strtotime($this->input->post('end_periode')));

				if(strtotime($start_periode) > strtotime($end_periode)){
					$this->session->set_flashdata('error', 'Error! Tanggal mulai periode lebih besar dibandingkan dengan tanggal selesai!');
					redirect('/laporan_gaji/periode');
				}
				
				$data = array(
					'START_PERIODE' => $start_periode,
					'END_PERIODE' => $end_periode,
					'KETERANGAN' => $ket_periode,
					'STATUS' => 1
				);
				$res = $this->Periode_gaji->insertPeriode($data);
				if($res){
					$this->session->set_flashdata('success', 'Berhasil melakukan set periode gaji admin!');
					redirect('/laporan_gaji/periode');
				}
				else{
					$this->session->set_flashdata('error', 'Gagal melakukan set periode gaji admin!');
					redirect('/laporan_gaji/periode');
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk melakukan set periode gaji admin
	function loadSetPeriode(){
		if($this->session->userdata('logged_in')){
			$data['title'] = 'Periode Gaji Admin | SI Akademik Lab. Komputasi TIF UNPAR';
			$this->load->model('Periode_gaji');
			$data['data_periode'] = $this->Periode_gaji->getAllPeriodeGaji();
			$data['periode_gaji'] = true;
			$is_periode_aktif = $this->Periode_gaji->checkPeriodeAktif();
			$data['is_aktif'] = $is_periode_aktif;
			// print_r($data['is_aktif']);
			// return;
			$this->load->view('template/Header', $data);
			$this->load->view('template/Sidebar', $data);
			$this->load->view('template/Topbar');
			$this->load->view('template/Notification');
			$this->load->view('pages_user/V_Periode_Gaji_Admin');
			$this->load->view('template/Footer');
		}
		else{
			redirect('/');
		}
	}
}
?>