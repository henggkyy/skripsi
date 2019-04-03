<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Jadwal_bertugas_admin extends CI_Model{
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