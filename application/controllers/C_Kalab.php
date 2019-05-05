<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani operasi terkait pengguna Kepala Laboratorium
class C_Kalab extends CI_Controller {
	//Constructor Controller
	function __construct() {
        parent::__construct();
        $this->load->library('google');
    }
	//Method untuk mengubah status Kepala Laboratorium
	function changeKalab(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role')!= 1){
				redirect('dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('dosen', 'ID Dosen', 'required');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required Field!');
				redirect('/kalab');
			}
			else{
				$this->load->model('Users');
				$dosen = $this->input->post('dosen');
				$is_dosen = $this->Users->checkUserIsDosen($dosen);
				if(!$is_dosen){
					$this->session->set_flashdata('error', 'Error! Kepala Laboratorium harus memiliki status sebelumnya sebagai Dosen');
					redirect('/kalab');
				}

				$data_update_as_dosen = array(
					'ID_ROLE' => 2
				);
				$data_update_as_kalab = array(
					'ID_ROLE' => 1
				);
				$update_kalab = $this->Users->changeRole($dosen, $data_update_as_kalab);
				$update_dosen = $this->Users->changeRole($this->session->userdata('id'), $data_update_as_dosen);
				if($update_kalab && $update_dosen){
					$this->session->set_flashdata('message', 'Berhasil mengubah Kepala Laboratorium! Anda dapat login kembali kedalam sistem sebagai Dosen!');
					$this->session->unset_userdata('logged_in');
					$this->session->unset_userdata('id');
					$this->session->unset_userdata('id_role');
					$this->session->unset_userdata('email');
					$this->session->unset_userdata('nama');
					$this->session->unset_userdata('nama_role');
					$this->google->revokeToken();
					redirect('/');
				}
				else{
					if(!$update_kalab){
						$this->session->set_flashdata('error', 'Error! Gagal mengubah status Dosen menjadi Kepala Laboratorium');
						redirect('/kalab');
					}
					else{
						$this->session->set_flashdata('error', 'Error! Gagal mengubah status Kepala Laboratorium menjadi Dosen');
						redirect('/kalab');
					}
				}
			}
		}
		else{
			redirect('/');
		}
	}
}
?>