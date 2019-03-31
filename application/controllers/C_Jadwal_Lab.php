<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani penjadwalan pemakaian laboratorium
class C_Jadwal_Lab extends CI_Controller{
	//Method untuk melakukan pengecekan ketersediaan peminjaman laboratorium
	function checkKetersediaanPeminjaman(){
		
		$tanggal = $this->input->post('tanggal');
		$jam_mulai = $this->input->post('jam_mulai');
		$jam_selesai = $this->input->post('jam_selesai');
		

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
	 	

	 	$tanggal = date("Y-m-d", strtotime($this->input->post('tanggal')));
		$jam_mulai = date("H:i:s", strtotime($this->input->post('jam_mulai')));
		$jam_selesai = date("H:i:s", strtotime($this->input->post('jam_selesai')));

		$daftar_lab = $this->getAllListLab();
		$start_event = $tanggal." ".$jam_mulai;
		$end_event  = $tanggal. " ".$jam_selesai;

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
		// print_r($arr_lab_tersedia);
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

	function checkKetersediaan(){
		$hari = $this->input->post('hari[]');
		
		$this->load->model('Periode_akademik');
		$periode_aktif = $this->Periode_akademik->getIDPeriodeAktif();
		if($periode_aktif){
			$start_periode = $this->Periode_akademik->getIndividualItem($periode_aktif, 'START_PERIODE');
			$end_periode = $this->Periode_akademik->getIndividualItem($periode_aktif, 'END_PERIODE');
			$start_uts = $this->Periode_akademik->getIndividualItem($periode_aktif, 'START_UTS');
			$end_uts = $this->Periode_akademik->getIndividualItem($periode_aktif, 'END_UTS');
			$start_uas = $this->Periode_akademik->getIndividualItem($periode_aktif, 'START_UAS');

			print_r($hari);
			$list_tanggal = array();

			$arr_tgl_sebelum_uts = $this->getAllDate($start_periode, $start_uts, $hari);
			$arr_tgl_setelah_uas = $this->getAllDate($end_uts, $start_uas, $hari);

			array_push($list_tanggal, $arr_tgl_sebelum_uts);
			array_push($list_tanggal, $arr_tgl_setelah_uas);

			print_r($arr_tgl_sebelum_uts);
			return;
		}
		else{
			redirect('/dashboard');
		}

		print_r($arr_hari);
		return;
		$jam_mulai = $this->input->post('jam_mulai[]');
		$jam_selesai = $this->input->post('jam_selesai[]');
		$daftar_lab = $this->getAllListLab();
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
	private function checkLabTersedia($tgl_awal, $tanggal_akhir){

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