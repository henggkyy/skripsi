<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani aksi mengenai proses Peminjaman
class C_Peminjaman extends CI_Controller{
	//Constructor Controller
	function __construct() {
        parent::__construct();
        $this->load->library('google');
    }
    //Method untuk menampilkan form peminjaman pada halaman admin
    function loadFormPeminjaman(){
    	if($this->session->userdata('logged_in')){
    		if($this->session->userdata('id_role') == 1){
    			$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
    		}
    		$data['title'] = "Form Peminjaman Alat / Ruangan Laboratorium | SI Operasional Lab. Komputasi TIF UNPAR";
			$this->load->model('Alat_lab');
			$data['form_peminjaman'] = true;
			$data['daftar_alat'] = $this->Alat_lab->getAllAlat();
			$this->load->model('Daftar_lab');
			$data['daftar_lab'] = $this->Daftar_lab->getListLab();
			$this->load->view('template/Header', $data);
			$this->load->view('template/Sidebar', $data);
			$this->load->view('template/Topbar');
			$this->load->view('template/Notification');
			$this->load->view('pages_user/V_Form_Peminjaman', $data);
			$this->load->view('template/Footer');
    	}
    	else{
    		redirect('/');
    	}
    }
	//Method untuk melakukan load halaman pilihan apakah ingin meminjam laboratorium atau alat lab
	function loadHomePeminjaman(){

		if($this->session->userdata('logged_in_public')){
			$data['title'] = "Form Peminjaman Alat / Ruangan Laboratorium | SI Operasional Lab. Komputasi TIF UNPAR";
			$this->load->model('Alat_lab');
			$data['daftar_alat'] = $this->Alat_lab->getAllAlat();
			$this->load->model('Daftar_lab');
			$data['daftar_lab'] = $this->Daftar_lab->getListLab();
			$this->load->view('pages_user/V_Home_Peminjaman', $data);
		}
		else{
			redirect('/');
		}
	}

