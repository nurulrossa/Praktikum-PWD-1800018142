<?php

namespace App\Controllers;
use App\Models\barkasModel;

class User extends BaseController
{
	// protected $partaiModel;
	protected $barkasModel;
	protected $session;

	public function __construct(){
        $this->session = service('session');
        $this->barkasModel = new BarkasModel();
        
	}
    
    public function index()
    {
        $barkas = $this->barkasModel->where('barkas_status', 'Ada')->findAll();
        $data = [
            'title' => 'BARKAS AMANAH',
            'barkas' => $barkas
        ];

        return view('v_index', $data);
    }

    public function daftarbarkas()
    {
		session();

        $data = [
            'title' => 'Daftar Barkas | DPRD Halteng'
        ];

        return view('v_daftar', $data);
    }
    

    public function save_barkas()
    {
		// validasi input
		if (!$this->validate([
            'gambar' => [
				'rules' => 'uploaded[gambar]|max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
				'errors' => [
					'uploaded' => 'Masukkan gambar barkas.',
					'max_size' => 'Ukuran gambar terlalu besar.',
					'is_image' => 'Yang anda pilih bukan gambar.',
					'mime_in' => 'Yang anda pilih bukan gambar.'
				]
                ],
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
			return redirect()->to('/daftarbarkas')->withInput()->with('validation', $validation->getErrors());
		}
        // ambil gambar
        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = $fileGambar->getRandomName();
        $fileGambar->move('assets/barkas', $namaGambar);

        $this->barkasModel->save([
            'barkas_nama' => $this->request->getVar('nama'),
            'barkas_gambar' => $namaGambar,
            'barkas_status' => 'Pending',
            'barkas_harga' => $this->request->getVar('harga'),
            'barkas_pemilik' => $this->request->getVar('pemilik'),
            'barkas_kontak' => $this->request->getVar('kontak'),
            'barkas_wa' => $this->request->getVar('wa'),
            'barkas_desc' => $this->request->getVar('desc'),
        ]);

        session()->setFlashdata('pesan', 'Silahkan lakukan pembayaran 10k melalui no rek 123456 atas nama Nurul Rossa!');

        // dd(session()->getFlashdata('pesan'));

        return redirect()->to('/daftarbarkas');
    }

    public function cari_barkas()
    {
        $key = $this->request->getVar('key');
        $find = $this->barkasModel->like('barkas_nama', '%'.$key.'%')
                                  ->orlike('barkas_desc', '%'.$key.'%')
                                  ->findAll();
        
        $data = [
            'title' => 'Pencarian Barkas',
            'barkas' => $find
        ];
        
        return view('v_pencarian', $data);
    }
}
