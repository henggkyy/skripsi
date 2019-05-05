<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Class ini dibuat untuk API dari aplikasi software checker ke aplikasi website
class C_Api extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->output->set_content_type('application/json');
	}
	//Method untuk memasukkan data software ke dalam database dan mengembalikkan uniq id
	function insertDataSoftware(){
		header('Content-Type: application/json');
		$data_software = $this->input->post('data_software');
		if($data_software == "" || !$data_software || $data_software == NULL){
			$this->output->set_status_header('500');
			$data = array(
				'error' => 1,
				'status' => 'Data software tidak ditemukan'
			);
			echo json_encode($data);
			return;
		}
		$uniq_id = $this->generateHash(10);
		$data = array(
			'DATA_SOFTWARE' => $data_software,
			'UNIQ_ID' => $uniq_id
		);
		$res = $this->db->insert('data_software', $data);
		if($res){
			$link = base_url();
			$uniq_link = $link."administrasi_matkul/checker?ref=".$uniq_id;
			$response = array(
				'uniq_link' => $uniq_link,
				'status' => 'Berhasil memasukkan data software ke dalam database'
			);
			$this->output->set_status_header('200');
			echo json_encode($response);
		}
		else{
			$response = array(
				'status' => 'Gagal memasukkan data software ke dalam database'
			);
			$this->output->set_status_header('500');
			echo json_encode($response);
		}
	}
	//Method untuk melakukan generate hash 
	private function generateHash($jmlh_char){
		$sListKarakter = "12345678901234567890123456";
 		$sPanjangKarakter = strlen($sListKarakter);
  		$number = "";
  		for($i=0;$i<$jmlh_char;$i++){
    		$number .= $sListKarakter[rand(0,$sPanjangKarakter-1)];
  		}
  		return "$number";
	}
}
?>