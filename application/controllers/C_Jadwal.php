<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini bertujuan untuk menangani jadwal public tanpa login
class C_Jadwal extends CI_Controller{

	function loadDebug(){
		$data['id_periode_aktif'] = 1;
		$this->load->view('pages_user/V_Debug', $data);
	}
	//Method untuk menampilkan halaman jadwal untuk public
	function loadJadwalPublic(){
		$data['title'] = "Jadwal Pemakaian Lab & Jadwal Bertugas Admin | SI Operasional Lab. Komputasi TIF UNPAR";
		if(isset($_GET['type'])){
			$type = $_GET['type'];
			if($type == 'lab'){
				$data['type'] = 'lab';
			}
			else{
				$data['type'] = 'admin';
			}
		}
		else{
			$data['type'] = 'lab';
		}
		
		$this->load->view('pages_user/V_Jadwal_Public', $data);
	}
	//Method untuk mendapatkan jadwal bertugas seluruh admin
	function getJadwalAllAdmin(){
		$this->load->model('Jadwal_bertugas_admin');
		$jadwal_admin = $this->Jadwal_bertugas_admin->getAllJadwal();
		$data_json = array();
		if(isset($jadwal_admin) && $jadwal_admin){
			foreach ($jadwal_admin as $jadwal) {
				$timetable = new stdClass();
				$timetable->name = $jadwal['INISIAL'];
				$timetable->image = "";
				$timetable->date = date('j', strtotime($jadwal['TANGGAL'])); // date : type DATE. For example: 2016-09-07
				$timetable->month = date('n', strtotime($jadwal['TANGGAL']));
				$timetable->year = date('Y', strtotime($jadwal['TANGGAL']));
				$timetable->day = $this->getDay($jadwal['NUM_DAY']);
				$timetable->start_time = $jadwal['JAM_MULAI'] ? date('H:i', strtotime($jadwal['JAM_MULAI'])) : ''; // start_time : Must be 24 hour format. For example: 18:00
				$timetable->end_time = $jadwal['JAM_SELESAI'] ? date('H:i', strtotime($jadwal['JAM_SELESAI'])) : ''; // end_time : Must be 24 hour format. For example: 20:30
				$timetable->color = $jadwal['COLOR'];
				$timetable->description = "Nama Admin : <b>". $jadwal['NAMA']." (".$jadwal['INISIAL'].") </b>"."<br> Jam Bertugas : <b>".$jadwal['JAM_MULAI']." s/d ".$jadwal['JAM_SELESAI']."</b><br>Tipe Bertugas : <b>".$jadwal['TIPE_BERTUGAS']."</b>";
				array_push($data_json, $timetable);
			}
		}
		echo json_encode($data_json);
	}
	//Method untuk mendapatkan jadwal pemakaian ruangan laboratorium
	function getAllJadwalRuangan(){
		$this->load->model('Jadwal_lab');
		$jadwal_lab = $this->Jadwal_lab->getJadwalPemakaianLab();
		$data_json = array();
		if(isset($jadwal_lab) && $jadwal_lab){
			foreach ($jadwal_lab as $jadwal) {
				$timetable = new stdClass();
				$timetable->name = $jadwal['nama_lab'];
				$timetable->image = "";
				$timetable->date = date('j', strtotime($jadwal['start'])); // date : type DATE. For example: 2016-09-07
				$timetable->month = date('n', strtotime($jadwal['start']));
				$timetable->year = date('Y', strtotime($jadwal['start']));
				$timetable->day = date('l', strtotime($jadwal['start']));
				$timetable->start_time = $jadwal['start'] ? date('H:i', strtotime($jadwal['start'])) : ''; // start_time : Must be 24 hour format. For example: 18:00
				$timetable->end_time = $jadwal['end'] ? date('H:i', strtotime($jadwal['end'])) : ''; // end_time : Must be 24 hour format. For example: 20:30
				$timetable->color = $jadwal['backgroundColor'];
				$timetable->description = "Lokasi Lab : <b>".$jadwal['nama_lab']." (".$jadwal['lokasi'].")</b><br>Waktu Pemakaian : <b>".$jadwal['start'] ." s/d ".$jadwal['end']."</b><br>Digunakan untuk : <b>". $jadwal['title']."</b>";
				array_push($data_json, $timetable);
			}
		}
		echo json_encode($data_json);
	}
	//Method untuk mendapatkan nama hari
	private function getDay($num_day){
		$day_eng = array ( 1 =>    'monday',
			'tuesday',
			'wednesday',
			'thursday',
			'friday',
			'saturday',
			'sunday'
		);
		return $day_eng[$num_day];
	}
}
?>