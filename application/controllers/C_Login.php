<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Class ini dibuat untuk menangani proses login dari pengguna
//Dalam class ini juga dibuat method untuk menangani logout pengguna dari aplikasi.
class C_Login extends CI_Controller {
	//Constructor Controller
	function __construct() {
        parent::__construct();
        $this->load->library('google');
    }
	//Method ini digunakan untuk melakukan load tampilan untuk login.
	//Apabila pengguna telah login ke dalam aplikasi, maka pengguna tidak akan perlu login kembali
	//dan tidak akan menampilkan halaman untuk login
	function loadLoginPage(){
		if(!$this->session->userdata('logged_in')){
			$data['google_login_url']=$this->google->get_login_url();
			$this->load->view('pages_user/V_Login', $data);
		}
		else{
			redirect('/dashboard');
		}
	}

	//Method untuk menangani email dan password yang diinput oleh pengguna
	//Method ini akan melakukan pengecekan terhadap pengguna yang telah terdaftar di database.
	function prosesLogin(){
		if(!$this->session->userdata('logged_in') && !$this->session->userdata('logged_in_public')){
			$google_data = $this->google->validate();
			$email = $google_data['email'];    
			$email_domain = substr($email, strpos($email, "@") + 1);
			if($email_domain == 'student.unpar.ac.id' || $email_domain == 'unpar.ac.id'){
				$this->load->model('Users');
				$data_login = $this->Users->checkUser($email);
				if($data_login){
					foreach ($data_login as $data) {
						$id = $data['ID'];
						$id_role = $data['ID_ROLE'];
						$email = $data['EMAIL'];
						$nama = $data['NAMA'];
						$nama_role = $data['NAMA_ROLE'];
					}
					$is_aktif = $this->Users->getStatus($id);
					if($is_aktif == 1){
						$userdata = array(
							'logged_in' => true,
							'id' => $id,
							'id_role' => $id_role,
							'email' => $email,
							'nama' => $nama,
							'nama_role' => $nama_role
						);
						$this->load->model('Users');
						date_default_timezone_set('Asia/Jakarta');
						$date_time = date("Y-m-d H:i:s");
						$ip = $this->input->ip_address();
						$data = array(
							'LAST_LOGIN' => $date_time,
							'LAST_IP' => $ip
						);
						$res = $this->Users->updateDataLogin($id, $data);
						$this->session->set_userdata($userdata);
						redirect('/dashboard');
					}
					else{
						$userdata = array(
							'logged_in_public' => true,
							'name' => $google_data['name'],
							'email' => $google_data['email']
						);
						$this->session->set_userdata($userdata);
						redirect('/peminjaman');
					}
				}
				else{
					$userdata = array(
						'logged_in_public' => true,
						'name' => $google_data['name'],
						'email' => $google_data['email']
					);
					$this->session->set_userdata($userdata);
					redirect('/peminjaman');
				}
			}
			else{
				$this->session->set_flashdata('message', 'Anda harus login menggunakan akun Email UNPAR!');
				$this->google->revokeToken();
				redirect('/');
			}
		}
		else{
			// print_r($this->session->all_userdata());
			// return;
			if($this->session->userdata('logged_in')){
				redirect('/dashboard');
			}
			else{
				redirect('/peminjaman');
			}
		}	
	}

	//Method untuk melakukan logout dari aplikasi website
	function logout(){
		if($this->session->userdata('logged_in') || $this->session->userdata('logged_in_public')){
			$this->session->set_flashdata('message', 'Berhasil Logout!');
			if($this->session->userdata('logged_in')){
				$this->session->unset_userdata('logged_in');
				$this->session->unset_userdata('id');
				$this->session->unset_userdata('id_role');
				$this->session->unset_userdata('email');
				$this->session->unset_userdata('nama');
				$this->session->unset_userdata('nama_role');
			}
			else{
				$this->session->unset_userdata('logged_in_public');
				$this->session->unset_userdata('email');
				$this->session->unset_userdata('name');
			}
			
			
			$this->google->revokeToken();
			// print_r($this->session->all_userdata());
			// return;
			redirect('/');
		}
		else{
			redirect('/');
		}
	}
}
?>