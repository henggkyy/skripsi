<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani aksi mengenai proses Peminjaman
class C_Peminjaman extends CI_Controller{
	//Constructor Controller
	function __construct() {
        parent::__construct();
        $this->load->library('google');
    }
    //Method untuk menampilkan form peminjaman pada halaman admin
    function loadFormPeminjaman(){
    	if($this->session->userdata('logged_in')){
    		$data['title'] = "Form Peminjaman Alat / Ruangan Laboratorium | SI Akademik Lab. Komputasi TIF";
			$this->load->model('Alat_lab');
			$data['form_peminjaman'] = true;
			$data['daftar_alat'] = $this->Alat_lab->getAllAlat();
			$this->load->model('Daftar_lab');
			$data['daftar_lab'] = $this->Daftar_lab->getListLab();
			$this->load->view('template/Header', $data);
			$this->load->view('template/Sidebar', $data);
			$this->load->view('template/Topbar');
			$this->load->view('template/Notification');
			$this->load->view('pages_user/V_Form_Peminjaman', $data);
			$this->load->view('template/Footer');
    	}
    	else{
    		redirect('/');
    	}
    }
	//Method untuk melakukan load halaman pilihan apakah ingin meminjam laboratorium atau alat lab
	function loadHomePeminjaman(){

		if($this->session->userdata('logged_in_public')){
			$data['title'] = "Form Peminjaman Alat / Ruangan Laboratorium | SI Akademik Lab. Komputasi TIF";
			$this->load->model('Alat_lab');
			$data['daftar_alat'] = $this->Alat_lab->getAllAlat();
			$this->load->model('Daftar_lab');
			$data['daftar_lab'] = $this->Daftar_lab->getListLab();
			$this->load->view('pages_user/V_Home_Peminjaman', $data);
		}
		else{
			redirect('/');
		}
	}

