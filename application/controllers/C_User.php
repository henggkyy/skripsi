<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani proses administrasi pengguna
class C_User extends CI_Controller{
	//Method ini digunakan untuk mengubah status aktif/nonaktif user.
	function changeStatus(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') == 1){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('id_user', 'ID User', 'required');
				if ($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('error', 'ID User tidak ditemukan!');
					redirect('/user');
				}
				else{
					$id_user = $this->input->post('id_user');
					$this->load->model('Users');
					$status = $this->Users->getStatus($id_user);
					if($status == 1){
						$new_status = 0;
					}
					else{
						$new_status = 1;
					}
					$res = $this->Users->changeStatus($id_user, $new_status);
					if($res){
						$this->session->set_flashdata('success', 'Berhasil mengubah status user.');
						redirect('/user');
					}
					else{
						$this->session->set_flashdata('error', 'Gagal mengubah status user.');
						redirect('/user');
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

	//Method ini digunakan untuk menambahkan user baru.
	function addUser(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') == 1){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('nama_user', 'Nama User', 'required');
				$this->form_validation->set_rules('email_user', 'Email User', 'required');
				$this->form_validation->set_rules('role_user', 'Role User', 'required');
				if ($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('error_form', 'Nama/Email/Role user tidak ditemukan!');
					redirect('/user');
				}
				else{
					$nama_user = $this->input->post('nama_user');
					$email_user = $this->input->post('email_user');
					$role_user = $this->input->post('role_user');
					$this->load->model('Users');
					$res = $this->Users->addUser($role_user, $nama_user, $email_user);
					if($res){
						$this->session->set_flashdata('success', 'Berhasil menambahkan user.');
						redirect('/user');
					}
					else{
						$this->session->set_flashdata('error', 'Gagal menambahkan user.');
						redirect('/user');
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