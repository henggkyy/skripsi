<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani Inisiasi dan Administrasi Mata Kuliah.
class C_Matkul extends CI_Controller{
	//Method ini digunakan untuk memasukkan tanggal ujian UTS dan UAS mata kuliah.
	function insertUjian(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('nama_matkul', 'Nama Mata Kuliah', 'required');
			$this->form_validation->set_rules('tgl_uts', 'Tanggal UTS', 'required');
			$this->form_validation->set_rules('tgl_uas', 'Tanggal UAS', 'required');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Nama Mata Kuliah/Tanggal UTS/Tanggal UAS tidak ditemukan!');
				redirect('/inisiasi_administrasi_matkul');
			}
			else{
				$id_matkul = $this->input->post('nama_matkul');
				$tgl_uts = $this->input->post('tgl_uts');
				$tgl_uas = $this->input->post('tgl_uas');
				$this->load->model('Mata_kuliah');
				$res = $this->Mata_kuliah->insertTanggalUjian($id_matkul, $tgl_uts, $tgl_uas);
				if($res){
					$this->session->set_flashdata('success', 'Berhasil menambahkan tanggal ujian mata kuliah!');
					redirect('/inisiasi_administrasi_matkul');
				}
				else{
					$this->session->set_flashdata('error', 'Gagal menambahkan tanggal ujian mata kuliah!');
					redirect('/inisiasi_administrasi_matkul');
				}
			}	
		}
		else{
			redirect('/');
		}
	}

	//Method ini digunakan untuk memasukkan mata kuliah.
	function addMatkul(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('kode_matkul', 'Kode Mata Kuliah', 'required');
			$this->form_validation->set_rules('nama_matkul', 'Nama Mata Kuliah', 'required');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Kode & Nama Mata Kuliah tidak ditemukan!');
				redirect('/inisiasi_administrasi_matkul');
			}
			else{
				$kode_matkul = $this->input->post('kode_matkul');
				$nama_matkul = $this->input->post('nama_matkul');
				$this->load->model('Periode_akademik');
				$id_periode = $this->Periode_akademik->getIDPeriodeAktif();
				if($id_periode){
					$this->load->model('Mata_kuliah');
					$res = $this->Mata_kuliah->insertMatkul($id_periode, $kode_matkul, $nama_matkul);
					if($res){
						$this->session->set_flashdata('success', 'Berhasil menambahkan mata kuliah!');
						redirect('/inisiasi_administrasi_matkul');
					}
					else{
						$this->session->set_flashdata('error', 'Gagal menambahkan mata kuliah!');
						redirect('/inisiasi_administrasi_matkul');
					}
				}
				else{
					$this->session->set_flashdata('error', 'Tidak ada Periode Akademik yang sedang aktif!');
					redirect('/inisiasi_administrasi_matkul');
				}
			}
		}
		else{
			redirect('/');
		}
	}
}
?>