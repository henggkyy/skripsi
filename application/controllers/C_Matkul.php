<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani Inisiasi dan Administrasi Mata Kuliah.
class C_Matkul extends CI_Controller{
	//Method untuk memasukkan jadwal kelas setiap mata kuliah
	function insertJadwalKelas(){
		if($this->session->userdata('logged_in')){
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
				$date_time = date("Y-m-d h:i:sa");
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
	//Method untuk memasukkan file-file bantuan ujian
	function insertFileBantuan(){
		if($this->session->userdata('logged_in')){
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
					$tanggal_insert = date("Y-m-d h:i:sa");
					$data = array(
						'NAMA_FILE_USER' => $nama_keterangan,
						'PATH_FILE' => $namaFileHash,
						'TIPE_UJIAN' => $tipe_ujian,
						'ID_MATKUL' => $id_matkul,
						'LAST_UPDATE'=> $tanggal_insert
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
		// if($this->session->userdata('logged_in')){
			// $this->load->library('form_validation');
			// $this->form_validation->set_rules('data_software', 'Data Perangkat Lunak', 'required');
			// $this->form_validation->set_rules('id_matkul_cek', 'ID Mata Kuliah', 'required');
			// if ($this->form_validation->run() == FALSE){
			// 	echo $this->input->post('data_software');
			// 	echo $this->input->post('id_matkul_cek');
			// 	return;
			// }
			// else{
				$data_sofware = $this->input->get('data_software');
				$data_sofware = strtolower($data_sofware);
				$id_matkul = $this->input->get('id_matkul_cek');
				date_default_timezone_set("Asia/Jakarta");
				$tanggal_checked = date("Y-m-d h:i:sa");
				$this->load->model('Kebutuhan_pl');
				$this->load->model('Mata_kuliah');
				$data_pl = $this->Kebutuhan_pl->getPL($id_matkul);
				$arr_res = array();
				$data['nama_matkul'] = $this->Mata_kuliah->getIndividualItem($id_matkul, 'NAMA_MATKUL');
				if(isset($data_pl) && $data_pl){
					foreach ($data_pl as $pl) {
						$tanggal_checked = date("Y-m-d h:i:sa");
						$arr_res_ind = array();
						if(strpos($data_sofware, $pl['NAMA_PL']) !== false){
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

				$data['hasil_checker'] = $arr_res;
				$string =  $this->load->view('pages_user/V_Hasil_Checker_PL', $data, TRUE);
				echo $string;
				return;
			// }
		// }
		// else{
		// 	redirect('/');
		// }
	}

	//Method untuk menghapus kebutuhan perangkat lunak
	function deletePL(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_pl', 'ID Perangkat Lunak', 'required');
			$this->form_validation->set_rules('id_matkul', 'ID Mata Kuliah', 'required');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing Required Fields');
				redirect("/administrasi_matkul_detail?id=$id_matkul");
			}
			else{
				$id_pl = $this->input->post('id_pl');
				$id_matkul = $this->input->post('id_matkul');
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
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_matkul', 'ID Mata Kuliah', 'required');
			$this->form_validation->set_rules('nama_pl', 'Nama Perangkat Lunak', 'required');

			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing Required Fields');
				redirect("/administrasi_matkul_detail?id=$id_matkul");
			}
			else{
				$id_matkul = $this->input->post('id_matkul');
				$nama_pl = $this->input->post('nama_pl');
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
			$data['title'] = 'Periksa Kebutuhan Perangkat Lunak | SI Akademik Lab. Komputasi TIF UNPAR';
			$this->load->model('Periode_akademik');
			$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();

			$id_periode_aktif = $this->Periode_akademik->getIDPeriodeAktif();
			if($id_periode_aktif){
				$data['data_software_cek'] = $this->input->get('data_software');
				// print_r($this->input->get('data_software'));
				// return;
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
				$this->load->view('template/Footer');
			}
			else{
				$this->session->set_flashdata('error', 'Tidak dapat melakukan pemeriksaan kebutuhan perangkat lunak karena tidak ada periode akademik yg sedang aktif!');
				redirect('/administrasi_matkul');
			}
		}
		else{
			redirect('/');
		}
	}

	//Method untuk memasukkan jadwal perkuliahan ke dalam tabel jadwal pemakaian laboratorium
	function insertJadwalPerkuliahan(){
		if($this->session->userdata('logged_in')){
			$hari     =  array('Monday');
			$tanggal = $this->getAllDate('2019-03-28', '2019-04-28', $hari);
			print_r($tanggal);
			return;
		}
		else{
			redirect('/');
		}
	}

	//Method untuk memasukkan mahasiswa peserta suatu mata kuliah
	//Dalam method ini akan dilakukan pembacaan data mahasiswa dari file excel menggunakan PHPSpreadSheet
	function insertMahasiswa(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_matkul', 'ID Mata Kuliah', 'required');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing Required Fields');
				redirect('/administrasi_matkul');
			}
			else{
				$id_matkul = $this->input->post('id_matkul');
				if(empty($_FILES['excel_mhs']['name'])){
					$this->session->set_flashdata('error', 'Missing Required Fields');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}

				$this->load->model('Mata_kuliah');
				$this->load->model('Periode_akademik');
				$this->load->model('Mhs_peserta');

				$id_periode = $this->Mata_kuliah->getIndividualItem($id_matkul, 'ID_PERIODE');
				$checkPeriodeAktif = $this->Periode_akademik->checkIdAktif($id_periode);
				if($checkPeriodeAktif){
					$this->load->library('MyReadFilter');
					$filterSubset = new MyReadFilter();
					$inputFileType = 'Xlsx';
					$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
					$reader->setReadDataOnly(true);
					$reader->setReadFilter($filterSubset);
					$spreadsheet = $reader->load($_FILES['excel_mhs']['tmp_name']);
		     
				    $sheetData = $spreadsheet->getActiveSheet()->toArray();
				    
				    $data_mhs_arr = array();
				    $iterator = 0;
				    foreach ($sheetData as $data_mhs) {
				    	if($data_mhs[0] != ""){
				    		$data_mhs_arr[$iterator]['NPM_MHS'] = $data_mhs[0]; 
				    		$data_mhs_arr[$iterator]['NAMA_MHS'] = $data_mhs[1]; 
				    		$data_mhs_arr[$iterator]['ID_MATKUL'] = $id_matkul; 
				    		$iterator++;
				    	}
				    }

				    $res_upload_db = $this->Mhs_peserta->insertMhs($data_mhs_arr);
				    if($res_upload_db){
				    	$this->session->set_flashdata('success', 'Berhasil memasukkan peserta mata kuliah!');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
				    }
				    else{
				    	$this->session->set_flashdata('error', 'Gagal memasukkan peserta mata kuliah!');
						redirect("/administrasi_matkul_detail?id=$id_matkul");
				    }
				    
				}
				else{
					$this->session->set_flashdata('error', 'Tidak dapat memasukkan peserta mata kuliah karena periode akademik mata kuliah sudah selesai!');
					redirect("/administrasi_matkul_detail?id=$id_matkul");
				}
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
			$this->load->model('Mhs_peserta');
			$this->load->model('Kebutuhan_pl');
			$this->load->model('File_bantuan_ujian');
			$this->load->model('Checklist_ujian');
			$this->load->model('Daftar_lab');
			$this->load->model('Jadwal_matkul');
			$id_matkul = $_GET['id'];

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

			$data['flag'] = $flag;
			$data['nama_matkul'] = $nama_matkul;
			$data['info_matkul'] = $this->Mata_kuliah->getInformasiBasicMatkul($id_matkul);
			$data['set_uts'] = $this->Mata_kuliah->cekJadwalUjian($id_matkul, "TANGGAL_UTS");
			$data['set_uas'] = $this->Mata_kuliah->cekJadwalUjian($id_matkul, "TANGGAL_UAS");
			$data['set_peserta'] = $this->Mhs_peserta->checkMhs($id_matkul);
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

					$res = $this->Mata_kuliah->insertTanggalUjian($id_matkul, "TANGGAL_UTS", $tgl_uts);
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

					$res = $this->Mata_kuliah->insertTanggalUjian($id_matkul, "TANGGAL_UAS", $tgl_uas);
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
			$this->form_validation->set_rules('kode_matkul', 'Kode Mata Kuliah', 'required');
			$this->form_validation->set_rules('nama_matkul', 'Nama Mata Kuliah', 'required');
			$this->form_validation->set_rules('dosen_koor', 'Dosen Koordinator', 'required');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Kode & Nama Mata Kuliah & Dosen Koordinator tidak ditemukan!');
				redirect('/administrasi_matkul');
			}
			else{
				$kode_matkul = $this->input->post('kode_matkul');
				$nama_matkul = $this->input->post('nama_matkul');
				$dosen_koor = $this->input->post('dosen_koor');
				$this->load->model('Periode_akademik');
				$id_periode = $this->Periode_akademik->getIDPeriodeAktif();
				if($id_periode){
					$this->load->model('Mata_kuliah');
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