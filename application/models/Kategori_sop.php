<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kategori_sop extends CI_Model{
	//Method untuk menambahkan kategori dokumen SOP baru.
	function addKategori($data){
		$res = $this->db->insert('kategori_sop', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk mendapatkan seluruh kategori dokumen SOP
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