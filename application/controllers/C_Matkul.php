<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani Inisiasi dan Administrasi Mata Kuliah.
class C_Matkul extends CI_Controller{

	//Method untuk menampilkan halaman pilihan mata kuliah yang akan dicek kebutuhan perangkat lunak-nya
	function loadPageCekPL(){
		if($this->session->userdata('logged_in')){
			$data['title'] = 'Periksa Kebutuhan Perangkat Lunak | SI Akademik Lab. Komputasi TIF UNPAR';
			$this->load->model('Periode_akademik');
			$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();
			$id_periode_aktif = $this->Periode_akademik->getIDPeriodeAktif();
			if($id_periode_aktif){

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

	function getDetailMataKuliah(){
		if($this->session->userdata('logged_in')){
			$this->load->model('Mata_kuliah');
			$this->load->model('Periode_akademik');
			$this->load->model('Mhs_peserta');
			$id_matkul = $_GET['id'];
			$data['periode_aktif'] = $this->Periode_akademik->checkPeriodeAktif();
			$data['title'] = 'Detail Mata Kuliah | SI Akademik Lab. Komputasi TIF UNPAR';
			$nama_matkul = $this->Mata_kuliah->getIndividualItem($id_matkul, "NAMA_MATKUL");
			if(!$nama_matkul){
				$this->session->set_flashdata('error', 'Mata Kuliah tidak tersedia!');
				redirect('/administrasi_matkul');
			}
			$data['nama_matkul'] = $nama_matkul;
			$data['info_matkul'] = $this->Mata_kuliah->getInformasiBasicMatkul($id_matkul);
			$data['set_uts'] = $this->Mata_kuliah->cekJadwalUjian($id_matkul, "TANGGAL_UTS");
			$data['set_uas'] = $this->Mata_kuliah->cekJadwalUjian($id_matkul, "TANGGAL_UAS");
			$data['set_peserta'] = $this->Mhs_peserta->checkMhs($id_matkul);
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
		}
		else{
			redirect('/');
		}
	}
	
	//Method ini digunakan untuk memasukkan mata kuliah.
	function addMatkul(){
		if($this->session->userdata('logged_in')){
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
}
?>