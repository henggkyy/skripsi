<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laporan_gaji_admin extends CI_Model{
	//Method untuk melakukan count terhadap jumlah laporan gaji berdasarkan user
	function countJumlahMasuk($id_admin, $id_periode){
		$this->db->select('ID');
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