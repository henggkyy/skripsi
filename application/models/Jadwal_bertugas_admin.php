<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Jadwal_bertugas_admin extends CI_Model{
	//Method untuk mendapatkan data jadwal bertugas Admin untuk dicetak
	//Data yang dihasilkan dari method ini merupakan jadwal bertugas admin sesuai bulan yang sedang berjalan
	function getJadwalByMonth(){
		$this->db->select('HARI, TANGGAL, JAM_MULAI, JAM_SELESAI, TIPE_BERTUGAS, users.NAMA as NAMA');
		$string = " YEAR(TANGGAL) = YEAR(CURRENT_DATE()) AND MONTH(TANGGAL) = MONTH(CURRENT_DATE())";
		$this->db->where($string, NULL, FALSE);
		$this->db->from('jadwal_bertugas_admin');
		$this->db->join('users', 'users.ID = jadwal_bertugas_admin.ID_ADMIN', 'left');
		$this->db->order_by('TANGGAL', 'asc');
		$result = $this->db->get();
		if($result->num_rows() > 0 ){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk mendapatkan jadwal bertugas Admin sesuai periode akademik
	//Data yang dihasilkan dari method ini akan digunakan untuk ditampilkan pada tiva timetable
	function getJadwalByPeriode($id_periode, $tipe_bertugas_int,  $day){
		if($tipe_bertugas_int == 0){
			$this->db->distinct('HARI');
			$this->db->select('HARI, JAM_MULAI, JAM_SELESAI, NUM_DAY, users.NAMA as NAMA, users.INISIAL as INISIAL, users.COLOR as COLOR');
			$this->db->where('IS_UPDATE', NULL);
			$this->db->where('TIPE_BERTUGAS_INT',0);
			$this->db->order_by('NUM_DAY', 'asc');
			$this->db->order_by('JAM_MULAI', 'asc');
			$this->db->group_by('JAM_MULAI');
			$this->db->group_by('users.ID');
			$this->db->group_by('HARI');
		}
		else{
			$this->db->select('HARI, TANGGAL, JAM_MULAI,NUM_DAY, JAM_SELESAI, users.NAMA as NAMA, users.INISIAL as INISIAL, users.COLOR as COLOR');
			$this->db->order_by('NUM_DAY', 'asc');
			$this->db->order_by('TANGGAL', 'asc');
			$this->db->order_by('JAM_MULAI', 'asc');
			$this->db->where('TIPE_BERTUGAS_INT', 1);
			$this->db->or_where('TIPE_BERTUGAS_INT', 2);
		}
		if($day != 99){
			$this->db->where('NUM_DAY', $day);
		}
		$this->db->where('ID_PERIODE', $id_periode);
		
		$this->db->from('jadwal_bertugas_admin');
		$this->db->join('users', 'users.ID = jadwal_bertugas_admin.ID_ADMIN', 'left');
		$result = $this->db->get();
		if($result->num_rows() > 0 ){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk mendapatkan seluruh jadwal bertugas admin
	function getAllJadwal(){
		$this->db->select('users.NAMA as NAMA, HARI, TANGGAL, JAM_MULAI, JAM_SELESAI, NUM_DAY,TIPE_BERTUGAS, INSERT_DATE, users.INISIAL as INISIAL, users.COLOR as COLOR');
		$this->db->order_by('TANGGAL', 'asc');
		$this->db->from('jadwal_bertugas_admin');
		$this->db->join('users', 'users.ID = jadwal_bertugas_admin.ID_ADMIN', 'left');
		$result = $this->db->get();
		if($result->num_rows() > 0 ){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk melakukan update jadwal bertugas admin
	function updateJadwalBertugas($id_bertugas, $id_admin, $data){
		$this->db->where('ID', $id_bertugas);
		$this->db->where('ID_ADMIN', $id_admin);
		$res = $this->db->update('jadwal_bertugas_admin', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk mendapatkan jadwal bertugas individual
	function getJadwalBertugasInd($id_bertugas, $id_admin){
		$this->db->select('ID, HARI, TANGGAL, JAM_MULAI, JAM_SELESAI');
		$this->db->where('ID', $id_bertugas);
		$this->db->where('ID_ADMIN', $id_admin);
		$this->db->from('jadwal_bertugas_admin');
		$result = $this->db->get();
		if($result->num_rows() == 1 ){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk menghapus jadwal bertugas admin dari database
	function deleteJadwalBertugas($id_bertugas){
		$this->db->where('ID', $id_bertugas);
		$res = $this->db->delete('jadwal_bertugas_admin');
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk mengecek apakah jadwal bertugas berada pada periode akademik yg aktif 
	//Method ini juga dapat digunakan untuk mengecek apakah jadwal bertugas merupakan milik admin yang bersangkutan
	function checkJadwalBertugas($id_bertugas,$field, $field_value){
		$this->db->select('ID');
		$this->db->where('ID', $id_bertugas);
		$this->db->where($field, $field_value);
		$this->db->from('jadwal_bertugas_admin');
		$result = $this->db->get();
		if($result->num_rows() == 1 ){
			return true;
		} 
		else {
			return false;
		}
	}
	//Method untuk mendapatkan jadwal bertugas admin
	function getJadwalBertugas($id_admin, $id_periode){
		$this->db->select('users.ID as ID,jadwal_bertugas_admin.ID as ID_JADWAL, users.INISIAL as INISIAL, users.NAMA as NAMA, NUM_DAY, HARI, TANGGAL, JAM_MULAI, JAM_SELESAI, TIPE_BERTUGAS, INSERT_DATE, users.COLOR as COLOR');
		$this->db->where('ID_ADMIN', $id_admin);
		$this->db->where('ID_PERIODE', $id_periode);
		$this->db->order_by('TANGGAL', 'asc');
		$this->db->from('jadwal_bertugas_admin');
		$this->db->join('users', 'users.ID = jadwal_bertugas_admin.ID_ADMIN', 'left');
		$result = $this->db->get();
		if($result->num_rows() > 0 ){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk memasukkan jadwal bertugas admin (Auto) ke dalam database
	function insertJadwalBertugasAuto($data){
		$res = $this->db->insert_batch('jadwal_bertugas_admin', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk memasukkan jadwal bertugas admin (Manual) ke dalam database
	function insertJadwalBertugasManual($data){
		$res = $this->db->insert('jadwal_bertugas_admin', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
}
?>