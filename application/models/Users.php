<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends CI_Model{
	//Method untuk mendapatkan email Kalab
	function getEmailKalab(){
		$this->db->select('EMAIL');
		$this->db->where('ID_ROLE', 1);
		$this->db->from('users');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return $result->row(0)->$item;
		} 
		else {
			return false;
		}
	}
	//Method untuk mendapatkan warna terakhir dari Admin yang terdaftar. Warna ini bertujuan untuk ditampilkan di timetable
	function getLastAdminColor(){
		$this->db->select('COLOR');
		$this->db->where('ID_ROLE', 4);
		$this->db->order_by('ID', 'desc');
		$this->db->limit(1);
		$result = $this->db->get('users');;
		if($result->num_rows() == 1){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk mengubah role pengguna
	function changeRole($id_user, $data){
		$this->db->where('ID', $id_user);
		$res = $this->db->update('users', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk mengecek apakah user role selain dosen bertindak sebagai dosen juga atau tidak
	function checkUserIsDosen($id_user){
		$this->db->select('ID');
		$this->db->where('ID', $id_user);
		$this->db->where('IS_DOSEN', 1);
		$this->db->from('users');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return true;
		} 
		else {
			return false;
		}
	}
	//Method untuk update last login dan last ip
	function updateDataLogin($id_user, $data){
		$this->db->where('ID', $id_user);
		$res = $this->db->update('users', $data);
		
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk mendapatkan data user berdasarkan id 
	function getUserById($id){
		$this->db->select('users.ID as ID, ID_ROLE, NAMA, NIK, EMAIL, STATUS, INISIAL');
		$this->db->where('ID', $id);
		$this->db->from('users');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk melakukan validasi apakah id admin sedang aktif atau tidak
	function checkAdminAktif($id_admin){
		$this->db->select('users.ID as ID, NAMA,NIK, EMAIL, STATUS, INISIAL');
		$this->db->from('users');
		$this->db->where('STATUS', 1);
		$this->db->where('ID_ROLE', 4);
		$this->db->where('ID', $id_admin);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk mendapatkan data admin yang aktif untuk keperluan input laporan absensi/gaji oleh TU
	function getDataAdminAktif(){
		$this->db->select('users.ID as ID, NAMA,NIK, EMAIL, STATUS, INISIAL');
		$this->db->from('users');
		$this->db->where('STATUS', 1);
		$this->db->where('ID_ROLE', 4);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk melakukan pengecekan user role
	function checkUserRole($id_user, $role){
		$this->db->select('users.ID');
		$this->db->where('ID', $id_user);
		$this->db->where('ID_ROLE', $role);
		$this->db->from('users');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return true;
		} 
		else {
			return false;
		}
	}

	//Method untuk mendapatkan individual item
	function getIndividualItem($id_user, $item){
		$this->db->select($item);
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
	//Method untuk mendapatkan data user berdasarkan role
	function getAllUserByRole($id_role){
		$this->db->select('users.ID as ID, NAMA,NIK, EMAIL, STATUS, INISIAL');
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
	function addUser($id_role, $nama_user, $email_user, $nik, $is_dosen, $inisial, $color){
		$data = array(
		    'ID_ROLE' => $id_role,
		    'NAMA' => $nama_user,
		    'EMAIL' => $email_user,
		    'NIK' => $nik,
		    'STATUS' => 1,
		    'IS_DOSEN' => $is_dosen,
		    'INISIAL' => $inisial,
		    'COLOR' => $color
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
	//Method untuk mendapatkan data login user pada halaman dashboard
	function getDataLogin(){
		$this->db->select('NAMA, EMAIL, STATUS, NAMA_ROLE, LAST_LOGIN, LAST_IP');
		$this->db->from('users');
		$this->db->join('user_role', 'users.ID_ROLE = user_role.ID');
		$this->db->order_by('LAST_LOGIN', 'desc');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk mendapatkan data user.
	function getUser(){
		$this->db->select('users.ID as ID, ID_ROLE, NAMA, EMAIL, STATUS, NAMA_ROLE, LAST_LOGIN, LAST_IP');
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