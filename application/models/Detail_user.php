<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Method menangani koneksi antara aplikasi dengan tabel detail_user
class Detail_user extends CI_Model{
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