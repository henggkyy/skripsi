<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani Inisiasi dan Administrasi Mata Kuliah.
class C_Matkul extends CI_Controller{
	//Method untuk set ruangan UAS
	function setRuanganUAS(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 4){
				redirect('/dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_matkul', 'ID Mata Kuliah', 'required');
			$this->form_validation->set_rules('lab', 'ID Lab', 'required');
			$id_matkul = $this->input->post('id_matkul');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing Required Fields');
				redirect("/administrasi_matkul_detail?id=$id_matkul");
			}
			else{
				$lab = $this->input->post('lab');
				$this->load->model('Mata_kuliah');
				$this->load->model('Periode_akademik');
				$this->load->model('Jadwal_lab');
				$id_periode = $this->Mata_kuliah->getIndividualItem($id_matkul, 'ID_PERIODE');
				$tanggal_uas = $this->Mata_kuliah->getIndividualItem($id_matkul, 'TANGGAL_UAS');
				$nama_matkul = $this->Mata_kuliah->getIndividualItem($id_matkul, 'NAMA_MATKUL');
				$kd_matkul = $this->Mata_kuliah->getIndividualItem($id_matkul, 'KD_MATKUL');
				$checkPeriodeAktif = $this->Periode_akademik->checkIdAktif($id_periode);
				if(!$checkPeriodeAktif){
					$this->session->set_flashdata('error', 'Tidak dapat set ruangan UAS karena periode akademik mata kuliah sudah berakhir!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
				if($tanggal_uas == NULL){
					$this->session->set_flashdata('error', 'Tidak dapat set ruangan UAS karena jadwal UTS belum diinput oleh Tata Usaha!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}

				$jam_mulai = $this->Mata_kuliah->getIndividualItem($id_matkul, 'JAM_MULAI_UAS');
				$jam_selesai = $this->Mata_kuliah->getIndividualItem($id_matkul, 'JAM_SELESAI_UAS');

				$this->load->model('Ruangan_ujian');
				$data = array(
					'ID_MATKUL' => $id_matkul,
					'ID_LAB' => $lab,
					'TIPE_UJIAN'=> 'UAS'
				);
				$res_ruangan = $this->Ruangan_ujian->insertData($data);

				$title = 'UAS '.$nama_matkul." (".$kd_matkul.")";
				$start_event = $tanggal_uas." ".$jam_mulai;
				$end_event = $tanggal_uas." ".$jam_selesai;

				$res_jadwal = $this->Jadwal_lab->insertJadwalPemakaian($title, $lab, $start_event, $end_event);

				if($res_ruangan && $res_jadwal){
					$this->session->set_flashdata('success', 'Berhasil melakukan set ruangan UAS!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
				else{
					if(!$res_ruangan){
						$this->session->set_flashdata('error', 'Gagal memasukkan ruangan UAS pada table mata kuliah');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
					}
					else{
						$this->session->set_flashdata('error', 'Gagal memasukkan jadwal pemakaian ruangan UAS pada table jadwal lab');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
					}
					
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk set ruangan UTS
	function setRuanganUTS(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 4){
				redirect('/dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_matkul', 'ID Mata Kuliah', 'required');
			$this->form_validation->set_rules('lab', 'ID Lab', 'required');
			$id_matkul = $this->input->post('id_matkul');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing Required Fields');
				redirect("/administrasi_matkul_detail?id=$id_matkul");
			}
			else{
				$lab = $this->input->post('lab');
				$this->load->model('Mata_kuliah');
				$this->load->model('Periode_akademik');
				$this->load->model('Jadwal_lab');
				$id_periode = $this->Mata_kuliah->getIndividualItem($id_matkul, 'ID_PERIODE');
				$tanggal_uts = $this->Mata_kuliah->getIndividualItem($id_matkul, 'TANGGAL_UTS');
				$nama_matkul = $this->Mata_kuliah->getIndividualItem($id_matkul, 'NAMA_MATKUL');
				$kd_matkul = $this->Mata_kuliah->getIndividualItem($id_matkul, 'KD_MATKUL');
				$checkPeriodeAktif = $this->Periode_akademik->checkIdAktif($id_periode);
				if(!$checkPeriodeAktif){
					$this->session->set_flashdata('error', 'Tidak dapat set ruangan UTS karena periode akademik mata kuliah sudah berakhir!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
				if($tanggal_uts == NULL){
					$this->session->set_flashdata('error', 'Tidak dapat set ruangan UTS karena jadwal UTS belum diinput oleh Tata Usaha!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}

				$jam_mulai = $this->Mata_kuliah->getIndividualItem($id_matkul, 'JAM_MULAI_UTS');
				$jam_selesai = $this->Mata_kuliah->getIndividualItem($id_matkul, 'JAM_SELESAI_UTS');
				$this->load->model('Ruangan_ujian');
				$data = array(
					'ID_MATKUL' => $id_matkul,
					'ID_LAB' => $lab,
					'TIPE_UJIAN'=> 'UTS'
				);
				$res_ruangan = $this->Ruangan_ujian->insertData($data);

				$title = 'UTS '.$nama_matkul." (".$kd_matkul.")";
				$start_event = $tanggal_uts." ".$jam_mulai;
				$end_event = $tanggal_uts." ".$jam_selesai;

				$res_jadwal = $this->Jadwal_lab->insertJadwalPemakaian($title, $lab, $start_event, $end_event);

				if($res_ruangan && $res_jadwal){
					$this->session->set_flashdata('success', 'Berhasil melakukan set ruangan UTS!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
				else{
					if(!$res_ruangan){
						$this->session->set_flashdata('error', 'Gagal memasukkan ruangan UTS pada table mata kuliah');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
					}
					else{
						$this->session->set_flashdata('error', 'Gagal memasukkan jadwal pemakaian ruangan UTS pada table jadwal lab');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
					}
					
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk memasukkan jadwal kelas setiap mata kuliah
	function insertJadwalKelas(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 3){
				redirect('/dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_matkul', 'ID Mata Kuliah', 'required');
			$this->form_validation->set_rules('hari[]', 'Hari Kelas', 'required');
			$this->form_validation->set_rules('jam_mulai[]', 'Jam Mulai', 'required');
			$this->form_validation->set_rules('jam_selesai[]', 'Jam Selesai', 'required');
			$this->form_validation->set_rules('lab[]', 'Kode Laboratorium', 'required');
			$this->form_validation->set_rules('kd_kelas', 'Kode Kelas', 'required');
			$id_matkul = $this->input->post('id_matkul');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing Required Fields');
				redirect("/administrasi_matkul_detail?id=$id_matkul");
			}
			else{
				$this->load->model('Mata_kuliah');
				$this->load->model('Periode_akademik');
				$id_periode = $this->Mata_kuliah->getIndividualItem($id_matkul, 'ID_PERIODE');
				$nama_matkul = $this->Mata_kuliah->getIndividualItem($id_matkul, 'NAMA_MATKUL');
				$kd_matkul = $this->Mata_kuliah->getIndividualItem($id_matkul, 'KD_MATKUL');
				$jam_mulai = $this->input->post('jam_mulai[]');
				$jam_selesai = $this->input->post('jam_selesai[]');
				$lab = $this->input->post('lab[]');
				$hari = $this->input->post('hari[]');
				$kd_kelas = $this->input->post('kd_kelas');
				$checkPeriodeAktif = $this->Periode_akademik->checkIdAktif($id_periode);
				if(!$checkPeriodeAktif){
					$this->session->set_flashdata('error', 'Tidak dapat memasukkan jadwal kelas karena periode akademik mata kuliah sudah berakhir!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
				
				$iterator = 0;
				$array_jadwal_kelas = array();
				$array_day_english = array();
				$array_event_lab = array();
				foreach ($hari as $day) {
					$arr_ind = array();
					$arr_ind['ID_MATKUL'] = $id_matkul;
					$arr_ind['HARI'] = $this->convertNumDay($day, 'id');
					$day_english = $this->convertNumDay($day, 'eng');
					$arr_ind['JAM_MULAI'] = $jam_mulai[$iterator];
					$arr_ind['JAM_SELESAI'] = $jam_selesai[$iterator];
					$arr_ind['ID_LAB'] = $lab[$iterator];
					$arr_ind['KODE_KELAS'] = $kd_kelas;
					array_push($array_day_english, $day_english);
					array_push($array_jadwal_kelas, $arr_ind);
					$iterator++;
				}

				$this->load->model('Jadwal_matkul');
				$res_jadwal = $this->Jadwal_matkul->bulkInsertJadwal($array_jadwal_kelas);
				//Get Tanggal Periode Akadeim Aktif
				$start_periode = $this->Periode_akademik->getIndividualItem($id_periode, 'START_PERIODE');
				$end_periode = $this->Periode_akademik->getIndividualItem($id_periode, 'END_PERIODE');
				$start_uts = $this->Periode_akademik->getIndividualItem($id_periode, 'START_UTS');
				$end_uts = $this->Periode_akademik->getIndividualItem($id_periode, 'END_UTS');
				$start_uas = $this->Periode_akademik->getIndividualItem($id_periode, 'START_UAS');
				$start_uts = date('Y-m-d', strtotime('-1 day', strtotime($start_uts)));
				$start_uas = date('Y-m-d', strtotime('-1 day', strtotime($start_uas)));
				$hari = array($hari);
				//Get seluruh tanggal sebelum uts dan setelah uts
				$arr_tgl_sebelum_uts = $this->getAllDate($start_periode, $start_uts, $array_day_english);
				$arr_tgl_setelah_uts = $this->getAllDate($end_uts, $start_uas, $array_day_english);
				$array_merge_alldate = array_merge($arr_tgl_sebelum_uts, $arr_tgl_setelah_uts);
				

				foreach ($array_merge_alldate as $date) {
					$arr_ind_lab = array();
					$arr_ind_lab['TITLE'] = "Kelas ".$nama_matkul." [" .$kd_kelas."] (".$kd_matkul.")";
					$day = $this->getDay($date);
					$index = array_search($day,$array_day_english);
					$arr_ind_lab['START_EVENT'] = $date." ".$jam_mulai[$index];
					$arr_ind_lab['END_EVENT'] = $date." ".$jam_selesai[$index];
					$arr_ind_lab['ID_LAB'] = $lab[$index];
					$arr_ind_lab['STATUS'] = 1;
					array_push($array_event_lab, $arr_ind_lab);
				}
				$this->load->model('Jadwal_lab');
				$res_lab = $this->Jadwal_lab->bulkInsertJadwal($array_event_lab);
				
				if($res_jadwal && $res_lab){
					$this->session->set_flashdata('success', 'Berhasil memasukkan jadwal kelas!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
				else{
					if(!$res_jadwal){
						$this->session->set_flashdata('error', 'Gagal memasukkan data ke dalam tabel jadwal mata kuliah!');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
					}
					else{
						$this->session->set_flashdata('error', 'Gagal memasukkan data ke dalam tabel jadwal pemakaian lab!');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
					}
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk melakukan checklist persiapan ujian
	function checkListUjian(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 2 && $this->session->userdata('id_role') != 1){
				redirect('/dashboard');
			}

			if($this->session->userdata('id_role') == 1){
				$this->load->model('Users');
				$rangkap_dosen = $this->Users->checkUserIsDosen($this->session->userdata('id'));
				if(!$rangkap_dosen){
					$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke fitur ini');
					redirect('/dashboard');
				}
			}

			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_matkul', 'ID Mata Kuliah', 'required');
			$this->form_validation->set_rules('tipe_ujian', 'Tipe Ujian', 'required');
			$id_matkul = $this->input->post('id_matkul');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing Required Fields');
				redirect("/administrasi_matkul_detail?id=$id_matkul");
			}
			else{
				$this->load->model('Mata_kuliah');

				$milik_dosen = $this->Mata_kuliah->checkMatkulDosen($id_matkul, $this->session->userdata('id'));
				if(!$milik_dosen){
					$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke mata kuliah ini');
					redirect('/dashboard');
				}
				
				$tipe_ujian = $this->input->post('tipe_ujian');
				if($tipe_ujian != 0 && $tipe_ujian != 1){
					$this->session->set_flashdata('error', 'Error Tipe Ujian!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
				$this->load->model('Periode_akademik');
				$id_periode = $this->Mata_kuliah->getIndividualItem($id_matkul, 'ID_PERIODE');
				$checkPeriodeAktif = $this->Periode_akademik->checkIdAktif($id_periode);
				if(!$checkPeriodeAktif){
					$this->session->set_flashdata('error', 'Tidak dapat melakukan checklist karena periode akademik mata kuliah sudah berakhir!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
				$checklist_01 = NULL;
				$checklist_02 = NULL;
				$checklist_03 = NULL;
				$checklist_04 = NULL;
				$checklist_05 = NULL;
				$checklist_06 = NULL;
				$checklist_07 = NULL;
				$checklist_08 = NULL;
				$checklist_09 = NULL;
				$checklist_10 = NULL;
				$array_checklist = $this->input->post('checklist[]');
				// print_r($array_checklist);
				// return;
				if(isset($array_checklist) && $array_checklist){
					
					if(in_array('01', $array_checklist)){
						$checklist_01 = 1;
					}
					if(in_array('02', $array_checklist)){
						$checklist_02 = 1;
					}
					if(in_array('03', $array_checklist)){
						$checklist_03 = 1;
					}
					if(in_array('04', $array_checklist)){
						$checklist_04 = 1;
					}
					if(in_array('05', $array_checklist)){
						$checklist_05 = 1;
					}
					if(in_array('06', $array_checklist)){
						$checklist_06 = 1;
					}
					if(in_array('07', $array_checklist)){
						$checklist_07 = 1;
					}
					if(in_array('08', $array_checklist)){
						$checklist_08 = 1;
					}
					if(in_array('09', $array_checklist)){
						$checklist_09 = 1;
					}
					if(in_array('10', $array_checklist)){
						$checklist_10 = 1;
					}
				}
				date_default_timezone_set('Asia/Jakarta');
				$date_time = date("Y-m-d H:i:s");
				$data = array(
					'ID_MATKUL' => $id_matkul,
					'TIPE_UJIAN' => $tipe_ujian,
					'CHECKLIST_01' => $checklist_01,
					'CHECKLIST_02' => $checklist_02,
					'CHECKLIST_03' => $checklist_03,
					'CHECKLIST_04' => $checklist_04,
					'CHECKLIST_05' => $checklist_05,
					'CHECKLIST_06' => $checklist_06,
					'CHECKLIST_07' => $checklist_07,
					'CHECKLIST_08' => $checklist_08,
					'CHECKLIST_09' => $checklist_09,
					'CHECKLIST_10' => $checklist_10,
					'LAST_UPDATE' => $date_time
				);
				$this->load->model('Checklist_ujian');
				if($tipe_ujian == 0){
					$nama_ujian = 'UTS';
				}
				else{
					$nama_ujian = 'UAS';
				}
				$res = $this->Checklist_ujian->insertChecklist($data);
				if($res){
					$this->session->set_flashdata('success', "Berhasil melakukan checklist persiapan ujian $nama_ujian");
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
				else{
					$this->session->set_flashdata('success', "Gagal melakukan checklist persiapan ujian $nama_ujian");
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk menghapus file-file bantuan ujian
	function deleteFileBantuan(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 2 && $this->session->userdata('id_role') != 1){
				redirect('/dashboard');
			}

			if($this->session->userdata('id_role') == 1){
				$this->load->model('Users');
				$rangkap_dosen = $this->Users->checkUserIsDosen($this->session->userdata('id'));
				if(!$rangkap_dosen){
					$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke fitur ini');
					redirect('/dashboard');
				}
			}

			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_file_bantuan', 'ID File Bantuan', 'required');
			$this->form_validation->set_rules('id_matkul', 'ID Mata Kuliah', 'required');
			$id_matkul = $this->input->post('id_matkul');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing Required Fields');
				redirect("/administrasi_matkul_detail?id=$id_matkul");
			}
			else{
				$this->load->model('Periode_akademik');
				$this->load->model('Mata_kuliah');
				$milik_dosen = $this->Mata_kuliah->checkMatkulDosen($id_matkul, $this->session->userdata('id'));
				if(!$milik_dosen){
					$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke mata kuliah ini');
					redirect('/dashboard');
				}
				$id_periode = $this->Mata_kuliah->getIndividualItem($id_matkul, 'ID_PERIODE');
				$checkPeriodeAktif = $this->Periode_akademik->checkIdAktif($id_periode);
				if(!$checkPeriodeAktif){
					$this->session->set_flashdata('error', 'Tidak dapat memasukkan file bantuan karena periode akademik mata kuliah sudah selesai!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
				$id_file_bantuan = $this->input->post('id_file_bantuan');

				$this->load->model('File_bantuan_ujian');
				$path_file = $this->File_bantuan_ujian->getPathFile($id_file_bantuan);

				$path_to_file = "./uploads/file_bantuan/$path_file";
				$res_delete = unlink($path_to_file);
				$res = $this->File_bantuan_ujian->deleteFileBantuan($id_file_bantuan);
				if($res && $res_delete){
					$this->session->set_flashdata('success', 'Berhasil menghapus  file bantuan ujian!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
				else{
					if(!$res_delete){
						$this->session->set_flashdata('error', 'Gagal menghapus file bantuan ujian dari server!');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
					}
					else{
						$this->session->set_flashdata('error', 'Gagal menghapus file bantuan ujian dari database!');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
					}
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk menerima file bantuan ujian yang dikirimkan oleh dosen koordinator
	function acceptFileBantuan(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1){
				redirect('/dashboard');
			}

			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_file_bantuan', 'ID File Bantuan', 'required');
			$this->form_validation->set_rules('id_matkul', 'ID Mata Kuliah', 'required');
			$id_matkul = $this->input->post('id_matkul');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing Required Fields');
				redirect("/administrasi_matkul_detail?id=$id_matkul");
			}
			else{
				$this->load->model('Periode_akademik');
				$this->load->model('Mata_kuliah');
				$id_periode = $this->Mata_kuliah->getIndividualItem($id_matkul, 'ID_PERIODE');
				$checkPeriodeAktif = $this->Periode_akademik->checkIdAktif($id_periode);
				if(!$checkPeriodeAktif){
					$this->session->set_flashdata('error', 'Tidak dapat memasukkan file bantuan karena periode akademik mata kuliah sudah selesai!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
				$id_file_bantuan = $this->input->post('id_file_bantuan');
				$this->load->model('File_bantuan_ujian');
				$status = $this->File_bantuan_ujian->getIndividualItem($id_file_bantuan, 'STATUS');
				if($status == 1 || $status == 2){
					$this->session->set_flashdata('error', 'Gagal menindaklanjuti file bantuan ujian karena telah ditidindaklanjuti!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
				$data = array(
					'STATUS' => 1
				);
				$res = $this->File_bantuan_ujian->acceptFileBantuan($id_file_bantuan, $data);
				if($res){
					$this->session->set_flashdata('success', 'Berhasil menyetujui file bantuan ujian!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
				else{
					$this->session->set_flashdata('error', 'Gagal menyetujui file bantuan ujian!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk menolak file bantuan ujian yang dikirimkan oleh dosen koordinator
	function rejectFileBantuan(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1){
				redirect('/dashboard');
			}

			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_file_bantuan', 'ID File Bantuan', 'required');
			$this->form_validation->set_rules('id_matkul', 'ID Mata Kuliah', 'required');
			$id_matkul = $this->input->post('id_matkul');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing Required Fields');
				redirect("/administrasi_matkul_detail?id=$id_matkul");
			}
			else{
				$this->load->model('Periode_akademik');
				$this->load->model('Mata_kuliah');
				$id_periode = $this->Mata_kuliah->getIndividualItem($id_matkul, 'ID_PERIODE');
				$checkPeriodeAktif = $this->Periode_akademik->checkIdAktif($id_periode);
				if(!$checkPeriodeAktif){
					$this->session->set_flashdata('error', 'Tidak dapat memasukkan file bantuan karena periode akademik mata kuliah sudah selesai!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
				$id_file_bantuan = $this->input->post('id_file_bantuan');
				$this->load->model('File_bantuan_ujian');
				$status = $this->File_bantuan_ujian->getIndividualItem($id_file_bantuan, 'STATUS');
				if($status == 1 || $status == 2){
					$this->session->set_flashdata('error', 'Gagal menindaklanjuti file bantuan ujian karena telah ditidindaklanjuti!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
				$data = array(
					'STATUS' => 2
				);
				$res = $this->File_bantuan_ujian->rejectFileBantuan($id_file_bantuan, $data);
				if($res){
					$this->session->set_flashdata('success', 'Berhasil menolak file bantuan ujian!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
				else{
					$this->session->set_flashdata('error', 'Gagal menyetujui file bantuan ujian!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk memasukkan file-file bantuan ujian
	function insertFileBantuan(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 2 && $this->session->userdata('id_role') != 1){
				redirect('/dashboard');
			}

			if($this->session->userdata('id_role') == 1){
				$this->load->model('Users');
				$rangkap_dosen = $this->Users->checkUserIsDosen($this->session->userdata('id'));
				if(!$rangkap_dosen){
					$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke fitur ini');
					redirect('/dashboard');
				}
			}

			$this->load->library('form_validation');
			$this->form_validation->set_rules('tipe_ujian', 'Tipe Ujian', 'required');
			$this->form_validation->set_rules('nama_keterangan', 'Nama/Keterangan File Bantuan', 'required');
			$this->form_validation->set_rules('id_matkul', 'ID Mata Kuliah', 'required');
			$id_matkul = $this->input->post('id_matkul');
			if(empty($_FILES['file_bantuan']['name'])){
				$this->session->set_flashdata('error_message', 'File bantuan ujian harus dilampirkan!');
	            redirect("/administrasi_matkul_detail?id=$id_matkul");
			}
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing Required Fields');
				redirect("/administrasi_matkul_detail?id=$id_matkul");
			}
			else{
				$this->load->model('Periode_akademik');
				$this->load->model('Mata_kuliah');
				$milik_dosen = $this->Mata_kuliah->checkMatkulDosen($id_matkul, $this->session->userdata('id'));
				if(!$milik_dosen){
					$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke mata kuliah ini');
					redirect('/dashboard');
				}
				$id_periode = $this->Mata_kuliah->getIndividualItem($id_matkul, 'ID_PERIODE');
				$checkPeriodeAktif = $this->Periode_akademik->checkIdAktif($id_periode);
				if(!$checkPeriodeAktif){
					$this->session->set_flashdata('error', 'Tidak dapat memasukkan file bantuan karena periode akademik mata kuliah sudah selesai!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
				$tipe_ujian = $this->input->post('tipe_ujian');
				if($tipe_ujian == 0 || $tipe_ujian == 1){
					$nama_keterangan = htmlentities($this->input->post('nama_keterangan'));
					$id_matkul = $this->input->post('id_matkul');
					$this->load->model('File_bantuan_ujian');

					$nama_file_real = $_FILES['file_bantuan']['name'];
					$ext = pathinfo($nama_file_real, PATHINFO_EXTENSION);

					$namaFileHash = $this->generateHash(20).'.'.$ext;
					$exists = $this->File_bantuan_ujian->checkFileName($namaFileHash);
					while ($exists) {
						$namaFileHash = $this->generateHash(20).'.'.$ext;
						$exists = $this->File_bantuan_ujian->checkFileName($namaFileHash);
					}

					$res_upload = $this->uploadFile($namaFileHash);
					date_default_timezone_set("Asia/Jakarta");
					$tanggal_insert = date("Y-m-d H:i:s");
					$data = array(
						'NAMA_FILE_USER' => $nama_keterangan,
						'PATH_FILE' => $namaFileHash,
						'TIPE_UJIAN' => $tipe_ujian,
						'ID_MATKUL' => $id_matkul,
						'LAST_UPDATE'=> $tanggal_insert,
						'USER_UPLOAD' => $this->session->userdata('id'),
						'STATUS' => 0
					);
					$res_db = $this->File_bantuan_ujian->insertFileBantuan($data);

					if(($res_upload==true) && $res_db){
						$this->session->set_flashdata('success', 'Berhasil melakukan upload file bantuan ujian!');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
					}
					else{
						
						if(!$res_upload){
							$this->session->set_flashdata('error', "Gagal melakukan upload file bantuan ujian ke server!");
							redirect("/administrasi_matkul_detail?id=$id_matkul");
						}
						else{
							$this->session->set_flashdata('error', 'Gagal memasukkan data file bantuan ke dalam database!');
							redirect("/administrasi_matkul_detail?id=$id_matkul");
						}
					}
				}
				else{
					$this->session->set_flashdata('error_message', 'Kesalahan value tipe ujian!');
	            redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
			}
		}
		else{
			redirect('/');
		}
	}

	//Method untuk menangani proses pengecekan perangkat lunak yang sudah terpasang 
	//Method ini dipanggil menggunakan Jquery AJAX pada Footer.php
	function periksaPL(){
		if(!$this->session->userdata('logged_in')){
			echo "You must login first!";
			return;
		}
		if($this->session->userdata('id_role') != 4){
			echo "Anda tidak memiliki akses ke fitur ini!";
			return;
		}
		$data_software = $this->input->post('data_software');
		$data_software = strtolower($data_software);
		$id_matkul = $this->input->post('id_matkul_cek');
		date_default_timezone_set("Asia/Jakarta");
		$tanggal_checked = date("Y-m-d H:i:s");
		$this->load->model('Kebutuhan_pl');
		$this->load->model('Mata_kuliah');
		$data_pl = $this->Kebutuhan_pl->getPL($id_matkul);
		$arr_res = array();
		$data['nama_matkul'] = $this->Mata_kuliah->getIndividualItem($id_matkul, 'NAMA_MATKUL');
		if(isset($data_pl) && $data_pl){
			foreach ($data_pl as $pl) {
				$tanggal_checked = date("Y-m-d H:i:s");
				$arr_res_ind = array();
				if(strpos($data_software, strtolower($pl['NAMA_PL'])) !== false){
					array_push($arr_res_ind, 1);
					array_push($arr_res_ind, $pl['NAMA_PL']);
					$this->Kebutuhan_pl->updateStatusPL($pl['ID'], 1, $tanggal_checked);
				    array_push($arr_res, $arr_res_ind);
				}
				else{
				    array_push($arr_res_ind, 2);
				    array_push($arr_res_ind, $pl['NAMA_PL']);
				    $this->Kebutuhan_pl->updateStatusPL($pl['ID'], 2, $tanggal_checked);
				    array_push($arr_res, $arr_res_ind);
				}
			}
		}
		$data['data_software'] = $data_software;
		$data['hasil_checker'] = $arr_res;
		// $data['data_software'] = $data_software;
		$string =  $this->load->view('pages_user/V_Hasil_Checker_PL', $data, TRUE);
		echo $string;
		return;
			
	}

	//Method untuk menghapus kebutuhan perangkat lunak
	function deletePL(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 2 && $this->session->userdata('id_role') != 1){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke fitur ini');
				redirect('/dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_pl', 'ID Perangkat Lunak', 'required');
			$this->form_validation->set_rules('id_matkul', 'ID Mata Kuliah', 'required');

			if($this->session->userdata('id_role') == 1){
				$this->load->model('Users');
				$rangkap_dosen = $this->Users->checkUserIsDosen($this->session->userdata('id'));
				if(!$rangkap_dosen){
					$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke fitur ini');
					redirect('/dashboard');
				}
			}

			$id_matkul = $this->input->post('id_matkul');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing Required Fields');
				redirect("/administrasi_matkul_detail?id=$id_matkul");
			}
			else{
				$id_pl = $this->input->post('id_pl');
				$this->load->model('Mata_kuliah');
				$milik_dosen = $this->Mata_kuliah->checkMatkulDosen($id_matkul, $this->session->userdata('id'));
				if(!$milik_dosen){
					$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke mata kuliah ini');
					redirect('/dashboard');
				}
				$this->load->model('Kebutuhan_pl');
				$this->load->model('Periode_akademik');
				$id_periode = $this->Mata_kuliah->getIndividualItem($id_matkul, 'ID_PERIODE');
				$checkPeriodeAktif = $this->Periode_akademik->checkIdAktif($id_periode);
				if($checkPeriodeAktif){
					$res_delete = $this->Kebutuhan_pl->removePL($id_pl);

					if($res_delete){
						$this->session->set_flashdata('success', 'Berhasil menghapus kebutuhan perangkat lunak');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
					}
					else{
						$this->session->set_flashdata('error', 'Gagal menghapus kebutuhan perangkat lunak');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
					}
				}
				else{
					$this->session->set_flashdata('error', 'Tidak dapat menghapus kebutuhan perangkat lunak karena periode akademik mata kuliah sudah selesai!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
			}
		}
		else{
			redirect('/');
		}
	}

	//Method untuk memasukkan informasi kebutuhan perangkat lunak suatu mata kuliah
	function insertPL(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 2){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke fitur ini');
				redirect('/dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_matkul', 'ID Mata Kuliah', 'required');
			$this->form_validation->set_rules('nama_pl', 'Nama Perangkat Lunak', 'required');
			$id_matkul = $this->input->post('id_matkul');
			if($this->session->userdata('id_role') == 1){
				$this->load->model('Users');
				$rangkap_dosen = $this->Users->checkUserIsDosen($this->session->userdata('id'));
				if(!$rangkap_dosen){
					$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke fitur ini');
					redirect('/dashboard');
				}
			}
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing Required Fields');
				redirect("/administrasi_matkul_detail?id=$id_matkul");
			}
			else{
				$id_matkul = $this->input->post('id_matkul');
				$this->load->model('Mata_kuliah');
				$milik_dosen = $this->Mata_kuliah->checkMatkulDosen($id_matkul, $this->session->userdata('id'));
				if(!$milik_dosen){
					$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke mata kuliah ini');
					redirect('/dashboard');
				}
				$nama_pl = $this->input->post('nama_pl');
				$nama_pl = str_replace(" ","",$nama_pl);
				$this->load->model('Kebutuhan_pl');
				$this->load->model('Periode_akademik');
				$id_periode = $this->Mata_kuliah->getIndividualItem($id_matkul, 'ID_PERIODE');
				$checkPeriodeAktif = $this->Periode_akademik->checkIdAktif($id_periode);
				if($checkPeriodeAktif){
					$res = $this->Kebutuhan_pl->insertPL($id_matkul, $nama_pl);
					if($res){
						$this->session->set_flashdata('success', 'Berhasil memasukkan kebutuhan perangkat lunak');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
					}
					else{
						$this->session->set_flashdata('error', 'Gagal memasukkan kebutuhan perangkat lunak');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
					}
				}
				else{
					$this->session->set_flashdata('error', 'Tidak dapat memasukkan kebutuhan perangkat lunak karena periode akademik mata kuliah sudah selesai!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
			}
		}
		else{
			redirect('/');
		}
	}

	//Method untuk menampilkan halaman pilihan mata kuliah yang akan dicek kebutuhan perangkat lunak-nya
	function loadPageCekPL(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 4){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke fitur ini!');
				redirect("/dashboard");
			}
			$data['title'] = 'Periksa Kebutuhan Perangkat Lunak | SI Operasional Lab. Komputasi TIF UNPAR';
			$this->load->model('Periode_akademik');
			$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();

			$id_periode_aktif = $this->Periode_akademik->getIDPeriodeAktif();
			if($id_periode_aktif){
				$uniq = $this->input->get('ref');
				$this->load->model('Data_software');
				$exists = $this->Data_software->checkLink($uniq);
				// print_r($exists);
				// return;
				if($exists){
					$data_sofware = $this->Data_software->getDataSoftware($uniq);
					$data['data_software_cek'] = $data_sofware[0]['DATA_SOFTWARE'];
					// print_r($data['data_software_cek']);
					// return;
					$this->Data_software->deleteLink($uniq);
					$data['data_software_cek'] = str_replace("-","",$data['data_software_cek']);
					$data['data_software_cek'] = str_replace(".","",$data['data_software_cek']);
					$data['data_software_cek'] = str_replace("(","",$data['data_software_cek']);
					$data['data_software_cek'] = str_replace(")","",$data['data_software_cek']);
					$data['data_software_cek'] = str_replace(" ","",$data['data_software_cek']);
					$data['data_software_cek'] = str_replace(",","",$data['data_software_cek']);
					$data['data_software_cek'] = str_replace("+","",$data['data_software_cek']);
					$data['data_software_cek'] = str_replace("/","",$data['data_software_cek']);
					$data['data_software_cek'] = htmlspecialchars($data['data_software_cek']);
					
					$this->load->model('Mata_kuliah');
					$data['list_matkul'] = $this->Mata_kuliah->getMatkul($id_periode_aktif);
					$this->load->view('template/Header', $data);
					$this->load->view('template/Sidebar', $data);
					$this->load->view('template/Topbar');
					$this->load->view('template/Notification');
					$this->load->view('pages_user/V_Kebutuhan_PL', $data);
					$this->load->view('template/Footer', $data);
				}
				else{
					$this->session->set_flashdata('error', 'Link tidak valid!');
					redirect('/dashboard');
				}
			}
			else{
				$this->session->set_flashdata('error', 'Tidak dapat melakukan pemeriksaan kebutuhan perangkat lunak karena tidak ada periode akademik yg sedang aktif!');
				redirect('/dashboard');
			}
		}
		else{
			redirect('/');
		}
	}


	//Method untuk melakukan load halaman detail mata kuliah
	function getDetailMataKuliah(){
		if($this->session->userdata('logged_in')){
			$this->load->model('Mata_kuliah');
			$this->load->model('Periode_akademik');
			$this->load->model('Kebutuhan_pl');
			$this->load->model('File_bantuan_ujian');
			$this->load->model('Checklist_ujian');
			$this->load->model('Daftar_lab');
			$this->load->model('Jadwal_matkul');
			$this->load->model('Users');
			$id_matkul = $_GET['id'];
			if($id_matkul == ""){
				redirect('/administrasi_matkul');
			}
			if($this->session->userdata('id_role') == 2){
				$milik_dosen = $this->Mata_kuliah->checkMatkulDosen($id_matkul, $this->session->userdata('id'));
				if(!$milik_dosen){
					redirect('/administrasi_matkul');
				}
			}
			$this->load->model('Peminjaman_lab');
			$data['count_lab'] = $this->Peminjaman_lab->countPeminjamanLabPending();
			$data['count_alat'] = $this->Peminjaman_lab->countPeminjamanAlatPending();
			//Method untuk cek apakah kalab bertindak sebagai dosen suatu mata kuliah
			$data['rangkap_dosen'] = false;
			if($this->session->userdata('id_role') == 1){
				$is_dosen = $this->Users->checkUserIsDosen($this->session->userdata('id'));
				if($is_dosen){
					$milik_dosen = $this->Mata_kuliah->checkMatkulDosen($id_matkul, $this->session->userdata('id'));
					if($milik_dosen){
						$data['rangkap_dosen'] = true;
					}
				}
			}
			
			$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();
			$id_periode_aktif = $this->Periode_akademik->getIDPeriodeAktif();
			$data['title'] = 'Detail Mata Kuliah | SI Akademik Lab. Komputasi TIF UNPAR';
			$nama_matkul = $this->Mata_kuliah->getIndividualItem($id_matkul, "NAMA_MATKUL");
			if(!$nama_matkul){
				$this->session->set_flashdata('error', 'Mata Kuliah tidak tersedia!');
				redirect('/administrasi_matkul');
			}
			$id_periode_matkul = $this->Mata_kuliah->getIndividualItem($id_matkul, 'ID_PERIODE');
			$flag = true;
			if($id_periode_aktif != $id_periode_matkul){
				$flag = false;
			}
			$this->load->model('Ruangan_ujian');
			$data['flag'] = $flag;
			$data['nama_matkul'] = $nama_matkul;
			$data['info_matkul'] = $this->Mata_kuliah->getInformasiBasicMatkul($id_matkul);
			$array_data_uts = $this->Mata_kuliah->cekJadwalUjian($id_matkul, "UTS");
			if($array_data_uts[0]['TANGGAL_UTS'] != NULL){

				$data['set_uts'] = true;
				$data['tanggal_uts'] = $array_data_uts[0]['TANGGAL_UTS'];
				$data['jam_mulai_uts'] = $array_data_uts[0]['JAM_MULAI_UTS'];
				$data['jam_selesai_uts'] = $array_data_uts[0]['JAM_SELESAI_UTS'];
				$start_event = $data['tanggal_uts']." ".$data['jam_mulai_uts']; 
				$end_event = $data['tanggal_uts']." ".$data['jam_selesai_uts']; 
				$data['list_lab_uts'] = $this->gesListLab($start_event, $end_event);
				$data['lab_uts'] = $this->Ruangan_ujian->getDataRuanganUjian($id_matkul, 'UTS');
			}
			else{
				$data['set_uts'] = false;
			}
			$array_data_uas = $this->Mata_kuliah->cekJadwalUjian($id_matkul, "UAS");
			if($array_data_uas[0]['TANGGAL_UAS'] != NULL){
				$data['set_uas'] = true;
				$data['tanggal_uas'] = $array_data_uas[0]['TANGGAL_UAS'];
				$data['jam_mulai_uas'] = $array_data_uas[0]['JAM_MULAI_UAS'];
				$data['jam_selesai_uas'] = $array_data_uas[0]['JAM_SELESAI_UAS'];
				$start_event = $data['tanggal_uas']." ".$data['jam_mulai_uas']; 
				$end_event = $data['tanggal_uas']." ".$data['jam_mulai_uas']; 
				$data['list_lab_uas'] = $this->gesListLab($start_event, $end_event);
				$data['lab_uas'] = $this->Ruangan_ujian->getDataRuanganUjian($id_matkul, 'UAS');
			}
			else{
				$data['set_uas'] = false;
			}
			$data['daftar_pl'] = $this->Kebutuhan_pl->getPL($id_matkul);
			$data['file_bantuan'] = $this->File_bantuan_ujian->getFileBantuan($id_matkul);
			$data['checklist_uts'] = $this->Checklist_ujian->getChecklist($id_matkul, 0);
			$data['checklist_uas'] = $this->Checklist_ujian->getChecklist($id_matkul, 1);
			$data['daftar_lab'] = $this->Daftar_lab->getListLab();
			$data['jadwal_kelas'] = $this->Jadwal_matkul->getJadwalMatkul($id_matkul);
			$data['page_detail_matkul'] = true;
			//$data['matkul'] = true;
			$this->load->view('template/Header', $data);
			$this->load->view('template/Sidebar', $data);
			$this->load->view('template/Topbar');
			$this->load->view('template/Notification');
			$this->load->view('pages_user/V_Detail_Matkul', $data);
			$this->load->view('template/Footer');
		}
		else{
			redirect('/');
		}
	}

	//Method untuk memasukkan tanggal UTS
	function insertTanggalUTS(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 3){
				redirect('/administrasi_matkul');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_matkul', 'ID Mata Kuliah', 'required');
			$this->form_validation->set_rules('tgl_uts', 'Tanggal UTS', 'required');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing Required Fields');
				redirect('/administrasi_matkul');
			}
			else{
				$id_matkul = $this->input->post('id_matkul');
				$tgl_uts = $this->input->post('tgl_uts');
				$tgl_uts = date("Y-m-d", strtotime($tgl_uts));
				$jam_mulai = $this->input->post('jam_mulai');
				$jam_selesai = $this->input->post('jam_selesai');
				$this->load->model('Mata_kuliah');
				$this->load->model('Periode_akademik');
				$id_periode = $this->Mata_kuliah->getIndividualItem($id_matkul, 'ID_PERIODE');
				$checkPeriodeAktif = $this->Periode_akademik->checkIdAktif($id_periode);
				if($checkPeriodeAktif){
					$array_tanggal_akademik = $this->Periode_akademik->getTanggalAkademik($id_periode);
					$start_uts = $array_tanggal_akademik[0]['START_UTS'];
					$end_uts = $array_tanggal_akademik[0]['END_UTS'];

					$check_in_range_uts = $this->check_in_range($start_uts, $end_uts, $tgl_uts, 'full');
					if(!$check_in_range_uts){
						$this->session->set_flashdata('error', 'Gagal menambahkan tanggal UTS karena tanggal UTS tidak berada dalam masa UTS periode akademik yg sdg berjalan!');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
					}
					if($jam_mulai >  $jam_selesai){
						$this->session->set_flashdata('error', 'Error! Jam mulai tidak boleh lebih besar dari jam selesai!');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
					}
					$data = array(
						'TANGGAL_UTS' => $tgl_uts,
						'JAM_MULAI_UTS' => $jam_mulai,
						'JAM_SELESAI_UTS' => $jam_selesai
					);
					$res = $this->Mata_kuliah->insertTanggalUjian($id_matkul, $data);
					if($res){
						$this->session->set_flashdata('success', 'Berhasil menambahkan tanggal UTS mata kuliah!');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
					}
					else{
						$this->session->set_flashdata('error', 'Gagal menambahkan tanggal UTS mata kuliah!');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
					}
				}
				else{
					$this->session->set_flashdata('error', 'Tidak dapat memasukkan jadwal UTS karena periode akademik mata kuliah sudah selesai!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
			}
		}
		else{
			redirect('/');
		}
	}

	//Method untuk memasukkan tanggal UAS
	function insertTanggalUAS(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 3){
				redirect('/administrasi_matkul');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_matkul', 'ID Mata Kuliah', 'required');
			$this->form_validation->set_rules('tgl_uas', 'Tanggal UAS', 'required');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing Required Fields');
				redirect('/administrasi_matkul');
			}
			else{
				$id_matkul = $this->input->post('id_matkul');
				$tgl_uas = $this->input->post('tgl_uas');
				$tgl_uas = date("Y-m-d", strtotime($tgl_uas));
				$jam_mulai = $this->input->post('jam_mulai');
				$jam_selesai = $this->input->post('jam_selesai');
				$this->load->model('Mata_kuliah');
				$this->load->model('Periode_akademik');
				$id_periode = $this->Mata_kuliah->getIndividualItem($id_matkul, 'ID_PERIODE');
				$checkPeriodeAktif = $this->Periode_akademik->checkIdAktif($id_periode);
				if($checkPeriodeAktif){
					$array_tanggal_akademik = $this->Periode_akademik->getTanggalAkademik($id_periode);
					$start_uas = $array_tanggal_akademik[0]['START_UAS'];
					$end_uas = $array_tanggal_akademik[0]['END_UAS'];

					$check_in_range_uas = $this->check_in_range($start_uas, $end_uas, $tgl_uas, 'full');
					if(!$check_in_range_uas){
						$this->session->set_flashdata('error', 'Gagal menambahkan tanggal UAS karena tanggal UAS tidak berada dalam masa UAS periode akademik yg sdg berjalan!');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
					}
					if($jam_mulai >  $jam_selesai){
						$this->session->set_flashdata('error', 'Error! Jam mulai tidak boleh lebih besar dari jam selesai!');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
					}
					$data = array(
						'TANGGAL_UAS' => $tgl_uas,
						'JAM_MULAI_UAS' => $jam_mulai,
						'JAM_SELESAI_UAS' => $jam_selesai
					);
					$res = $this->Mata_kuliah->insertTanggalUjian($id_matkul, $data);
					if($res){
						$this->session->set_flashdata('success', 'Berhasil menambahkan tanggal UAS mata kuliah!');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
					}
					else{
						$this->session->set_flashdata('error', 'Gagal menambahkan tanggal UAS mata kuliah!');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
					}
				}
				else{
					$this->session->set_flashdata('error', 'Tidak dapat memasukkan jadwal UAS karena periode akademik mata kuliah sudah selesai!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
			}
		}
		else{
			redirect('/');
		}
	}
	
	//Method ini digunakan untuk memasukkan mata kuliah.
	function addMatkul(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1 && $this->session->userdata('id_role') != 3){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('matkul', 'Mata Kuliah', 'required');
			// $this->form_validation->set_rules('kode_matkul', 'Kode Mata Kuliah', 'required');
			// $this->form_validation->set_rules('nama_matkul', 'Nama Mata Kuliah', 'required');
			$this->form_validation->set_rules('dosen_koor', 'Dosen Koordinator', 'required');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Kode & Nama Mata Kuliah & Dosen Koordinator tidak ditemukan!');
				redirect('/administrasi_matkul');
			}
			else{
				$matkul = $this->input->post('matkul');
				// $kode_matkul = $this->input->post('kode_matkul');
				// $nama_matkul = $this->input->post('nama_matkul');
				$dosen_koor = $this->input->post('dosen_koor');
				$this->load->model('Periode_akademik');
				$id_periode = $this->Periode_akademik->getIDPeriodeAktif();
				if($id_periode){
					$this->load->model('Mata_kuliah');
					$this->load->model('List_mata_kuliah');
					$arr_matkul = $this->List_mata_kuliah->getDataMatkulById($matkul);
					if(!$arr_matkul){
						$this->session->set_flashdata('error', 'Error! Data mata kuliah tidak ditemukan');
						redirect('/administrasi_matkul');
					}
					$kode_matkul = $arr_matkul[0]['KODE_MATKUL'];
					$nama_matkul = $arr_matkul[0]['NAMA_MATKUL'];
					$res = $this->Mata_kuliah->insertMatkul($id_periode, $kode_matkul, $nama_matkul, $dosen_koor);
					if($res){
						$this->session->set_flashdata('success', 'Berhasil menambahkan mata kuliah!');
						redirect('/administrasi_matkul');
					}
					else{
						$this->session->set_flashdata('error', 'Gagal menambahkan mata kuliah!');
						redirect('/administrasi_matkul');
					}
				}
				else{
					$this->session->set_flashdata('error', 'Tidak ada Periode Akademik yang sedang aktif!');
					redirect('/administrasi_matkul');
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk mendapatkan nama hari dari tanggal yang dipilih user
	private function getDay($date){
		date_default_timezone_set('Asia/Jakarta');
		$day = array ( 1 =>    'Monday',
			'Tuesday',
			'Wednesday',
			'Thursday',
			'Friday',
			'Saturday',
			'Sunday'
		);
		$day_num = date('N', strtotime($date)); 
		return $day[$day_num];
	}
	//Method untuk konversi nama hari dari numerik ke nama hari
	function convertNumDay($num_day, $tipe){
		if($tipe == 'eng'){
			$day = array ( 1 =>    'Monday',
				'Tuesday',
				'Wednesday',
				'Thursday',
				'Friday',
				'Saturday',
				'Sunday'
			);
		}
		else{
			$day = array ( 1 =>    'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu',
				'Minggu'
			);
		}
		return $day[$num_day];
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
	//Method untuk mendapatkan list lab yang tersedia untuk uts dan uas
	private function gesListLab($start_event, $end_event){
		$this->load->model('Daftar_lab');
		$daftar_lab = $this->Daftar_lab->getListLab();
		$this->load->model('Jadwal_lab');
		$lab_terpakai = $this->Jadwal_lab->checkPemakaianLab($start_event, $end_event);
		$arr_lab_tersedia = array();
		// print_r($lab_terpakai);
		// return;
		foreach ($daftar_lab as $list_lab) {
			$flag = true;
			$ID = $list_lab['ID'];
			$NAMA_LAB = $list_lab['NAMA_LAB'];
			$LOKASI = $list_lab['LOKASI'];
			if($lab_terpakai){
				foreach ($lab_terpakai as $lab_pakai) {
					$id_lab_pakai = $lab_pakai['ID_LAB_PAKAI'];
					if($ID == $id_lab_pakai){
						$flag = false;
					}
				}
			}
			

			if($flag){
				$arr_temp = array($ID, $NAMA_LAB, $LOKASI);
				array_push($arr_lab_tersedia, $arr_temp);
			}
		}
		// print_r($lab_terpakai);
		// return;
		if($arr_lab_tersedia){
			return $arr_lab_tersedia;
		}
		else{
			return false;
		}
	}
	//Method untuk mendapatkan seluruh tanggal berdasarkan tanggal mulai, tanggal akhir dan hari yang dipilih
	private function getAllDate($date_start, $date_end, $day){
		$date_start_time = strtotime($date_start);
	    $date_end_time   = strtotime($date_end);
	    $dates = array();
	    while ($date_start_time <= $date_end_time) {
	        if (in_array(date('l', $date_start_time), $day)) {
	           $dates[] = date('Y-m-d', $date_start_time);
	        }
	        $date_start_time = strtotime('+1 day', $date_start_time);
	    }
	    return $dates;
	}
	private function uploadFile($fileName){
		$sNewFileName 				= $fileName;
		$config['file_name'] 			= $sNewFileName;
		$config['upload_path']          = './uploads/file_bantuan/';
		$config['allowed_types']        = 'pdf|docx|zip';
		$config['detect_mime']        	= 'TRUE';
		$config['max_size']             = 2048;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
				
		if ( ! $this->upload->do_upload('file_bantuan')){
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