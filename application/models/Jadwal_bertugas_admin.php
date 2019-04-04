<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Jadwal_bertugas_admin extends CI_Model{
	//Method untuk melakukan update jadwal bertugas admin
	function updateJadwalBertugas($id_bertugas, $id_user, $data){
		$this->db->where('ID', $id_bertugas);
		$this->db->where('ID_ADMIN', $id_user);
		$res = $this->db->update('jadwal_bertugas_admin', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk mendapatkan jadwal bertugas individual
	function getJadwalBertugasInd($id_bertugas, $id_user){
		$this->db->select('ID, HARI, TANGGAL, JAM_MULAI, JAM_SELESAI');
		$this->db->where('ID', $id_bertugas);
		$this->db->where('ID_ADMIN', $id_user);
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
	function checkJadwalBertugas($id_tugas,$field, $field_value){
		$this->db->select('ID');
		$this->db->where('ID', $id_tugas);
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
	function getJadwalBertugas($id_user, $id_periode){
		$this->db->select('ID, HARI, TANGGAL, JAM_MULAI, JAM_SELESAI, TIPE_BERTUGAS, INSERT_DATE');
		$this->db->where('ID_ADMIN', $id_user);
		$this->db->where('ID_PERIODE', $id_periode);
		$this->db->order_by('TANGGAL', 'asc');
		$this->db->from('jadwal_bertugas_admin');
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