<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Jadwal_matkul extends CI_Model{
	//Method untuk memasukkan jadwal kelas mata kuliah (bulk insert)
	function bulkInsertJadwal($data){
		$res = $this->db->insert_batch('jadwal_matkul', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
}
?>