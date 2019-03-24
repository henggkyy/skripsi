<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Alat_lab extends CI_Model{
	function deleteAlat($id){
		$this->db->where('ID', $id);
		$res = $this->db->delete('alat_lab');
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	function getAllAlat(){
		$this->db->select('alat_lab.ID as ID, alat_lab.NAMA_ALAT as NAMA_ALAT');
		$this->db->from('alat_lab');
		$result = $this->db->get();
		if($result->num_rows() > 0 ){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	function inputAlat($nama_alat){
		$data = array(
		    'NAMA_ALAT' => $nama_alat
		);
		$res = $this->db->insert('alat_lab', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
}
?>