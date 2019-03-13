<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani proses input, update, dan delete mengenai dokumen SOP
class C_Sop extends CI_Controller {

	//Method untuk melakukan update dokumen SOP
	function updateSop(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('kategori_sop', 'Kategori SOP', 'required');
			$this->form_validation->set_rules('visibility', 'Visibility SOP', 'required');
			$this->form_validation->set_rules('judul_sop', 'Judul SOP', 'required');
			$this->form_validation->set_rules('id_sop', 'ID SOP', 'required');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error_message', 'Missing required Field!');
	            redirect('/dokumen_sop');
			}
			else{
				$kategori_sop = htmlentities($this->input->post('kategori_sop'));
				$visibility = htmlentities($this->input->post('visibility'));
				$judul_sop = htmlentities($this->input->post('judul_sop'));
				$id_sop = $this->input->post('id_sop');
				$this->load->model('Data_file_sop');
				// print_r($_FILES['dokumen']['name']);
				// return;
				if(!empty($_FILES['dokumen']['name'])){
					$namePathOld = $this->Data_file_sop->getPathFile($id_sop);
					$namaFileHash = $this->generateHash(20);
					$exists = $this->Data_file_sop->checkHash($namaFileHash);
					while ($exists) {
						$namaFileHash = $this->generateHash(20);
						$exists = $this->Data_file_sop->checkHash($namaFileHash);
					}
					$path_to_file = "./uploads/sop/$namePathOld";
					$res_delete = unlink($path_to_file);
					$res_upload = $this->uploadFile($namaFileHash);
					$res_update = $this->Data_file_sop->updateSop($id_sop, $judul_sop, $res_upload, $visibility, $kategori_sop);
					if($res_upload && $res_update){
						$this->session->set_flashdata('success', 'Berhasil melakukan update dokumen SOP!');
						redirect('/dokumen_sop');
					}
					else{
						if(!$res_upload){
							$this->session->set_flashdata('error', 'Gagal upload dokumen SOP ke server!');
							redirect('/dokumen_sop');
						}
						else{
							$this->session->set_flashdata('error', 'Gagal update SOP ke dalam database!');
							redirect('/dokumen_sop');
						}
					}
				}
				else{
					$res_update = $this->Data_file_sop->updateSop($id_sop, $judul_sop, NULL, $visibility, $kategori_sop);
					if($res_update){
						$this->session->set_flashdata('success', 'Berhasil melakukan update dokumen SOP!');
						redirect('/dokumen_sop');
					}
					else{
						$this->session->set_flashdata('success', 'Gagal melakukan update dokumen SOP!');
						redirect('/dokumen_sop');
					}
				}
			}

		}
		else{
			redirect('/');
		}
	}

	//Method untuk menghapus dokumen SOP
	function deleteSop(){
		if($this->session->userdata('logged_in')){
			$id_sop = $this->input->post('id_sop');
			if($id_sop == ""){
				$this->session->set_flashdata('error', 'Missing ID SOP!');
				redirect('/dokumen_sop');
			}
			$this->load->model('Data_file_sop');
			$path_file = $this->Data_file_sop->getPathFile($id_sop);

			$path_to_file = "./uploads/sop/$path_file";

			$res_delete = unlink($path_to_file);
			// // print_r($res_delete);
			// // return;
			// $res = true;
			$res = $this->Data_file_sop->deleteDokumenSop($id_sop);
			if($res && $res_delete){
				$this->session->set_flashdata('success', 'Berhasil menghapus dokumen SOP!');
				redirect('/dokumen_sop');
			}
			else{
				if(!$res_delete){
					$this->session->set_flashdata('error', 'Gagal menghapus dokumen SOP dari server!');
					redirect('/dokumen_sop');
				}
				else{
					$this->session->set_flashdata('error', 'Gagal menghapus dokumen SOP dari database!');
					redirect('/dokumen_sop');
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk menangani input dokumen SOP
	function inputDokumenSop(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('kategori_sop', 'Kategori SOP', 'required');
			$this->form_validation->set_rules('visibility', 'Visibility SOP', 'required');
			$this->form_validation->set_rules('judul_sop', 'Judul SOP', 'required');
			if(empty($_FILES['dokumen']['name'])){
				$this->session->set_flashdata('error_message', 'File dokumen SOP belum dilampirkan!');
	            redirect('/dokumen_sop');
			}
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Ada field belum lengkap!');
				redirect('/dokumen_sop');
			}
			else{
				$kategori_sop = htmlentities($this->input->post('kategori_sop'));
				$visibility = htmlentities($this->input->post('visibility'));
				$judul_sop = htmlentities($this->input->post('judul_sop'));
				$namaFileHash = $this->generateHash(20);
				$this->load->model('Data_file_sop');
				$exists = $this->Data_file_sop->checkHash($namaFileHash);
				while ($exists) {
					$namaFileHash = $this->generateHash(20);
					$exists = $this->Data_file_sop->checkHash($namaFileHash);
				}

				$res_upload = $this->uploadFile($namaFileHash);
				// print_r($res_upload);
				// return;
				$res_db = $this->Data_file_sop->inputDokumenSop($judul_sop, $kategori_sop, $visibility, $res_upload);
				if(($res_upload==true) && $res_db){
					$this->session->set_flashdata('success', 'Berhasil menambahkan dokumen SOP!');
					redirect('/dokumen_sop');
				}
				else{
					print_r($res_upload);
					return;
					if(!$res_upload){
						$this->session->set_flashdata('error', "$Gagal upload dokumen SOP");
						redirect('/dokumen_sop');
					}
					else{
						$this->session->set_flashdata('error', 'Gagal memasukkan SOP ke dalam database!');
						redirect('/dokumen_sop');
					}
				}
			}
		}
		else{
			redirect('/');
		}
	}

	private function uploadFile($fileName){
		$sNewFileName 				= $fileName;
		$config['file_name'] 			= $sNewFileName;
		$config['upload_path']          = './uploads/sop/';
		$config['allowed_types']        = 'pdf';
		$config['detect_mime']        	= 'TRUE';
		$config['max_size']             = 4056;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
				
		if ( ! $this->upload->do_upload('dokumen')){
			$error = array('error' => $this->upload->display_errors());
			return false;
		}
		else{
			return $sNewFileName. ".pdf";
		}
	}
	private function generateHash($jmlh_char){
		$sListKarakter = "12345678901234567890123456";
 		$sPanjangKarakter = strlen($sListKarakter);
  		$number = "";
  		for($i=0;$i<$jmlh_char;$i++){
    		$number .= $sListKarakter[rand(0,$sPanjangKarakter-1)];
  		}
  		return "$number";
	}
}
?>