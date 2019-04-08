<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Checklist_ujian extends CI_Model{
	//Method untuk mendapatkan checklist ujian
	function getChecklist($id_matkul, $tipe_ujian){
		$this->db->select('*');
		$this->db->where('ID_MATKUL', $id_matkul);
		$this->db->where('TIPE_UJIAN', $tipe_ujian);
		$this->db->order_by('ID', 'desc');
		$result = $this->db->get('checklist_ujian', 1);
		if($result->num_rows() > 0 ){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk memasukkan data checklist persiapan ujian ke dalam database
	function insertChecklist($data){
		$res = $this->db->insert('checklist_ujian', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
}
?>