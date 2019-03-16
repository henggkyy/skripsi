<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani Inisiasi dan Administrasi Mata Kuliah.
class C_Download extends CI_Controller{
	function downloadTemplateInsertMhs(){
		if($this->session->userdata('logged_in')){
			$this->load->helper('download');
			force_download('./assets/excel/Template_Insert_Mhs_Matkul.xlsx', NULL);
		}
		else{

		}
	}
}
?>