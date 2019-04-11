<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini bertujuan untuk menangani jadwal public tanpa login
class C_Jadwal extends CI_Controller{
	//Method untuk menampilkan halaman jadwal untuk public
	function loadJadwalPublic(){
		$data['title'] = "Jadwal Pemakaian Lab & Jadwal Bertugas Admin | SI Akademik Lab. Komputasi TIF";
		
		if(isset($_GET['type'])){
			$type = $_GET['type'];
			if($type == 'lab'){
				$this->load->model('Jadwal_lab');
				$data['type'] = 'lab';
				$data['jadwal'] = json_encode($this->Jadwal_lab->getJadwalPemakaianLab());
			}
			else{
				$this->load->model('Jadwal_bertugas_admin');
				$jadwal_admin = $this->Jadwal_bertugas_admin->getAllJadwal();
				$data_json = array();
				if(isset($jadwal_admin) && $jadwal_admin){
					foreach ($jadwal_admin as $jadwal) {
						$arr_ind = array();
						$arr_ind['start'] = $jadwal['TANGGAL']." ". $jadwal['JAM_MULAI'];
						$arr_ind['end'] = $jadwal['TANGGAL']." ". $jadwal['JAM_SELESAI'];
						$arr_ind['title'] = $jadwal['NAMA'];
						$arr_ind['backgroundColor'] = 'blue';
						array_push($data_json, $arr_ind);
					}
				}
				$data['type'] = 'admin';
				$data['jadwal'] = json_encode($data_json);
			}
		}
		else{
			$this->load->model('Jadwal_lab');
			$data['type'] = 'lab';
			$data['jadwal'] = json_encode($this->Jadwal_lab->getJadwalPemakaianLab());
		}
		$this->load->view('pages_user/V_Jadwal_Public', $data);
	}
}
?>