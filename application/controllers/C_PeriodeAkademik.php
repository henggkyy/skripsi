<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_PeriodeAkademik extends CI_Controller{

	//Method untuk melakukan nonaktif periode akademik
	function nonaktifkanPeriode(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') == 1 || $this->session->userdata('id_role') == 3){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('id_periode', 'ID Periode Akademik', 'required');
				if ($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('error', 'ID Periode Akademik tidak ditemukan!');
					redirect('/periode_akademik');
				}
				else{
					$id_periode = $this->input->post('id_periode');
					$this->load->model('Periode_akademik');
					$res = $this->Periode_akademik->nonaktifkanPeriode($id_periode);
					if($res){
						$this->session->set_flashdata('success', 'Berhasil menonaktifkan Periode Akademik.');
						redirect('/periode_akademik');
					}
					else{
						$this->session->set_flashdata('error', 'Gagal menonaktifkan Periode Akademik.');
						redirect('/periode_akademik');
					}
				}
			}
			else{
				redirect('/dashboard');
			}
		}
		else{
			redirect('/');
		}
	}

	//Method untuk mengaktifkan periode akademik
	function aktifkanPeriodeAkademik(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') == 1 || $this->session->userdata('id_role') == 3){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('nama_periode', 'Nama Periode Akademik', 'required');
				$this->form_validation->set_rules('start_periode', 'Tanggal Periode Awal', 'required');
				$this->form_validation->set_rules('end_periode', 'Tanggal Periode Akhir', 'required');
				$this->form_validation->set_rules('start_uts', 'Tanggal Mulai UTS', 'required');
				$this->form_validation->set_rules('end_uts', 'Tanggal Akhir UTS', 'required');
				$this->form_validation->set_rules('start_uas', 'Tanggal Mulai UAS', 'required');
				$this->form_validation->set_rules('end_uas', 'Tanggal Akhir UAS', 'required');
				if ($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('error_form', 'Missing required fields!');
					redirect('/periode_akademik');
				}
				else{
					$this->load->model('Periode_akademik');
					$check_periode_aktif = $this->Periode_akademik->checkPeriodeAktif();
					if($check_periode_aktif){
						$this->session->set_flashdata('error', 'Tidak dapat set Periode Akademik. Masih ada Periode Akademik sdg Aktif');
						redirect('/periode_akademik');
					}
					else{
						$nama_periode = $this->input->post('nama_periode');

						$start_periode = date("Y-m-d", strtotime($this->input->post('start_periode')));
						$end_periode = date("Y-m-d", strtotime($this->input->post('end_periode')));
						if(strtotime($start_periode) > strtotime($end_periode)){
							$this->session->set_flashdata('error', 'Error! Tanggal mulai periode akademik lebih besar dibandingkan dengan tanggal selesai!');
							redirect('/periode_akademik');
						}

						$start_uts = date("Y-m-d", strtotime($this->input->post('start_uts')));
						$end_uts = date("Y-m-d", strtotime($this->input->post('end_uts')));
						if(strtotime($start_uts) > strtotime($end_uts)){
							$this->session->set_flashdata('error', 'Error! Tanggal mulai periode UTS lebih besar dibandingkan dengan tanggal selesai!');
							redirect('/periode_akademik');
						}

						$check_start_uts = $this->check_in_range($start_periode, $end_periode, $start_uts, 'full');
						$check_end_uts = $this->check_in_range($start_periode, $end_periode, $end_uts, 'full');
						if(!$check_start_uts || !$check_end_uts){
							$this->session->set_flashdata('error', 'Error! Tanggal periode UTS tidak berada dalam tanggal periode akademik!');
							redirect('/periode_akademik');
						}

						$start_uas = date("Y-m-d", strtotime($this->input->post('start_uas')));
						$end_uas = date("Y-m-d", strtotime($this->input->post('end_uas')));
						if(strtotime($start_uas) > strtotime($end_uas)){
							$this->session->set_flashdata('error', 'Error! Tanggal mulai periode UAS lebih besar dibandingkan dengan tanggal selesai!');
							redirect('/periode_akademik');
						}

						$check_start_uas = $this->check_in_range($start_periode, $end_periode, $start_uas, 'full');
						$check_end_uas = $this->check_in_range($start_periode, $end_periode, $end_uas, 'full');
						if(!$check_start_uas || !$check_end_uas){
							$this->session->set_flashdata('error', 'Error! Tanggal periode UAS tidak berada dalam tanggal periode akademik!');
							redirect('/periode_akademik');
						}

						$res = $this->Periode_akademik->insertPeriode($nama_periode, $start_periode, $end_periode, $start_uts, $end_uts, $start_uas, $end_uas);
						if($res){
							$this->session->set_flashdata('success', 'Berhasil menambahkan Periode Akademik.');
							redirect('/periode_akademik');
						}
						else{
							$this->session->set_flashdata('error', 'Gagal menambahkan Periode Akademik.');
							redirect('/periode_akademik');
						}
					}
				}
			}
			else{
				redirect('/dashboard');
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk melakukan pengecekan range tanggal yang dipilih user apakah berada dalam periode akademik yg dipilih atau tidak.
	private function check_in_range($start_date, $end_date, $date_from_user, $tipe){
		
		$start_ts = strtotime($start_date);
		$end_ts = strtotime($end_date);
		$user_ts = strtotime($date_from_user);

		if($tipe == 'full_kiri'){
			return (($user_ts >= $start_ts) && ($user_ts < $end_ts));
		}
		else if($tipe == 'full_kanan'){
			return (($user_ts > $start_ts) && ($user_ts <= $end_ts));
		}
		else if($tipe == 'full_outer'){
			return (($user_ts > $start_ts) && ($user_ts < $end_ts));
		}
		else{
			return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
		}
	}
}
?>