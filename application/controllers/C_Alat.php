<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani input dan delete dari alat Laboratorium
class C_Alat extends CI_Controller{
	//Method untuk memasukkan alat laboratorium ke dalam database
	function insertAlat(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 4){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('nama', 'Nama Alat', 'required');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error_message', 'Nama Alat belum diisi!');
	            redirect('/alat_lab');
			}
			else{
				if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 4){
					redirect('/dashboard');
				}
				$nama_alat = $this->input->post('nama');
				$this->load->model('Alat_lab');
				$res = $this->Alat_lab->inputAlat($nama_alat);
				if($res){
					$this->session->set_flashdata('success', 'Berhasil menambahkan Alat Laboratorium');
					redirect('/alat_lab');
				}
				else{
					$this->session->set_flashdata('error', 'Gagal menambahkan Alat Laboratorium');
					redirect('/alat_lab');
				}
			}
		}
		else{
			redirect('/');
		}
	}

	//Method untuk menghapus alat laboratorium
	function deleteAlat(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 4){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_alat', 'ID Alat', 'required');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error_message', 'ID Alat tidak ditemukan!');
	            redirect('/alat_lab');
			}
			else{
				if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 4){
					redirect('/dashboard');
				}
				$id_alat = $this->input->post('id_alat');
				$this->load->model('Alat_lab');
				$res = $this->Alat_lab->deleteAlat($id_alat);
				if($res){
					$this->session->set_flashdata('success', 'Berhasil menghapus Alat Laboratorium');
					redirect('/alat_lab');
				}
				else{
					$this->session->set_flashdata('error', 'Gagal menghapus Alat Laboratorium');
					redirect('/alat_lab');
				}
			}
		}
		else{
			redirect('/');
		}
	}
}
?>
