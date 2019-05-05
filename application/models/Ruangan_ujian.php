<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ruangan_ujian extends CI_Model{
	//Method untuk mendapatkan data ruangan ujian
	function getDataRuanganUjian($id_matkul, $tipe_ujian){
		$this->db->select('daftar_lab.NAMA_LAB as nama_lab, daftar_lab.LOKASI as lokasi');
		$this->db->where('ID_MATKUL', $id_matkul);
		$this->db->where('TIPE_UJIAN', $tipe_ujian);
		$this->db->from('ruangan_ujian');
		$this->db->join('daftar_lab', 'daftar_lab.ID = ruangan_ujian.ID_LAB', 'left');
		$result = $this->db->get();
		if($result->num_rows() > 0 ){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk memasukkan data ruangan ujian
	function insertData($data){
		$res = $this->db->insert('ruangan_ujian', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}	
}
?>