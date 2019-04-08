<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Jadwal_lab extends CI_Model{
	//Method untuk menghapus jadwal pemakaian laboratorium dari database
	function deleteJadwalPemakaian($id){
		$this->db->where('ID', $id);
		$res = $this->db->delete('jadwal_lab');
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk melakukan update jadwal pemakaian laboratorium
	function editJadwalPemakaian($id, $data){
		$this->db->where('ID', $id);
		$res = $this->db->update('jadwal_lab', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk mendapatkan jadwal pemakaian lab berdasarkan id pemakaian
	function getDataPemakaian($id){
		$this->db->select('jadwal_lab.ID as id,daftar_lab.ID as id_lab, daftar_lab.NAMA_LAB as nama_lab, jadwal_lab.TITLE as title, jadwal_lab.START_EVENT as start, jadwal_lab.END_EVENT as end, daftar_lab.BG_COLOR as backgroundColor');
		$this->db->where('jadwal_lab.ID', $id);
		$this->db->from('jadwal_lab');
		$this->db->join('daftar_lab', 'jadwal_lab.ID_LAB = daftar_lab.ID' , 'left outer');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk mendapatkan laboratorium yang sedang dipakai dalam rentang waktu tertentu
	function checkPemakaianLab($start_event, $end_event){
		$this->db->select('daftar_lab.ID as ID_LAB_PAKAI, daftar_lab.NAMA_LAB as NAMA_LAB_PAKAI, jadwal_lab.TITLE as TITLE_PAKAI ,jadwal_lab.START_EVENT as START_EVENT_PAKAI, jadwal_lab.END_EVENT as END_EVENT_PAKAI');
		$this->db->from('jadwal_lab');
		$this->db->join('daftar_lab', 'jadwal_lab.ID_LAB = daftar_lab.ID' , 'left outer');
		$where = "('$start_event'  >= jadwal_lab.START_EVENT  AND '$start_event'< jadwal_lab.END_EVENT )OR ('$end_event'   > jadwal_lab.START_EVENT  AND '$end_event' <= jadwal_lab.END_EVENT ) OR (jadwal_lab.START_EVENT >= '$start_event' AND jadwal_lab.END_EVENT < '$end_event')";
		$this->db->where($where, NULL, FALSE);  
  		$result = $this->db->get();
  		if($result->num_rows() > 0){
  			return $result->result_array();
  		}
  		else{
  			return false;
  		}
	}

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
		date_default_timezone_set('Asia/Jakarta');
		$date_time = date('Y-m-d h:i');
		$this->db->select('jadwal_lab.ID as id, daftar_lab.NAMA_LAB as nama_lab, jadwal_lab.TITLE as title, jadwal_lab.START_EVENT as start, jadwal_lab.END_EVENT as end, daftar_lab.BG_COLOR as backgroundColor');
		$this->db->where('START_EVENT >=', $date_time);
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