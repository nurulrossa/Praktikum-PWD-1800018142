<?php

namespace App\Controllers;
use App\Models\AdminModel;
use App\Models\BarkasModel;

class Admin extends BaseController
{
	protected $adminModel;
	protected $barkasModel;

	public function __construct(){
		$this->session = service('session');
		$this->adminModel = new AdminModel();
		$this->barkasModel = new BarkasModel();
	}
    
    public function index()
    {
        
        return view('admin/v_index');
    }

    public function profil()
    {
        $admin = $this->adminModel->first();

        $data = [
            'title' => 'Data Admin | DPRD Halteng',
            'admin' => $admin
        ];

        return view('admin/v_profil', $data);
    }

    public function password()
    {
        $admin = $this->adminModel->first();

        $data = [
            'title' => 'Edit Password | DPRD Halteng',
            'admin' => $admin
        ];

        return view('admin/v_password', $data);
    }

    public function editAdmin()
    {
        $InputAdminId = $this->request->getVar('admin_id');
        $InputAdminNama = $this->request->getVar('admin_nama');
        $InputAdminUsername = $this->request->getVar('admin_username');

        // $admin = $this->adminModel->where('admin_id', $InputAdminId)->first();

        if (!$this->validate([
			'admin_nama' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Nama harus diisi.'
				]
			],
			'admin_username' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Username harus diisi.'
				]
			]
		])) {

			$validation = \Config\Services::validation();
			
			return redirect()->to('/profil-admin')->withInput()->with('validation', $validation->getErrors());
		}

        $this->adminModel->save([
			'admin_id' => $InputAdminId,
			'admin_nama' => $InputAdminNama,
			'admin_username' => $InputAdminUsername,
		]);

		session()->setFlashdata('pesan', 'Data berhasil diubah.');

		return redirect()->to('/profil-admin');
    }

    public function editPassword()
    {
        $validation = \Config\Services::validation();
        
        $InputAdminId = $this->request->getVar('admin_id');
        $InputPassLama = md5($this->request->getVar('password_lama'));
        $InputPassBaru = md5($this->request->getVar('password_baru'));
        $InputPassBaru2 = md5($this->request->getVar('password_baru2'));

        $admin = $this->adminModel->where('admin_id', $InputAdminId)->first();

        if($InputPassLama != $admin['admin_pass']){
            session()->setFlashdata('error', 'Password lama tidak sama');

            return redirect()->to('/password-admin');
        }

        // dd($admin);

        if (!$this->validate([
			'password_lama' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Password lama harus diisi.',
				]
			],
			'password_baru' => [
				'rules' => 'required|min_length[6]|is_unique[admin.admin_pass]',
				'errors' => [
					'required' => 'Password baru harus diisi.',
                    'min_length' => 'Password tidak boleh kurang dari 6 karakter',
                    'is_unique' => 'Password belum berubah'
				]
            ],
            'password_baru2' => [
				'rules' => 'required|matches[password_baru]',
				'errors' => [
					'required' => 'Verifikasi harus diisi.',
                    'matches' => 'Verifikasi Password tidak sesuai'
				]
            ],
		])) {
			
			return redirect()->to('/password-admin')->withInput()->with('validation', $validation->getErrors());
		}else{
            $this->adminModel->save([
                'admin_id' => $InputAdminId,
                'admin_pass' => $InputPassBaru2
            ]);
    
            session()->setFlashdata('pesan', 'Data berhasil diubah.');
    
            return redirect()->to('/profil-admin');
        }
    
    }

    public function barkas_pending()
    {
        $barkas_pending = $this->barkasModel->where('barkas_status', 'Pending')->findAll();
        $data = [
            'title' => 'Data Barkas Pending',
            'barkas_pending' => $barkas_pending
        ];

        return view('admin/v_barkas', $data);
    }

    public function barkas_ada()
    {
        $barkas_ada = $this->barkasModel->where('barkas_status', 'Ada')->findAll();
        $data = [
            'title' => 'Data Barkas Pending',
            'barkas_ada' => $barkas_ada
        ];

        return view('admin/v_barkasada', $data);
    }

    public function barkas_sold()
    {
        $barkas_sold = $this->barkasModel->where('barkas_status', 'Terjual')->findAll();
        $data = [
            'title' => 'Data Barkas Pending',
            'barkas_sold' => $barkas_sold
        ];

        return view('admin/v_barkassold', $data);
    }

    public function edit($id)
    {
        $barkas_edit = $this->barkasModel->where('barkas_id', $id)->first();
        $data = [
            'title' => 'Data Barkas Pending',
            'barkas' => $barkas_edit
        ];

        return view('admin/v_editbarkas', $data);
    }

    public function update_barkas()
    {
		// validasi input
		if (!$this->validate([
			'nama' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Nama barkas harus diisi.'
				]
			],
			'harga' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Harga barkas harus diisi.'
				]
			],
			'kontak' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Kontak pemilik barkas harus diisi.'
				]
			],
			'pemilik' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Nama pemilik barkas harus diisi.'
				]
			]
		])) {

			$validation = \Config\Services::validation();
			//dd($validation);
			return redirect()->to('/edit-barkas/'.$this->request->getVar('id'))->withInput()->with('validation', $validation->getErrors());
		}

        $this->barkasModel->save([
            'barkas_id' => $this->request->getVar('id'),
            'barkas_nama' => $this->request->getVar('nama'),
            'barkas_harga' => $this->request->getVar('harga'),
            'barkas_pemilik' => $this->request->getVar('pemilik'),
            'barkas_kontak' => $this->request->getVar('kontak'),
            'barkas_wa' => $this->request->getVar('wa'),
            'barkas_desc' => $this->request->getVar('desc'),
        ]);

        session()->setFlashdata('pesan', 'Silahkan lakukan pembayaran 10k melalui no rek 123456 atas nama Nurul Rossa!');

        // dd(session()->getFlashdata('pesan'));

        return redirect()->to('/barkas-ada');
    }

    public function aktivasi($id)
    {
        $this->barkasModel->save([
            'barkas_id' => $id,
            'barkas_status' => 'Ada'
        ]);

        return redirect()->to('/barkas-ada');
    }

    public function sold($id)
    {
        $this->barkasModel->save([
            'barkas_id' => $id,
            'barkas_status' => 'Terjual'
        ]);

        return redirect()->to('/barkas-sold');
    }

    public function batal($id)
    {
        $this->barkasModel->delete($id);

        return redirect()->to('/barkas-pending');
    }


	public function hapus($id)
	{
		//cari gambar
		$gambar = $this->barkasModel->where('barkas_id', $id)->first();
        $namaGambar = $gambar['barkas_gambar'];
		
        unlink('assets/barkas/'.$namaGambar);

		$this->barkasModel->delete($id);
		//$this->gambarwisataModel->deleteGambar($id);
		session()->setFlashdata('pesan', 'Data berhasil dihapus.');

		return redirect()->to('/barkas-ada');
	}

    public function cetak_laporan()
    {
        $awal = $this->request->getVar('awal');
        $akhir = $this->request->getVar('akhir');
        $barkas = $this->barkasModel->findAll();
        // $barkas = $this->barkasModel->where('barkas_created', between(''))->findAll();
        $data = [
            'barkas' => $barkas
        ];
        return view('admin/v_lappdfnew.php', $data);
    }

    public function pilih_tgl()
    {
        return view('admin/v_laporan');
    }
    
}
