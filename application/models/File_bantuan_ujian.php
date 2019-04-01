<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class File_bantuan_ujian extends CI_Model{
	//Method untuk menghapus file bantuan ujian dari database
	function deleteFileBantuan($id){
		$this->db->where('ID', $id);
		$res = $this->db->delete('file_bantuan_ujian');
		if($res){
			return true;
		}
		else{
			return false;
		}
	}

	//Method untuk mendapatkan nama file bantuan
	function getPathFile($id){
		$this->db->select('PATH_FILE');
		$item = "PATH_FILE";
		$this->db->where('ID', $id);
		$this->db->from('file_bantuan_ujian');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return $result->row(0)->$item;
		} 
		else {
			return false;
		}
	}

	//Method untuk mendapatkan file bantuan berdasarkan id mata kuliah
	function getFileBantuan($id_matkul){
		$this->db->select('file_bantuan_ujian.ID as ID, file_bantuan_ujian.PATH_FILE as PATH_FILE, file_bantuan_ujian.NAMA_FILE_USER as NAMA_KETERANGAN, file_bantuan_ujian.TIPE_UJIAN as TIPE_UJIAN, file_bantuan_ujian.LAST_UPDATE as LAST_UPDATE, users.NAMA as USER_UPLOAD');
		$this->db->from('file_bantuan_ujian');
		$this->db->join('users', 'file_bantuan_ujian.USER_UPLOAD = users.ID', 'left');
		$this->db->where('ID_MATKUL', $id_matkul);
		$result = $this->db->get();
		if($result->num_rows() > 0 ){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}

	//Method untuk melakukan pengencekan nama file dalam database
	function checkFileName($nama_file){
		$this->db->select('PATH_FILE');
		$this->db->where('PATH_FILE', $nama_file);
		$this->db->from('file_bantuan_ujian');
		$result = $this->db->get();
		if($result->num_rows() > 0 ){
			return true;
		} 
		else {
			return false;
		}
	}
	//Method untuk memasukkan data file bantuan ke database dan server
	function insertFileBantuan($data){
		$res = $this->db->insert('file_bantuan_ujian', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
}
?>