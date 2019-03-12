<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Data_file_sop extends CI_Model{

	function checkHash($hash){
		$this->db->select('PATH_FILE');
		$this->db->where('PATH_FILE', $hash);
		$this->db->from('data_file_sop');
		$result = $this->db->get();
		if($result->num_rows() > 0 ){
			return true;
		} 
		else {
			return false;
		}
	}
	function inputDokumenSop($judul, $kategori, $visibility, $path){
		$data = array(
		    'JUDUL' => $judul,
		    'PATH_FILE' => $path,
		    'VISIBILITY' => $visibility,
		    'ID_KATEGORI' => $kategori
		);
		$res = $this->db->insert('data_file_sop', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	function getAllSOP(){
		$this->db->select('data_file_sop.ID as ID, data_file_sop.VISIBILITY as visibility, data_file_sop.JUDUL as judul, data_file_sop.PATH_FILE as path, kategori_sop.NAMA_KATEGORI as nama_kategori');
		$this->db->from('data_file_sop');
		$this->db->join('kategori_sop', 'data_file_sop.ID_KATEGORI = kategori_sop.ID' , 'left outer');
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