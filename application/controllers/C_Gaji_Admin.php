<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani proses input dan menampilkan halaman yang berhubungan dengan sistem penggajian dan absensi admin
class C_Gaji_Admin extends CI_Controller {
	//Method untuk mencetak laporan gaji admin
	function cetakLaporanGajiAdmin(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 4){
				redirect('dashboard');
			}
			$id_periode = $this->input->get('id_periode');
			if($id_periode != ""){
				$id_admin = $this->session->userdata('id');
				$data['title'] = 'Cetak Laporan Gaji/Absensi Admin | SI Akademik Lab. Komputasi TIF UNPAR';
				$this->load->model('Periode_gaji');
				$this->load->model('Laporan_gaji_admin');
				$this->load->model('Users');
				$this->load->model('Konfigurasi_gaji');
				$is_admin = $this->Users->checkUserRole($id_admin, 4);
				if(!$is_admin){
					redirect('laporan_gaji/report');
				}
				$data['detail_admin'] = $this->Users->getUserById($id_admin);
				$data['nama_periode'] = $this->Periode_gaji->getIndividualItem($id_periode, 'KETERANGAN');
				$data['daftar_gaji'] = $this->Laporan_gaji_admin->getDataLaporan($id_periode, $id_admin);
				$array_data_tarif_jam = $this->Laporan_gaji_admin->getTarifAndJam($id_periode, $id_admin);
				$data['tarif'] = $array_data_tarif_jam[0]['TARIF_AKTIF'];
				$data['maks_jam'] = $array_data_tarif_jam[0]['WAKTU_MAKS_AKTIF'];
				date_default_timezone_set('Asia/Jakarta');
				$data['now_date'] = date('Y-m-d h:i:sa');
				$this->load->view('template/Header', $data);
				$this->load->view('pages_user/V_Cetak_Laporan_Gaji', $data);
				$this->load->view('template/Footer');
			}
			else{
				redirect('laporan_gaji');
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk melakukan load detail laporan gaji apabila admin yang login
	function loadDaftarGajiAdmin(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 4){
				redirect('dashboard');
			}
			$data['title'] = 'Daftar Laporan Gaji/Absensi Admin | SI Akademik Lab. Komputasi TIF UNPAR';
			$id_admin = $this->session->userdata('id');
			$this->load->model('Periode_gaji');
			$this->load->model('Laporan_gaji_admin');
			$this->load->model('Users');
			$this->load->model('Konfigurasi_gaji');
			$is_admin = $this->Users->checkUserRole($id_admin, 4);
			if(!$is_admin){
				redirect('laporan_gaji/report');
			}
			$array_gaji_aktif = $this->Periode_gaji->getPeriodeAktif();
			
			if(isset($_GET['id_periode'])){
				$id_periode_selected = $_GET['id_periode'];
				if($id_periode_selected){
					$id_periode = $id_periode_selected;
				}
				else{
					$id_periode = $this->Periode_gaji->getLastActiveId();
				}
			}
			else{
				if($array_gaji_aktif){
					$id_periode = $array_gaji_aktif[0]['ID'];
				}
				else{
					$id_periode = $this->Periode_gaji->getLastActiveId();
				}
			}
			
			$data['data_periode'] = $this->Periode_gaji->getAllPeriodeGaji();
			$data['detail_admin'] = $this->Users->getUserById($id_admin);
			$data['nama_periode'] = $this->Periode_gaji->getIndividualItem($id_periode, 'KETERANGAN');
			$data['daftar_gaji'] = $this->Laporan_gaji_admin->getDataLaporan($id_periode, $id_admin);
			$data['id_periode_aktif'] = $id_periode;
			$flag = true;
			$is_periode_aktif = $this->Periode_gaji->checkIDPeriodeAktif($id_periode);
			if(!$is_periode_aktif){
				$flag = false;
			}
			$data['laporan_gaji_admin'] = true;
			$data['flag'] = $flag;
			$data['id_admin'] = $id_admin;
			$array_data_tarif_jam = $this->Laporan_gaji_admin->getTarifAndJam($id_periode, $id_admin);
			$data['tarif'] = $array_data_tarif_jam[0]['TARIF_AKTIF'];
			$data['maks_jam'] = $array_data_tarif_jam[0]['WAKTU_MAKS_AKTIF'];
			$this->load->view('template/Header', $data);
			$this->load->view('template/Sidebar', $data);
			$this->load->view('template/Topbar');
			$this->load->view('template/Notification');
			$this->load->view('pages_user/V_Laporan_Gaji_Admin', $data);
			$this->load->view('template/Footer');
		}
		else{
			redirect('/');
		}
	}
	//Method untuk menghapus laporan gaji admin
	function hapusLaporanGaji(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 3){
				redirect('dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('uniq', 'UNIQ ID', 'required');
			$this->form_validation->set_rules('id_periode', 'ID Periode', 'required');
			$this->form_validation->set_rules('id_admin', 'ID Admin', 'required');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required fields!');
				redirect("laporan_gaji/report");
			}
			else{
				$uniq = $this->input->post('uniq');
				$id_periode = $this->input->post('id_periode');
				$id_admin = $this->input->post('id_admin');
				$this->load->model('Laporan_gaji_admin');
				$this->load->model('Periode_gaji');
				$is_periode_aktif = $this->Periode_gaji->checkIDPeriodeAktif($id_periode);
				if(!$is_periode_aktif){
					$this->session->set_flashdata('error', 'Error! Tidak dapat melakukan update karena periode laporan tidak dalam periode aktif!');
					redirect("laporan_gaji/detail?id_periode=$id_periode&id_admin=$id_admin");
				}
				$res = $this->Laporan_gaji_admin->deleteLaporanGaji($uniq, $id_admin, $id_periode);

				if($res){
					$this->session->set_flashdata('success', "Berhasil menghapus laporan gaji/absensi admin!");
					redirect("laporan_gaji/detail?id_periode=$id_periode&id_admin=$id_admin");
				}
				else{
					$this->session->set_flashdata('error', 'Gagal menghapus laporan gaji/absensi admin!');
					redirect("laporan_gaji/detail?id_periode=$id_periode&id_admin=$id_admin");
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk melakukan edit laporan gaji
	function editLaporanGaji(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 3){
				redirect('dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('uniq', 'UNIQ ID', 'required');
			$this->form_validation->set_rules('tgl_masuk', 'Tanggal Masuk', 'required');
			$this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
			$this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
			$this->form_validation->set_rules('istirahat', 'Istirahat', 'required');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required fields!');
				redirect("laporan_gaji/report");
			}
			else{
				$hash = $this->input->post('uniq');
				$id_periode = $this->input->post('id_periode');
				$id_admin = $this->input->post('id_admin');
				$this->load->model('Periode_gaji');
				$this->load->model('Laporan_gaji_admin');
				$tgl_masuk = $this->input->post('tgl_masuk');
				$tgl_masuk = date("Y-m-d", strtotime($tgl_masuk));
				$jam_mulai = $this->input->post('jam_mulai');
				$jam_selesai = $this->input->post('jam_selesai');
				if($jam_mulai > $jam_selesai){
					$this->session->set_flashdata('error', 'Error! Jam masuk tidak boleh melebihi jam keluar');
					redirect("laporan_gaji/detail?id_periode=$id_periode&id_admin=$id_admin");
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
					redirect("laporan_gaji/detail?id_periode=$id_periode&id_admin=$id_admin");
				}
				$istirahat = $this->input->post('istirahat');
				if($istirahat < 0){
					$this->session->set_flashdata('error', 'Jumlah jam istirahat tidak boleh lebih kecil dari 0!');
					redirect("laporan_gaji/detail?id_periode=$id_periode&id_admin=$id_admin");
				}
				
				$is_periode_aktif = $this->Periode_gaji->checkIDPeriodeAktif($id_periode);
				if(!$is_periode_aktif){
					$this->session->set_flashdata('error', 'Error! Tidak dapat melakukan update karena periode laporan tidak dalam periode aktif!');
					redirect("laporan_gaji/detail?id_periode=$id_periode&id_admin=$id_admin");
				}
				$tanggal_awal_periode = $this->Periode_gaji->getIndividualItem($id_periode, 'START_PERIODE');
				$tanggal_akhir_periode = $this->Periode_gaji->getIndividualItem($id_periode, 'END_PERIODE');
				// print_r($tgl_masuk);
				// return;
				if($tgl_masuk > $tanggal_akhir_periode || $tgl_masuk < $tanggal_awal_periode){
	                $this->session->set_flashdata('error', 'Tanggal Masuk tidak sesuai Periode Gaji Aktif.');
					redirect("laporan_gaji/detail?id_periode=$id_periode&id_admin=$id_admin");
				}

				$hari = $this->getDay($tgl_masuk);
				$jam_masuk_data = strtotime($jam_mulai);
	            $jam_keluar_data = strtotime($jam_selesai);
	            $total_jam = $jam_keluar_data - $jam_masuk_data;
				$total_jam = (floor((($total_jam/60)/60)));
				$waktu_real = $total_jam - $istirahat;
				$this->load->model('Konfigurasi_gaji');
				$this->load->model('Detail_user');
				$id_golongan = $this->Detail_user->getIndividualItem($id_admin, 'ID_GAJI');
				$array_konfigurasi = $this->Konfigurasi_gaji->getDataKonfigurasi($id_golongan);
				$tarif = $array_konfigurasi[0]['TARIF'];
				$waktu_maks = $array_konfigurasi[0]['JAM_MAX'];
				$biaya = $waktu_real * $tarif;
				$data = array(
					'HARI' => $hari,
					'TANGGAL_MASUK' => $tgl_masuk,
					'JAM_MASUK' => $jam_mulai,
					'JAM_KELUAR' => $jam_selesai,
					'TOTAL_JAM' => $total_jam,
					'ISTIRAHAT' => $istirahat,
					'WAKTU_REAL' => $waktu_real,
					'BIAYA' => $biaya
				);
				$res = $this->Laporan_gaji_admin->updateLaporanGaji($hash, $id_admin, $id_periode, $data);
				if($res){
					$this->session->set_flashdata('success', "Berhasil melakukan update laporan gaji/absensi admin pada tanggal $tgl_masuk ($jam_mulai - $jam_selesai)!");
					redirect("laporan_gaji/detail?id_periode=$id_periode&id_admin=$id_admin");
				}
				else{
					$this->session->set_flashdata('error', 'Gagal melakukan update laporan gaji/absensi admin!');
					redirect("laporan_gaji/detail?id_periode=$id_periode&id_admin=$id_admin");
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk memamnggil data input laporan gaji/admin untuk keperluan update
	//Method ini dipanggil menggunakan Jquery AJAX.
	function getInputLaporan(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 3){
				return;
			}
			$uniq = $this->input->get('uniq');
			if($uniq != ""){
				$this->load->model('Laporan_gaji_admin');
				$data['daftar_gaji'] = $this->Laporan_gaji_admin->getInputLaporan($uniq);
				if($data['daftar_gaji']){
					$data['uniq'] = $uniq;
					$string =  $this->load->view('pages_user/V_Template_Laporan_Gaji', $data, TRUE);
					echo $string;
					return;
				}
				else{
					echo 'Data tidak ditemukan';
					return;
				}
			}
		}
		else{
			echo "You dont have access!";
			return;
		}
	}
	//Method untuk mendapatkan detail seluruh gaji dari id periode dan admin yang dipilih
	//Pada menu ini akan disediakan detail untuk edit dan delete laporan gaji
	function getDaftarLaporan(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 3){
				redirect('dashboard');
			}
			$id_periode = $this->input->get('id_periode');
			$id_admin = $this->input->get('id_admin');
			if($id_periode != "" && $id_admin != ""){
				$data['title'] = 'Daftar Laporan Gaji/Absensi Admin | SI Akademik Lab. Komputasi TIF UNPAR';
				$this->load->model('Periode_gaji');
				$this->load->model('Laporan_gaji_admin');
				$this->load->model('Users');
				$this->load->model('Konfigurasi_gaji');
				$is_admin = $this->Users->checkUserRole($id_admin, 4);
				if(!$is_admin){
					redirect('laporan_gaji/report');
				}
				$data['detail_admin'] = $this->Users->getUserById($id_admin);
				$data['nama_periode'] = $this->Periode_gaji->getIndividualItem($id_periode, 'KETERANGAN');
				$data['daftar_gaji'] = $this->Laporan_gaji_admin->getDataLaporan($id_periode, $id_admin);
				$data['id_periode_aktif'] = $id_periode;
				$flag = true;
				$is_periode_aktif = $this->Periode_gaji->checkIDPeriodeAktif($id_periode);
				if(!$is_periode_aktif){
					$flag = false;
				}

				$data['flag'] = $flag;
				$data['id_admin'] = $id_admin;
				$array_data_tarif_jam = $this->Laporan_gaji_admin->getTarifAndJam($id_periode, $id_admin);
				$data['tarif'] = $array_data_tarif_jam[0]['TARIF_AKTIF'];
				$data['maks_jam'] = $array_data_tarif_jam[0]['WAKTU_MAKS_AKTIF'];
				$this->load->view('template/Header', $data);
				$this->load->view('template/Sidebar', $data);
				$this->load->view('template/Topbar');
				$this->load->view('template/Notification');
				$this->load->view('pages_user/V_Daftar_Laporan_Gaji', $data);
				$this->load->view('template/Footer');
			}
			else{
				redirect('laporan_gaji/report');
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk menampilkan halaman untuk cetak laporan gaji berdasarkan id periode dan id admin
	function cetakLaporanAdmin(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 3){
				redirect('dashboard');
			}
			$id_periode = $this->input->get('id_periode');
			$id_admin = $this->input->get('id_admin');
			if($id_periode != "" && $id_admin != ""){
				$data['title'] = 'Cetak Laporan Gaji/Absensi Admin | SI Akademik Lab. Komputasi TIF UNPAR';
				$this->load->model('Periode_gaji');
				$this->load->model('Laporan_gaji_admin');
				$this->load->model('Users');
				$this->load->model('Konfigurasi_gaji');
				$is_admin = $this->Users->checkUserRole($id_admin, 4);
				if(!$is_admin){
					redirect('laporan_gaji/report');
				}
				$data['detail_admin'] = $this->Users->getUserById($id_admin);
				$data['nama_periode'] = $this->Periode_gaji->getIndividualItem($id_periode, 'KETERANGAN');
				$data['daftar_gaji'] = $this->Laporan_gaji_admin->getDataLaporan($id_periode, $id_admin);
				$array_data_tarif_jam = $this->Laporan_gaji_admin->getTarifAndJam($id_periode, $id_admin);
				$data['tarif'] = $array_data_tarif_jam[0]['TARIF_AKTIF'];
				$data['maks_jam'] = $array_data_tarif_jam[0]['WAKTU_MAKS_AKTIF'];
				date_default_timezone_set('Asia/Jakarta');
				$data['now_date'] = date('Y-m-d H:i:s');
				$this->load->view('template/Header', $data);
				$this->load->view('pages_user/V_Cetak_Laporan_Gaji', $data);
				$this->load->view('template/Footer');
			}
			else{
				redirect('laporan_gaji/report');
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk menampilkan halaman daftar laporan/absensi admin
	function loadHalamanLaporan(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 3){
				redirect('dashboard');
			}
			$this->load->model('Periode_gaji');
			$this->load->model('Laporan_gaji_admin');
			$this->load->model('Users');
			$data['title'] = 'Laporan Gaji/Absensi Admin | SI Akademik Lab. Komputasi TIF UNPAR';
			$data['data_periode'] = $this->Periode_gaji->getAllPeriodeGaji();
			$array_periode_aktif = $this->Periode_gaji->getPeriodeAktif();
			if($array_periode_aktif){
				foreach ($array_periode_aktif as $periode) {
					$data['id_periode_aktif'] = $periode['ID'];
				}
			}
			else{
				$data['id_periode_aktif'] = $this->Periode_gaji->getLastActiveId();
			}
			$data['laporan_gaji'] = true;
			$id_periode_selected = $this->input->get('id_periode');
			if($id_periode_selected){
				$data['id_periode_aktif'] = $id_periode_selected;
			}
			$data['ket_periode'] = $this->Periode_gaji->getIndividualItem($data['id_periode_aktif'],'KETERANGAN');
			$data_admin = $this->Users->getAllUserByRole(4);
			$data['data_admin'] = $data_admin;
			$arr_jumlah_masuk = array();
			if($data_admin){
				foreach ($data_admin as $admin) {
					
					$jumlah_hari_masuk = $this->Laporan_gaji_admin->countJumlahMasuk($admin['ID'], $data['id_periode_aktif']);
					$arr_jml_masuk_ind = array($admin['ID'], $jumlah_hari_masuk);
					array_push($arr_jumlah_masuk, $arr_jml_masuk_ind);
				}
			}
			$data['jmlh_masuk'] = $arr_jumlah_masuk;
			$this->load->view('template/Header', $data);
			$this->load->view('template/Sidebar', $data);
			$this->load->view('template/Topbar');
			$this->load->view('template/Notification');
			$this->load->view('pages_user/V_List_Laporan_Gaji', $data);
			$this->load->view('template/Footer');
		}
		else{
			redirect('/');
		}
	}
	//Method untuk menangani input laporan gaji dari pengguna.
	function prosesInputGaji(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 3){
				redirect('dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_periode', 'ID Periode Gaji', 'required');
			$this->form_validation->set_rules('id_admin', 'ID Periode Gaji', 'required');
			$this->form_validation->set_rules('tgl_masuk', 'Tanggal Masuk', 'required');
			$this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
			$this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
			$this->form_validation->set_rules('istirahat', 'Istirahat', 'required');
			$id_periode = $this->input->post('id_periode');
			$id_admin = $this->input->post('id_admin');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required fields!');
				redirect("laporan_gaji/input?id_periode=$id_periode&id_admin=$id_admin");
			}
			else{
				$this->load->model('Periode_gaji');
				$this->load->model('Users');
				$this->load->model('Laporan_gaji_admin');
				$this->load->model('Detail_user');
				$tgl_masuk = $this->input->post('tgl_masuk');
				$tgl_masuk = date("Y-m-d", strtotime($tgl_masuk));
				$jam_mulai = $this->input->post('jam_mulai');
				$jam_selesai = $this->input->post('jam_selesai');
				$istirahat = $this->input->post('istirahat');
				if($jam_mulai > $jam_selesai){
					$this->session->set_flashdata('error', 'Error! Jam masuk tidak boleh melebihi jam keluar');
					redirect("laporan_gaji/input?id_periode=$id_periode&id_admin=$id_admin");
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
					redirect("laporan_gaji/input?id_periode=$id_periode&id_admin=$id_admin");
				}
				if($istirahat < 0){
					$this->session->set_flashdata('error', 'Jumlah jam istirahat tidak boleh lebih kecil dari 0!');
					redirect("laporan_gaji/input?id_periode=$id_periode&id_admin=$id_admin");
				}
				$is_periode_aktif = $this->Periode_gaji->checkIDPeriodeAktif($id_periode);
				$is_admin_aktif = $this->Users->checkAdminAktif($id_admin);
				if(!$is_periode_aktif || !$is_admin_aktif){
					redirect("laporan_gaji/input");
				}
				
				$tanggal_awal_periode = $this->Periode_gaji->getIndividualItem($id_periode, 'START_PERIODE');
				$tanggal_akhir_periode = $this->Periode_gaji->getIndividualItem($id_periode, 'END_PERIODE');
				if($tgl_masuk > $tanggal_akhir_periode || $tgl_masuk < $tanggal_awal_periode){
	                $this->session->set_flashdata('error', 'Tanggal Masuk tidak sesuai Periode Gaji Aktif.');
					redirect("laporan_gaji/input");
				}

				$hash = $this->generateHash(8);
				$exists = $this->Laporan_gaji_admin->checkHash($hash);
				while($exists){
					$hash = $this->generateHash(8);
					$exists = $this->Laporan_gaji_admin->checkHash($hash);
				}
				$id_golongan = $this->Detail_user->getIndividualItem($id_admin, 'ID_GAJI');
				$hari = $this->getDay($tgl_masuk);
				$jam_masuk_data = strtotime($jam_mulai);
	            $jam_keluar_data = strtotime($jam_selesai);
	            $total_jam = $jam_keluar_data - $jam_masuk_data;
				$total_jam = (floor((($total_jam/60)/60)));
				$waktu_real = $total_jam - $istirahat;
				$this->load->model('Konfigurasi_gaji');
				$array_konfigurasi = $this->Konfigurasi_gaji->getDataKonfigurasi($id_golongan);
				$tarif = $array_konfigurasi[0]['TARIF'];
				$waktu_maks = $array_konfigurasi[0]['JAM_MAX'];
				$biaya = $waktu_real * $tarif;
				$data = array(
					'UNIQ' => $hash,
					'ID_PERIODE' => $id_periode,
					'ID_ADMIN' => $id_admin,
					'HARI' => $hari,
					'TANGGAL_MASUK' => $tgl_masuk,
					'JAM_MASUK' => $jam_mulai,
					'JAM_KELUAR' => $jam_selesai,
					'TOTAL_JAM' => $total_jam,
					'ISTIRAHAT' => $istirahat,
					'WAKTU_REAL' => $waktu_real,
					'BIAYA' => $biaya,
					'TARIF_AKTIF' => $tarif,
					'WAKTU_MAKS_AKTIF' => $waktu_maks
				);
				$res = $this->Laporan_gaji_admin->insertGaji($data);
				if($res){
					$this->session->set_flashdata('success', "Berhasil menyimpan laporan gaji/absensi admin pada tanggal $tgl_masuk ($jam_mulai - $jam_selesai)!");
					redirect("laporan_gaji/input?id_periode=$id_periode&id_admin=$id_admin");
				}
				else{
					$this->session->set_flashdata('error', 'Gagal menyimpan laporan gaji/absensi admin!');
					redirect("laporan_gaji/input?id_periode=$id_periode&id_admin=$id_admin");
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk memasukkan daftar absensi admin
	function insertAbsensi(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 3){
				redirect('dashboard');
			}
			$data['title'] = 'Input Gaji/Absensi Admin | SI Akademik Lab. Komputasi TIF UNPAR';
			$this->load->model('Periode_gaji');
			$this->load->model('Users');
			$id_periode = $this->input->get('id_periode');
			$id_admin = $this->input->get('id_admin');
			if((isset($id_periode) && $id_periode) && (isset($id_admin) && $id_admin)){
				$is_periode_aktif = $this->Periode_gaji->checkIDPeriodeAktif($id_periode);
				$is_admin_aktif = $this->Users->checkAdminAktif($id_admin);
				if($is_periode_aktif && $is_admin_aktif){
					$data['data_aktif'] = $this->Periode_gaji->getPeriodeAktif();
					$data['data_admin'] = $this->Users->getUserById($id_admin);
					$this->load->view('template/Header', $data);
					$this->load->view('template/Sidebar', $data);
					$this->load->view('template/Topbar');
					$this->load->view('template/Notification');
					$this->load->view('pages_user/V_Form_Input_Gaji', $data);
					$this->load->view('template/Footer');
				}
				else{
					redirect("laporan_gaji/input");
				}
			}
			else{
				$data['input_gaji'] = true;
				$is_periode_aktif = $this->Periode_gaji->checkPeriodeAktif();
				$data['is_aktif'] = $is_periode_aktif;
				if($is_periode_aktif){
					$data['data_aktif'] = $this->Periode_gaji->getPeriodeAktif();
				}
				$data['data_admin'] = $this->Users->getDataAdminAktif();
				$this->load->view('template/Header', $data);
				$this->load->view('template/Sidebar', $data);
				$this->load->view('template/Topbar');
				$this->load->view('template/Notification');
				$this->load->view('pages_user/V_Insert_Gaji');
				$this->load->view('template/Footer');
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk melakukan editKonfigurasi
	//Method ini dipanggil dengan menggunakan Jquery AJAX
	function editKonfigurasi(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 3){
				return;
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('tarif', 'Tarif', 'required|numeric');
			$this->form_validation->set_rules('jam_max', 'Maksimal Jam', 'required|numeric');
			if ($this->form_validation->run() == FALSE){
				echo "Gagal melakukan edit! Tarif dan jam maksimal harus numerik!";
				return;
			}
			$tarif = $this->input->post('tarif');
			$jam_max = $this->input->post('jam_max');
			$id = $this->input->post('id');
			if($tarif != "" && $jam_max != "" && $id != ""){
				$this->load->model('Periode_gaji');
				$is_periode_aktif = $this->Periode_gaji->checkPeriodeAktif();
				if($is_periode_aktif){
					echo 'Tidak dapat melakukan edit golongan gaji karena terdapat periode gaji yang sedang berjalan!';
	            	return;
				}
				if($tarif <= 0 && $jam_max <= 0){
					echo "Value tarif dan/atau jam maksimal tidak boleh lebih kecil atau sama dengan 0";
					return;
				}
				$this->load->model('Konfigurasi_gaji');
				$data = array(
					'TARIF' => $tarif,
					'JAM_MAX' => $jam_max
				);
				$res = $this->Konfigurasi_gaji->editKonfigurasi($data, $id);
				if($res){
					echo 'Berhasil melakukan edit konfigurasi gaji!';
					return;
				}
				else{
					echo 'Gagal melakukan edit konfigurasi gaji!';
					return;
				}
			}
			else{
				echo "Gagal melakukan update konfigurasi";
				return;
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk menonaktifkan periode gaji
	function nonaktifkanPeriode(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 3){
				redirect('dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_periode_gaji', 'ID Periode Gaji', 'required');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required fields!');
				redirect('/laporan_gaji/periode');
			}
			else{
				$id_periode = $this->input->post('id_periode_gaji');
				$this->load->model('Periode_gaji');
				$is_id_aktif = $this->Periode_gaji->checkIDPeriodeAktif($id_periode);
				if(!$is_id_aktif){
					$this->session->set_flashdata('error', 'Error! Tidak dapat menonaktifkan periode gaji karena bukan merupakan periode yang sdg aktif!');
					redirect('/laporan_gaji/periode');
				}
				$data = array(
					'STATUS' => 0
				);
				$res = $this->Periode_gaji->nonaktifkanPeriode($data, $id_periode);
				if($res){
					$this->session->set_flashdata('success', 'Berhasil menonaktifkan periode gaji admin!');
					redirect('/laporan_gaji/periode');
				}
				else{
					$this->session->set_flashdata('error', 'Gagal menonaktifkan periode gaji admin!');
					redirect('/laporan_gaji/periode');
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk melakukan set periode gaji admin
	function setPeriodeGaji(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 3){
				redirect('dashboard');
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('ket_periode', 'Keterangan Periode Gaji', 'required');
			$this->form_validation->set_rules('start_periode', 'Tanggal Periode Awal', 'required');
			$this->form_validation->set_rules('end_periode', 'Tanggal Periode Akhir', 'required');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('error', 'Missing required fields!');
				redirect('/laporan_gaji/periode');
			}
			else{
				$this->load->model('Periode_gaji');
				$is_periode_aktif = $this->Periode_gaji->checkPeriodeAktif();
				if($is_periode_aktif){
					$this->session->set_flashdata('error', 'Error! Tidak dapat set periode gaji karena masih terdapat periode yang masih aktif!');
					redirect('/laporan_gaji/periode');
				}
				$ket_periode = $this->input->post('ket_periode');
				$start_periode = $this->input->post('start_periode');
				$end_periode = $this->input->post('end_periode');

				$start_periode = date("Y-m-d", strtotime($this->input->post('start_periode')));
				$end_periode = date("Y-m-d", strtotime($this->input->post('end_periode')));

				if(strtotime($start_periode) > strtotime($end_periode)){
					$this->session->set_flashdata('error', 'Error! Tanggal mulai periode lebih besar dibandingkan dengan tanggal selesai!');
					redirect('/laporan_gaji/periode');
				}
				
				$data = array(
					'START_PERIODE' => $start_periode,
					'END_PERIODE' => $end_periode,
					'KETERANGAN' => $ket_periode,
					'STATUS' => 1
				);
				$res = $this->Periode_gaji->insertPeriode($data);
				if($res){
					$this->session->set_flashdata('success', 'Berhasil melakukan set periode gaji admin!');
					redirect('/laporan_gaji/periode');
				}
				else{
					$this->session->set_flashdata('error', 'Gagal melakukan set periode gaji admin!');
					redirect('/laporan_gaji/periode');
				}
			}
		}
		else{
			redirect('/');
		}
	}
	//Method untuk melakukan set periode gaji admin
	function loadSetPeriode(){
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('id_role') != 3){
				redirect('dashboard');
			}
			$data['title'] = 'Periode Gaji Admin & Konfigurasi | SI Akademik Lab. Komputasi TIF UNPAR';
			$this->load->model('Periode_gaji');
			$this->load->model('Konfigurasi_gaji');
			$data['data_periode'] = $this->Periode_gaji->getAllPeriodeGaji();
			$data['periode_gaji'] = true;
			$is_periode_aktif = $this->Periode_gaji->checkPeriodeAktif();
			$data['is_aktif'] = $is_periode_aktif;
			$data['konfigurasi'] = $this->Konfigurasi_gaji->getKonfigurasi();
			$this->load->view('template/Header', $data);
			$this->load->view('template/Sidebar', $data);
			$this->load->view('template/Topbar');
			$this->load->view('template/Notification');
			$this->load->view('pages_user/V_Periode_Gaji_Admin');
			$this->load->view('template/Footer');
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
	//Method untuk melakukan generate hash
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