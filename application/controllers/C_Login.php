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
		$tipe_login = $_GET['s'];
		if($tipe_login == 'login_admin' || $tipe_login == 'peminjaman'){
			$google_data = $this->google->validate();
			
			$email = $google_data['email'];    
			$email_domain = substr($email, strpos($email, "@") + 1);
			if($email_domain == 'student.unpar.ac.id' || $email_domain == 'unpar.ac.id'){
				if($tipe_login == 'login_admin'){
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
						$userdata = array(
							'logged_in' => true,
							'id' => $id,
							'id_role' => $id_role,
							'email' => $email,
							'nama' => $nama,
							'nama_role' => $nama_role
						);
						$this->session->set_userdata($userdata);
						redirect('/dashboard');
					}
					else{
						$this->session->set_flashdata('message', "Email tidak terdaftar!");
						redirect('/');
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
			$this->google->revokeToken();
			$this->session->set_flashdata('message', 'Missing login type!');
			redirect('/');
		}
	}

	//Method untuk melakukan logout dari aplikasi website
	function logout(){
		if($this->session->userdata('logged_in')){
			$this->session->set_flashdata('message', 'Berhasil Logout!');
			$this->google->revokeToken();
			$this->session->unset_userdata('logged_in');
			$this->session->unset_userdata('id');
			$this->session->unset_userdata('id_role');
			$this->session->unset_userdata('email');
			$this->session->unset_userdata('nama');
			redirect('/');
		}
		else{
			redirect('/');
		}
	}
}
?>