	//Method untuk menindaklanjuti permintaan peminjaman laboratorium
	function tindaklanjutiPinjaman(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('tindakan', 'Tindakan', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
			$this->form_validation->set_rules('id_pinjaman', 'ID Pinjaman', 'required');
			if($this->session->userdata('id_role') != 1){
				redirect('/dashboard');
			}
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error_message', 'Missing required Field!');
		        redirect('/data_peminjaman_lab');
			}
			else{
				$id_pinjaman = $this->input->post('id_pinjaman');
				$tindakan = $this->input->post('tindakan');
				$keterangan = $this->input->post('keterangan');
				$this->load->model('Peminjaman_lab');
				$id_tindakan = $this->Peminjaman_lab->getIndividualItem($id_pinjaman, "TINDAKAN");
				if($id_tindakan != 0){
					$this->session->set_flashdata('error', 'Permintaan tersebut telah ditindaklanjuti!');
					redirect('/peminjaman_lab');
				}
				$id_alat = $this->Peminjaman_lab->getIndividualItem($id_pinjaman, "ID_ALAT");
				$res = $this->Peminjaman_lab->tindaklanjutiPermintaanLab($id_pinjaman, $tindakan, $keterangan);
				if($res){
					if($id_alat == NULL){
						if($tindakan == 1){
							$this->load->model('Jadwal_lab');
							$event = $this->Peminjaman_lab->getIndividualItem($id_pinjaman, 'KEPERLUAN');
							$tanggal = $this->Peminjaman_lab->getIndividualItem($id_pinjaman, 'TANGGAL_PINJAM');
							$jam_mulai = $this->Peminjaman_lab->getIndividualItem($id_pinjaman, 'JAM_MULAI');
							$jam_selesai = $this->Peminjaman_lab->getIndividualItem($id_pinjaman, 'JAM_SELESAI');
							$id_lab = $this->Peminjaman_lab->getIndividualItem($id_pinjaman, 'LAB');
							$start = $tanggal. " ".$jam_mulai;
							$end = $tanggal. " ".$jam_selesai;
							$res_insert_jadwal = $this->Jadwal_lab->insertJadwalPemakaian($event, $id_lab, $start, $end);
							if($res_insert_jadwal){
								$this->session->set_flashdata('success', 'Berhasil menindaklanjuti permintaan peminjaman ruangan laboratorium');
								redirect("/peminjaman_lab");
							}
							else{
								$this->session->set_flashdata('error', 'Gagal memasukkan data peminjaman ke dalam database jadwal laboratorium');
								redirect("/peminjaman_lab");
							}
						}
						else{
							$this->session->set_flashdata('success', 'Berhasil menindaklanjuti permintaan peminjaman ruangan laboratorium');
							redirect("/peminjaman_lab");
						}
					}
					else{
						$this->session->set_flashdata('success', 'Berhasil menindaklanjuti permintaan peminjaman alat');
						redirect("/peminjaman_alat");
					}
				}
				else{
					if($id_alat == NULL){
						$this->session->set_flashdata('error', 'Gagal menindaklanjuti permintaan peminjaman ruangan laboratorium');
						redirect("/peminjaman_lab");
					}
					else{
						$this->session->set_flashdata('error', 'Gagal menindaklanjuti permintaan peminjaman alat');
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
		if($this->session->userdata('logged_in_public')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('tgl_pinjam', 'Tanggal Pinjam', 'required');
			$this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
			$this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
			$this->form_validation->set_rules('keperluan', 'Keperluan', 'required');
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
				$email_peminjam = $this->session->userdata('email');
				$nama_peminjam = $this->session->userdata('name');
				$tipe_lab = $this->input->post('lab');
				$alat =  $this->input->post('alat');
				$tgl_pinjam = $this->input->post('tgl_pinjam');
				$jam_mulai = $this->input->post('jam_mulai');
				$jam_selesai = $this->input->post('jam_selesai');
				if($jam_mulai > $jam_selesai){
					$this->session->set_flashdata('success', 'Tidak dapat melakukan permintaan peminjaman. Jam mulai tidak boleh lebih besar dari jam selesai peminjaman!');
					redirect("/peminjaman");
				}
				$start_event = $tgl_pinjam. " ". $jam_mulai;
				$end_event = $tgl_pinjam. " ". $jam_selesai;
				if($mode == 'lab'){
					$arr_lab_tersedia = $this->cekKetersediaanLab($start_event, $end_event);

					//Cek ketersediaan laboratorium yang dipilih
					//If tidak tersedia, return ke home peminjaman
					if(!in_array($tipe_lab, $arr_lab_tersedia)){
						$this->session->set_flashdata('error', 'Ruangan laboratorium yang dipilih tidak dapat digunakan pada tanggal dan rentang waktu yang diinginkan!');
						redirect("/peminjaman");
					}
				}
				

				$keterangan = $this->input->post('keterangan');
				$keperluan = $this->input->post('keperluan');
				$this->load->model('Peminjaman_lab');
				$res = $this->Peminjaman_lab->addPeminjaman($email_peminjam, $nama_peminjam, $tipe_lab, $alat, $tgl_pinjam, $jam_mulai, $jam_selesai, $keterangan, $keperluan);
				if($res){
					$this->session->set_flashdata('success', 'Berhasil melakukan permintaan peminjaman alat/ruangan laboratorium. Silahkan tunggu notifikasi selanjutnya pada Email UNPAR Anda');
					redirect("/peminjaman");
				}
				else{
					$this->session->set_flashdata('error', 'Terjadi kesalahan dalam melakukan permintaan peminjaman alat/ruangan laboratorium.');
					redirect("/peminjaman");
				}
			}
		}
		else{
			redirect('/');
		}
	}

	private function cekKetersediaanLab($start_event, $end_event){
		$daftar_lab = $this->getAllListLab();

		$this->load->model('Jadwal_lab');
		$lab_terpakai = $this->Jadwal_lab->checkPemakaianLab($start_event, $end_event);
		$arr_lab_tersedia = array();
		// print_r($lab_terpakai);
		// return;
		foreach ($daftar_lab as $list_lab) {
			$flag = true;
			$id = $list_lab['ID'];
			if($lab_terpakai){
				foreach ($lab_terpakai as $lab_pakai) {
					$id_lab_pakai = $lab_pakai['ID_LAB_PAKAI'];
					if($id == $id_lab_pakai){
						$flag = false;
					}
				}
			}
			

			if($flag){
				
				array_push($arr_lab_tersedia, $id);
			}
		}
		return $arr_lab_tersedia;
	}
	private function getAllListLab(){
		$this->load->model('Daftar_lab');
		$daftar_lab = $this->Daftar_lab->getListLab();
		if($daftar_lab){
			return $daftar_lab;
		}
		else{
			return false;
		}
	}
}
?>