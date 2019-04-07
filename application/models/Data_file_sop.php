<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Data_file_sop extends CI_Model{
	function updateSop($id,$judul, $path_file, $visibility, $kategori){
		date_default_timezone_set('Asia/Jakarta');
		$date_time = date("Y-m-d h:i:sa");
		if($path_file != NULL){
			$data = array(
			    'JUDUL' => $judul,
			    'PATH_FILE' => $path_file,
			    'VISIBILITY' => $visibility,
			    'ID_KATEGORI' => $kategori,
			    'LAST_UPDATE' => $date_time,
			    'USER' => $this->session->userdata('id')
			);
		}
		else{
			$data = array(
			    'JUDUL' => $judul,
			    'VISIBILITY' => $visibility,
			    'ID_KATEGORI' => $kategori,
			    'LAST_UPDATE' => $date_time,
			    'USER' => $this->session->userdata('id')
			);
		}
		$this->db->where('ID', $id);
		$res = $this->db->update('data_file_sop', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	function getPathFile($id){
		$this->db->select('PATH_FILE');
		$item = "PATH_FILE";
		$this->db->where('ID', $id);
		$this->db->from('data_file_sop');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return $result->row(0)->$item;
		} 
		else {
			return false;
		}
	}
	function deleteDokumenSop($id){
		$this->db->where('ID', $id);
		$res = $this->db->delete('data_file_sop');
		if($res){
			return true;
		}
		else{
			return false;
		}
	}

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
		date_default_timezone_set('Asia/Jakarta');
		$date_time = date("Y-m-d h:i:sa");
		$data = array(
		    'JUDUL' => $judul,
		    'PATH_FILE' => $path,
		    'VISIBILITY' => $visibility,
		    'ID_KATEGORI' => $kategori,
		    'LAST_UPDATE' => $date_time,
			'USER' => $this->session->userdata('id')
		);
		$res = $this->db->insert('data_file_sop', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}

	function getSopPublic(){
		$this->db->select('data_file_sop.JUDUL as judul, data_file_sop.PATH_FILE as path, kategori_sop.NAMA_KATEGORI as nama_kategori, data_file_sop.LAST_UPDATE as LAST_UPDATE, users.EMAIL as USER');
		$this->db->from('data_file_sop');
		$this->db->join('kategori_sop', 'data_file_sop.ID_KATEGORI = kategori_sop.ID' , 'left outer');
		$this->db->join('users', 'data_file_sop.USER = users.ID' , 'left outer');
		$this->db->where('VISIBILITY', 1);
		$result = $this->db->get();
		if($result->num_rows() > 0 ){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	function getAllSOP(){
		$this->db->select('data_file_sop.ID as ID, data_file_sop.VISIBILITY as visibility, data_file_sop.JUDUL as judul, data_file_sop.PATH_FILE as path, data_file_sop.ID_KATEGORI as id_kategori, kategori_sop.NAMA_KATEGORI as nama_kategori, data_file_sop.LAST_UPDATE as LAST_UPDATE, users.EMAIL as USER');
		$this->db->from('data_file_sop');
		$this->db->join('kategori_sop', 'data_file_sop.ID_KATEGORI = kategori_sop.ID' , 'left outer');
		$this->db->join('users', 'data_file_sop.USER = users.ID' , 'left outer');
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