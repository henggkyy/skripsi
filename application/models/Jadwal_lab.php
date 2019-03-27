<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Jadwal_lab extends CI_Model{
	function getJadwalPemakaianLab(){
		$this->db->select('jadwal_lab.ID as id, daftar_lab.NAMA_LAB as nama_lab, jadwal_lab.TITLE as title, jadwal_lab.START_EVENT as start, jadwal_lab.END_EVENT as end, jadwal_lab.BG_COLOR as backgroundColor');
		$this->db->from('jadwal_lab');
		$this->db->join('daftar_lab', 'jadwal_lab.ID_LAB = daftar_lab.ID' , 'left outer');
		$result = $this->db->get();
		if($result->num_rows() > 0 ){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
}
?>