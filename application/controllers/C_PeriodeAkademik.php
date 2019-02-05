<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_PeriodeAkademik extends CI_Controller{

	//Method untuk melakukan nonaktif periode akademik
	function nonaktifkanPeriode(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') == 1){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('id_periode', 'ID Periode Akademik', 'required');
				if ($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('error', 'ID Periode Akademik tidak ditemukan!');
					redirect('/periode_akademik');
				}
				else{
					$id_periode = $this->input->post('id_periode');
					$this->load->model('Periode_akademik');
					$res = $this->Periode_akademik->nonaktifkanPeriode($id_periode);
					if($res){
						$this->session->set_flashdata('success', 'Berhasil menonaktifkan Periode Akademik.');
						redirect('/periode_akademik');
					}
					else{
						$this->session->set_flashdata('error', 'Gagal menonaktifkan Periode Akademik.');
						redirect('/periode_akademik');
					}
				}
			}
			else{
				redirect('/dashboard');
			}
		}
		else{
			redirect('/');
		}
	}

	//Method untuk mengaktifkan periode akademik
	function aktifkanPeriodeAkademik(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') == 1){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('nama_periode', 'Nama Periode Akademik', 'required');
				if ($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('error_form', 'Silahkan Isi Nama Periode Akademik');
					redirect('/periode_akademik');
				}
				else{
					$this->load->model('Periode_akademik');
					$check_periode_aktif = $this->Periode_akademik->checkPeriodeAktif();
					if($check_periode_aktif){
						$this->session->set_flashdata('error', 'Tidak dapat set Periode Akademik. Masih ada Periode Akademik sdg Aktif');
						redirect('/periode_akademik');
					}
					else{
						$nama_periode = $this->input->post('nama_periode');
						$res = $this->Periode_akademik->insertPeriode($nama_periode);
						if($res){
							$this->session->set_flashdata('success', 'Berhasil menambahkan Periode Akademik.');
							redirect('/periode_akademik');
						}
						else{
							$this->session->set_flashdata('error', 'Gagal menambahkan Periode Akademik.');
							redirect('/periode_akademik');
						}
					}
				}
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