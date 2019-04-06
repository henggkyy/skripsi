<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Konfigurasi_gaji extends CI_Model{
	//Method untuk melakukan edit konfigurasi gaji
	function editKonfigurasi($data){
		$this->db->where('ID', 1);
		$res = $this->db->update('konfigurasi_gaji', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk mendapatkan item peminjaman lab
	function getIndividualItem($item){
		$this->db->select($item);
		$this->db->where('ID', 1);
		$this->db->from('konfigurasi_gaji');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return $result->row(0)->$item;
		} 
		else {
			return false;
		}
	}
	//Method untuk mendapatkan konfigurasi gaji dari database
	function getKonfigurasi(){
		$this->db->select('JAM_MAX, TARIF');
		$this->db->where('ID', 1);
		$this->db->from('konfigurasi_gaji');
		$result = $this->db->get();
		if($result->num_rows() == 1 ){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
}
?>