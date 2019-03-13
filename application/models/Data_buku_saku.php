<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Data_buku_saku extends CI_Model{
	function updateBukuSaku($id,$judul, $path_file, $visibility){
		if($path_file != NULL){
			$data = array(
			    'JUDUL' => $judul,
			    'PATH_FILE' => $path_file,
			    'VISIBILITY' => $visibility
			);
		}
		else{
			$data = array(
			    'JUDUL' => $judul,
			    'VISIBILITY' => $visibility
			);
		}
		$this->db->where('ID', $id);
		$res = $this->db->update('data_buku_saku', $data);
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
		$this->db->from('data_buku_saku');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return $result->row(0)->$item;
		} 
		else {
			return false;
		}
	}
	function deleteDokumenBukuSaku($id){
		$this->db->where('ID', $id);
		$res = $this->db->delete('data_buku_saku');
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	function getAllBukuSaku(){
		$this->db->select('data_buku_saku.ID as ID, data_buku_saku.VISIBILITY as visibility, data_buku_saku.JUDUL as judul, data_buku_saku.PATH_FILE as path');
		$this->db->from('data_buku_saku');
		$result = $this->db->get();
		if($result->num_rows() > 0 ){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	function checkHash($hash){
		$this->db->select('PATH_FILE');
		$this->db->where('PATH_FILE', $hash);
		$this->db->from('data_buku_saku');
		$result = $this->db->get();
		if($result->num_rows() > 0 ){
			return true;
		} 
		else {
			return false;
		}
	}
	function inputDokumenSaku($judul, $visibility, $path){
		$data = array(
		    'JUDUL' => $judul,
		    'PATH_FILE' => $path,
		    'VISIBILITY' => $visibility
		);
		$res = $this->db->insert('data_buku_saku', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
}
?>