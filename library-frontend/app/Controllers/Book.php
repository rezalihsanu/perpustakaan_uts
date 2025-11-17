<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Client;

class Book extends BaseController
{
    private $apiURL = 'http://127.0.0.1:8000/api/books';
    private $client;
    private $timeout = 10; // Timeout dalam detik

    public function __construct()
    {
        // Konfigurasi cURL request dengan timeout dan verify SSL
        $this->client = \Config\Services::curlrequest([
            'timeout' => $this->timeout,
            'verify' => false,  // Disable SSL verification untuk localhost
            'connect_timeout' => 5 // Connection timeout
        ]);
    }

    /**
     * Halaman utama - Tampilkan daftar buku
     */
    public function index()
    {
        try {
            log_message('info', 'Fetching books from API: ' . $this->apiURL);
            
            $response = $this->client->get($this->apiURL, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ]
            ]);
            
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            
            log_message('info', 'API Response Status: ' . $statusCode);
            log_message('info', 'API Response: ' . substr($body, 0, 200));
            
            if ($statusCode !== 200) {
                throw new \Exception("API returned status code: $statusCode");
            }
            
            $data = json_decode($body, true);

            $viewData = [
                'title' => 'Daftar Buku',
                'books' => isset($data['data']) ? $data['data'] : [],
                'message' => session()->getFlashdata('message')
            ];

            return view('books/index', $viewData);
        } catch (\Exception $e) {
            log_message('error', 'Error in index: ' . $e->getMessage());
            
            $viewData = [
                'title' => 'Daftar Buku',
                'books' => [],
                'error' => 'Gagal terhubung ke API: ' . $e->getMessage() . 
                           ' | Pastikan Laravel server berjalan di http://127.0.0.1:8000'
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

            log_message('info', 'Sending POST to API: ' . $this->apiURL);
            log_message('info', 'Data: ' . json_encode($postData));

            $response = $this->client->post($this->apiURL, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ],
                'json' => $postData,
                'http_errors' => false
            ]);

            $statusCode = $response->getStatusCode();
            $responseBody = $response->getBody();
            
            log_message('info', 'API Response Status: ' . $statusCode);
            log_message('info', 'API Response Body: ' . substr($responseBody, 0, 500));

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
                    'text' => 'Error ' . $statusCode . ': ' . $errorMsg
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
            log_message('info', 'Fetching book with ID: ' . $id);
            
            $response = $this->client->get($this->apiURL . '/' . $id, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ]
            ]);
            
            $statusCode = $response->getStatusCode();
            
            if ($statusCode !== 200) {
                throw new \Exception("API returned status code: $statusCode");
            }
            
            $result = json_decode($response->getBody(), true);

            if (!isset($result['success']) || !$result['success']) {
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
            log_message('error', 'Error in edit: ' . $e->getMessage());
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

            log_message('info', 'Sending PUT to API: ' . $this->apiURL . '/' . $id);
            log_message('info', 'Data: ' . json_encode($postData));

            $response = $this->client->put($this->apiURL . '/' . $id, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ],
                'json' => $postData,
                'http_errors' => false
            ]);

            $statusCode = $response->getStatusCode();
            $responseBody = $response->getBody();
            
            log_message('info', 'API Response Status: ' . $statusCode);

            $result = json_decode($responseBody, true);

            if ($statusCode >= 200 && $statusCode < 300 && isset($result['success']) && $result['success']) {
                return redirect()->to('/book')->with('message', [
                    'type' => 'success',
                    'text' => 'Buku berhasil diperbarui!'
                ]);
            } else {
                $errorMsg = isset($result['message']) ? $result['message'] : 'Gagal memperbarui buku';
                return redirect()->back()->withInput()->with('message', [
                    'type' => 'danger',
                    'text' => 'Error ' . $statusCode . ': ' . $errorMsg
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception in update: ' . $e->getMessage());
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
            log_message('info', 'Sending DELETE to API: ' . $this->apiURL . '/' . $id);
            
            $response = $this->client->delete($this->apiURL . '/' . $id, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ],
                'http_errors' => false
            ]);

            $statusCode = $response->getStatusCode();
            $responseBody = $response->getBody();
            
            log_message('info', 'API Response Status: ' . $statusCode);

            $result = json_decode($responseBody, true);

            if ($statusCode >= 200 && $statusCode < 300 && isset($result['success']) && $result['success']) {
                return redirect()->to('/book')->with('message', [
                    'type' => 'success',
                    'text' => 'Buku berhasil dihapus!'
                ]);
            } else {
                $errorMsg = isset($result['message']) ? $result['message'] : 'Gagal menghapus buku';
                return redirect()->to('/book')->with('message', [
                    'type' => 'danger',
                    'text' => 'Error ' . $statusCode . ': ' . $errorMsg
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception in delete: ' . $e->getMessage());
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
            log_message('info', 'Fetching book detail with ID: ' . $id);
            
            $response = $this->client->get($this->apiURL . '/' . $id, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ]
            ]);
            
            $statusCode = $response->getStatusCode();
            
            if ($statusCode !== 200) {
                throw new \Exception("API returned status code: $statusCode");
            }
            
            $result = json_decode($response->getBody(), true);

            if (!isset($result['success']) || !$result['success']) {
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
            log_message('error', 'Error in show: ' . $e->getMessage());
            return redirect()->to('/book')->with('message', [
                'type' => 'danger',
                'text' => 'Gagal mengambil data buku: ' . $e->getMessage()
            ]);
        }
    }
}