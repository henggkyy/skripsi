<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani proses administrasi admin mulai dari proses input, jadwal, dsb.
class C_Admin extends CI_Controller {
	function updateJadwalBertugasAdmin(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_admin', 'ID Admin', 'required');
			$this->form_validation->set_rules('id_bertugas', 'ID Bertugas', 'required');
			$this->form_validation->set_rules('tgl_bertugas', 'Tanggal Bertugas', 'required');
			$this->form_validation->set_rules('jam_mulai', 'Jam Mulai Bertugas', 'required');
			$this->form_validation->set_rules('jam_selesai', 'Jam Selesai Bertugas', 'required');
			$id_admin = $this->input->post('id_admin');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required Field!');
	            redirect("admin_lab/detail?id_admin=$id_admin");
			}
			else{
				$this->load->model('Periode_akademik');
				$this->load->model('Jadwal_bertugas_admin');
				$id_bertugas = $this->input->post('id_bertugas');
				$tgl_bertugas = date("Y-m-d", strtotime($this->input->post('tgl_bertugas')));
				$jam_mulai = $this->input->post('jam_mulai');
				$jam_selesai = $this->input->post('jam_selesai');

				if($jam_mulai > $jam_selesai){
					$this->session->set_flashdata('error', 'Error! Jam mulai bertugas tidak boleh lebih besar dari jam selesai bertugas!');
	            	redirect("admin_lab/detail?id_admin=$id_admin");
				}
				$id_periode_aktif = $this->Periode_akademik->getIDPeriodeAktif();
				if($id_periode_aktif){
					$check_belongs_to_periode = $this->Jadwal_bertugas_admin->checkJadwalBertugas($id_bertugas, 'ID_PERIODE', $id_periode_aktif);
					if(!$check_belongs_to_periode){
						$this->session->set_flashdata('error', 'Tidak dapat melakukan update jadwal bertugas karena Jadwal Bertugas tidak pada periode akademik saat ini!');
						redirect("admin_lab/detail?id_admin=$id_admin");
					}
					$check_belongs_to_user = $this->Jadwal_bertugas_admin->checkJadwalBertugas($id_bertugas, 'ID_ADMIN', $id_admin);
					if(!$check_belongs_to_user){
						$this->session->set_flashdata('error', 'Tidak dapat melakukan update jadwal bertugas karena Jadwal Bertugas bukan milik Anda!');
						redirect("admin_lab/detail?id_admin=$id_admin");
					}

					$array_tanggal_akademik = $this->Periode_akademik->getTanggalAkademik($id_periode_aktif);
					$tgl_start_periode = $array_tanggal_akademik[0]['START_PERIODE'];
					$tgl_end_periode = $array_tanggal_akademik[0]['END_PERIODE'];
					$start_uts = $array_tanggal_akademik[0]['START_UTS'];
					$end_uts = $array_tanggal_akademik[0]['END_UTS'];
					$start_uas = $array_tanggal_akademik[0]['START_UAS'];
					$end_uas = $array_tanggal_akademik[0]['END_UAS'];

					$check_tgl_in_periode = $this->check_in_range($tgl_start_periode, $tgl_end_periode, $tgl_bertugas, 'full');
					// print_r($tgl_start_periode);
					// print_r($tgl_end_periode);
					// print_r($tgl_bertugas);
					// return;

					if(!$check_tgl_in_periode){
						$this->session->set_flashdata('error', 'Error! Tanggal yang diinput tidak berada dalam periode akademik yg sedang aktif.');
						redirect("admin_lab/detail?id_admin=$id_admin");
					}
					date_default_timezone_set('Asia/Jakarta');

					$check_perkuliahan_before_uts =  $this->check_in_range($tgl_start_periode, $start_uts, $tgl_bertugas, 'full_kiri');
					$check_perkuliahan_after_uts =  $this->check_in_range($end_uts, $start_uas, $tgl_bertugas, 'full_outer');
					$check_in_uts = $this->check_in_range($start_uts, $end_uts, $tgl_bertugas, 'full_inner');
					$check_in_uas = $this->check_in_range($start_uas, $end_uas, $tgl_bertugas, 'full_inner');
					$check_perkuliahan_after_uas =  $this->check_in_range($end_uts, $tgl_end_periode, $tgl_bertugas, 'full_kanan');
					if(!$check_in_uts && !$check_in_uas){
						$status = "Masa Perkuliahan";
					}
					else if($check_in_uts){
						$status = "Masa UTS";
					}
					else if($check_in_uas){
						$status = "Masa UAS";
					}

					$hari = $this->getDay($tgl_bertugas);
					$date_now = date("Y-m-d h:i:sa");
					$data = array(
						'HARI' => $hari,
						'TANGGAL' => $tgl_bertugas,
						'JAM_MULAI' => $jam_mulai,
						'JAM_SELESAI' => $jam_selesai,
						'TIPE_BERTUGAS' => $status,
						'INSERT_DATE' => $date_now
					);
					$this->load->model('Jadwal_bertugas_admin');
					$res = $this->Jadwal_bertugas_admin->updateJadwalBertugas($id_bertugas, $id_admin, $data);
					if($res){
						$this->session->set_flashdata('success', "Berhasil melakukan update jadwal bertugas admin!");
						redirect("admin_lab/detail?id_admin=$id_admin");
					}
					else{
						$this->session->set_flashdata('error', "Gagal melakukan update jadwal bertugas admin!");
						redirect("admin_lab/detail?id_admin=$id_admin");
					}

				}
				else{
					$this->session->set_flashdata('error', 'Tidak dapat melakukan update jadwal bertugas karena tidak terdapat periode akademik yg sedang aktif!');
					redirect("admin_lab/detail?id_admin=$id_admin");
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk mendapatkan jadwal bertugas admin secara individual.
	//Data dari method ini akan digunakan untuk update data admin
	//Method ini dipanggil dengan menggunakan Jquery AJAX pada footer di menu Detail Admin.
	function getIndividualJadwalAdmin(){
		if($this->session->userdata('logged_in')){
			$id_admin = $this->input->get('id_admin');
			$id_bertugas = $this->input->get('id_bertugas');
			if($id_admin != "" && $id_bertugas !=""){
				$this->load->model('Jadwal_bertugas_admin');
				$this->load->model('Periode_akademik');
				$id_periode_aktif = $this->Periode_akademik->getIDPeriodeAktif();
				if($id_periode_aktif){
					$check_belongs_to_periode = $this->Jadwal_bertugas_admin->checkJadwalBertugas($id_bertugas, 'ID_PERIODE', $id_periode_aktif);
					if(!$check_belongs_to_periode){
						echo "Tidak dapat menghapus tanggal bertugas karena Jadwal Bertugas tidak pada periode akademik saat ini!";
						return;
					}
					$check_belongs_to_user = $this->Jadwal_bertugas_admin->checkJadwalBertugas($id_bertugas, 'ID_ADMIN', $id_admin);
					if(!$check_belongs_to_user){
						echo "Tidak dapat menghapus tanggal bertugas karena Jadwal Bertugas bukan milik Anda!";
						return;
					}

					$data['data_jadwal'] = $this->Jadwal_bertugas_admin->getJadwalBertugasInd($id_bertugas, $id_admin);
					$data['id_admin'] = $id_admin;
					$string =  $this->load->view('pages_user/V_Template_Jadwal_Bertugas_Admin', $data, TRUE);
					echo $string;
					return;
				}
				else{
					echo "Tidak dapat melakukan update jadwal bertugas karena tidak terdapat periode akademik yg sedang aktif!";
					return;
				}
			}
			else{
				echo "Tidak dapat mengambil data karena tidak dapat menemukan ID Admin dan ID Bertugas!";
				return;
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk menghapus jadwal bertugas admin
	function deleteJadwalAdmin(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_admin', 'ID Admin', 'required');
			$this->form_validation->set_rules('id_bertugas', 'ID Bertugas', 'required');
			$id_admin = $this->input->post('id_admin');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required Field!');
	            redirect("admin_lab/detail?id_admin=$id_admin");
			}
			else{
				
				$id_bertugas = $this->input->post('id_bertugas');

				$this->load->model('Periode_akademik');
				$this->load->model('Jadwal_bertugas_admin');
				$id_periode_aktif = $this->Periode_akademik->getIDPeriodeAktif();
				if($id_periode_aktif){
					$check_belongs_to_periode = $this->Jadwal_bertugas_admin->checkJadwalBertugas($id_bertugas, 'ID_PERIODE', $id_periode_aktif);
					if(!$check_belongs_to_periode){
						$this->session->set_flashdata('error', 'Tidak dapat menghapus tanggal bertugas karena Jadwal Bertugas tidak pada periode akademik saat ini!');
						redirect("admin_lab/detail?id_admin=$id_admin");
					}
					$check_belongs_to_user = $this->Jadwal_bertugas_admin->checkJadwalBertugas($id_bertugas, 'ID_ADMIN', $id_admin);
					if(!$check_belongs_to_user){
						$this->session->set_flashdata('error', 'Tidak dapat menghapus tanggal bertugas karena Jadwal Bertugas bukan milik Anda!');
						redirect("admin_lab/detail?id_admin=$id_admin");
					}

					$res = $this->Jadwal_bertugas_admin->deleteJadwalBertugas($id_bertugas);
					if($res){
						$this->session->set_flashdata('success', "Berhasil menghapus jadwal bertugas admin!");
						redirect("admin_lab/detail?id_admin=$id_admin");
					}
					else{
						$this->session->set_flashdata('error', "Gagal menghapus jadwal bertugas admin!");
						redirect("admin_lab/detail?id_admin=$id_admin");
					}
				}
				else{
					$this->session->set_flashdata('error', 'Tidak dapat menghapus tanggal bertugas karena tidak terdapat periode akademik yg sedang aktif!');
					redirect("admin_lab/detail?id_admin=$id_admin");
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk memasukkan jadwal bertugas admin (auto)
	//Method ini secara otomatis melakukan generate tanggal berdasarkan hari yang diinput pengguna
	//Jadwal bertugas ini diluar jadwal bertugas pada saat uts dan uas
	function insertJadwalBertugasAuto(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_admin', 'ID Admin', 'required');
			$this->form_validation->set_rules('hari_bertugas[]', 'Hari Bertugas', 'required');
			$this->form_validation->set_rules('jam_mulai[]', 'Jam Mulai Bertugas', 'required');
			$this->form_validation->set_rules('jam_selesai[]', 'Jam Selesai Bertugas', 'required');
			$id_admin = $this->input->post('id_admin');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required Field!');
	            redirect("admin_lab/detail?id_admin=$id_admin");
			}
			else{
				//Validasi Jam Mulai tidak boleh lebih besar dari Jam Selesai
				$arr_hari_input = $this->input->post('hari_bertugas');
				$arr_jam_mulai = $this->input->post('jam_mulai');
				$arr_jam_selesai = $this->input->post('jam_selesai');

				$iterator = 0;
				$flag_input_error = false;
				$output_error_input = "Error!<br>";
				foreach ($arr_jam_mulai as $jam_mulai) {
					if($jam_mulai > $arr_jam_selesai[$iterator]){
						$flag_input_error = true;
						$jam_selesai_error = $arr_jam_selesai[$iterator];
						$hari_error = $arr_hari_input[$iterator];
						$output_error_input .= "Jam mulai lebih kecil daripada jam selesai! $hari_error $jam_mulai (Jam Mulai)  s/d $jam_selesai_error (Jam Selesai)<br>";
					}
					$iterator++;
				}
				if($flag_input_error){
					$this->session->set_flashdata('error', "$output_error_input");
		            redirect("admin_lab/detail?id_admin=$id_admin");
				}
				//Cek is admin
				$this->load->model('Users');
				$is_admin = $this->Users->checkUserRole($id_admin, 4);
				if(!$is_admin){
					$this->session->set_flashdata('error', 'Tidak dapat perbaharui masa kontrak karena ID User bukan Admin!');
					redirect('/admin_lab');
				}
				//Cek ada periode aktif atau tidak
				$this->load->model('Periode_akademik');
				$id_periode = $this->Periode_akademik->getIDPeriodeAktif();
				if($id_periode){

					$array_tanggal_akademik = $this->Periode_akademik->getTanggalAkademik($id_periode);
					$tgl_start_periode = $array_tanggal_akademik[0]['START_PERIODE'];
					$tgl_end_periode = $array_tanggal_akademik[0]['END_PERIODE'];
					$start_uts = $array_tanggal_akademik[0]['START_UTS'];
					$end_uts = $array_tanggal_akademik[0]['END_UTS'];
					$start_uas = $array_tanggal_akademik[0]['START_UAS'];
					$end_uas = $array_tanggal_akademik[0]['END_UAS'];
					
					$all_date_before_uts = $this->getAllDate($tgl_start_periode, $start_uts, $arr_hari_input, 'left_outer', 'before_uts');
					$all_date_after_uts = $this->getAllDate($end_uts, $start_uas, $arr_hari_input, 'left_outer', 'after_uts');
					$all_date_after_uas = $this->getAllDate($end_uas, $tgl_end_periode, $arr_hari_input, 'left_inner', 'after_uas');
					date_default_timezone_set('Asia/Jakarta');
					$date_now = date("Y-m-d h:i:sa");
					$arr_res = array();
					foreach ($all_date_before_uts as $date_uts) {
						$arr_ind = array();
						$arr_ind['HARI'] = $this->getDay($date_uts);
						$arr_ind['TANGGAL'] = $date_uts;
						$timestamp_date = strtotime($date_uts);
						$day = date('l', $timestamp_date);
						
						$index = array_search($day,$arr_hari_input);
						$arr_ind['JAM_MULAI'] = $arr_jam_mulai[$index];
						$arr_ind['JAM_SELESAI'] = $arr_jam_selesai[$index];
						$arr_ind['TIPE_BERTUGAS'] = "Masa Perkuliahan";
						$arr_ind['ID_PERIODE'] = $id_periode;
						$arr_ind['ID_ADMIN'] = $id_admin;
						$arr_ind['INSERT_DATE'] = $date_now;
						array_push($arr_res, $arr_ind);
						
					}
					foreach ($all_date_after_uts as $after_uts) {
						$arr_ind = array();
						$arr_ind['HARI'] = $this->getDay($after_uts);
						$arr_ind['TANGGAL'] = $after_uts;
						$timestamp_date = strtotime($after_uts);
						$day = date('l', $timestamp_date);
						
						$index = array_search($day,$arr_hari_input);
						$arr_ind['JAM_MULAI'] = $arr_jam_mulai[$index];
						$arr_ind['JAM_SELESAI'] = $arr_jam_selesai[$index];
						$arr_ind['TIPE_BERTUGAS'] = "Masa Perkuliahan";
						$arr_ind['ID_PERIODE'] = $id_periode;
						$arr_ind['ID_ADMIN'] = $id_admin;
						$arr_ind['INSERT_DATE'] = $date_now;
						array_push($arr_res, $arr_ind);
						
					}
					foreach ($all_date_after_uas as $after_uas) {
						$arr_ind = array();
						$arr_ind['HARI'] = $this->getDay($after_uas);
						$arr_ind['TANGGAL'] = $after_uas;
						$timestamp_date = strtotime($after_uas);
						$day = date('l', $timestamp_date);
						
						$index = array_search($day,$arr_hari_input);
						$arr_ind['JAM_MULAI'] = $arr_jam_mulai[$index];
						$arr_ind['JAM_SELESAI'] = $arr_jam_selesai[$index];
						$arr_ind['TIPE_BERTUGAS'] = "Masa Perkuliahan";
						$arr_ind['ID_PERIODE'] = $id_periode;
						$arr_ind['ID_ADMIN'] = $id_admin;
						$arr_ind['INSERT_DATE'] = $date_now;
						array_push($arr_res, $arr_ind);
						
					}
					$this->load->model('Jadwal_bertugas_admin');
					$res = $this->Jadwal_bertugas_admin->insertJadwalBertugasAuto($arr_res);
					if($res){
						$this->session->set_flashdata('success', "Berhasil memasukkan jadwal bertugas admin!");
						redirect("admin_lab/detail?id_admin=$id_admin");
					}
					else{
						$this->session->set_flashdata('error', "Gagal memasukkan jadwal bertugas admin!");
						redirect("admin_lab/detail?id_admin=$id_admin");
					}
				}
				else{
					$this->session->set_flashdata('error', 'Tidak dapat memasukkan tanggal bertugas karena tidak terdapat periode akademik yg sedang aktif!');
					redirect("admin_lab/detail?id_admin=$id_admin");
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk menangani input jadwal bertugas admin secara manual (Input tanggal satu per satu)
	function insertJadwalBertugasManual(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_admin', 'ID Admin', 'required');
			$this->form_validation->set_rules('tgl_bertugas', 'Tanggal Bertugas', 'required');
			$this->form_validation->set_rules('jam_mulai', 'Jam Mulai Bertugas', 'required');
			$this->form_validation->set_rules('jam_selesai', 'Jam Selesai Bertugas', 'required');
			$id_admin = $this->input->post('id_admin');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required Field!');
	            redirect("admin_lab/detail?id_admin=$id_admin");
			}
			else{
				$tgl_bertugas = date("Y-m-d", strtotime($this->input->post('tgl_bertugas')));
				$jam_mulai = $this->input->post('jam_mulai');
				$jam_selesai = $this->input->post('jam_selesai');

				if($jam_mulai > $jam_selesai){
					$this->session->set_flashdata('error', 'Jam mulai bertugas tidak boleh lebih besar dari jam selesai bertugas!');
	            	redirect("admin_lab/detail?id_admin=$id_admin");
				}
				$this->load->model('Users');
				$is_admin = $this->Users->checkUserRole($id_admin, 4);
				if(!$is_admin){
					$this->session->set_flashdata('error', 'Tidak dapat memasukkan jadwal bertugas karena ID User bukan Admin!');
					redirect('/admin_lab');
				}

				$this->load->model('Periode_akademik');
				$id_periode = $this->Periode_akademik->getIDPeriodeAktif();
				if($id_periode){
					$array_tanggal_akademik = $this->Periode_akademik->getTanggalAkademik($id_periode);
					$tgl_start_periode = $array_tanggal_akademik[0]['START_PERIODE'];
					$tgl_end_periode = $array_tanggal_akademik[0]['END_PERIODE'];
					$start_uts = $array_tanggal_akademik[0]['START_UTS'];
					$end_uts = $array_tanggal_akademik[0]['END_UTS'];
					$start_uas = $array_tanggal_akademik[0]['START_UAS'];
					$end_uas = $array_tanggal_akademik[0]['END_UAS'];

					$check_tgl_in_periode = $this->check_in_range($tgl_start_periode, $tgl_end_periode, $tgl_bertugas, 'full');
					
					if(!$check_tgl_in_periode){
						$this->session->set_flashdata('error', 'Error! Tanggal yang diinput tidak berada dalam periode akademik yg sedang aktif.');
						redirect("admin_lab/detail?id_admin=$id_admin");
					}
					date_default_timezone_set('Asia/Jakarta');

					$check_perkuliahan_before_uts =  $this->check_in_range($tgl_start_periode, $start_uts, $tgl_bertugas, 'full_kiri');
					$check_perkuliahan_after_uts =  $this->check_in_range($end_uts, $start_uas, $tgl_bertugas, 'full_outer');
					$check_in_uts = $this->check_in_range($start_uts, $end_uts, $tgl_bertugas, 'full_inner');
					$check_in_uas = $this->check_in_range($start_uas, $end_uas, $tgl_bertugas, 'full_inner');
					$check_perkuliahan_after_uas =  $this->check_in_range($end_uts, $tgl_end_periode, $tgl_bertugas, 'full_kanan');
					if(!$check_in_uts && !$check_in_uas){
						$status = "Masa Perkuliahan";
					}
					else if($check_in_uts){
						$status = "Masa UTS";
					}
					else if($check_in_uas){
						$status = "Masa UAS";
					}

					$hari = $this->getDay($tgl_bertugas);
					$date_now = date("Y-m-d h:i:sa");
					$data = array(
						'HARI' => $hari,
						'TANGGAL' => $tgl_bertugas,
						'JAM_MULAI' => $jam_mulai,
						'JAM_SELESAI' => $jam_selesai,
						'TIPE_BERTUGAS' => $status,
						'ID_PERIODE' => $id_periode,
						'ID_ADMIN' => $id_admin,
						'INSERT_DATE' => $date_now
					);
					$this->load->model('Jadwal_bertugas_admin');
					$res = $this->Jadwal_bertugas_admin->insertJadwalBertugasManual($data);
					if($res){
						$this->session->set_flashdata('success', "Berhasil memasukkan jadwal bertugas admin!");
						redirect("admin_lab/detail?id_admin=$id_admin");
					}
					else{
						$this->session->set_flashdata('error', "Gagal memasukkan jadwal bertugas admin!");
						redirect("admin_lab/detail?id_admin=$id_admin");
					}
				}
				else{
					$this->session->set_flashdata('error', 'Tidak dapat memasukkan tanggal bertugas karena tidak terdapat periode akademik yg sedang aktif!');
					redirect("admin_lab/detail?id_admin=$id_admin");
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk memperbaharui masa kontrak admin
	function updateMasaKontrak(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_admin', 'ID Admin', 'required');
			$this->form_validation->set_rules('mulai_kontrak', 'Tanggal Mulai Kontrak', 'required');
			$this->form_validation->set_rules('akhir_kontrak', 'Tanggal Berakhir Kontrak', 'required');
			$id_admin = $this->input->post('id_admin');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required Field!');
	            redirect("admin_lab/detail?id_admin=$id_admin");
			}
			else{
				$tgl_awal = date("Y-m-d", strtotime($this->input->post('mulai_kontrak')));
				$tgl_akhir = date("Y-m-d", strtotime($this->input->post('akhir_kontrak')));
				$this->load->model('Users');
				$is_admin = $this->Users->checkUserRole($id_admin, 4);
				if(!$is_admin){
					$this->session->set_flashdata('error', 'Tidak dapat perbaharui masa kontrak karena ID User bukan Admin!');
					redirect('/admin_lab');
				}
				if($tgl_awal >= $tgl_akhir){
					$this->session->set_flashdata('error', 'Error! Tanggal mulai kontrak tidak boleh lebih besar dari tanggal berakhir kontrak');
	            	redirect("admin_lab/detail?id_admin=$id_admin");
				}
				$this->load->model('Detail_user');
				$res = $this->Detail_user->updateKontrakAdmin($id_admin, $tgl_awal, $tgl_akhir);
				if($res){
					$this->session->set_flashdata('success', 'Berhasil memperbaharui periode kontrak!');
	           	 	redirect("admin_lab/detail?id_admin=$id_admin");
				}
				else{
					$this->session->set_flashdata('error', 'Gagal memperbaharui periode kontrak!');
	           	 	redirect("admin_lab/detail?id_admin=$id_admin");
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk load halaman detail admin
	function loadDetailAdmin(){
		if($this->session->userdata('logged_in')){
			$id_admin = $this->input->get('id_admin');

			if($id_admin != ""){

				$this->load->model('Detail_user');
				$this->load->model('Users');
				$is_admin = $this->Users->checkUserRole($id_admin, 4);
				if(!$is_admin){
					$this->session->set_flashdata('error', 'Data admin tidak ditemukan!');
					redirect('/admin_lab');
				}
				$data['title'] = 'Detail Admin Laboratorium | SI Akademik Lab. Komputasi TIF UNPAR';
				$this->load->model('Periode_akademik');
				$this->load->model('Jadwal_bertugas_admin');
				$data['detail_admin'] = true;
				$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();
				$data['daftar_periode'] = $this->Periode_akademik->getAllPeriode();
				$data['data_admin'] = $this->Detail_user->getDataAdmin($id_admin);
				$data['nama_admin'] = $this->Users->getIndividualItem($id_admin, 'NAMA');
				$data['id_admin'] = $this->Users->getIndividualItem($id_admin, 'ID');
				$id_periode = $this->Periode_akademik->getIDPeriodeAktif();
				$flag = true;
				if(isset($_GET['id_periode'])){
					$id_periode_selected = $_GET['id_periode'];
					if($id_periode_selected != ""){
						$data['jadwal_admin'] = $this->Jadwal_bertugas_admin->getJadwalBertugas($data['id_admin'], $id_periode_selected);
						$data['id_periode_aktif'] = $id_periode_selected;
					}
					if($id_periode_selected != $id_periode){
						$flag = false;
					}
				}
				else{
					$data['id_periode_aktif'] = $id_periode;
					$data['jadwal_admin'] = $this->Jadwal_bertugas_admin->getJadwalBertugas($data['id_admin'], $id_periode);
				}
				$data['flag'] = $flag; 
				$data_json = array();
				if(isset($data['jadwal_admin']) && $data['jadwal_admin']){
					foreach ($data['jadwal_admin'] as $jadwal) {
						$arr_ind = array();
						$arr_ind['start'] = $jadwal['TANGGAL']." ". $jadwal['JAM_MULAI'];
						$arr_ind['end'] = $jadwal['TANGGAL']." ". $jadwal['JAM_SELESAI'];
						$arr_ind['title'] = "Bertugas (".$jadwal['TIPE_BERTUGAS'].")";
						$arr_ind['backgroundColor'] = 'blue';
						array_push($data_json, $arr_ind);
					}
				}
				
				$data['jadwal_json'] = json_encode($data_json);
				$this->load->view('template/Header', $data);
				$this->load->view('template/Sidebar', $data);
				$this->load->view('template/Topbar');
				$this->load->view('template/Notification');
				$this->load->view('pages_user/V_Detail_Admin', $data);
				$this->load->view('template/Footer');
			}
			else{
				redirect('/admin_lab');
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk mengaktifkan kembali admin
	function activateAdmin(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_admin', 'ID Admin', 'required');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required Field!');
	            redirect('/admin_lab');
			}
			else{
				$id_admin = $this->input->post('id_admin');
				$this->load->model('Users');
				$res_update = $this->Users->changeStatus($id_admin, 1);
				if($res_update){
					$this->session->set_flashdata('success', 'Berhasil mengakifkan kembali Admin.');
					redirect('/admin_lab');
				}
				else{
					$this->session->set_flashdata('error', 'Gagal mengakifkan kembali Admin.');
					redirect('/admin_lab');
				}
			}
		}
		else{
			redirect('/');
		}
	}

	//Method untuk menonaktifkan admin
	function nonactivateAdmin(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_admin', 'ID Admin', 'required');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required Field!');
	            redirect('/admin_lab');
			}
			else{
				$id_admin = $this->input->post('id_admin');
				$this->load->model('Users');
				$res_update = $this->Users->changeStatus($id_admin, 0);
				if($res_update){
					$this->session->set_flashdata('success', 'Berhasil menonaktifkan Admin.');
					redirect('/admin_lab');
				}
				else{
					$this->session->set_flashdata('error', 'Gagal menonaktifkan Admin.');
					redirect('/admin_lab');
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk memasukkan data admin
	function insertAdmin(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('nik', 'NIK Admin', 'required');
			$this->form_validation->set_rules('nama', 'Nama Admin', 'required');
			$this->form_validation->set_rules('email', 'Email Admin', 'required');
			$this->form_validation->set_rules('angkatan', 'Angkatan Admin', 'required');
			$this->form_validation->set_rules('awal_kontrak', 'Awal Kontrak Admin', 'required');
			$this->form_validation->set_rules('akhir_kontrak', 'Akhir Kontrak Admin', 'required');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error_message', 'Missing required Field!');
	            redirect('/admin_lab');
			}
			else{
				$nik = $this->input->post('nik');
				$nama = $this->input->post('nama');
				$email = $this->input->post('email');
				$angkatan = $this->input->post('angkatan');
				$awal_kontrak = $this->input->post('awal_kontrak');
				$akhir_kontrak = $this->input->post('akhir_kontrak');
				$awal_kontrak = date("Y-m-d", strtotime($awal_kontrak));
				$akhir_kontrak = date("Y-m-d", strtotime($akhir_kontrak));
				$this->load->model('Users');
				$inserted_id = $this->Users->addUser(4, $nama, $email, $nik, 0);
				if($inserted_id){
					$this->load->model('Detail_user');
					$insert_detail = $this->Detail_user->insertDetailUser($inserted_id, $angkatan, $awal_kontrak, $akhir_kontrak);
					if($insert_detail){
						$this->session->set_flashdata('success', 'Berhasil memasukkan data admin laboratorium!');
						redirect('/admin_lab');
					}
					else{
						$this->session->set_flashdata('error', 'Gagal memasukkan detail data admin laboratorium!');
						redirect('/admin_lab');
					}
				}
				else{
					$this->session->set_flashdata('error', 'Gagal memasukkan data admin laboratorium!');
					redirect('/admin_lab');
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk melakukan generate seluruh tanggal berdasarkan hari yang dipilih oleh user
	//Method ini digunakan dalam insert jadwal bertugas auto
	private function getAllDate($date_start, $date_end, $day, $method, $type){
		$date_start_time = strtotime($date_start);
	    $date_end_time   = strtotime($date_end);
	    $dates = array();
	    if($type == 'after_uts' || $type == 'after_uas'){
	    	$date_start_time = strtotime('+1 day', $date_start_time);
	    }
	    if($method == 'left_inner'){
	    	while ($date_start_time <= $date_end_time) {
		        if (in_array(date('l', $date_start_time), $day)) {
		           $dates[] = date('Y-m-d', $date_start_time);
		        }
		        $date_start_time = strtotime('+1 day', $date_start_time);
		    }
	    }
	    else if($method == 'left_outer'){
	    	while ($date_start_time < $date_end_time) {
		        if (in_array(date('l', $date_start_time), $day)) {
		           $dates[] = date('Y-m-d', $date_start_time);
		        }
		        $date_start_time = strtotime('+1 day', $date_start_time);
		    }
	    }
	    
	    return $dates;
	}

	//Method untuk mendapatkan nama hari dari tanggal yang dipilih user
	private function getDay($date){
		date_default_timezone_set('Asia/Jakarta');
		$day = array ( 1 =>    'Senin',
			'Selasa',
			'Rabu',
			'Kamis',
			'Jumat',
			'Sabtu',
			'Minggu'
		);
		$day_num = date('N', strtotime($date)); 
		return $day[$day_num];
	}

	//Method untuk melakukan pengecekan range tanggal yang dipilih user berada dalam periode uts/uas/kuliah
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