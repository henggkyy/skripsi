<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani Inisiasi dan Administrasi Mata Kuliah.
class C_Download extends CI_Controller{
	//Method untuk melakukan download file bantuan ujian
	function downloadFileBantuan($path_file){
		if($this->session->userdata('logged_in')){
			$this->load->model('File_bantuan_ujian');
			$status = $this->File_bantuan_ujian->getIndividualItemByPath($path_file, 'STATUS');
			$this->load->helper('download');
			if($this->session->userdata('id_role') == 4){
				$this->load->helper('download');
				if($status == 0 || $status == 2){
					$this->session->set_flashdata('error', 'Anda tidak mendownload file bantuan!');
					redirect('/dashboard');
				}
				if($path_file!=""){
					force_download("./uploads/file_bantuan/$path_file", NULL);
				}
			}
			else if($this->session->userdata('id_role') == 2 || $this->session->userdata('id_role') == 1){
				if($path_file!=""){
					force_download("./uploads/file_bantuan/$path_file", NULL);
				}
			}
			else{
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke fitur ini!');
				redirect('/dashboard');
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk download checker aplikasi java
	function downloadChecker(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 4){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke fitur ini!');
				redirect('/dashboard');
			}
			$this->load->helper('download');
			force_download('./assets/checker/checker.jar', NULL);
		}
		else{
			redirect('/');
		}
	}
}
?>