	//Method untuk menindaklanjuti permintaan peminjaman laboratorium
	function tindaklanjutiPinjaman(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 1){
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke menu ini!');
				redirect('/dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('tindakan', 'Tindakan', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
			$this->form_validation->set_rules('id_pinjaman', 'ID Pinjaman', 'required');
			if($this->session->userdata('id_role') != 1){
				redirect('/dashboard');
			}
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error_message', 'Missing required Field!');
		        redirect('/data_peminjaman_lab');
			}
			else{
				$id_pinjaman = $this->input->post('id_pinjaman');
				$tindakan = $this->input->post('tindakan');
				$keterangan = $this->input->post('keterangan');
				$this->load->model('Peminjaman_lab');
				$id_tindakan = $this->Peminjaman_lab->getIndividualItem($id_pinjaman, "DISETUJUI");
				if($id_tindakan != 0){
					$this->session->set_flashdata('error', 'Permintaan tersebut telah ditindaklanjuti!');
					redirect('/peminjaman_lab');
				}
				$id_alat = $this->Peminjaman_lab->getIndividualItem($id_pinjaman, "ID_ALAT");
				$email = $this->Peminjaman_lab->getIndividualItem($id_pinjaman, "EMAIL_PEMINJAM");
				$keperluan = $this->Peminjaman_lab->getIndividualItem($id_pinjaman, "KEPERLUAN");
				$tgl_pinjam = $this->Peminjaman_lab->getIndividualItem($id_pinjaman, "TANGGAL_PINJAM");
				$jam_mulai = $this->Peminjaman_lab->getIndividualItem($id_pinjaman, "JAM_MULAI");
				$jam_selesai = $this->Peminjaman_lab->getIndividualItem($id_pinjaman, "JAM_SELESAI");
				$res = $this->Peminjaman_lab->tindaklanjutiPermintaanLab($id_pinjaman, $tindakan, $keterangan);
				if($res){
					if($id_alat == NULL){
						$this->load->model('Jadwal_lab');
						if($tindakan == 1){
							
							$id_jadwal = $this->Peminjaman_lab->getIndividualItem($id_pinjaman, 'ID_JADWAL');
							$res_insert_jadwal = $this->Jadwal_lab->updateJadwalBookingAccepted($id_jadwal);
							if($res_insert_jadwal){
								$this->session->set_flashdata('success', 'Berhasil menindaklanjuti permintaan peminjaman ruangan laboratorium');
								$subject = "Status Permintaan Peminjaman Ruangan Laboratorium";
								$message = "Hello, <b>$email!</b> <br> 
									Terimakasih telah menggunakan <i>website</i> <a href = \"\">Kegiatan Operasional Lab. Komputasi TIF UNPAR</a><br>
									<p>Permintaan peminjaman ruangan laboratorium Anda telah ditindaklanjuti oleh Kepala Laboratorium.</p>
									<br>
									<p><b>STATUS PEMINJAMAN : DISETUJUI</b></p>
									<p><b>Keterangan Kepala Lab </b>: $keterangan</p>
									<p>Silahkan Anda menunjukkan email ini kepada Kepala Laboratorium sebelum ruangan lab akan digunakan.</p>
									<br>
									<b>Data peminjaman : </b><br> 
									<p style= \"margin-left : 25px;\"><b>Acara/Keperluan</b> : $keperluan</p> 
									<p style= \"margin-left : 25px;\"><b>Tanggal Pinjam</b> : $tgl_pinjam</p>
									<p style= \"margin-left : 25px;\"><b>Jam Mulai</b> : $jam_mulai</p>
									<p style= \"margin-left : 25px;\"><b>Jam Selesai</b> : $jam_selesai</p>
									
							        	Terimakasih
									";
								$this->sendMail($email, $subject, $message, 'action');
								redirect("/peminjaman_lab");
							}
							else{
								$this->session->set_flashdata('error', 'Gagal memasukkan data peminjaman ke dalam database jadwal laboratorium');
								redirect("/peminjaman_lab");
							}
						}
						else{

							$id_jadwal = $this->Peminjaman_lab->getIndividualItem($id_pinjaman, 'ID_JADWAL');
							$res_set_jadwal_null = $this->Peminjaman_lab->setJadwalToNull($id_pinjaman);
							$res_delete_jadwal = $this->Jadwal_lab->deleteJadwalBooking($id_jadwal);
							$this->session->set_flashdata('success', 'Berhasil menindaklanjuti permintaan peminjaman ruangan laboratorium');
							$subject = "Status Permintaan Peminjaman Ruangan Laboratorium";
							$message = "Hello, <b>$email!</b> <br> 
									Terimakasih telah menggunakan <i>website</i> <a href = \"\">Kegiatan Operasional Lab. Komputasi TIF UNPAR</a><br>
									<p>Permintaan peminjaman ruangan laboratorium Anda telah ditindaklanjuti oleh Kepala Laboratorium.</p>
									<br>
									<p><b>STATUS PEMINJAMAN : TIDAK DISETUJUI</b></p>
									<p><b>Keterangan Kepala Lab </b>: $keterangan</p>
									<br>
									<b>Data peminjaman : </b><br> 
									<p style= \"margin-left : 25px;\"><b>Acara/Keperluan</b> : $keperluan</p> 
									<p style= \"margin-left : 25px;\"><b>Tanggal Pinjam</b> : $tgl_pinjam</p>
									<p style= \"margin-left : 25px;\"><b>Jam Mulai</b> : $jam_mulai</p>
									<p style= \"margin-left : 25px;\"><b>Jam Selesai</b> : $jam_selesai</p>
									
							        	Terimakasih
									";
							$this->sendMail($email, $subject, $message,  'action');
							redirect("/peminjaman_lab");
						}
					}
					else{
						if($tindakan == 1){
							$subject = "Status Permintaan Peminjaman Alat Laboratorium";
							$message = "Hello, <b>$email!</b> <br> 
									Terimakasih telah menggunakan <i>website</i> <a href = \"\">Kegiatan Operasional Lab. Komputasi TIF UNPAR</a><br>
									<p>Permintaan peminjaman alat laboratorium Anda telah ditindaklanjuti oleh Kepala Laboratorium.</p>
									<br>
									<p><b>STATUS PEMINJAMAN : DISETUJUI</b></p>
									<p><b>Keterangan Kepala Lab </b>: $keterangan</p>
									<p>Silahkan Anda menunjukkan email ini kepada Kepala Laboratorium sebelum alat lab akan digunakan.</p>
									<br>
									<b>Data peminjaman : </b><br> 
									<p style= \"margin-left : 25px;\"><b>Acara/Keperluan</b> : $keperluan</p> 
									<p style= \"margin-left : 25px;\"><b>Tanggal Pinjam</b> : $tgl_pinjam</p>
									<p style= \"margin-left : 25px;\"><b>Jam Mulai</b> : $jam_mulai</p>
									<p style= \"margin-left : 25px;\"><b>Jam Selesai</b> : $jam_selesai</p>
									
							        	Terimakasih
									";
							$this->sendMail($email, $subject, $message,  'action');
						}
						else{
							$subject = "Status Permintaan Peminjaman Alat Laboratorium";
							$message = "Hello, <b>$email!</b> <br> 
									Terimakasih telah menggunakan <i>website</i> <a href = \"\">Kegiatan Operasional Lab. Komputasi TIF UNPAR</a><br>
									<p>Permintaan peminjaman alat laboratorium Anda telah ditindaklanjuti oleh Kepala Laboratorium.</p>
									<br>
									<p><b>STATUS PEMINJAMAN : TIDAK DISETUJUI</b></p>
									<p><b>Keterangan Kepala Lab </b>: $keterangan</p>
									<br>
									<b>Data peminjaman : </b><br> 
									<p style= \"margin-left : 25px;\"><b>Acara/Keperluan</b> : $keperluan</p> 
									<p style= \"margin-left : 25px;\"><b>Tanggal Pinjam</b> : $tgl_pinjam</p>
									<p style= \"margin-left : 25px;\"><b>Jam Mulai</b> : $jam_mulai</p>
									<p style= \"margin-left : 25px;\"><b>Jam Selesai</b> : $jam_selesai</p>
									
							        	Terimakasih
									";
							$this->sendMail($email, $subject, $message,  'action');
						}
						$this->session->set_flashdata('success', 'Berhasil menindaklanjuti permintaan peminjaman alat');
						redirect("/peminjaman_alat");
					}
				}
				else{
					if($id_alat == NULL){
						$this->session->set_flashdata('error', 'Gagal menindaklanjuti permintaan peminjaman ruangan laboratorium');
						redirect("/peminjaman_lab");
					}
					else{
						$this->session->set_flashdata('error', 'Gagal menindaklanjuti permintaan peminjaman alat');
						redirect("/peminjaman_alat");
					}
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk memasukkan data peminjaman laboratorium yang dilakukan oleh pengguna yang login ke dalam SI
	function insertPeminjamanInAdmin(){
		if($this->session->userdata('logged_in')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('tgl_pinjam', 'Tanggal Pinjam', 'required');
			$this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
			$this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
			$this->form_validation->set_rules('keperluan', 'Keperluan', 'required');
			$this->form_validation->set_rules('choice', 'Mode', 'required');
			$mode = $this->input->post('choice');
			if($mode == 'lab'){
				$this->form_validation->set_rules('lab', 'Tipe Laboratorium', 'required');
			}
			else{
				$this->form_validation->set_rules('alat', 'Alat Laboratorium', 'required');
			}

			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required Field!');
		        redirect('/peminjaman/form');
			}
			else{
				$email_peminjam = $this->session->userdata('email');
				$nama_peminjam = $this->session->userdata('nama');
				$tipe_lab = $this->input->post('lab');
				$alat =  $this->input->post('alat');
				$tgl_pinjam = $this->input->post('tgl_pinjam');
				$tgl_pinjam = date('Y-m-d', strtotime($tgl_pinjam));
				$jam_mulai = $this->input->post('jam_mulai');
				$jam_selesai = $this->input->post('jam_selesai');
				if($jam_mulai > $jam_selesai){
					$this->session->set_flashdata('error', 'Tidak dapat melakukan permintaan peminjaman. Jam mulai tidak boleh lebih besar dari jam selesai peminjaman!');
					redirect("/peminjaman/form");
				}
				$validate_time_mulai = $this->validate_time($jam_mulai);
				$validate_time_selesai = $this->validate_time($jam_selesai);
				if(!$validate_time_mulai || !$validate_time_selesai){
					if(!$validate_time_mulai){
						$this->session->set_flashdata('error', "Error! Jam mulai peminjaman bukan format waktu yang benar! ($jam_mulai)");
					}
					else{
						$this->session->set_flashdata('error', "Error! Jam selesai peminjaman bukan format waktu yang benar! ($jam_selesai)");
					}
					redirect("/peminjaman/form");
				}
				date_default_timezone_set('Asia/Jakarta');
				$date_time = date("Y-m-d");
				$start_event = $tgl_pinjam. " ". $jam_mulai;
				$end_event = $tgl_pinjam. " ". $jam_selesai;
				
				if($mode == 'lab'){
					$arr_lab_tersedia = $this->cekKetersediaanLab($start_event, $end_event);

					$date_time = date('Y-m-d',(strtotime ( '+6 day' , strtotime ( $date_time) ) ));
					
					if($start_event < $date_time){
						$this->session->set_flashdata('error', 'Gagal mengajukan permintaan peminjaman! Tanggal pemakaian minimal H+7 dari tanggal hari ini!');
						redirect("/peminjaman/form");
					}
					//Cek ketersediaan laboratorium yang dipilih
					//If tidak tersedia, return ke home peminjaman
					if(!in_array($tipe_lab, $arr_lab_tersedia)){
						$this->session->set_flashdata('error', 'Ruangan laboratorium yang dipilih tidak dapat digunakan pada tanggal dan rentang waktu yang diinginkan karena sudah dipakai oleh kegiatan lain!');
						redirect("/peminjaman/form");
					}
				}
				else{
					$date_time = date('Y-m-d',(strtotime ( '+2 day' , strtotime ( $date_time) ) ));
					if($start_event < $date_time){
						$this->session->set_flashdata('error', 'Gagal mengajukan permintaan peminjaman! Tanggal pemakaian minimal H+3 dari tanggal hari ini!');
						redirect("/peminjaman/form");
					}
				}
				

				$keterangan = $this->input->post('keterangan');
				$keperluan = $this->input->post('keperluan');
				$this->load->model('Peminjaman_lab');
				$this->load->model('Jadwal_lab');
				if($mode == 'lab'){
					$data = array(
						'TITLE' => $keperluan,
						'ID_LAB' => $tipe_lab,
						'START_EVENT' => $start_event,
						'END_EVENT' => $end_event,
						'STATUS' => 0
					);
					$id_jadwal = $this->Jadwal_lab->insertJadwalBooking($data);
				}
				$res = $this->Peminjaman_lab->addPeminjaman($email_peminjam, $nama_peminjam, $tipe_lab, $alat, $tgl_pinjam, $jam_mulai, $jam_selesai, $keterangan, $keperluan, $id_jadwal);
				if($res){
					if($mode == 'lab'){
						$subject = "Permintaan Peminjaman Ruangan Laboratorium Komputasi TIF UNPAR";
						$nama_tipe_email = "ruangan";
						$this->session->set_flashdata('success', 'Berhasil melakukan permintaan peminjaman ruangan laboratorium. Silahkan tunggu notifikasi selanjutnya pada Email UNPAR Anda');
					}
					else{
						$subject = "Permintaan Peminjaman Alat Laboratorium Komputasi TIF UNPAR";
						$nama_tipe_email = "alat";
						$this->session->set_flashdata('success', 'Berhasil melakukan permintaan peminjaman alat laboratorium. Silahkan tunggu notifikasi selanjutnya pada Email UNPAR Anda');
					}

					$message = "Hello, <b>$email_peminjam!</b> <br> 
						Terimakasih telah menggunakan <i>website</i> <a href = \"\">Kegiatan Operasional Lab. Komputasi TIF UNPAR</a><br>
						<p>Permintaan peminjaman $nama_tipe_email laboratorium Anda akan ditindaklanjuti oleh Kepala Laboratorium Komputasi TIF UNPAR. Mohon menunggu proses dan notifikasi selanjutnya melalui e-mail Anda.</p>
						<br>
						<b>Data peminjaman : </b><br> 
						<p style= \"margin-left : 25px;\"><b>Acara/Keperluan</b> : $keperluan</p> 
						<p style= \"margin-left : 25px;\"><b>Tanggal Pinjam</b> : $tgl_pinjam</p>
						<p style= \"margin-left : 25px;\"><b>Jam Mulai</b> : $jam_mulai</p>
						<p style= \"margin-left : 25px;\"><b>Jam Selesai</b> : $jam_selesai</p>
						<p style= \"margin-left : 25px;\"><b>Keterangan</b> : $keterangan</p>
						
				        	Terimakasih
						";
					$this->sendMail($email_peminjam, $subject, $message,  'new');
					redirect("/peminjaman/form");
				}
				else{
					$this->session->set_flashdata('error', 'Terjadi kesalahan dalam melakukan permintaan peminjaman alat/ruangan laboratorium.');
					redirect("/peminjaman/form");
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk memasukkan data peminjaman laboratorium ke dalam database
	function insertPeminjaman(){
		if($this->session->userdata('logged_in_public')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('tgl_pinjam', 'Tanggal Pinjam', 'required');
			$this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
			$this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
			$this->form_validation->set_rules('keperluan', 'Keperluan', 'required');
			$this->form_validation->set_rules('choice', 'Mode', 'required');
			$mode = $this->input->post('choice');
			if($mode == 'lab'){
				$this->form_validation->set_rules('lab', 'Tipe Laboratorium', 'required');
			}
			else{
				$this->form_validation->set_rules('alat', 'Alat Laboratorium', 'required');
			}

			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required Field!');
		        redirect('/peminjaman');
			}
			else{
				$email_peminjam = $this->session->userdata('email');
				$nama_peminjam = $this->session->userdata('name');
				$tipe_lab = $this->input->post('lab');
				$alat =  $this->input->post('alat');
				$tgl_pinjam = $this->input->post('tgl_pinjam');
				$tgl_pinjam = date('Y-m-d', strtotime($tgl_pinjam));
				$jam_mulai = $this->input->post('jam_mulai');
				$jam_selesai = $this->input->post('jam_selesai');
				if($jam_mulai > $jam_selesai){
					$this->session->set_flashdata('error', 'Tidak dapat melakukan permintaan peminjaman. Jam mulai tidak boleh lebih besar dari jam selesai peminjaman!');
					redirect("/peminjaman");
				}
				$validate_time_mulai = $this->validate_time($jam_mulai);
				$validate_time_selesai = $this->validate_time($jam_selesai);
				if(!$validate_time_mulai || !$validate_time_selesai){
					if(!$validate_time_mulai){
						$this->session->set_flashdata('error', "Error! Jam mulai peminjaman bukan format waktu yang benar! ($jam_mulai)");
					}
					else{
						$this->session->set_flashdata('error', "Error! Jam selesai peminjaman bukan format waktu yang benar! ($jam_selesai)");
					}
					redirect("/peminjaman");
				}
				date_default_timezone_set('Asia/Jakarta');
				$date_time = date("Y-m-d");
				$start_event = $tgl_pinjam. " ". $jam_mulai;
				$end_event = $tgl_pinjam. " ". $jam_selesai;
				if($mode == 'lab'){
					$arr_lab_tersedia = $this->cekKetersediaanLab($start_event, $end_event);
					$date_time = date('Y-m-d',(strtotime ( '+6 day' , strtotime ( $date_time) ) ));
					if($start_event < $date_time){
						$this->session->set_flashdata('error', 'Gagal mengajukan permintaan peminjaman! Tanggal pemakaian minimal H+7 dari tanggal hari ini!');
						redirect("/peminjaman/form");
					}
					//Cek ketersediaan laboratorium yang dipilih
					//If tidak tersedia, return ke home peminjaman
					if(!in_array($tipe_lab, $arr_lab_tersedia)){
						$this->session->set_flashdata('error', 'Ruangan laboratorium yang dipilih tidak dapat digunakan pada tanggal dan rentang waktu yang diinginkan!');
						redirect("/peminjaman");
					}
				}
				else{
					$date_time = date('Y-m-d',(strtotime ( '+2 day' , strtotime ( $date_time) ) ));
					if($start_event < $date_time){
						$this->session->set_flashdata('error', 'Gagal mengajukan permintaan peminjaman! Tanggal pemakaian minimal H+3 dari tanggal hari ini!');
						redirect("/peminjaman/form");
					}
				}

				$keterangan = $this->input->post('keterangan');
				$keperluan = $this->input->post('keperluan');
				$this->load->model('Peminjaman_lab');
				$this->load->model('Jadwal_lab');
				if($mode == 'lab'){
					$data = array(
						'TITLE' => $keperluan,
						'ID_LAB' => $tipe_lab,
						'START_EVENT' => $start_event,
						'END_EVENT' => $end_event,
						'STATUS' => 0
					);
					$id_jadwal = $this->Jadwal_lab->insertJadwalBooking($data);
				}
				else{
					$id_jadwal = NULL;
				}
				$res = $this->Peminjaman_lab->addPeminjaman($email_peminjam, $nama_peminjam, $tipe_lab, $alat, $tgl_pinjam, $jam_mulai, $jam_selesai, $keterangan, $keperluan, $id_jadwal);
				if($res){
					if($mode == 'lab'){
						$subject = "Permintaan Peminjaman Ruangan Laboratorium Komputasi TIF UNPAR";
						$nama_tipe_email = "ruangan";
						$this->session->set_flashdata('success', 'Berhasil melakukan permintaan peminjaman ruangan laboratorium. Silahkan tunggu notifikasi selanjutnya pada Email UNPAR Anda');
					}
					else{
						$subject = "Permintaan Peminjaman Alat Laboratorium Komputasi TIF UNPAR";
						$nama_tipe_email = "alat";
						$this->session->set_flashdata('success', 'Berhasil melakukan permintaan peminjaman alat laboratorium. Silahkan tunggu notifikasi selanjutnya pada Email UNPAR Anda');
					}

					$message = "Hello, <b>$email_peminjam!</b> <br> 
						Terimakasih telah menggunakan <i>website</i> <a href = \"\">Kegiatan Operasional Lab. Komputasi TIF UNPAR</a><br>
						<p>Permintaan peminjaman $nama_tipe_email laboratorium Anda akan ditindaklanjuti oleh Kepala Laboratorium Komputasi TIF UNPAR. Mohon menunggu proses dan notifikasi selanjutnya melalui e-mail Anda.</p>
						<br>
						<b>Data peminjaman : </b><br> 
						<p style= \"margin-left : 25px;\"><b>Acara/Keperluan</b> : $keperluan</p> 
						<p style= \"margin-left : 25px;\"><b>Tanggal Pinjam</b> : $tgl_pinjam</p>
						<p style= \"margin-left : 25px;\"><b>Jam Mulai</b> : $jam_mulai</p>
						<p style= \"margin-left : 25px;\"><b>Jam Selesai</b> : $jam_selesai</p>
						<p style= \"margin-left : 25px;\"><b>Keterangan</b> : $keterangan</p>
						
				        	Terimakasih
						";
					$debug = $this->sendMail($email_peminjam, $subject, $message, 'new');
					// print_r($debug);
					// return;
					redirect("/peminjaman");
				}
				else{
					$this->session->set_flashdata('error', 'Terjadi kesalahan dalam melakukan permintaan peminjaman alat/ruangan laboratorium.');
					redirect("/peminjaman");
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk melakukan validasi waktu yang diinput pengguna
	public function validate_time($str){
		$array_jam = explode(':', $str);
		$hh = $array_jam[0];
		$mm = $array_jam[1];
		if (!is_numeric($hh) || !is_numeric($mm)){
			return FALSE;
		}
		else if ((int) $hh > 24 || (int) $mm > 59){
		    return FALSE;
		}
		else if (mktime((int) $hh, (int) $mm) === FALSE){
		    return FALSE;
		}
		return TRUE;
	}
	//Method untuk mengirimkan email ke pengguna
	private function sendMail($email, $subject, $body, $tipe){
		$this->load->model('Users');
		$this->load->library('email');
		$email_kalab = $this->Users->getEmailKalab();
		$config['protocol']    = 'smtp';
		$config['smtp_host']    = 'ssl://smtp.gmail.com';
		$config['smtp_port']    = '465';
		$config['smtp_timeout'] = '20';
		$config['smtp_user']    = '*user_email*';
		$config['smtp_pass']    = '*user_pass*';
		$config['charset']    = 'iso-8859-1';
		$config['newline']    = "\r\n";
		$config['mailtype'] = 'html'; // or html
		$config['validation'] = TRUE; // bool whether to validate email or not      
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");
		$this->email->set_mailtype("html");
		$this->email->from('henggkyy@gmail.com', 'Hengky Surya');
		if($tipe == 'new'){
			$this->email->to($email, $email_kalab); 
		}
    	else{
    		$this->email->to($email);
    	}
    	$this->email->subject($subject);
    	$this->email->message($body);  
		if(!$this->email->send()){
	        $debug_email = $this->email->print_debugger();
	        return $debug_email;
	    }
		//$result = $this->email->send();
	}
	//Method untuk mengecek ketersediaan lab pada jam mulai dan jam selesai yang diinput oleh user.
	private function cekKetersediaanLab($start_event, $end_event){
		$daftar_lab = $this->getAllListLab();

		$this->load->model('Jadwal_lab');
		$lab_terpakai = $this->Jadwal_lab->checkPemakaianLab($start_event, $end_event);
		$arr_lab_tersedia = array();
		// print_r($lab_terpakai);
		// return;
		foreach ($daftar_lab as $list_lab) {
			$flag = true;
			$id = $list_lab['ID'];
			if($lab_terpakai){
				foreach ($lab_terpakai as $lab_pakai) {
					$id_lab_pakai = $lab_pakai['ID_LAB_PAKAI'];
					if($id == $id_lab_pakai){
						$flag = false;
					}
				}
			}
			

			if($flag){
				
				array_push($arr_lab_tersedia, $id);
			}
		}
		return $arr_lab_tersedia;
	}
	//Method untuk mendapatkan daftar seluruh laboratorium
	private function getAllListLab(){
		$this->load->model('Daftar_lab');
		$daftar_lab = $this->Daftar_lab->getListLab();
		if($daftar_lab){
			return $daftar_lab;
		}
		else{
			return false;
		}
	}
}
?>