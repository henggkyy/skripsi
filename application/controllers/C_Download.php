<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani Inisiasi dan Administrasi Mata Kuliah.
class C_Download extends CI_Controller{
	function downloadFileBantuan($path_file){
		if($this->session->userdata('logged_in')){
			$this->load->helper('download');
			if($path_file!=""){
				force_download("./uploads/file_bantuan/$path_file", NULL);
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk download checker aplikasi java
	function downloadChecker(){
		if($this->session->userdata('logged_in')){
			$this->load->helper('download');
			if(PHP_INT_SIZE == 8){
				force_download('./assets/checker/checker32.jar', NULL);
			}
			else{
				force_download('./assets/checker/checker64.jar', NULL);
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk download template excel untuk input peserta mahasiswa
	function downloadTemplateInsertMhs(){
		if($this->session->userdata('logged_in')){
			$this->load->helper('download');
			force_download('./assets/excel/Template_Insert_Mhs_Matkul.xlsx', NULL);
		}
		else{
			redirect('/');
		}
	}
}
?>