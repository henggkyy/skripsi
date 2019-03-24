<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani aksi mengenai proses Peminjaman
class C_Peminjaman extends CI_Controller{
	//Method untuk melakukan load halaman pilihan apakah ingin meminjam laboratorium atau alat lab
	function loadHomePeminjaman(){
		$data['title'] = "Form Peminjaman Alat / Ruangan Laboratorium | SI Akademik Lab. Komputasi TIF";
		$this->load->model('Alat_lab');
		$data['daftar_alat'] = $this->Alat_lab->getAllAlat();
		$this->load->model('Daftar_lab');
		$data['daftar_lab'] = $this->Daftar_lab->getListLab();
		$this->load->view('pages_user/V_Home_Peminjaman', $data);
	}

	//Method untuk menindaklanjuti permintaan peminjaman laboratorium
	function tindaklanjutiPinjaman(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('tindakan', 'Tindakan', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
			$this->form_validation->set_rules('id_pinjaman', 'ID Pinjaman', 'required');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error_message', 'Missing required Field!');
		        redirect('/data_peminjaman_lab');
			}
			else{
				$id_pinjaman = $this->input->post('id_pinjaman');
				$tindakan = $this->input->post('tindakan');
				$keterangan = $this->input->post('keterangan');
				$this->load->model('Peminjaman_lab');
				$id_alat = $this->Peminjaman_lab->getIndividualItem($id_pinjaman, "ID_ALAT");
				$res = $this->Peminjaman_lab->tindaklanjutiPermintaanLab($id_pinjaman, $tindakan, $keterangan);
				if($res){
					if($id_alat == NULL){
						$this->session->set_flashdata('success', 'Berhasil menindaklanjuti permintaan peminjaman ruangan laboratorium');
						redirect("/peminjaman_lab");
					}
					else{
						$this->session->set_flashdata('success', 'Berhasil menindaklanjuti permintaan peminjaman alat');
						redirect("/peminjaman_alat");
					}
				}
				else{
					if($id_alat == NULL){
						$this->session->set_flashdata('success', 'Gagal menindaklanjuti permintaan peminjaman ruangan laboratorium');
						redirect("/peminjaman_lab");
					}
					else{
						$this->session->set_flashdata('success', 'Gagal menindaklanjuti permintaan peminjaman alat');
						redirect("/peminjaman_alat");
					}
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk memasukkan data peminjaman laboratorium ke dalam database
	function insertPeminjaman(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('tgl_pinjam', 'Tanggal Pinjam', 'required');
		$this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
		$this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
		$this->form_validation->set_rules('choice', 'Mode', 'required');
		$mode = $this->input->post('choice');
		if($mode == 'lab'){
			$this->form_validation->set_rules('lab', 'Tipe Laboratorium', 'required');
		}
		else{
			$this->form_validation->set_rules('alat', 'Alat Laboratorium', 'required');
		}

		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error', 'Missing required Field!');
	        redirect('/peminjaman');
		}
		else{
			$user_peminjam = '7315051@student.unpar.ac.id';
			$tipe_lab = $this->input->post('lab');
			$alat =  $this->input->post('alat');
			$tgl_pinjam = $this->input->post('tgl_pinjam');
			$jam_mulai = $this->input->post('jam_mulai');
			$jam_selesai = $this->input->post('jam_selesai');
			$keterangan = $this->input->post('keterangan');

			$this->load->model('Peminjaman_lab');
			$res = $this->Peminjaman_lab->addPeminjaman($user_peminjam, $tipe_lab, $alat, $tgl_pinjam, $jam_mulai, $jam_selesai, $keterangan);
			if($res){
				$this->session->set_flashdata('success', 'Berhasil melakukan permintaan peminjaman alat/ruangan laboratorium. Silahkan tunggu notifikasi selanjutnya pada Email UNPAR Anda');
				redirect("/peminjaman");
			}
			else{
				$this->session->set_flashdata('success', 'Terjadi kesalahan dalam melakukan permintaan peminjaman alat/ruangan laboratorium.');
				redirect("/peminjaman");
			}
		}
	}
}
?>