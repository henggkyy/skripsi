<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani user role petugas Tata Usaha
class C_TataUsaha extends CI_Controller {
	//Method untuk menonaktifkan petugas tata usaha
	function nonactivateTU(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') == 1){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('id_tu', 'ID Admin', 'required');
				if($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('error', 'Missing required Field!');
		            redirect('/tata_usaha');
				}
				else{
					$id_tu = $this->input->post('id_tu');
					$this->load->model('Users');
					$res_update = $this->Users->changeStatus($id_tu, 0);
					if($res_update){
						$this->session->set_flashdata('success', 'Berhasil menonaktifkan petugas tata usaha.');
						redirect('/tata_usaha');
					}
					else{
						$this->session->set_flashdata('error', 'Gagal menonaktifkan petugas tata usaha.');
						redirect('/tata_usaha');
					}
				}
			}
			else{
				redirect('/');
			}
		}
		else{
			redirect('/');
		}
	}

	//Method untuk mengaktifkan petugas tata usaha
	function activateTU(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') == 1){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('id_tu', 'ID Admin', 'required');
				if($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('error', 'Missing required Field!');
		            redirect('/tata_usaha');
				}
				else{
					$id_tu = $this->input->post('id_tu');
					$this->load->model('Users');
					$res_update = $this->Users->changeStatus($id_tu, 1);
					if($res_update){
						$this->session->set_flashdata('success', 'Berhasil mengakifkan kembali petugas tata usaha.');
						redirect('/tata_usaha');
					}
					else{
						$this->session->set_flashdata('error', 'Gagal mengakifkan kembali petugas tata usaha.');
						redirect('/tata_usaha');
					}
				}
			}
			else{
				redirect('/');
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk menambahkan user petugas tata usaha
	function addTataUsaha(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('nik', 'NIK Admin', 'required|numeric');
			$this->form_validation->set_rules('nama', 'Nama Admin', 'required');
			$this->form_validation->set_rules('email', 'Email Admin', 'required|valid_email');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required Field!');
	            redirect('/tata_usaha');
			}
			else{
				$nik = $this->input->post('nik');
				$nama = $this->input->post('nama');
				$email = $this->input->post('email');
				$email_domain = substr($email, strpos($email, "@") + 1);
				if($email_domain != 'student.unpar.ac.id' && $email_domain != 'unpar.ac.id'){
					$this->session->set_flashdata('error', 'Gagal menambahkan petugas Tata Usaha! Email petugas Tata Usaha harus merupakan email UNPAR!');
					redirect('/tata_usaha');
				}
				$this->load->model('Users');
				$user_exist = $this->Users->checkNik($nik);
				if($user_exist){
					$this->session->set_flashdata('error', 'Gagal menambahkan petugas Tata Usaha! NIK Tata Usaha telah terdaftar');
					redirect('/tata_usaha');
				}
				$email_exist = $this->Users->checkUser($email);
				if($email_exist){
					$this->session->set_flashdata('error', 'Gagal menambahkan petugas Tata Usaha! Email petugas Tata Usaha telah terdaftar');
					redirect('/tata_usaha');
				}
				$inisial = NULL;
				$color = NULL;
				$inserted_id = $this->Users->addUser(3, $nama, $email, $nik, 0, $inisial, $color);
				if($inserted_id){
					$this->session->set_flashdata('success', 'Berhasil memasukkan data petugas tata usaha!');
					redirect('/tata_usaha');
				}
				else{
					$this->session->set_flashdata('error', 'Gagal memasukkan data petugas tata usaha!');
					redirect('/tata_usaha');
				}
			}
		}
		else{
			redirect('/');
		}
	}
}
?>