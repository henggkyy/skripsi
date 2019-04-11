<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani proses administrasi admin mulai dari proses input, jadwal, dsb.
class C_Admin extends CI_Controller {
	//Method untuk melakukan load rekapitulasi jadwal pengajuan yang dilakukan oleh admin
	function loadRekapitulasiPengajuanJadwal(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role')!= 1){
				redirect('dashboard');
			}
			$data['title'] = 'Rekapitulasi Pengajuan Jadwal Bertugas | SI Operasional Lab. Komputasi TIF UNPAR';
			$this->load->model('Periode_akademik');
			$data['daftar_periode'] = $this->Periode_akademik->getAllPeriode();
			$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();
			$id_periode = $this->Periode_akademik->getIDPeriodeAktif();
			if(isset($_GET['id_periode'])){
				$id_periode_selected = $_GET['id_periode'];
				if($id_periode_selected != ""){
					if($id_periode_selected == $id_periode){
						$data['flag'] = true;
					}
					else{
						$data['flag'] = false;
					}
					$data['id_periode_aktif'] = $id_periode_selected;
				}
				else{
					$id_periode = $this->Periode_akademik->getIDPeriodeAktif(); 
					$data['id_periode_aktif'] = $id_periode;
					$data['flag'] = true;
				}
			}
			else{
				if(!$id_periode){
					$data['id_periode_aktif'] = $this->Periode_akademik->getLastActiveId();
					$data['flag'] = false;
				}
				else{
					$data['id_periode_aktif'] = $id_periode;
					$data['flag'] = true;
				}
			}
			$this->load->model('Pengajuan_jadwal_bertugas');
			$data['pengajuan_kuliah'] = $this->Pengajuan_jadwal_bertugas->getDataPengajuanByPeriode($data['id_periode_aktif'] ,0);
			$data['pengajuan_uts'] = $this->Pengajuan_jadwal_bertugas->getDataPengajuanByPeriode($data['id_periode_aktif'] ,1);
			$data['pengajuan_uas'] = $this->Pengajuan_jadwal_bertugas->getDataPengajuanByPeriode($data['id_periode_aktif'] ,2);
			$this->load->view('template/Header', $data);
			$this->load->view('template/Sidebar', $data);
			$this->load->view('template/Topbar');
			$this->load->view('template/Notification');
			$this->load->view('pages_user/V_Rekapitulasi_Pengajuan_Jadwal', $data);
			$this->load->view('template/Footer');
		}
		else{
			redirect('/');
		}
	}
	//Method untuk melakukan accept jadwal pengajuan bertugas pada masa ujian
	function acceptJadwalMasaUjian(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role')!= 1){
				redirect('dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_pengajuan', 'ID Pengajuan', 'required');
			$this->form_validation->set_rules('id_admin', 'ID Admin', 'required');
			$id_admin = $this->input->post('id_admin');
			$rekap = false;
			if(isset($_POST['method'])){
				$rekap = true;
			}
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required Field!');
				if($rekap){
					redirect("rekapitulasi_pengajuan");
				}
	            redirect("admin_lab/detail?id_admin=$id_admin");
			}
			else{
				$this->load->model('Pengajuan_jadwal_bertugas');
				$id_pengajuan = $this->input->post('id_pengajuan');
				$this->load->model('Periode_akademik');
				$id_periode = $this->Periode_akademik->getIDPeriodeAktif();
				
				if($id_periode){
					$array_data_pengajuan = $this->Pengajuan_jadwal_bertugas->getDataPengajuanById($id_pengajuan, $id_admin, $id_periode);
					if(!$array_data_pengajuan){
						$this->session->set_flashdata('error', 'Error! Data Pengajuan tidak ditemukan!');
						if($rekap){
							redirect("rekapitulasi_pengajuan");
						}
	            		redirect("admin_lab/detail?id_admin=$id_admin");
					}
					$tgl_bertugas = $array_data_pengajuan[0]['TANGGAL'];
					$jam_mulai = $array_data_pengajuan[0]['JAM_MULAI'];
					$jam_selesai = $array_data_pengajuan[0]['JAM_SELESAI'];
					//Get data tanggal periode akademik
					$array_tanggal_akademik = $this->Periode_akademik->getTanggalAkademik($id_periode);
					$start_uts = $array_tanggal_akademik[0]['START_UTS'];
					$end_uts = $array_tanggal_akademik[0]['END_UTS'];
					$start_uas = $array_tanggal_akademik[0]['START_UAS'];
					$end_uas = $array_tanggal_akademik[0]['END_UAS'];

					date_default_timezone_set('Asia/Jakarta');

					$check_in_uts = $this->check_in_range($start_uts, $end_uts, $tgl_bertugas, 'full_inner');
					$check_in_uas = $this->check_in_range($start_uas, $end_uas, $tgl_bertugas, 'full_inner');
					
					if($check_in_uts){
						$status = "Masa UTS";
					}
					else if($check_in_uas){
						$status = "Masa UAS";
					}
					// print_r($check_in_uts);
					// return;
					$hari = $array_data_pengajuan[0]['HARI'];
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
					$data_update = array(
						'STATUS' => 1,
						'DATE_SUBMITTED' => $date_now
					);
					$res_update = $this->Pengajuan_jadwal_bertugas->updateStatus($id_pengajuan, $data_update);
					$res = $this->Jadwal_bertugas_admin->insertJadwalBertugasManual($data);
					if($res){
						$this->session->set_flashdata('success', "Berhasil memasukkan jadwal bertugas admin!");
						if($rekap){
							redirect("rekapitulasi_pengajuan");
						}
						redirect("admin_lab/detail?id_admin=$id_admin");
					}
					else{
						$this->session->set_flashdata('error', "Gagal memasukkan jadwal bertugas admin!");
						if($rekap){
							redirect("rekapitulasi_pengajuan");
						}
						redirect("admin_lab/detail?id_admin=$id_admin");
					}
				}
				else{
					$this->session->set_flashdata('error', 'Tidak dapat memasukkan tanggal bertugas karena tidak terdapat periode akademik yg sedang aktif!');
					if($rekap){
						redirect("rekapitulasi_pengajuan");
					}
					redirect("admin_lab/detail?id_admin=$id_admin");
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk melakukan accept jadwal pengajuan bertugas yang diinput oleh admin pada masa kuliah
	function acceptJadwalMasaKuliah(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role')!= 1){
				redirect('dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_pengajuan', 'ID Pengajuan', 'required');
			$this->form_validation->set_rules('id_admin', 'ID Admin', 'required');
			$id_admin = $this->input->post('id_admin');
			if(isset($_POST['method'])){
				$rekap = true;
			}
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required Field!');
				if($rekap){
					redirect("rekapitulasi_pengajuan");
				}
	            redirect("admin_lab/detail?id_admin=$id_admin");
			}
			else{
				$this->load->model('Pengajuan_jadwal_bertugas');
				$id_pengajuan = $this->input->post('id_pengajuan');
				
				//Cek ada periode aktif atau tidak
				$this->load->model('Periode_akademik');
				$id_periode = $this->Periode_akademik->getIDPeriodeAktif();
				if(!$id_periode){
					$this->session->set_flashdata('error', 'Tidak dapat memasukkan tanggal bertugas karena tidak terdapat periode akademik yg sedang aktif!');
					if($rekap){
						redirect("rekapitulasi_pengajuan");
					}
					redirect("admin_lab/detail?id_admin=$id_admin");
				}
				$array_data_pengajuan = $this->Pengajuan_jadwal_bertugas->getDataPengajuanById($id_pengajuan, $id_admin, $id_periode);
				if($array_data_pengajuan){
					$arr_day_eng = $this->convertDayFromId($array_data_pengajuan[0]['HARI']);
					$arr_hari_input = array($arr_day_eng[1]);
					$jam_mulai = $array_data_pengajuan[0]['JAM_MULAI'];
					$jam_selesai = $array_data_pengajuan[0]['JAM_SELESAI'];
					
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
							
						$arr_ind['JAM_MULAI'] = $jam_mulai;
						$arr_ind['JAM_SELESAI'] = $jam_selesai;
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
							
						$arr_ind['JAM_MULAI'] = $jam_mulai;
						$arr_ind['JAM_SELESAI'] = $jam_selesai;
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
							
						$arr_ind['JAM_MULAI'] = $jam_mulai;
						$arr_ind['JAM_SELESAI'] = $jam_selesai;
						$arr_ind['TIPE_BERTUGAS'] = "Masa Perkuliahan";
						$arr_ind['ID_PERIODE'] = $id_periode;
						$arr_ind['ID_ADMIN'] = $id_admin;
						$arr_ind['INSERT_DATE'] = $date_now;
						array_push($arr_res, $arr_ind);
							
					}
					$this->load->model('Jadwal_bertugas_admin');
					date_default_timezone_set('Asia/Jakarta');
					$date_now = date("Y-m-d h:i:sa");
					$data_update = array(
						'STATUS' => 1,
						'DATE_SUBMITTED' => $date_now
					);
					$res_update = $this->Pengajuan_jadwal_bertugas->updateStatus($id_pengajuan, $data_update);
					$res = $this->Jadwal_bertugas_admin->insertJadwalBertugasAuto($arr_res);
					if($res){
						$this->session->set_flashdata('success', "Berhasil memasukkan jadwal bertugas admin!");
						if($rekap){
							redirect("rekapitulasi_pengajuan");
						}
						redirect("admin_lab/detail?id_admin=$id_admin");
					}
					else{
						$this->session->set_flashdata('error', "Gagal memasukkan jadwal bertugas admin!");
						if($rekap){
							redirect("rekapitulasi_pengajuan");
						}
						redirect("admin_lab/detail?id_admin=$id_admin");
					}
				}
				else{
					$this->session->set_flashdata('error', 'Error! Data Pengajuan tidak ditemukan!');
					if($rekap){
						redirect("rekapitulasi_pengajuan");
					}
	            	redirect("admin_lab/detail?id_admin=$id_admin");
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk mengajukan jadwal bertugas admin pada masa perkuliahan
	function pengajuanJadwalMasaKuliah(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role')!= 4){
				redirect('dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('hari_bertugas[]', 'Hari Bertugas', 'required');
			$this->form_validation->set_rules('jam_mulai[]', 'Jam Mulai Bertugas', 'required');
			$this->form_validation->set_rules('jam_selesai[]', 'Jam Selesai Bertugas', 'required');
			
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required Field!');
	            redirect("admin_lab/jadwal_bertugas");
			}
			else{
				$id_admin = $this->session->userdata('id');
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
		            redirect("admin_lab/jadwal_bertugas");
				}
				//Cek is admin
				$this->load->model('Users');
				$is_admin = $this->Users->checkUserRole($id_admin, 4);
				if(!$is_admin){
					$this->session->set_flashdata('error', 'Tidak dapat perbaharui masa kontrak karena ID User bukan Admin!');
					redirect("admin_lab/jadwal_bertugas");
				}
				$admin_aktif = $this->Users->checkAdminAktif($id_admin);
				if(!$admin_aktif){
					$this->session->set_flashdata('error', 'Tidak dapat melakukan pengajuan jadwal bertugas karena status Admin sedang nonaktif!');
					redirect("admin_lab/jadwal_bertugas");
				}

				//Cek ada periode aktif atau tidak
				$this->load->model('Periode_akademik');
				$id_periode = $this->Periode_akademik->getIDPeriodeAktif();
				if($id_periode){

					$array_pengajuan_jadwal = array();
					$iterator = 0;
					date_default_timezone_set('Asia/Jakarta');
					$date_now = date("Y-m-d h:i:sa");
					foreach ($arr_hari_input as $hari) {
						$arr_ind = array();
						$arr_ind['ID_ADMIN'] = $id_admin;
						$arr_ind['ID_PERIODE'] = $id_periode;
						$arr_data_hari = $this->convertDayFromEng($hari);
						$arr_ind['NUM_DAY'] = $arr_data_hari[0];
						$arr_ind['HARI'] = $arr_data_hari[1];
						$arr_ind['JAM_MULAI'] = $arr_jam_mulai[$iterator];
						$arr_ind['JAM_SELESAI'] = $arr_jam_selesai[$iterator];
						$arr_ind['TIPE_BERTUGAS'] = 0;
						$arr_ind['STATUS'] = 0;
						$arr_ind['DATE_SUBMITTED'] = $date_now;
						array_push($array_pengajuan_jadwal, $arr_ind);
						$iterator++;
					}
					

					$this->load->model('Pengajuan_jadwal_bertugas');

					$res = $this->Pengajuan_jadwal_bertugas->bulkInsertPengajuan($array_pengajuan_jadwal);
					if($res){
						$this->session->set_flashdata('success', "Berhasil melakukan pengajuan jadwal bertugas admin (Masa Perkuliahan)!");
						redirect("admin_lab/jadwal_bertugas");
					}
					else{
						$this->session->set_flashdata('error', "Gagal melakukan pengajuan jadwal bertugas admin (Masa Perkuliahan)!");
						redirect("admin_lab/jadwal_bertugas");
					}
				}
				else{
					$this->session->set_flashdata('error', 'Tidak dapat melakukan pengajuan jadwal bertugas karena tidak terdapat periode akademik yg sedang aktif!');
					redirect("admin_lab/jadwal_bertugas");
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk mengajukan jadwal bertugas admin pada masa ujian (UTS/UAS)
	function pengajuanJadwalMasaUjian(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role')!= 4){
				redirect('dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('tgl_bertugas', 'Tanggal Bertugas', 'required');
			$this->form_validation->set_rules('jam_mulai', 'Jam Mulai Bertugas', 'required');
			$this->form_validation->set_rules('jam_selesai', 'Jam Selesai Bertugas', 'required');
			
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required Field!');
	            redirect("admin_lab/jadwal_bertugas");
			}
			else{
				$id_admin = $this->session->userdata('id');
				$tgl_bertugas = date("Y-m-d", strtotime($this->input->post('tgl_bertugas')));
				$jam_mulai = $this->input->post('jam_mulai');
				$jam_selesai = $this->input->post('jam_selesai');

				if($jam_mulai > $jam_selesai){
					$this->session->set_flashdata('error', 'Jam mulai bertugas tidak boleh lebih besar dari jam selesai bertugas!');
	            	redirect("admin_lab/jadwal_bertugas");
				}
				$this->load->model('Users');
				$is_admin = $this->Users->checkUserRole($id_admin, 4);
				if(!$is_admin){
					$this->session->set_flashdata('error', 'Tidak dapat melakukan pengajuan jadwal bertugas karena ID User bukan Admin!');
					redirect("admin_lab/jadwal_bertugas");
				}
				$admin_aktif = $this->Users->checkAdminAktif($id_admin);
				if(!$admin_aktif){
					$this->session->set_flashdata('error', 'Tidak dapat melakukan pengajuan jadwal bertugas karena status Admin sedang nonaktif!');
					redirect("admin_lab/jadwal_bertugas");
				}
				$this->load->model('Periode_akademik');
				$id_periode = $this->Periode_akademik->getIDPeriodeAktif();
				if($id_periode){
					$array_tanggal_akademik = $this->Periode_akademik->getTanggalAkademik($id_periode);
					$start_uts = $array_tanggal_akademik[0]['START_UTS'];
					$end_uts = $array_tanggal_akademik[0]['END_UTS'];
					$start_uas = $array_tanggal_akademik[0]['START_UAS'];
					$end_uas = $array_tanggal_akademik[0]['END_UAS'];

					

					$check_perkuliahan_before_uts =  $this->check_in_range($tgl_start_periode, $start_uts, $tgl_bertugas, 'full_kiri');
					$check_perkuliahan_after_uts =  $this->check_in_range($end_uts, $start_uas, $tgl_bertugas, 'full_outer');
					$check_in_uts = $this->check_in_range($start_uts, $end_uts, $tgl_bertugas, 'full_inner');
					$check_in_uas = $this->check_in_range($start_uas, $end_uas, $tgl_bertugas, 'full_inner');

					if(!$check_in_uts && !$check_in_uas){
						$this->session->set_flashdata('error', "Gagal melakukan pengajuan jadwal bertugas admin karena tanggal yang diinput tidak berada dalam periode UTS/UAS!");
						redirect("admin_lab/jadwal_bertugas");
					}
					else{
						if($check_in_uts){
							$tipe_ujian = 1;
						}
						else{
							$tipe_ujian = 2;
						}
					}
					
					

					$hari = $this->getDay($tgl_bertugas);
					date_default_timezone_set('Asia/Jakarta');
					$date_now = date("Y-m-d h:i:sa");
					$arr_tgl = $this->convertDayFromId($this->getDay($tgl_bertugas));
					$data = array(
						'ID_ADMIN' => $id_admin,
						'ID_PERIODE' => $id_periode,
						'HARI' => $this->getDay($tgl_bertugas),
						'NUM_DAY' => $arr_tgl[0],
						'TANGGAL' => $tgl_bertugas,
						'JAM_MULAI' => $jam_mulai,
						'JAM_SELESAI' => $jam_selesai,
						'TIPE_BERTUGAS' => $tipe_ujian,
						'STATUS' => 0,
						'DATE_SUBMITTED' => $date_now
					);
					$this->load->model('Pengajuan_jadwal_bertugas');
					$res = $this->Pengajuan_jadwal_bertugas->insertPengajuan($data);
					if($res){
						$this->session->set_flashdata('success', "Berhasil melakukan pengajuan jadwal bertugas masa UTS/UAS!");
						redirect("admin_lab/jadwal_bertugas");
					}
					else{
						$this->session->set_flashdata('error', "Gagal melakukan pengajuan jadwal bertugas masa UTS/UAS!");
						redirect("admin_lab/jadwal_bertugas");
					}
				}
				else{
					$this->session->set_flashdata('error', 'Tidak dapat melakukan pengajuan tanggal bertugas karena tidak terdapat periode akademik yg sedang aktif!');
					redirect("admin_lab/jadwal_bertugas");
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk melakukan load jadwal bertugas admin ketika admin yang login
	function loadJadwalBertugasAdmin(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role')!= 4){
				redirect('dashboard');
			}
			$this->load->model('Detail_user');
			$this->load->model('Users');
			$this->load->model('Periode_gaji');
			$flag_gaji = true;
			$is_periode_gaji_aktif = $this->Periode_gaji->checkPeriodeAktif();
			if(!$is_periode_gaji_aktif){
				$flag_gaji = false;
			}
			$data['flag_gaji'] = $flag_gaji;
			$id_admin = $this->session->userdata('id');
			$is_admin = $this->Users->checkUserRole($id_admin, 4);
			if(!$is_admin){
				$this->session->set_flashdata('error', 'Data admin tidak ditemukan!');
				redirect('/admin_lab');
			}
			$data['title'] = 'Jadwal Bertugas Admin Laboratorium | SI Operasional Lab. Komputasi TIF UNPAR';
			$this->load->model('Periode_akademik');
			$this->load->model('Jadwal_bertugas_admin');
			$this->load->model('Konfigurasi_gaji');
			$data['jadwal_admin_flag'] = true;
			$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();
			$data['daftar_periode'] = $this->Periode_akademik->getAllPeriode();
			$data['data_admin'] = $this->Detail_user->getDataAdmin($id_admin);
			$data['id_gol'] = $data['data_admin'][0]['ID_GOL'];
			$data['nama_admin'] = $this->Users->getIndividualItem($id_admin, 'NAMA');
			$data['id_admin'] = $id_admin;
			$data['konfigurasi_gaji'] = $this->Konfigurasi_gaji->getKonfigurasi();
			$id_periode = $this->Periode_akademik->getIDPeriodeAktif();
			$flag = true;
			$flag_admin = true;
			$admin_aktif = $this->Users->checkAdminAktif($id_admin);
			if(!$admin_aktif){
				$flag_admin = false;
			}
			if(isset($_GET['id_periode'])){
				$id_periode_selected = $_GET['id_periode'];
				if($id_periode_selected != ""){
					$data['jadwal_admin'] = $this->Jadwal_bertugas_admin->getJadwalBertugas($data['id_admin'], $id_periode_selected);
					$data['id_periode_aktif'] = $id_periode_selected;
					
					$data['id_periode_aktif'] = $id_periode_selected;
				}
				else{
					$data['id_periode_aktif'] = $this->Periode_akademik->getLastActiveId();
				}
				if($id_periode_selected != $id_periode){
					$flag = false;
				}
			}
			else{
				if(!$id_periode){
					$data['id_periode_aktif'] = $this->Periode_akademik->getLastActiveId();
					$data['jadwal_admin'] = $this->Jadwal_bertugas_admin->getJadwalBertugas($data['id_admin'], $data['id_periode_aktif']);
					$flag = false;
				}
				else{
					$data['id_periode_aktif'] = $id_periode;
					$data['jadwal_admin'] = $this->Jadwal_bertugas_admin->getJadwalBertugas($data['id_admin'], $id_periode);
				}
			}
			$this->load->model('Pengajuan_jadwal_bertugas');
			$data['jadwal_pending_kuliah'] = $this->Pengajuan_jadwal_bertugas->getDataPengajuan($data['id_periode_aktif'], $data['id_admin'], 0);
			$data['jadwal_pending_uts'] = $this->Pengajuan_jadwal_bertugas->getDataPengajuan($data['id_periode_aktif'], $data['id_admin'], 1);
			$data['jadwal_pending_uas'] = $this->Pengajuan_jadwal_bertugas->getDataPengajuan($data['id_periode_aktif'], $data['id_admin'], 2);
			$data['flag_admin'] = $flag_admin; 
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
			$this->load->view('pages_user/V_Jadwal_Admin', $data);
			$this->load->view('template/Footer');
		}
		else{
			redirect('/');
		}
	}
	//Method untuk melakukan update jadwal bertugas admin
	function updateJadwalBertugasAdmin(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			if($this->session->userdata('id_role') != 1){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
			if($this->session->userdata('id_role') != 4){
				$this->form_validation->set_rules('id_admin', 'ID Admin', 'required');
				$id_admin = $this->input->post('id_admin');
			}
			else{
				$id_admin = $this->session->userdata('id');
			}
			$this->form_validation->set_rules('id_bertugas', 'ID Bertugas', 'required');
			$this->form_validation->set_rules('tgl_bertugas', 'Tanggal Bertugas', 'required');
			$this->form_validation->set_rules('jam_mulai', 'Jam Mulai Bertugas', 'required');
			$this->form_validation->set_rules('jam_selesai', 'Jam Selesai Bertugas', 'required');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required Field!');
				if($this->session->userdata('id_role') != 4){
	            	redirect("admin_lab/detail?id_admin=$id_admin");
	        	}
	        	else{
	        		redirect("admin_lab/jadwal_bertugas");
	        	}
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
	            	if($this->session->userdata('id_role') != 4){
		            	redirect("admin_lab/detail?id_admin=$id_admin");
		        	}
		        	else{
		        		redirect("admin_lab/jadwal_bertugas");
		        	}
				}
				$id_periode_aktif = $this->Periode_akademik->getIDPeriodeAktif();
				if($id_periode_aktif){
					$check_belongs_to_periode = $this->Jadwal_bertugas_admin->checkJadwalBertugas($id_bertugas, 'ID_PERIODE', $id_periode_aktif);
					if(!$check_belongs_to_periode){
						$this->session->set_flashdata('error', 'Tidak dapat melakukan update jadwal bertugas karena Jadwal Bertugas tidak pada periode akademik saat ini!');
						if($this->session->userdata('id_role') != 4){
			            	redirect("admin_lab/detail?id_admin=$id_admin");
			        	}
			        	else{
			        		redirect("admin_lab/jadwal_bertugas");
			        	}
					}
					$check_belongs_to_user = $this->Jadwal_bertugas_admin->checkJadwalBertugas($id_bertugas, 'ID_ADMIN', $id_admin);
					if(!$check_belongs_to_user){
						$this->session->set_flashdata('error', 'Tidak dapat melakukan update jadwal bertugas karena Jadwal Bertugas bukan milik Anda!');
						if($this->session->userdata('id_role') != 4){
			            	redirect("admin_lab/detail?id_admin=$id_admin");
			        	}
			        	else{
			        		redirect("admin_lab/jadwal_bertugas");
			        	}
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
						if($this->session->userdata('id_role') != 4){
			            	redirect("admin_lab/detail?id_admin=$id_admin");
			        	}
			        	else{
			        		redirect("admin_lab/jadwal_bertugas");
			        	}
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
						if($this->session->userdata('id_role') != 4){
			            	redirect("admin_lab/detail?id_admin=$id_admin");
			        	}
			        	else{
			        		redirect("admin_lab/jadwal_bertugas");
			        	}
					}
					else{
						$this->session->set_flashdata('error', "Gagal melakukan update jadwal bertugas admin!");
						if($this->session->userdata('id_role') != 4){
			            	redirect("admin_lab/detail?id_admin=$id_admin");
			        	}
			        	else{
			        		redirect("admin_lab/jadwal_bertugas");
			        	}
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
			if($this->session->userdata('id_role') != 1){
				echo "You dont have access to this feature!";
				return;
			}
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
			if($this->session->userdata('id_role') != 1 ){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
			$this->load->library('form_validation');

			if($this->session->userdata('id_role') != 4){
				$this->form_validation->set_rules('id_admin', 'ID Admin', 'required');
				$id_admin = $this->input->post('id_admin');
			}
			else{
				$id_admin = $this->session->userdata('id');
			}

			$this->form_validation->set_rules('id_bertugas', 'ID Bertugas', 'required');
			
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required Field!');
	            if($this->session->userdata('id_role') != 4){
			        redirect("admin_lab/detail?id_admin=$id_admin");
			    }
			    else{
			        redirect("admin_lab/jadwal_bertugas");
			    }
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
						if($this->session->userdata('id_role') != 4){
			            	redirect("admin_lab/detail?id_admin=$id_admin");
			        	}
			        	else{
			        		redirect("admin_lab/jadwal_bertugas");
			        	}
					}
					$check_belongs_to_user = $this->Jadwal_bertugas_admin->checkJadwalBertugas($id_bertugas, 'ID_ADMIN', $id_admin);
					if(!$check_belongs_to_user){
						$this->session->set_flashdata('error', 'Tidak dapat menghapus tanggal bertugas karena Jadwal Bertugas bukan milik Anda!');
						if($this->session->userdata('id_role') != 4){
			            	redirect("admin_lab/detail?id_admin=$id_admin");
			        	}
			        	else{
			        		redirect("admin_lab/jadwal_bertugas");
			        	}
					}

					$res = $this->Jadwal_bertugas_admin->deleteJadwalBertugas($id_bertugas);
					if($res){
						$this->session->set_flashdata('success', 'Berhasil menghapus jadwal bertugas dari database!');
						if($this->session->userdata('id_role') != 4){
			            	redirect("admin_lab/detail?id_admin=$id_admin");
			        	}
			        	else{
			        		redirect("admin_lab/jadwal_bertugas");
			        	}
					}
					else{
						$this->session->set_flashdata('error', 'Gagal menghapus jadwal bertugas dari database!');
						if($this->session->userdata('id_role') != 4){
			            	redirect("admin_lab/detail?id_admin=$id_admin");
			        	}
			        	else{
			        		redirect("admin_lab/jadwal_bertugas");
			        	}
					}
				}
				else{
					$this->session->set_flashdata('error', 'Tidak dapat menghapus tanggal bertugas karena tidak terdapat periode akademik yg sedang aktif!');
					if($this->session->userdata('id_role') != 4){
			            redirect("admin_lab/detail?id_admin=$id_admin");
			        }
			        else{
			        	redirect("admin_lab/jadwal_bertugas");
			        }
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
			if($this->session->userdata('id_role') != 1 ){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
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
				$admin_aktif = $this->Users->checkAdminAktif($id_admin);
				if(!$admin_aktif){
					$this->session->set_flashdata('error', 'Tidak dapat memasukkan jadwal bertugas karena status Admin sedang nonaktif!');
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
			if($this->session->userdata('id_role') != 1 ){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
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
				$admin_aktif = $this->Users->checkAdminAktif($id_admin);
				if(!$admin_aktif){
					$this->session->set_flashdata('error', 'Tidak dapat memasukkan jadwal bertugas karena status Admin sedang nonaktif!');
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
			if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 3){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
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
	//Method untuk melakukan edit konfigurasi golongan gaji
	function editKonfigurasiGolonganGaji(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 3){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_admin', 'ID Admin', 'required');
			$this->form_validation->set_rules('id_gol', 'ID Golongan', 'required');
			$id_admin = $this->input->post('id_admin');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required Field!');
	            redirect("admin_lab/detail?id_admin=$id_admin");
			}
			else{
				$id_gol = $this->input->post('id_gol');
				$this->load->model('Users');
				$is_admin = $this->Users->checkUserRole($id_admin, 4);
				if(!$is_admin){
					$this->session->set_flashdata('error', 'Tidak dapat perbaharui masa kontrak karena ID User bukan Admin!');
					redirect('/dashboard');
				}

				$is_aktif = $this->Users->checkAdminAktif($id_admin);
				if(!$is_aktif){
					$this->session->set_flashdata('error', 'Tidak dapat perbaharui ID Golongan gaji karena bukan merupakan admin aktif!');
					redirect("admin_lab/detail?id_admin=$id_admin");
				}
				$this->load->model('Periode_gaji');
				$id_periode_gaji_aktif = $this->Periode_gaji->checkPeriodeAktif();
				if($id_periode_gaji_aktif){
					$this->session->set_flashdata('error', 'Tidak dapat perbaharui ID Golongan gaji karena masih terdapat periode gaji yang sedang berjalan!');
					redirect("admin_lab/detail?id_admin=$id_admin");
				}
				$this->load->model('Detail_user');
				$res = $this->Detail_user->updateGolonganGaji($id_admin, $id_gol);
				if($res){
					$this->session->set_flashdata('success', 'Berhasil memperbaharui golongan gaji!');
	           	 	redirect("admin_lab/detail?id_admin=$id_admin");
				}
				else{
					$this->session->set_flashdata('error', 'Gagal memperbaharui golongan gaji!');
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
			if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 3){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
			$id_admin = $this->input->get('id_admin');

			if($id_admin != ""){

				$this->load->model('Detail_user');
				$this->load->model('Users');
				$this->load->model('Periode_gaji');
				$this->load->model('Pengajuan_jadwal_bertugas');
				$flag_gaji = true;
				$is_periode_gaji_aktif = $this->Periode_gaji->checkPeriodeAktif();
				if(!$is_periode_gaji_aktif){
					$flag_gaji = false;
				}
				$data['flag_gaji'] = $flag_gaji;
				$is_admin = $this->Users->checkUserRole($id_admin, 4);
				if(!$is_admin){
					$this->session->set_flashdata('error', 'Data admin tidak ditemukan!');
					redirect('/admin_lab');
				}
				$data['title'] = 'Detail Admin Laboratorium | SI Operasional Lab. Komputasi TIF UNPAR';
				$this->load->model('Periode_akademik');
				$this->load->model('Jadwal_bertugas_admin');
				$this->load->model('Konfigurasi_gaji');
				$data['detail_admin'] = true;
				$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();
				$data['daftar_periode'] = $this->Periode_akademik->getAllPeriode();
				$data['data_admin'] = $this->Detail_user->getDataAdmin($id_admin);
				$data['id_gol'] = $data['data_admin'][0]['ID_GOL'];
				$data['nama_admin'] = $this->Users->getIndividualItem($id_admin, 'NAMA');
				$data['id_admin'] = $this->Users->getIndividualItem($id_admin, 'ID');
				$data['konfigurasi_gaji'] = $this->Konfigurasi_gaji->getKonfigurasi();
				$id_periode = $this->Periode_akademik->getIDPeriodeAktif();
				$flag = true;
				$flag_admin = true;
				$admin_aktif = $this->Users->checkAdminAktif($id_admin);
				if(!$admin_aktif){
					$flag_admin = false;
				}
				if(isset($_GET['id_periode'])){
					$id_periode_selected = $_GET['id_periode'];
					if($id_periode_selected != ""){
						$data['jadwal_admin'] = $this->Jadwal_bertugas_admin->getJadwalBertugas($data['id_admin'], $id_periode_selected);
						$data['jadwal_pending_kuliah'] = $this->Pengajuan_jadwal_bertugas->getDataPengajuan($id_periode_selected, $data['id_admin'], 0);
						$data['jadwal_pending_uts'] = $this->Pengajuan_jadwal_bertugas->getDataPengajuan($id_periode_selected, $data['id_admin'], 1);
						$data['jadwal_pending_uas'] = $this->Pengajuan_jadwal_bertugas->getDataPengajuan($id_periode_selected, $data['id_admin'], 2);
						$data['id_periode_aktif'] = $id_periode_selected;
					}
					if($id_periode_selected != $id_periode){
						$flag = false;
					}
				}
				else{
					if(!$id_periode){
						$data['id_periode_aktif'] = $this->Periode_akademik->getLastActiveId();
						$data['jadwal_admin'] = $this->Jadwal_bertugas_admin->getJadwalBertugas($data['id_admin'], $data['id_periode_aktif']);
						$data['jadwal_pending_kuliah'] = $this->Pengajuan_jadwal_bertugas->getDataPengajuan($data['id_periode_aktif'], $data['id_admin'], 0);
						$data['jadwal_pending_uts'] = $this->Pengajuan_jadwal_bertugas->getDataPengajuan($data['id_periode_aktif'], $data['id_admin'], 1);
						$data['jadwal_pending_uas'] = $this->Pengajuan_jadwal_bertugas->getDataPengajuan($data['id_periode_aktif'], $data['id_admin'], 2);
						$flag = false;
					}
					else{
						$data['id_periode_aktif'] = $id_periode;
						$data['jadwal_admin'] = $this->Jadwal_bertugas_admin->getJadwalBertugas($data['id_admin'], $id_periode);
						$data['jadwal_pending_kuliah'] = $this->Pengajuan_jadwal_bertugas->getDataPengajuan($id_periode, $data['id_admin'], 0);
						$data['jadwal_pending_uts'] = $this->Pengajuan_jadwal_bertugas->getDataPengajuan($id_periode, $data['id_admin'], 1);
						$data['jadwal_pending_uas'] = $this->Pengajuan_jadwal_bertugas->getDataPengajuan($id_periode, $data['id_admin'], 2);
					}
				}

				$data['flag_admin'] = $flag_admin; 
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
			if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 3){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
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
			if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 3){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
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
			if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 3){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('nik', 'NIK Admin', 'required');
			$this->form_validation->set_rules('nama', 'Nama Admin', 'required');
			$this->form_validation->set_rules('email', 'Email Admin', 'required');
			$this->form_validation->set_rules('angkatan', 'Angkatan Admin', 'required');
			$this->form_validation->set_rules('awal_kontrak', 'Awal Kontrak Admin', 'required');
			$this->form_validation->set_rules('akhir_kontrak', 'Akhir Kontrak Admin', 'required');
			$this->form_validation->set_rules('id_gol', 'ID Golongan', 'required');
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
				$id_gol = $this->input->post('id_gol');
				$this->load->model('Users');
				$inserted_id = $this->Users->addUser(4, $nama, $email, $nik, 0);
				if($inserted_id){
					$this->load->model('Detail_user');
					$insert_detail = $this->Detail_user->insertDetailUser($inserted_id, $angkatan, $awal_kontrak, $akhir_kontrak, $id_gol);
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
	//Method untuk melakukan convert nama hari ke dalam hari bahasa inggris ke bahasa indonesia dan mendapatkan nomor hari
	private function convertDayFromId($hari){
		$day_eng = array ( 1 =>    'Monday',
			'Tuesday',
			'Wednesday',
			'Thursday',
			'Friday',
			'Saturday',
			'Monday'
		);
		$day_id = array ( 1 =>    'Senin',
			'Selasa',
			'Rabu',
			'Kamis',
			'Jumat',
			'Sabtu',
			'Minggu'
		);

		$idx_id = array_search($hari, $day_id);
		$arr_res = array();
		$arr_res[0] = $idx_id;
		$arr_res[1] = $day_eng[$idx_id];
		return $arr_res;
	}
	//Method untuk melakukan convert nama hari ke dalam hari bahasa indonesia dan mendapatkan nomor hari
	private function convertDayFromEng($day){
		$day_eng = array ( 1 =>    'Monday',
			'Tuesday',
			'Wednesday',
			'Thursday',
			'Friday',
			'Saturday',
			'Monday'
		);
		$day_id = array ( 1 =>    'Senin',
			'Selasa',
			'Rabu',
			'Kamis',
			'Jumat',
			'Sabtu',
			'Minggu'
		);

		$idx_eng = array_search($day, $day_eng);
		$arr_res = array();
		$arr_res[0] = $idx_eng;
		$arr_res[1] = $day_id[$idx_eng];
		return $arr_res;
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