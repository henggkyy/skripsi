<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Jadwal_lab extends CI_Model{
	//Method untuk memasukkan jadwal pemakaian laboratorium berdasarkan ketika ada peminjaman
	//yang sudah disetujui oleh Kepala Laboratorium
	function insertJadwalPemakaian($title, $id_lab, $start, $end){
		$data = array(
		    'ID_LAB' => $id_lab,
		    'TITLE' => $title,
		    'START_EVENT' => $start,
		    'END_EVENT' => $end
		);
		$res = $this->db->insert('jadwal_lab', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}

	//Method untuk mendapatkan jadwal keseluruhan laboratorium, termasuk jadwal kuliah, jadwal uts/uas,
	//dan jadwal ketika ada permintaan peminjaman
	function getJadwalPemakaianLab(){
		$this->db->select('jadwal_lab.ID as id, daftar_lab.NAMA_LAB as nama_lab, jadwal_lab.TITLE as title, jadwal_lab.START_EVENT as start, jadwal_lab.END_EVENT as end, daftar_lab.BG_COLOR as backgroundColor');
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