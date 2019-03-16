<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Periode_akademik extends CI_Model{

	//Method untuk melakukan pengecekan id periode akademik apakah sedang aktif atau tidak
	function checkIdAktif($id_periode){
		$this->db->select('ID');
		$this->db->where('STATUS', 1);
		$this->db->where('ID', $id_periode);
		$this->db->from('periode_akademik');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return true;
		} 
		else {
			return false;
		}
	}
	//Method untuk menambahkan periode akademik baru ke dalam database
	function insertPeriode($nama){
		$data = array(
		    'NAMA' => $nama,
		    'STATUS' => 1,
		    'CREATED_BY' => $this->session->userdata('id')
		);

		$res = $this->db->insert('periode_akademik', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}

	//Method untuk menonaktifkan periode akademik
	function nonaktifkanPeriode($id_periode){
		$data = array(
		    'STATUS' => 0
		);

		$this->db->where('ID', $id_periode);
		$res = $this->db->update('periode_akademik', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}

	//Method untuk mendapatkan ID dari Periode akademik yang sedang aktif.
	function getIDPeriodeAktif(){
		$this->db->select('ID');
		$item = "ID";
		$this->db->where('STATUS', 1);
		$this->db->from('periode_akademik');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return $result->row(0)->$item;
		} 
		else {
			return false;
		}
	}

	//Method untuk melakukan pengecekan apakah terdapat periode aktif atau tidak.
	//Apabila terdapat periode aktif, maka akan kembalikan nama periode yang sedang aktif.
	function checkPeriodeAktif(){
		$this->db->select('NAMA');
		$item = "NAMA";
		$this->db->where('STATUS', 1);
		$this->db->from('periode_akademik');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return $result->row(0)->$item;
		} 
		else {
			return false;
		}
	}

	//Method untuk mendapatkan seluruh periode akademik
	function getAllPeriode(){
		$this->db->select('NAMA, ID, STATUS');
		$this->db->from('periode_akademik');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk mendapatkan item periode aktif.
	//Apabila terdapat periode aktif, maka akan kembalikan nama periode dan ID yang sedang aktif.
	function getPeriodeAktif(){
		$this->db->select('NAMA, ID');
		$this->db->where('STATUS', 1);
		$this->db->from('periode_akademik');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
}
?>