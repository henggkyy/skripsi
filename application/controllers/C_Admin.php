<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani proses administrasi admin mulai dari proses input, jadwal, dsb.
class C_Admin extends CI_Controller {
	//Method untuk mengaktifkan kembali admin
	function activateAdmin(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_admin', 'ID Admin', 'required');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error_message', 'Missing required Field!');
	            redirect('/admin_lab');
			}
			else{
				$id_admin = $this->input->post('id_admin');
				$this->load->model('Users');
				$res_update = $this->Users->changeStatus($id_admin, 1);
				if($res_update){
					$this->session->set_flashdata('success', 'Berhasil mengakifkan kembali Admin.');
					redirect('/admin_lab');
				}
				else{
					$this->session->set_flashdata('error', 'Gagal mengakifkan kembali Admin.');
					redirect('/admin_lab');
				}
			}
		}
		else{
			redirect('/');
		}
	}

	//Method untuk menonaktifkan admin
	function nonactivateAdmin(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_admin', 'ID Admin', 'required');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error_message', 'Missing required Field!');
	            redirect('/admin_lab');
			}
			else{
				$id_admin = $this->input->post('id_admin');
				$this->load->model('Users');
				$res_update = $this->Users->changeStatus($id_admin, 0);
				if($res_update){
					$this->session->set_flashdata('success', 'Berhasil menonaktifkan Admin.');
					redirect('/admin_lab');
				}
				else{
					$this->session->set_flashdata('error', 'Gagal menonaktifkan Admin.');
					redirect('/admin_lab');
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk memasukkan data admin
	function insertAdmin(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('nik', 'NIK Admin', 'required');
			$this->form_validation->set_rules('nama', 'Nama Admin', 'required');
			$this->form_validation->set_rules('email', 'Email Admin', 'required');
			$this->form_validation->set_rules('angkatan', 'Angkatan Admin', 'required');
			$this->form_validation->set_rules('awal_kontrak', 'Awal Kontrak Admin', 'required');
			$this->form_validation->set_rules('akhir_kontrak', 'Akhir Kontrak Admin', 'required');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error_message', 'Missing required Field!');
	            redirect('/admin_lab');
			}
			else{
				$nik = $this->input->post('nik');
				$nama = $this->input->post('nama');
				$email = $this->input->post('email');
				$angkatan = $this->input->post('angkatan');
				$awal_kontrak = $this->input->post('awal_kontrak');
				$akhir_kontrak = $this->input->post('akhir_kontrak');
				$this->load->model('Users');
				$inserted_id = $this->Users->addUser(4, $nama, $email, $nik, 0);
				if($inserted_id){
					$this->load->model('Detail_user');
					$insert_detail = $this->Detail_user->insertDetailUser($inserted_id, $angkatan, $awal_kontrak, $akhir_kontrak);
					if($insert_detail){
						$this->session->set_flashdata('success', 'Berhasil memasukkan data admin laboratorium!');
						redirect('/admin_lab');
					}
					else{
						$this->session->set_flashdata('error', 'Gagal memasukkan detail data admin laboratorium!');
						redirect('/admin_lab');
					}
				}
				else{
					$this->session->set_flashdata('error', 'Gagal memasukkan data admin laboratorium!');
					redirect('/admin_lab');
				}
			}
		}
		else{
			redirect('/');
		}
	}
}
?>