<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani CRUD mengenai data dosen
class C_Dosen extends CI_Controller{

	//Method untuk mengaktifkan kembali dosen
	function activateDosen(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 3){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_dosen', 'ID Dosen', 'required');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error_message', 'Missing required Field!');
	            redirect('/dosen');
			}
			else{
				$id_dosen = $this->input->post('id_dosen');
				$this->load->model('Users');
				$res_update = $this->Users->changeStatus($id_dosen, 1);
				if($res_update){
					$this->session->set_flashdata('success', 'Berhasil mengakifkan kembali Dosen.');
					redirect('/dosen');
				}
				else{
					$this->session->set_flashdata('error', 'Gagal mengakifkan kembali Dosen.');
					redirect('/dosen');
				}
			}
		}
		else{
			redirect('/');
		}
	}

	//Method untuk menonaktifkan dosen
	function nonactivateDosen(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 3){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_dosen', 'ID Dosen', 'required');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error_message', 'Missing required Field!');
	            redirect('/dosen');
			}
			else{
				$id_dosen = $this->input->post('id_dosen');
				$this->load->model('Users');
				$res_update = $this->Users->changeStatus($id_dosen, 0);
				if($res_update){
					$this->session->set_flashdata('success', 'Berhasil menonaktifkan Dosen.');
					redirect('/dosen');
				}
				else{
					$this->session->set_flashdata('error', 'Gagal menonaktifkan Dosen.');
					redirect('/dosen');
				}
			}
		}
		else{
			redirect('/');
		}
	}

	//Method untuk menambahkan data dosen
	function addDosen(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 3){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('nik', 'NIK Dosen', 'required');
			$this->form_validation->set_rules('nama', 'Nama Dosen', 'required');
			$this->form_validation->set_rules('email', 'Email Dosen', 'required');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error_message', 'Missing required Field!');
	            redirect('/dosen');
			}
			else{
				$nik = $this->input->post('nik');
				$nama = $this->input->post('nama');
				$email = $this->input->post('email');
				$this->load->model('Users');
				$user_exist = $this->Users->checkNik($nik);
				if($user_exist){
					$this->session->set_flashdata('error', 'Gagal menambahkan Dosen! NIK Dosen telah terdaftar');
					redirect('/dosen');
				}
				$res_add_dosen = $this->Users->addUser(2, $nama, $email, $nik, 1);
				if($res_add_dosen){
					$this->session->set_flashdata('success', 'Berhasil menambahkan Dosen.');
					redirect('/dosen');
				}
				else{
					$this->session->set_flashdata('error', 'Gagal menambahkan Dosen.');
					redirect('/dosen');
				}
			}
		}
		else{
			redirect('/');
		}
	}
}
?>