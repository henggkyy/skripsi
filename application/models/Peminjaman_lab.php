<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Peminjaman_lab extends CI_Model{
	//Method untuk melakukan update status permintaan peminjaman laboratorium kedalam database.
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
	//Method untuk memasukkan data permintaan peminjaman laboratorium ke dalam database 
	function addPeminjaman($email_peminjam, $nama_peminjam, $lab, $id_alat, $tgl_pinjam, $jam_mulai, $jam_selesai, $keterangan, $keperluan){
		date_default_timezone_set("Asia/Jakarta");
		$tanggal_request = date("Y-m-d h:i:sa");
		$tgl_pinjam = date("Y-m-d", strtotime($tgl_pinjam));
		$data = array(
		    'EMAIL_PEMINJAM' => $email_peminjam,
		    'NAMA_PEMINJAM' => $nama_peminjam,
		    'LAB' => $lab,
		    'ID_ALAT' => $id_alat,
		    'TANGGAL_PINJAM' => $tgl_pinjam,
		    'JAM_MULAI' => $jam_mulai,
		    'JAM_SELESAI' => $jam_selesai,
		    'KETERANGAN_PEMINJAM' => $keterangan,
		    'DISETUJUI' => 0,
		    'KEPERLUAN' => $keperluan,
		    'TANGGAL_REQUEST' => $tanggal_request
		);
		$res = $this->db->insert('peminjaman_lab', $data);
		if($res){
			return true;
		}
		else{
			return false;
		}
	}
	//Method untuk mendapatkan item peminjaman lab
	function getIndividualItem($id_pinjaman, $item){
		$this->db->select($item);
		$this->db->where('ID', $id_pinjaman);
		$this->db->from('peminjaman_lab');
		$result = $this->db->get();
		if($result->num_rows() == 1){
			return $result->row(0)->$item;
		} 
		else {
			return false;
		}
	}
	//Method untuk mendapatkan seluruh data permintaan peminjaman alat-alat laboratorium
	function getAllDataPeminjamanAlat(){
		$this->db->select('peminjaman_lab.ID as ID, peminjaman_lab.EMAIL_PEMINJAM as EMAIL_PEMINJAM, peminjaman_lab.NAMA_PEMINJAM as NAMA_PEMINJAM, peminjaman_lab.TANGGAL_REQUEST as TANGGAL_REKAM, peminjaman_lab.TANGGAL_PINJAM, alat_lab.NAMA_ALAT as NAMA_ALAT, peminjaman_lab.JAM_MULAI as JAM_MULAI, peminjaman_lab.JAM_SELESAI as JAM_SELESAI, peminjaman_lab.DISETUJUI as STATUS,  peminjaman_lab.KETERANGAN_PEMINJAM as KETERANGAN_PEMINJAM');
		$this->db->from('peminjaman_lab');
		$this->db->where('LAB', NULL);
		$this->db->join('alat_lab', 'peminjaman_lab.ID_ALAT = alat_lab.ID' , 'left outer');
		$result = $this->db->get();
		if($result->num_rows() > 0 ){
			return $result->result_array();
		} 
		else {
			return false;
		}
	}
	//Method untuk mendapatkan seluruh data permintaan peminjaman ruangan laboratorium
	function getAllDataPeminjamanLab(){
		$this->db->select('peminjaman_lab.ID as ID, peminjaman_lab.EMAIL_PEMINJAM as EMAIL_PEMINJAM, peminjaman_lab.NAMA_PEMINJAM as NAMA_PEMINJAM, peminjaman_lab.TANGGAL_REQUEST as TANGGAL_REKAM, peminjaman_lab.TANGGAL_PINJAM, daftar_lab.NAMA_LAB as NAMA_LAB, daftar_lab.LOKASI as LOKASI, peminjaman_lab.JAM_MULAI as JAM_MULAI, peminjaman_lab.JAM_SELESAI as JAM_SELESAI, peminjaman_lab.DISETUJUI as STATUS,  peminjaman_lab.KETERANGAN_PEMINJAM as KETERANGAN_PEMINJAM');
		$this->db->from('peminjaman_lab');
		$this->db->where('ID_ALAT', NULL);
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