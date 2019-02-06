<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mata_kuliah extends CI_Model{
	//Method untuk memasukkan tanggal ujian UTS dan tanggal ujian UAS
	function insertTanggalUjian($id_matkul, $tgl_uts, $tgl_uas){
		$data = array(
		    'TANGGAL_UTS' => $tgl_uts,
		    'TANGGAL_UAS' => $tgl_uas
		);

		$this->db->where('ID', $id_matkul);
		$res = $this->db->update('mata_kuliah', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}

	//Method untuk mendapatkan daftar mata kuliah pada periode yang sedang aktif
	function getMatkul($id_periode){
		$this->db->select('ID, KD_MATKUL, NAMA_MATKUL, TANGGAL_UTS, TANGGAL_UAS');
		$this->db->where('ID_PERIODE', $id_periode);
		$this->db->from('mata_kuliah');
		$result = $this->db->get();
		if($result->num_rows() > 0 ){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}

	//Method untuk memasukkan mata kuliah ke dalam database.
	function insertMatkul($id_periode, $kd_matkul, $nama_matkul){
		$data = array(
		    'KD_MATKUL' => $kd_matkul,
		    'NAMA_MATKUL' => $nama_matkul,
		    'ID_PERIODE' => $id_periode
		);
		$res = $this->db->insert('mata_kuliah', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
}
?>