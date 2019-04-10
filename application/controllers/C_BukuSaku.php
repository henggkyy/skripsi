<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani proses input, update, dan delete mengenai dokumen Buku Saku
class C_BukuSaku extends CI_Controller {

	//Method untuk melakukan update dokumen Buku Saku
	function updateBukuSaku(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 4){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('visibility', 'Visibility Buku Saku', 'required');
			$this->form_validation->set_rules('judul_saku', 'Judul Buku Saku', 'required');
			$this->form_validation->set_rules('id_saku', 'ID Buku Saku', 'required');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error_message', 'Missing required Field!');
	            redirect('/dokumen_saku');
			}
			else{
				$visibility = htmlentities($this->input->post('visibility'));
				$judul_saku = htmlentities($this->input->post('judul_saku'));
				$id_saku = $this->input->post('id_saku');
				$this->load->model('Data_buku_saku');
				if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 4){
					$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
					redirect('/dashboard');
				}
				// print_r($_FILES['dokumen']['name']);
				// return;
				if(!empty($_FILES['dokumen']['name'])){
					$namePathOld = $this->Data_buku_saku->getPathFile($id_saku);
					$nama_file_real = $_FILES['dokumen']['name'];
					$ext = pathinfo($nama_file_real, PATHINFO_EXTENSION);
					$namaFileHash = $this->generateHash(20).'.'.$ext;
					$exists = $this->Data_buku_saku->checkHash($namaFileHash);
					while ($exists) {
						$namaFileHash = $this->generateHash(20).'.'.$ext;
						$exists = $this->Data_buku_saku->checkHash($namaFileHash);
					}
					$path_to_file = "./uploads/buku_saku/$namePathOld";
					$res_delete = unlink($path_to_file);
					$res_upload = $this->uploadFile($namaFileHash);
					$res_update = $this->Data_buku_saku->updateBukuSaku($id_saku, $judul_saku, $res_upload, $visibility);
					if($res_upload && $res_update){
						$this->session->set_flashdata('success', 'Berhasil melakukan update dokumen Buku Saku!');
						redirect('/dokumen_saku');
					}
					else{
						if(!$res_upload){
							$this->session->set_flashdata('error', 'Gagal upload dokumen Buku Saku ke server!');
							redirect('/dokumen_saku');
						}
						else{
							$this->session->set_flashdata('error', 'Gagal update Buku Saku ke dalam database!');
							redirect('/dokumen_saku');
						}
					}
				}
				else{
					$res_update = $this->Data_buku_saku->updateBukuSaku($id_saku, $judul_saku, NULL, $visibility);
					if($res_update){
						$this->session->set_flashdata('success', 'Berhasil melakukan update dokumen Buku Saku!');
						redirect('/dokumen_saku');
					}
					else{
						$this->session->set_flashdata('success', 'Gagal melakukan update dokumen Buku Saku!');
						redirect('/dokumen_saku');
					}
				}
			}

		}
		else{
			redirect('/');
		}
	}

	//Method untuk menghapus dokumen Buku Saku
	function deleteBukuSaku(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 4){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
			$id_saku = $this->input->post('id_saku');
			if($id_saku == ""){
				$this->session->set_flashdata('error', 'Missing ID Buku Saku!');
				redirect('/dokumen_saku');
			}
			if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 4){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
			$this->load->model('Data_buku_saku');
			$path_file = $this->Data_buku_saku->getPathFile($id_saku);

			$path_to_file = "./uploads/buku_saku/$path_file";

			$res_delete = unlink($path_to_file);
			// // print_r($res_delete);
			// // return;
			// $res = true;
			$res = $this->Data_buku_saku->deleteDokumenBukuSaku($id_saku);
			if($res && $res_delete){
				$this->session->set_flashdata('success', 'Berhasil menghapus dokumen Buku Saku!');
				redirect('/dokumen_saku');
			}
			else{
				if(!$res_delete){
					$this->session->set_flashdata('error', 'Gagal menghapus dokumen Buku Saku dari server!');
					redirect('/dokumen_saku');
				}
				else{
					$this->session->set_flashdata('error', 'Gagal menghapus dokumen Buku Saku dari database!');
					redirect('/dokumen_saku');
				}
			}
		}
		else{
			redirect('/');
		}
	}

	//Method untuk menangani input dokumen Buku Saku
	function inputBukuSaku(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 4){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('visibility', 'Visibility Buku Saku', 'required');
			$this->form_validation->set_rules('judul_saku', 'Judul Buku Saku', 'required');
			if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 4){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
			if(empty($_FILES['dokumen']['name'])){
				$this->session->set_flashdata('error_message', 'File dokumen Buku Saku belum dilampirkan!');
	            redirect('/dokumen_saku');
			}
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Ada field belum lengkap!');
				redirect('/dokumen_saku');
			}
			else{
				$visibility = htmlentities($this->input->post('visibility'));
				$judul_saku = htmlentities($this->input->post('judul_saku'));
				
				
				$this->load->model('Data_buku_saku');
				$nama_file_real = $_FILES['dokumen']['name'];
				$ext = pathinfo($nama_file_real, PATHINFO_EXTENSION);
				$namaFileHash = $this->generateHash(20).'.'.$ext;
				$exists = $this->Data_buku_saku->checkHash($namaFileHash);
				while ($exists) {
					$namaFileHash = $this->generateHash(20).'.'.$ext;
					$exists = $this->Data_buku_saku->checkHash($namaFileHash);
				}

				$res_upload = $this->uploadFile($namaFileHash);
				// print_r($res_upload);
				// return;
				$res_db = $this->Data_buku_saku->inputDokumenSaku($judul_saku, $visibility, $res_upload);
				if(($res_upload==true) && $res_db){
					$this->session->set_flashdata('success', 'Berhasil menambahkan dokumen SOP!');
					redirect('/dokumen_saku');
				}
				else{
					
					if(!$res_upload){
						$this->session->set_flashdata('error', "Gagal upload dokumen SOP");
						redirect('/dokumen_saku');
					}
					else{
						$this->session->set_flashdata('error', 'Gagal memasukkan SOP ke dalam database!');
						redirect('/dokumen_saku');
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
		$config['upload_path']          = './uploads/buku_saku/';
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
			return $sNewFileName;
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