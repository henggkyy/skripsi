<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Jadwal_lab extends CI_Model{
	//Method untuk mendapatkan data pemakaian laboratorium untuk dicetak
	function getDataPemakaianForPrint(){
		$this->db->select('daftar_lab.LOKASI as lokasi, daftar_lab.NAMA_LAB as nama_lab, jadwal_lab.TITLE as title, jadwal_lab.START_EVENT as start, jadwal_lab.END_EVENT as end, daftar_lab.BG_COLOR as backgroundColor');
		$this->db->where('STATUS', 1);
		$string = " YEAR(START_EVENT) = YEAR(CURRENT_DATE()) AND MONTH(START_EVENT) = MONTH(CURRENT_DATE())";
		$this->db->where($string, NULL, FALSE);
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
	//Method untuk mendapatkan individual item
	function getIndividualItem($id, $item){
		$this->db->select($item);
		$this->db->where('ID', $id);
		$this->db->from('jadwal_lab');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return $result->row(0)->$item;
		} 
		else {
			return false;
		}
	}
	//Method untuk bulk insert jadwal pemakaian lab
	function bulkInsertJadwal($data){
		$res = $this->db->insert_batch('jadwal_lab', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
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
	function deleteJadwalBooking($id){
		$this->db->where('ID', $id);
		$res = $this->db->delete('jadwal_lab');
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk update status jadwal pemakaian
	function updateJadwalBookingAccepted($id){
		$data = array(
			'STATUS' => 1
		);
		$this->db->where('ID', $id);
		$res = $this->db->update('jadwal_lab', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk memasukkan data pemakaian laboratorium (booking sistem ketika ada yang pinjam)
	function insertJadwalBooking($data){
		$res = $this->db->insert('jadwal_lab', $data);
		if($res){
			$insert_id = $this->db->insert_id();
   			return  $insert_id;
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
		    'END_EVENT' => $end,
		    'STATUS' => 1
		);
		$res = $this->db->insert('jadwal_lab', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk mendapatkan jadwal laboratorium untuk datatables
	//Data yang didapatkan merupakan jadwal yang lebih dari hari ini dan menampilkan status pemakaian
	function getJadwalPemakaianLabDataTables(){
		date_default_timezone_set('Asia/Jakarta');
		$date_time = date('Y-m-d H:i');
		$this->db->select('jadwal_lab.ID as id, daftar_lab.NAMA_LAB as nama_lab, jadwal_lab.TITLE as title, jadwal_lab.START_EVENT as start, jadwal_lab.END_EVENT as end, daftar_lab.BG_COLOR as backgroundColor, jadwal_lab.STATUS as status');
		$this->db->where('START_EVENT >=', $date_time);
		$this->db->order_by('START_EVENT', 'asc');
		$this->db->where('STATUS', 1);
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
	//Method untuk mendapatkan jadwal keseluruhan laboratorium, termasuk jadwal kuliah, jadwal uts/uas,
	//dan jadwal ketika ada permintaan peminjaman
	//Data yang didapatkan dari method ini merupakan data yang sudah terverifikasi
	function getJadwalPemakaianLab(){
		date_default_timezone_set('Asia/Jakarta');
		$date_time = date('Y-m-d H:i');
		$this->db->select('jadwal_lab.ID as id, daftar_lab.LOKASI as lokasi, daftar_lab.NAMA_LAB as nama_lab, jadwal_lab.TITLE as title, jadwal_lab.START_EVENT as start, jadwal_lab.END_EVENT as end, daftar_lab.BG_COLOR as backgroundColor');
		$this->db->where('STATUS', 1);
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