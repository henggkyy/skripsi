<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kategori_sop extends CI_Model{

	function getAllKategori(){
		$this->db->select('ID, NAMA_KATEGORI');
		$this->db->from('kategori_sop');
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