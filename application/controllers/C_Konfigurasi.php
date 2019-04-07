<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani proses konfigurasi/golongan gaji admin
class C_Konfigurasi extends CI_Controller {
	//Method untuk menambahkan konfigurasi gaji baru.
	function addKonfigurasi(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('nama', 'Nama Golongan', 'required');
			$this->form_validation->set_rules('maks_jam', 'Jam Maksimal', 'required');
			$this->form_validation->set_rules('tarif', 'Tarif per Jam', 'required');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required Field!');
	            redirect("laporan_gaji/periode");
			}
			else{
				$nama = $this->input->post('nama');
				$maks_jam = $this->input->post('maks_jam');
				$tarif = $this->input->post('tarif');
				if($maks_jam < 0 || $tarif < 0){
					$this->session->set_flashdata('error', 'Jam maksiman dan/atau tarif per jam tidak boleh lebih kecil dari 0!');
	            	redirect("laporan_gaji/periode");
				}
				$data = array(
					'NAMA_GOLONGAN' => $nama,
					'JAM_MAX' => $maks_jam,
					'TARIF' => $tarif
				);
				$this->load->model('Konfigurasi_gaji');
				$res = $this->Konfigurasi_gaji->insertKonfigurasi($data);
				if($res){
					$this->session->set_flashdata('success', "Berhasil menambahkan konfigurasi gaji!");
					redirect("laporan_gaji/periode");
				}
				else{
					$this->session->set_flashdata('error', "Gagal menambahkan konfigurasi gaji!");
					redirect("laporan_gaji/periode");
				}
			}
		}
		else{
			redirect('/');
		}
	}
}
?>