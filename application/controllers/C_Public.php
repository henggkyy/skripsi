<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani dokumen SOP/buku saku dan jadwal yang bersifat public
class C_Public extends CI_Controller{
	//Method untuk menampilkan halaman utama dokumen
	function loadViewDokumen(){
		$data['title'] = 'Dokumen | SI Akademik Lab. Komputasi TIF UNPAR';
		$this->load->view('pages_user/V_Dokumen_Public', $data);
	}
}
?>