<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laporan_gaji_admin extends CI_Model{
	//Method untuk mendapatkan tarif dan jam maksimal dari setiap periode dan user
	function getTarifAndJam($id_periode, $id_admin){
		$this->db->distinct();
		$this->db->select('TARIF_AKTIF, WAKTU_MAKS_AKTIF');
		$this->db->where('ID_PERIODE', $id_periode);
		$this->db->where('ID_ADMIN', $id_admin);
		$result = $this->db->get('laporan_gaji_admin', 1);
		if($result->num_rows() > 0){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk menghapus laporan gaji admin dari database
	function deleteLaporanGaji($hash, $id_admin, $id_periode){
		$this->db->where('UNIQ', $hash);
		$this->db->where('ID_ADMIN', $id_admin);
		$this->db->where('ID_PERIODE', $id_periode);
		$res = $this->db->delete('laporan_gaji_admin');
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk melakukan update laporan gaji ke dalam database
	function updateLaporanGaji($hash,$id_admin, $id_periode, $data){
		$this->db->where('UNIQ', $hash);
		$this->db->where('ID_ADMIN', $id_admin);
		$this->db->where('ID_PERIODE', $id_periode);
		$res = $this->db->update('laporan_gaji_admin', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk mendapatkan input laporan gaji untuk keperluan update berdasarkan hash
	function getInputLaporan($hash){
		$this->db->select('TANGGAL_MASUK, JAM_MASUK, JAM_KELUAR, TOTAL_JAM, ISTIRAHAT, ID_ADMIN, ID_PERIODE');
		$this->db->where('UNIQ', $hash);
		$this->db->from('laporan_gaji_admin');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk mendapakatkan seluruh data laporan absensi/gaji admin
	function getDataLaporan($id_periode, $id_admin){
		$this->db->select('UNIQ, HARI, TANGGAL_MASUK, JAM_MASUK, JAM_KELUAR, TOTAL_JAM, ISTIRAHAT, WAKTU_REAL, BIAYA');
		$this->db->where('ID_PERIODE', $id_periode);
		$this->db->where('ID_ADMIN', $id_admin);
		$this->db->from('laporan_gaji_admin');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk melakukan count terhadap jumlah laporan gaji berdasarkan user
	function countJumlahMasuk($id_admin, $id_periode){
		$this->db->distinct();
		$this->db->select('TANGGAL_MASUK');
		$this->db->where('ID_ADMIN', $id_admin);
		$this->db->where('ID_PERIODE', $id_periode);
		$this->db->from('laporan_gaji_admin');
		return $this->db->count_all_results();
	}
	//Method untuk memasukkan data laporan gaji admin ke dalam database
	function insertGaji($data){
		$res = $this->db->insert('laporan_gaji_admin', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk melakukan pengecekan hash apakah sudah dipakai atau belum
	function checkHash($hash){
		$this->db->select('ID');
		$this->db->where('UNIQ', $hash);
		$this->db->from('laporan_gaji_admin');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return true;
		} 
		else {
			return false;
		}
	}
}
?>