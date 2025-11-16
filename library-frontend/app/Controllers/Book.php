<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Client;

class Book extends BaseController
{
    private $apiURL = 'http://localhost:8000/api/books';
    private $client;

    public function __construct()
    {
        $this->client = \Config\Services::curlrequest();
    }

    /**
     * Halaman utama - Tampilkan daftar buku
     */
    public function index()
    {
        try {
            $response = $this->client->get($this->apiURL);
            $data = json_decode($response->getBody(), true);

            $viewData = [
                'title' => 'Daftar Buku',
                'books' => $data['success'] ? $data['data'] : [],
                'message' => session()->getFlashdata('message')
            ];

            return view('books/index', $viewData);
        } catch (\Exception $e) {
            $viewData = [
                'title' => 'Daftar Buku',
                'books' => [],
                'error' => 'Gagal terhubung ke API: ' . $e->getMessage()
            ];

            return view('books/index', $viewData);
        }
    }

    /**
     * Halaman form tambah buku
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Buku Baru',
            'validation' => \Config\Services::validation()
        ];

        return view('books/create', $data);
    }

    /**
     * Proses tambah buku baru
     */
    public function store()
    {
        $rules = [
            'judul' => 'required|min_length[3]',
            'pengarang' => 'required|min_length[3]',
            'penerbit' => 'required|min_length[3]',
            'tahun_terbit' => 'required|numeric|greater_than[1000]',
            'jumlah_halaman' => 'required|numeric|greater_than[0]',
            'kategori' => 'required',
            'isbn' => 'required',
            'status' => 'required|in_list[Tersedia,Dipinjam]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $postData = [
                'judul' => $this->request->getPost('judul'),
                'pengarang' => $this->request->getPost('pengarang'),
                'penerbit' => $this->request->getPost('penerbit'),
                'tahun_terbit' => (int)$this->request->getPost('tahun_terbit'),
                'jumlah_halaman' => (int)$this->request->getPost('jumlah_halaman'),
                'kategori' => $this->request->getPost('kategori'),
                'isbn' => $this->request->getPost('isbn'),
                'status' => $this->request->getPost('status')
            ];

            // Debug: Log data yang akan dikirim
            log_message('info', 'Sending data to API: ' . json_encode($postData));
            log_message('info', 'API URL: ' . $this->apiURL);

            $response = $this->client->post($this->apiURL, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ],
                'json' => $postData,
                'http_errors' => false, // Jangan throw exception pada HTTP error
                'verify' => false // Disable SSL verification untuk localhost
            ]);

            $statusCode = $response->getStatusCode();
            $responseBody = $response->getBody();
            
            // Debug: Log response
            log_message('info', 'API Response Status: ' . $statusCode);
            log_message('info', 'API Response Body: ' . $responseBody);

            if ($statusCode === 404) {
                return redirect()->back()->withInput()->with('message', [
                    'type' => 'danger',
                    'text' => 'Backend API tidak ditemukan. Pastikan Laravel berjalan di http://localhost:8000'
                ]);
            }

            $result = json_decode($responseBody, true);

            if ($statusCode >= 200 && $statusCode < 300 && isset($result['success']) && $result['success']) {
                return redirect()->to('/book')->with('message', [
                    'type' => 'success',
                    'text' => 'Buku berhasil ditambahkan!'
                ]);
            } else {
                $errorMsg = isset($result['message']) ? $result['message'] : 'Gagal menambahkan buku';
                if (isset($result['errors'])) {
                    $errorMsg .= ': ' . json_encode($result['errors']);
                }
                return redirect()->back()->withInput()->with('message', [
                    'type' => 'danger',
                    'text' => $errorMsg
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception in store: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('message', [
                'type' => 'danger',
                'text' => 'Gagal terhubung ke server backend. Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Halaman form edit buku
     */
    public function edit($id)
    {
        try {
            $response = $this->client->get($this->apiURL . '/' . $id);
            $result = json_decode($response->getBody(), true);

            if (!$result['success']) {
                return redirect()->to('/book')->with('message', [
                    'type' => 'danger',
                    'text' => 'Buku tidak ditemukan'
                ]);
            }

            $data = [
                'title' => 'Edit Buku',
                'book' => $result['data'],
                'validation' => \Config\Services::validation()
            ];

            return view('books/edit', $data);
        } catch (\Exception $e) {
            return redirect()->to('/book')->with('message', [
                'type' => 'danger',
                'text' => 'Gagal mengambil data buku: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Proses update buku
     */
    public function update($id)
    {
        $rules = [
            'judul' => 'required|min_length[3]',
            'pengarang' => 'required|min_length[3]',
            'penerbit' => 'required|min_length[3]',
            'tahun_terbit' => 'required|numeric|greater_than[1000]',
            'jumlah_halaman' => 'required|numeric|greater_than[0]',
            'kategori' => 'required',
            'isbn' => 'required',
            'status' => 'required|in_list[Tersedia,Dipinjam]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $postData = [
                'judul' => $this->request->getPost('judul'),
                'pengarang' => $this->request->getPost('pengarang'),
                'penerbit' => $this->request->getPost('penerbit'),
                'tahun_terbit' => $this->request->getPost('tahun_terbit'),
                'jumlah_halaman' => $this->request->getPost('jumlah_halaman'),
                'kategori' => $this->request->getPost('kategori'),
                'isbn' => $this->request->getPost('isbn'),
                'status' => $this->request->getPost('status')
            ];

            $response = $this->client->put($this->apiURL . '/' . $id, [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'json' => $postData
            ]);

            $result = json_decode($response->getBody(), true);

            if ($result['success']) {
                return redirect()->to('/book')->with('message', [
                    'type' => 'success',
                    'text' => 'Buku berhasil diperbarui!'
                ]);
            } else {
                return redirect()->back()->withInput()->with('message', [
                    'type' => 'danger',
                    'text' => $result['message']
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('message', [
                'type' => 'danger',
                'text' => 'Gagal memperbarui buku: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Proses hapus buku
     */
    public function delete($id)
    {
        try {
            $response = $this->client->delete($this->apiURL . '/' . $id);
            $result = json_decode($response->getBody(), true);

            if ($result['success']) {
                return redirect()->to('/book')->with('message', [
                    'type' => 'success',
                    'text' => 'Buku berhasil dihapus!'
                ]);
            } else {
                return redirect()->to('/book')->with('message', [
                    'type' => 'danger',
                    'text' => $result['message']
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->to('/book')->with('message', [
                'type' => 'danger',
                'text' => 'Gagal menghapus buku: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Lihat detail buku
     */
    public function show($id)
    {
        try {
            $response = $this->client->get($this->apiURL . '/' . $id);
            $result = json_decode($response->getBody(), true);

            if (!$result['success']) {
                return redirect()->to('/book')->with('message', [
                    'type' => 'danger',
                    'text' => 'Buku tidak ditemukan'
                ]);
            }

            $data = [
                'title' => 'Detail Buku',
                'book' => $result['data']
            ];

            return view('books/show', $data);
        } catch (\Exception $e) {
            return redirect()->to('/book')->with('message', [
                'type' => 'danger',
                'text' => 'Gagal mengambil data buku: ' . $e->getMessage()
            ]);
        }
    }
}