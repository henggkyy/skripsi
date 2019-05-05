<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Surat_tugas_admin extends CI_Model{
	//Method untuk mendapatkan data surat tugas admin
	function getSuratTugas($id_admin){
		$this->db->select('AWAL_KONTRAK, AKHIR_KONTRAK, PATH_FILE');
		$this->db->where('ID_ADMIN', $id_admin);
		$this->db->order_by('AWAL_KONTRAK', 'asc');
		$this->db->from('surat_tugas_admin');
		$result = $this->db->get();
		if($result->num_rows() > 0 ){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk memasukkan surat tugas admin ke dalam database
	function insertSuratTugas($data){
		$res = $this->db->insert('surat_tugas_admin', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk check hash nama file
	function checkHash($hash){
		$this->db->select('PATH_FILE');
		$this->db->where('PATH_FILE', $hash);
		$this->db->from('surat_tugas_admin');
		$result = $this->db->get();
		if($result->num_rows() > 0 ){
			return true;
		} 
		else {
			return false;
		}
	}
}
?>