<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Jadwal_matkul extends CI_Model{
	//Method untuk mendapatkan jadwal perkuliahan berdasarkan id mata kuliah
	function getJadwalMatkul($id_matkul){
		$this->db->select('mata_kuliah.NAMA_MATKUL as NAMA_MATKUL, jadwal_matkul.HARI as HARI, jadwal_matkul.JAM_MULAI as JAM_MULAI, jadwal_matkul.JAM_SELESAI as JAM_SELESAI, jadwal_matkul.KODE_KELAS as KODE_KELAS, daftar_lab.NAMA_LAB as NAMA_LAB, daftar_lab.LOKASI as LOKASI');
		$this->db->from('jadwal_matkul');
		$this->db->join('daftar_lab', 'daftar_lab.ID = jadwal_matkul.ID_LAB', 'left');
		$this->db->join('mata_kuliah', 'mata_kuliah.ID = jadwal_matkul.ID_MATKUL', 'left');
		$this->db->order_by('jadwal_matkul.HARI', 'desc');
		$this->db->order_by('jadwal_matkul.KODE_KELAS', 'desc');
		$this->db->where('jadwal_matkul.ID_MATKUL', $id_matkul);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk memasukkan jadwal kelas mata kuliah (bulk insert)
	function bulkInsertJadwal($data){
		$res = $this->db->insert_batch('jadwal_matkul', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
}
?>