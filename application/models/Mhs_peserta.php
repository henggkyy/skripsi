<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mhs_peserta extends CI_Model{
	//Method untuk melakukan pengecekan apakah suatu mata kuliah telah dimasukkan mahasiswa atau belum
	function checkMhs($id_matkul){
		$this->db->select('NPM_MHS, NAMA_MHS');
		$this->db->where('ID_MATKUL', $id_matkul);
		$result = $this->db->get('mhs_peserta');
		if($result->num_rows() > 0){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk memasukkan nama dan npm mahasiswa peserta mata kuliah
	function insertMhs($data_mhs){
		$res = $this->db->insert_batch('mhs_peserta', $data_mhs);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
}
?>