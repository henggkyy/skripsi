<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_role extends CI_Model{
	//Method untuk mendapatkan daftar user role yang tersedia
	function getUserRole(){
		$this->db->select('ID, NAMA_ROLE');
		$this->db->from('user_role');
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