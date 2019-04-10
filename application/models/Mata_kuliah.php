<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mata_kuliah extends CI_Model{
	//Method untuk pengecekan apakah tanggal UTS/UAS telah di set
	//Param : Id Matkul, Tipe Ujian (UTS / UAS)
	function cekJadwalUjian($id_matkul, $tipe_ujian){
		$this->db->select($tipe_ujian);
		$this->db->where('mata_kuliah.ID', $id_matkul);
		$this->db->from('mata_kuliah');
		$result = $this->db->get();
		if($result->num_rows() == 1 ){
			return $result->row(0)->$tipe_ujian;
		} 
		else {
			return false;
		}
	}

	//Method untuk mendapatkan informasi mengenai suatu mata kuliah
	function getInformasiBasicMatkul($id_matkul){
		$this->db->select('mata_kuliah.ID as ID, KD_MATKUL, NAMA_MATKUL, TANGGAL_UTS, TANGGAL_UAS, users.NAMA as NAMA_DOSEN');
		$this->db->where('mata_kuliah.ID', $id_matkul);
		$this->db->from('mata_kuliah');
		$this->db->join('users', 'mata_kuliah.ID_DOSEN = users.ID' , 'left outer');
		$result = $this->db->get();
		if($result->num_rows() == 1 ){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}

	//Method untuk mendapatkan item matakuliah
	function getIndividualItem($id_matkul, $item){
		$this->db->select($item);
		$this->db->where('ID', $id_matkul);
		$this->db->from('mata_kuliah');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return $result->row(0)->$item;
		} 
		else {
			return false;
		}
	}

	//Method untuk memasukkan tanggal ujian UTS dan tanggal ujian UAS
	function insertTanggalUjian($id_matkul, $tipe_ujian, $tanggal){
		$data = array(
		    $tipe_ujian => $tanggal
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
	//Method untuk mendapatkan daftar mata kuliah pada periode yang aktif berdasarkan id dosen yang login
	function getMatkulByDosen($id_periode, $id_dosen){
		$this->db->select('mata_kuliah.ID as ID, KD_MATKUL, NAMA_MATKUL, TANGGAL_UTS, TANGGAL_UAS, users.NAMA as NAMA_DOSEN, periode_akademik.NAMA as NAMA_PERIODE');
		$this->db->where('ID_PERIODE', $id_periode);
		$this->db->where('ID_DOSEN', $id_dosen);
		$this->db->from('mata_kuliah');
		$this->db->join('users', 'mata_kuliah.ID_DOSEN = users.ID' , 'left outer');
		$this->db->join('periode_akademik', 'mata_kuliah.ID_PERIODE = periode_akademik.ID' , 'left outer');
		$result = $this->db->get();
		if($result->num_rows() > 0 ){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk mendapatkan daftar mata kuliah pada periode yang sedang aktif
	function getMatkul($id_periode){
		$this->db->select('mata_kuliah.ID as ID, KD_MATKUL, NAMA_MATKUL, TANGGAL_UTS, TANGGAL_UAS, users.NAMA as NAMA_DOSEN, periode_akademik.NAMA as NAMA_PERIODE');
		$this->db->where('ID_PERIODE', $id_periode);
		$this->db->from('mata_kuliah');
		$this->db->join('users', 'mata_kuliah.ID_DOSEN = users.ID' , 'left outer');
		$this->db->join('periode_akademik', 'mata_kuliah.ID_PERIODE = periode_akademik.ID' , 'left outer');
		$result = $this->db->get();
		if($result->num_rows() > 0 ){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}

	//Method untuk memasukkan mata kuliah ke dalam database.
	function insertMatkul($id_periode, $kd_matkul, $nama_matkul, $dosen_koor){
		$data = array(
		    'KD_MATKUL' => $kd_matkul,
		    'NAMA_MATKUL' => $nama_matkul,
		    'ID_PERIODE' => $id_periode,
		    'ID_DOSEN' => $dosen_koor
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