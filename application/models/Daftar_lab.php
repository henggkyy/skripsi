<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Daftar_lab extends CI_Model{
	//Method untuk mendapatkan seluruh daftar laboratorium yang ada di lab komputasi TIF
	function getListLab(){
		$this->db->select('daftar_lab.ID as ID, daftar_lab.NAMA_LAB as NAMA_LAB, daftar_lab.LOKASI as LOKASI');
		$this->db->from('daftar_lab');
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