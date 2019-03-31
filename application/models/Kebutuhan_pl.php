<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kebutuhan_pl extends CI_Model{

	//Method untuk melakukan update status pengecekan kebutuhan perangkat lunak
	function updateStatusPL($id_pl, $status, $last_checked){
		$data = array(
		    'STATUS' => $status,
		    'LAST_CHECKED' => $last_checked
		);

		$this->db->where('ID', $id_pl);
		$res = $this->db->update('kebutuhan_pl', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}

	//Method untuk menghapus kebutuhan perangkat lunak suatu mata kuliah
	function removePL($id_pl){
		$this->db->where('ID', $id_pl);
		$res = $this->db->delete('kebutuhan_pl');
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk mendapatkan daftar kebutuhan perangkat lunak suatu mata kuliah
	function getPL($id_matkul){
		$this->db->select('ID, NAMA_PL, STATUS, LAST_CHECKED');
		$this->db->from('kebutuhan_pl');
		$this->db->where('ID_MATKUL', $id_matkul);
		$result = $this->db->get();
		if($result->num_rows() > 0 ){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk memasukkan kebutuhan perangkat lunak suatu mata kuliah ke dalam database
	function insertPL($id_matkul, $nama_pl){
		$data = array(
		    'ID_MATKUL' => $id_matkul,
		    'NAMA_PL' => $nama_pl,
		    'STATUS' => 0,
		    'LAST_CHECKED' => '-'
		);
		$res = $this->db->insert('kebutuhan_pl', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
}
?>