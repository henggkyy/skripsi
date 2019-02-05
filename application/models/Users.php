<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends CI_Model{

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