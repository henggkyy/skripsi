<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani dokumen SOP/buku saku dan jadwal yang bersifat public
class C_Public extends CI_Controller{
	//Method untuk menampilkan halaman utama dokumen
	function loadViewDokumen(){
		$data['title'] = 'Dokumen Laboratorium Komputasi TIF UNPAR | SI Akademik Lab. Komputasi TIF UNPAR';
		$this->load->model('Data_file_sop');
		$data['daftar_file'] = $this->Data_file_sop->getSopPublic();
		$this->load->view('pages_user/V_Dokumen_Public', $data);
	}

	//Method untuk mendapatkan data dokumen yang dipilih oleh pengguna public (not logged in)
	//Method ini dipanggil dengan menggunakan Jquery AJAX dari V_Dokumen_Public
	//Return : View data table
	function getSelectedDokumen(){
		$tipe_dokumen = $this->input->get('jenis_dokumen');
		if($tipe_dokumen == 'sop' || $tipe_dokumen == 'buku_saku'){
			if($tipe_dokumen == 'sop'){
				$this->load->model('Data_file_sop');
				$data['daftar_file'] = $this->Data_file_sop->getSopPublic();
				$data['jenis_dokumen'] = 'SOP';
			}
			else{
				$this->load->model('Data_buku_saku');
				$data['daftar_file'] = $this->Data_buku_saku->getSakuPublic();
				$data['jenis_dokumen'] = 'Buku_saku';
			}
			$string =  $this->load->view('pages_user/V_Template_Selected_Dok_Public', $data, TRUE);
			echo $string;
		}
	}
}
?>