<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends CI_Model{

	//Method untuk mendapatkan data user berdasarkan role
	function getAllUserByRole($id_role){
		$this->db->select('users.ID as ID, NAMA,NIK, EMAIL, STATUS');
		$this->db->from('users');
		$this->db->where('ID_ROLE', $id_role);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}

	//Method untuk mendapatkan data dosen yang sedang aktif
	function getDosenAktif(){
		$this->db->select('users.ID as ID, NAMA, NIK');
		$this->db->from('users');
		$this->db->where('IS_DOSEN', 1);
		$this->db->where('STATUS', 1);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}

	//Method untuk mendapatkan data dosen
	function getAllDosen(){
		$this->db->select('users.ID as ID, NAMA,NIK, EMAIL, STATUS');
		$this->db->from('users');
		$this->db->where('ID_ROLE =', 2);
		$this->db->or_where('IS_DOSEN =', 1);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}

	//Method untuk mengubah status user.
	function changeStatus($id_user, $status){
		$data = array(
		    'STATUS' => $status
		);

		$this->db->where('ID', $id_user);
		$res = $this->db->update('users', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}

	//Method untuk mendapatkan status user.
	function getStatus($id_user){
		$this->db->select('STATUS');
		$item = "STATUS";
		$this->db->where('ID', $id_user);
		$this->db->from('users');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return $result->row(0)->$item;
		} 
		else {
			return false;
		}
	}

	//Method untuk menambahkan user baru.
	function addUser($id_role, $nama_user, $email_user, $nik, $is_dosen){
		$data = array(
		    'ID_ROLE' => $id_role,
		    'NAMA' => $nama_user,
		    'EMAIL' => $email_user,
		    'NIK' => $nik,
		    'STATUS' => 1,
		    'IS_DOSEN' => $is_dosen
		);
		$this->db->insert('users', $data);
		$insert_id = $this->db->insert_id();
		if($insert_id){
			return $insert_id;
		}
		else{
			return false;
		}
	}

	//Method untuk mendapatkan data user.
	function getUser(){
		$this->db->select('users.ID as ID, ID_ROLE, NAMA, EMAIL, STATUS, NAMA_ROLE');
		$this->db->from('users');
		$this->db->join('user_role', 'users.ID_ROLE = user_role.ID');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk pengencekan NIK ketika mendaftarkan pengguna baru.
	function checkNik($nik){
		$this->db->select('NIK');
		$this->db->where('NIK', $nik);
		$this->db->from('users');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return true;
		} 
		else {
			return false;
		}
	}
	//Method ini digunakan untuk pengecekan data pengguna yang login dengan data di database.
	//Apabila data terdaftar dalam database, maka akan mengembalikan informasi pengguna.
	function checkUser($email){
		$this->db->select('users.ID as ID, ID_ROLE, NAMA, EMAIL, NAMA_ROLE');
		$this->db->where('EMAIL', $email);
		$this->db->from('users');
		$this->db->join('user_role', 'users.ID_ROLE = user_role.ID');
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