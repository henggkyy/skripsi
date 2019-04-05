<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Periode_gaji extends CI_Model{
	//Method untuk melakukan pengecekan apakah id periode sedang aktif atau tidak
	function checkIDPeriodeAktif($id_periode){
		$this->db->select('ID');
		$this->db->where('ID', $id_periode);
		$this->db->where('STATUS', 1);
		$this->db->from('periode_gaji');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return true;
		} 
		else {
			return false;
		}
	}
	//Method untuk menonaktifkan periode gaji
	function nonaktifkanPeriode($data, $id_periode){
		$this->db->where('ID', $id_periode);
		$res = $this->db->update('periode_gaji', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk mendapatkan seluruh periode gaji.
	function getAllPeriodeGaji(){
		$this->db->select('ID, START_PERIODE, END_PERIODE, KETERANGAN, STATUS');
		$this->db->from('periode_gaji');
		$this->db->order_by('STATUS', 'desc');
		$this->db->order_by('START_PERIODE', 'desc');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk melakukan pengecekan periode apakah ada yang aktif atau tidak
	function checkPeriodeAktif(){
		$this->db->select('ID');
		$this->db->where('STATUS', 1);
		$this->db->from('periode_gaji');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return true;
		} 
		else {
			return false;
		}
	}
	//Method untuk melakukan insert periode gaji ke dalam database
	function insertPeriode($data){
		$res = $this->db->insert('periode_gaji', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
}
?>