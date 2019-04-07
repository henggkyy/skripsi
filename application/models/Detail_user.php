<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Method menangani koneksi antara aplikasi dengan tabel detail_user
class Detail_user extends CI_Model{
	//Method untuk melakukan update golongan gaji admin
	function updateGolonganGaji($id_admin, $id_gol){
		$data = array(
		    'ID_GAJI' => $id_gol
		);

		$this->db->where('ID_USER', $id_admin);
		$res = $this->db->update('detail_user', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk mengambil individual item berdasarkan id admin
	function getIndividualItem($id_admin, $item){
		$this->db->select($item);
		$this->db->where('ID_USER', $id_admin);
		$this->db->from('detail_user');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return $result->row(0)->$item;
		} 
		else {
			return false;
		}
	}
	//Method untuk update periode kontrak admin
	function updateKontrakAdmin($id_user, $tgl_awal, $tgl_akhir){
		$data = array(
		    'AWAL_KONTRAK' => $tgl_awal,
		    'AKHIR_KONTRAK' => $tgl_akhir
		);

		$this->db->where('ID_USER', $id_user);
		$res = $this->db->update('detail_user', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}

	//Method untuk mendapatkan data admin
	function getDataAdmin($id_user){
		$this->db->select('detail_user.ANGKATAN as ANGKATAN, detail_user.AWAL_KONTRAK as AWAL_KONTRAK, detail_user.AKHIR_KONTRAK as AKHIR_KONTRAK, users.NAMA as NAMA, users.EMAIL as EMAIL, users.NIK as NIK,detail_user.ID_GAJI as ID_GOL, konfigurasi_gaji.NAMA_GOLONGAN as NAMA_GOLONGAN, konfigurasi_gaji.TARIF as TARIF');
		$this->db->from('detail_user');
		$this->db->join('users', 'users.ID = detail_user.ID_USER', 'left');
		$this->db->join('konfigurasi_gaji', 'konfigurasi_gaji.ID = detail_user.ID_GAJI', 'left');
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
	function insertDetailUser($id_user, $angkatan, $awal_kontrak, $akhir_kontrak, $id_gol){
		$data = array(
		    'ID_USER' => $id_user,
		    'ANGKATAN' => $angkatan,
		    'AWAL_KONTRAK' => $awal_kontrak,
		    'AKHIR_KONTRAK' => $akhir_kontrak,
		    'ID_GAJI' => $id_gol
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