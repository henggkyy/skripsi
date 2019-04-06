<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani proses input dan menampilkan halaman yang berhubungan dengan sistem penggajian dan absensi admin
class C_Gaji_Admin extends CI_Controller {
	//Method untuk menampilkan halaman daftar laporan/absensi admin
	function loadHalamanLaporan(){
		if($this->session->userdata('logged_in')){
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
				$tgl_masuk = $this->input->post('tgl_masuk');
				$tgl_masuk = date("Y-m-d", strtotime($tgl_masuk));
				$jam_mulai = $this->input->post('jam_mulai');
				$jam_selesai = $this->input->post('jam_selesai');
				$istirahat = $this->input->post('istirahat');
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

				$hari = $this->getDay($tgl_masuk);
				$jam_masuk_data = strtotime($jam_mulai);
	            $jam_keluar_data = strtotime($jam_selesai);
	            $total_jam = $jam_keluar_data - $jam_masuk_data;
				$total_jam = (floor((($total_jam/60)/60)));
				$waktu_real = $total_jam - $istirahat;
				$this->load->model('Konfigurasi_gaji');
				
				$tarif = $this->Konfigurasi_gaji->getIndividualItem('TARIF');
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
					'BIAYA' => $biaya
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
			$tarif = $this->input->post('tarif');
			$jam_max = $this->input->post('jam_max');
			if($tarif != "" && $jam_max != ""){
				if($tarif <= 0 && $jam_max <= 0){
					echo "Value tarif dan/atau jam maksimal tidak boleh lebih kecil atau sama dengan 0";
					return;
				}
				$this->load->model('Konfigurasi_gaji');
				$data = array(
					'TARIF' => $tarif,
					'JAM_MAX' => $jam_max
				);
				$res = $this->Konfigurasi_gaji->editKonfigurasi($data);
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