<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pengajuan_jadwal_bertugas extends CI_Model{
	//Method untuk melakukan update status dan last update
	function updateStatus($id_pengajuan, $data){
		$this->db->where('ID', $id_pengajuan);
		$res = $this->db->update('pengajuan_jadwal_bertugas', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk mendapatkan data pengajuan jadwal bertugas berdasarkan id pengajuan
	function getDataPengajuanById($id_pengajuan, $id_admin, $id_periode){
		$this->db->select('ID, HARI, TANGGAL, JAM_MULAI, JAM_SELESAI, DATE_SUBMITTED, STATUS');
		$this->db->where('ID', $id_pengajuan);
		$this->db->where('ID_ADMIN', $id_admin);
		$this->db->where('ID_PERIODE', $id_periode);
		$this->db->from('pengajuan_jadwal_bertugas');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	function getDataPengajuanByPeriode($id_periode, $tipe){
		$this->db->select('pengajuan_jadwal_bertugas.ID as ID, pengajuan_jadwal_bertugas.ID_ADMIN as ID_ADMIN, users.NAMA as NAMA, HARI, TANGGAL, JAM_MULAI, JAM_SELESAI, DATE_SUBMITTED, pengajuan_jadwal_bertugas.STATUS as STATUS');
		$this->db->where('ID_PERIODE', $id_periode);
		$this->db->where('TIPE_BERTUGAS', $tipe);
		$this->db->order_by('TANGGAL', 'asc');
		$this->db->order_by('NUM_DAY', 'asc');
		$this->db->order_by('JAM_MULAI', 'asc');
		$this->db->from('pengajuan_jadwal_bertugas');
		$this->db->join('users', 'users.ID = pengajuan_jadwal_bertugas.ID_ADMIN', 'left');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk mendapatkan pengajuan jadwal bertugas berdasarkan id periode akademik dan id admin
	function getDataPengajuan($id_periode, $id_admin, $tipe_bertugas){
		$this->db->select('ID, HARI, TANGGAL, JAM_MULAI, JAM_SELESAI, DATE_SUBMITTED, STATUS');
		$this->db->where('ID_PERIODE', $id_periode);
		$this->db->where('ID_ADMIN', $id_admin);
		$this->db->where('TIPE_BERTUGAS', $tipe_bertugas);
		$this->db->order_by('STATUS', 'asc');
		$this->db->order_by('NUM_DAY', 'asc');
		$this->db->order_by('JAM_MULAI', 'asc');
		$this->db->from('pengajuan_jadwal_bertugas');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk memasukkan pengajuan jadwal bertugas admin
	function insertPengajuan($data){
		$res = $this->db->insert('pengajuan_jadwal_bertugas', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}

	//Method untuk bulk insert pengajuan jadwal bertugas admin
	function bulkInsertPengajuan($data){
		$res = $this->db->insert_batch('pengajuan_jadwal_bertugas', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
}
?>