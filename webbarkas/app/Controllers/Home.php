<?php

namespace App\Controllers;
use App\Models\AdminModel;

class Home extends BaseController
{
	protected $adminModel;
    
	public function __construct(){
		$this->session = service('session');
		$this->adminModel = new AdminModel();
	}

    public function login()
    {
		$random_alpha = md5(rand()); //membuat kode random
		// $captcha_code = substr($random_alpha, 0, 6); //kode memiliki 
		// $_SESSION["captcha_code"] = $captcha_code; //membuat session captcha kode
		// $target_layer = imagecreatetruecolor(70,30); //menghasilkan gambar PNG dengan lebar 70 piksel kali tinggi 30 pikse
		// $captcha_background = imagecolorallocate($target_layer, 255, 160, 119); //Mengalokasikan warna untuk gambar
		// imagefill($target_layer,0,0,$captcha_background); //mengisi gambar yang sudah dibuat di baris 6 dan diisi dengan warna dari baris 7
		// $captcha_text_color = imagecolorallocate($target_layer, 0, 0, 0); //membuat warna captcha_code
		// imagestring($target_layer, 5, 5, 5, $captcha_code, $captcha_text_color); //memasukkan text capthca_code ke dalam gambar
		// header("Content-type: image/jpeg"); //menampilkan gambar
		// $data = [
		// 	'img' => imagejpeg($target_layer)
		// ];

        return view('auth/v_login');
    }

    public function prosesLogin()
	{
		session();

        // validasi input
		if (!$this->validate([
			'username' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Silahkan isi username anda.'
				]
            ],
            'password' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Password tidak boleh kosong.'
				]
            ],
            'captcha_code' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Isi kode diatas.'
				]
				// |matches[password_baru]
            ]
		])) {
			$validation = \Config\Services::validation();
			$data = $validation->getErrors();
			return redirect()->to('/login')->withInput()->with('validation', $validation->getErrors());
		}

		$admin = $this->adminModel->asObject()->where('admin_username', $this->request->getVar('username'))->first();
		if ($admin) {
			if (md5($this->request->getVar('password')) == $admin->admin_pass) {
				session()->set([
					'username'  => $admin->admin_username,
					'admin_nama'=> $admin->admin_nama,
					'logged_in' => TRUE
				]);
				return redirect()->to('/admin');
			}
            return redirect()->back()->withInput()->with('error_pass', 'Password salah!');
		}else{
			return redirect()->back()->withInput()->with('error', 'Username atau Password salah!');
		}
	}

	public function logout()
	{
		session_destroy();
		return redirect()->to('/login');

	}

}
