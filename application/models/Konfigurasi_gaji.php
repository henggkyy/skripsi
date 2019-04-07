<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Konfigurasi_gaji extends CI_Model{
	//Method untuk mendapatkan seluruh data konfigurasi berdasarkan id
	function getDataKonfigurasi($id){
		$this->db->select('TARIF, JAM_MAX');
		$this->db->where('ID', $id);
		$this->db->from('konfigurasi_gaji');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk memasukkan data golongan konfigurasi admin ke dalam database
	function insertKonfigurasi($data){
		$res = $this->db->insert('konfigurasi_gaji', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk melakukan edit konfigurasi gaji
	function editKonfigurasi($data, $id){
		$this->db->where('ID', $id);
		$res = $this->db->update('konfigurasi_gaji', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk mendapatkan item 
	function getIndividualItem($id, $item){
		$this->db->select($item);
		$this->db->where('ID', $id);
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
		$this->db->select('ID, NAMA_GOLONGAN, JAM_MAX, TARIF');
		$this->db->from('konfigurasi_gaji');
		$result = $this->db->get();
		if($result->num_rows() > 0 ){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
}
?>