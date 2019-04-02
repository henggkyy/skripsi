<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Method menangani koneksi antara aplikasi dengan tabel detail_user
class Detail_user extends CI_Model{
	//Method untuk mendapatkan data admin
	function getDataAdmin($id_user){
		$this->db->select('detail_user.ANGKATAN as ANGKATAN, detail_user.AWAL_KONTRAK as AWAL_KONTRAK, detail_user.AKHIR_KONTRAK as AKHIR_KONTRAK, users.NAMA as NAMA, users.EMAIL as EMAIL, users.NIK as NIK');
		$this->db->from('detail_user');
		$this->db->join('users', 'users.ID = detail_user.ID_USER', 'left');
		$this->db->where('detail_user.ID_USER', $id_user);
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk memasukkan data detail admin
	function insertDetailUser($id_user, $angkatan, $awal_kontrak, $akhir_kontrak){
		$data = array(
		    'ID_USER' => $id_user,
		    'ANGKATAN' => $angkatan,
		    'AWAL_KONTRAK' => $awal_kontrak,
		    'AKHIR_KONTRAK' => $akhir_kontrak
		);
		$res = $this->db->insert('detail_user', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
}
?>