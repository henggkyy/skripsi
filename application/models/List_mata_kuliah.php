<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class List_mata_kuliah extends CI_Model{
	//Method untuk mendapatkan kode dan nama mata kuliah berdasarkan ID
	function getDataMatkulById($id){
		$this->db->select('KODE_MATKUL, NAMA_MATKUL');
		$this->db->where('ID', $id);
		$this->db->from('list_mata_kuliah');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return $result->result_array();
		}
		else{
			return false;
		}
	}
	//Method untuk mendapatkan daftar seluruh mata kuliah yang ada di FTIS
	function getAllMatkul(){
		$this->db->select('ID, KODE_MATKUL, NAMA_MATKUL');
		$this->db->order_by('KODE_MATKUL', 'asc');
		$this->db->from('list_mata_kuliah');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		}
		else{
			return false;
		}
	}

}
?>