<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani penjadwalan pemakaian laboratorium
class C_Jadwal_Lab extends CI_Controller{
	//Method untuk mencetak jadwal pemakaian laboratorium
	function cetakJadwalLab(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1){
				redirect('/dashboard');
			}
			$data['title']= "Cetak Jadwal Pemakaian Laboratorium | SI Kegiatan Operasional Lab. Komputasi TIF UNPAR";
			$data['nama_bulan'] = $this->getNamaBulan(date('n'));
			date_default_timezone_set('Asia/Jakarta');
			$data['now_date'] = date("Y-m-d H:i:s");
			$this->load->model('Jadwal_lab');
			$data['jadwal_lab'] = $this->Jadwal_lab->getDataPemakaianForPrint();
			$this->load->view('template/Header', $data);
			$this->load->view('pages_user/V_Cetak_Jadwal_Lab', $data);
			$this->load->view('template/Footer');
		}
		else{
			redirect('/');
		}
	}
	//Method untuk menghapus jadwal pemakaian laboratorium
	function deleteJadwalPemakaian(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1){
				redirect('/dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_pemakaian', 'ID Pemakaian Lab', 'required');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required fields!');
				redirect("jadwal_lab");
			}
			else{
				$id_pemakaian = $this->input->post('id_pemakaian');
				$this->load->model('Jadwal_lab');
				$this->load->model('Peminjaman_lab');
				$id_pinjaman = $this->Peminjaman_lab->getIDPinjamanByIdJadwal($id_pemakaian, 'ID');
				if($id_pinjaman){
					$this->Peminjaman_lab->setJadwalToNull($id_pinjaman);
					$this->Peminjaman_lab->setStatusToCancelled($id_pinjaman);
				}
				$res = $this->Jadwal_lab->deleteJadwalPemakaian($id_pemakaian);
				if($res){
					$this->session->set_flashdata('success', 'Berhasil menghapus jadwal pemakaian laboratorium!');
					redirect("jadwal_lab");
				}
				else{
					$this->session->set_flashdata('error', 'Gagal menghapus pemakaian laboratorium!');
					redirect("jadwal_lab");
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method ini digunakan untuk mengambil data pemakaian laboratorium
	//Method ini dipanggil menggunakan jquery ajax
	function loadDataPemakaian(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1){
				return;
			}
			$id_pemakaian = $this->input->get('id_pemakaian');
			if($id_pemakaian!=""){
				$this->load->model('Jadwal_lab');
				$data['data_pemakaian'] = $this->Jadwal_lab->getDataPemakaian($id_pemakaian);
				if($data['data_pemakaian']){
					$string =  $this->load->view('pages_user/V_Template_Jadwal_Lab', $data, TRUE);
					echo $string;
					return;
				}
				else{
					return;
				}
			}
			else{
				return;
			}
		}
		else{
			return;
		}	
	}
	//Method untuk update jadwal pemakaian laboratorium
	function updateJadwalPemakaian(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1){
				redirect('/dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_pemakaian', 'ID Pemakaian Lab', 'required');
			$this->form_validation->set_rules('tgl_pemakaian', 'Tanggal Pemakaian', 'required');
			$this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
			$this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
			$this->form_validation->set_rules('lab', 'Lab', 'required');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required fields!');
				redirect("jadwal_lab");
			}
			else{
				$id_pemakaian = $this->input->post('id_pemakaian');
				$tgl_pemakaian = $this->input->post('tgl_pemakaian');
				$tgl_pemakaian = date("Y-m-d", strtotime($tgl_pemakaian));
				$jam_mulai = $this->input->post('jam_mulai');
				$jam_selesai = $this->input->post('jam_selesai');

				if($jam_mulai > $jam_selesai){
					$this->session->set_flashdata('error', 'Jam Mulai tidak boleh lebih besar daripada jam selesai!');
					redirect("jadwal_lab");
				}
				$validate_time_mulai = $this->validate_time($jam_mulai);
				$validate_time_selesai = $this->validate_time($jam_selesai);
				if(!$validate_time_mulai || !$validate_time_selesai){
					if(!$validate_time_mulai){
						$this->session->set_flashdata('error', "Error! Jam mulai bukan format waktu yang benar! ($jam_mulai)");
					}
					else{
						$this->session->set_flashdata('error', "Error! Jam selesai bukan format waktu yang benar! ($jam_selesai)");
					}
					redirect("jadwal_lab");
				}
				$lab = $this->input->post('lab');
				$start_event = $tgl_pemakaian." ".$jam_mulai.":00";
				date_default_timezone_set('Asia/Jakarta');
				$date_time = date("Y-m-d H:i:s");
				$date_time = date('Y-m-d H:i:s',(strtotime ( '-1 day' , strtotime ( $date_time) ) ));
				if($start_event < $date_time){
					$this->session->set_flashdata('error', 'Tanggal pemakaian tidak boleh lebih kecil daripada tanggal hari ini!');
					redirect("jadwal_lab");
				}
				$end_event = $tgl_pemakaian." ".$jam_selesai.":00";
				$this->load->model('Jadwal_lab');
				$data = array(
					'START_EVENT' => $start_event,
					'END_EVENT' => $end_event,
					'ID_LAB' => $lab
				);
				$res = $this->Jadwal_lab->editJadwalPemakaian($id_pemakaian, $data);
				if($res){
					$this->session->set_flashdata('success', 'Berhasil melakukan update jadwal pemakaian laboratorium!');
					redirect("jadwal_lab");
				}
				else{
					$this->session->set_flashdata('error', 'Gagal melakukan update jadwal pemakaian laboratorium!');
					redirect("jadwal_lab");
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk memasukkan jadwal pemakaian lab
	function insertJadwalPemakaian(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1){
				redirect('/dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('tgl_pemakaian', 'Tanggal Pemakaian', 'required');
			$this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
			$this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
			$this->form_validation->set_rules('lab', 'Lab', 'required');
			$this->form_validation->set_rules('keperluan', 'Keperluan', 'required');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required fields!');
				redirect("jadwal_lab");
			}
			else{
				$tgl_pemakaian = $this->input->post('tgl_pemakaian');
				$tgl_pemakaian = date("Y-m-d", strtotime($this->input->post('tgl_pemakaian')));
				$jam_mulai = $this->input->post('jam_mulai');
				$jam_selesai = $this->input->post('jam_selesai');
				if($jam_mulai > $jam_selesai){
					$this->session->set_flashdata('error', 'Jam Mulai tidak boleh lebih besar daripada jam selesai!');
					redirect("jadwal_lab");
				}
				$validate_time_mulai = $this->validate_time($jam_mulai);
				$validate_time_selesai = $this->validate_time($jam_selesai);
				if(!$validate_time_mulai || !$validate_time_selesai){
					if(!$validate_time_mulai){
						$this->session->set_flashdata('error', "Error! Jam mulai bukan format waktu yang benar! ($jam_mulai)");
					}
					else{
						$this->session->set_flashdata('error', "Error! Jam selesai bukan format waktu yang benar! ($jam_selesai)");
					}
					redirect("jadwal_lab");
				}
				$lab = $this->input->post('lab');
				$keperluan = $this->input->post('keperluan');
				$this->load->model('Jadwal_lab');
				$start_event = $tgl_pemakaian." ".$jam_mulai.":00";
				date_default_timezone_set('Asia/Jakarta');
				$date_time = date("Y-m-d H:i:s");
				$date_time = date('Y-m-d H:i:s',(strtotime ( '-1 day' , strtotime ( $date_time) ) ));
				if($start_event < $date_time){
					$this->session->set_flashdata('error', 'Tanggal pemakaian tidak boleh lebih kecil daripada tanggal saat ini!');
					redirect("jadwal_lab");
				}
				$end_event = $tgl_pemakaian." ".$jam_selesai.":00";
				$res = $this->Jadwal_lab->insertJadwalPemakaian($keperluan, $lab, $start_event, $end_event);
				if($res){
					$this->session->set_flashdata('success', 'Berhasil menambahkan jadwal pemakaian laboratorium!');
					redirect("jadwal_lab");
				}
				else{
					$this->session->set_flashdata('error', 'Gagal menambahkan jadwal pemakaian laboratorium!');
					redirect("jadwal_lab");
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk melakukan pengecekan ketersediaan peminjaman laboratorium
	function checkKetersediaanPeminjaman(){
		
		$tanggal = $this->input->get('tanggal');
		$jam_mulai = $this->input->get('jam_mulai');
		$jam_selesai = $this->input->get('jam_selesai');
		
		// echo $tanggal;
		// return;
		if(!isset($tanggal) || $tanggal == ""){
			echo '<span style="color:red;">Tanggal peminjaman harus diisi!</span>';
			return;
		}
		if(!isset($jam_mulai)  || $jam_mulai == ""){
			echo '<span style="color:red;">Jam mulai peminjaman harus diisi!</span>';
			return;
		}
		if(!isset($jam_selesai)  || $jam_selesai == ""){
			echo '<span style="color:red;">Jam selesai peminjaman harus diisi!</span>';
			return;
		}


	 	$tanggal = date("Y-m-d", strtotime($this->input->get('tanggal')));
		$jam_mulai = date("H:i:s", strtotime($this->input->get('jam_mulai')));
		$jam_selesai = date("H:i:s", strtotime($this->input->get('jam_selesai')));

		

		$daftar_lab = $this->getAllListLab();
		$start_event = $tanggal." ".$jam_mulai;
		$end_event  = $tanggal. " ".$jam_selesai;

		// print_r($daftar_lab);
		// print_r($start_event);
		// print_r($end_event);
		$this->load->model('Jadwal_lab');
		$lab_terpakai = $this->Jadwal_lab->checkPemakaianLab($start_event, $end_event);
		$arr_lab_tersedia = array();
		// print_r($lab_terpakai);
		// return;
		foreach ($daftar_lab as $list_lab) {
			$flag = true;
			$ID = $list_lab['ID'];
			$NAMA_LAB = $list_lab['NAMA_LAB'];
			$LOKASI = $list_lab['LOKASI'];
			if($lab_terpakai){
				foreach ($lab_terpakai as $lab_pakai) {
					$id_lab_pakai = $lab_pakai['ID_LAB_PAKAI'];
					if($ID == $id_lab_pakai){
						$flag = false;
					}
				}
			}
			

			if($flag){
				$arr_temp = array($ID, $NAMA_LAB, $LOKASI);
				array_push($arr_lab_tersedia, $arr_temp);
			}
		}
		// print_r($lab_terpakai);
		// return;
		if($arr_lab_tersedia){
			$data['daftar_lab'] = $arr_lab_tersedia;
			$string =  $this->load->view('pages_user/V_Template_Lab_Tersedia', $data, TRUE);
			echo $string;
		}
		else{
			echo '<span style="color:red;">Tidak ada Ruangan Laboratorium yang tersedia pada tanggal dan waktu diatas!</span>';
		}
	}

	//Method untuk melakukan validasi waktu yang diinput pengguna
	public function validate_time($str){
		$array_jam = explode(':', $str);
		$hh = $array_jam[0];
		$mm = $array_jam[1];
		if (!is_numeric($hh) || !is_numeric($mm)){
			return FALSE;
		}
		else if ((int) $hh > 24 || (int) $mm > 59){
		    return FALSE;
		}
		else if (mktime((int) $hh, (int) $mm) === FALSE){
		    return FALSE;
		}
		return TRUE;
	}
	private function getNamaBulan($num_month){
		$arr_bulan = array(
			1 => 'Januari',
			2 => 'Februari',
			3 => 'Maret',
			4 => 'April',
			5 => 'Mei',
			6 => 'Juni',
			7 => 'Juli',
			8 => 'Agustus',
			9 => 'September',
			10 => 'Oktober',
			11 => 'November',
			12 => 'Desember',
		);
		return $arr_bulan[$num_month];
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
	private function getAllDate($date_start, $date_end, $day){
		$date_start_time = strtotime($date_start);
	    $date_end_time   = strtotime($date_end);
	    $dates = array();
	    while ($date_start_time <= $date_end_time) {
	        if (in_array(date('l', $date_start_time), $day)) {
	           $dates[] = date('Y-m-d', $date_start_time);
	        }
	        $date_start_time = strtotime('+1 day', $date_start_time);
	    }
	    return $dates;
	}
}
?>