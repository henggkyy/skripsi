<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Data_software extends CI_Model{
	//Method untuk mendapatkan data software yang sudah terpasang di komputer
	function getDataSoftware($uniq){
		$this->db->select('DATA_SOFTWARE');
		$this->db->where('UNIQ_ID', $uniq);
		$this->db->from('data_software');
		$result = $this->db->get();
		if($result->num_rows() == 1 ){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk menghapus link uniq id dari database
	function deleteLink($uniq){
		$this->db->where('UNIQ_ID', $uniq);
		$res = $this->db->delete('data_software');
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk melakukan pengecekan uniq link
	function checkLink($uniq){
		$this->db->select('ID');
		$this->db->where('UNIQ_ID', $uniq);
		$this->db->from('data_software');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return true;
		} 
		else {
			return false;
		}
	}
}
?>