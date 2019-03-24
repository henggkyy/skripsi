<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Peminjaman_lab extends CI_Model{
	function tindaklanjutiPermintaanLab($id_pinjaman, $tindakan, $keterangan){
		$data = array(
		    'DISETUJUI' => $tindakan,
		    'KETERANGAN_KALAB' => $keterangan
		);

		$this->db->where('ID', $id_pinjaman);
		$res = $this->db->update('peminjaman_lab', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	function addPeminjaman($user, $lab, $tgl_pinjam, $jam_mulai, $jam_selesai, $keterangan){
		$data = array(
		    'USER_PEMINJAM' => $user,
		    'LAB' => $lab,
		    'TANGGAL_PINJAM' => $tgl_pinjam,
		    'JAM_MULAI' => $jam_mulai,
		    'JAM_SELESAI' => $jam_selesai,
		    'KETERANGAN_PEMINJAM' => $keterangan,
		    'DISETUJUI' => 0
		);
		$res = $this->db->insert('peminjaman_lab', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}

	function getAllDataPeminjaman(){
		$this->db->select('peminjaman_lab.ID as ID, peminjaman_lab.USER_PEMINJAM as USER_PEMINJAM, peminjaman_lab.DATE_SUBMITTED as TANGGAL_REKAM, peminjaman_lab.TANGGAL_PINJAM, daftar_lab.NAMA_LAB as NAMA_LAB, daftar_lab.LOKASI as LOKASI, peminjaman_lab.JAM_MULAI as JAM_MULAI, peminjaman_lab.JAM_SELESAI as JAM_SELESAI, peminjaman_lab.DISETUJUI as STATUS,  peminjaman_lab.KETERANGAN_PEMINJAM as KETERANGAN_PEMINJAM');
		$this->db->from('peminjaman_lab');
		$this->db->join('daftar_lab', 'peminjaman_lab.LAB = daftar_lab.ID' , 'left outer');
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