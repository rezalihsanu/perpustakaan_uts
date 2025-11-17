# 🧪 PANDUAN TESTING API LIBRARY BACKEND

## Prasyarat
- Server Laravel berjalan: `php artisan serve` → `http://localhost:8000`
- Database sudah dimigrasi dan di-seed
- Tools: Postman, Insomnia, atau terminal dengan `curl`

---

## 📌 BASE URL
```
http://localhost:8000/api
```

---

## 🔗 API ENDPOINTS

### 1️⃣ **GET - Ambil Semua Buku**
**Endpoint:** `GET /api/books`

**CURL:**
```bash
curl -X GET http://localhost:8000/api/books \
  -H "Content-Type: application/json" \
  -H "Accept: application/json"
```

**PowerShell:**
```powershell
$response = Invoke-RestMethod -Uri "http://localhost:8000/api/books" `
  -Method Get `
  -Headers @{"Content-Type" = "application/json"; "Accept" = "application/json"}
$response | ConvertTo-Json -Depth 10
```

**Response (200):**
```json
{
  "success": true,
  "message": "Data buku berhasil diambil",
  "data": [
    {
      "id": 1,
      "judul": "Clean Code",
      "pengarang": "Robert C. Martin",
      "penerbit": "Prentice Hall",
      "tahun_terbit": 2008,
      "jumlah_halaman": 464,
      "kategori": "Programming",
      "isbn": "9780132350884",
      "status": "Tersedia",
      "created_at": "2025-11-17T10:30:00Z",
      "updated_at": "2025-11-17T10:30:00Z"
    },
    ...
  ]
}
```

---

### 2️⃣ **POST - Tambah Buku Baru**
**Endpoint:** `POST /api/books`

**CURL:**
```bash
curl -X POST http://localhost:8000/api/books \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "judul": "Web Development with Laravel",
    "pengarang": "John Doe",
    "penerbit": "Tech Publisher",
    "tahun_terbit": 2024,
    "jumlah_halaman": 400,
    "kategori": "Programming",
    "isbn": "9781234567890",
    "status": "Tersedia"
  }'
```

**PowerShell:**
```powershell
$body = @{
    judul = "Web Development with Laravel"
    pengarang = "John Doe"
    penerbit = "Tech Publisher"
    tahun_terbit = 2024
    jumlah_halaman = 400
    kategori = "Programming"
    isbn = "9781234567890"
    status = "Tersedia"
} | ConvertTo-Json

$response = Invoke-RestMethod -Uri "http://localhost:8000/api/books" `
  -Method Post `
  -Headers @{"Content-Type" = "application/json"; "Accept" = "application/json"} `
  -Body $body

$response | ConvertTo-Json -Depth 10
```

**Response (201):**
```json
{
  "success": true,
  "message": "Buku berhasil ditambahkan",
  "data": {
    "id": 9,
    "judul": "Web Development with Laravel",
    "pengarang": "John Doe",
    "penerbit": "Tech Publisher",
    "tahun_terbit": 2024,
    "jumlah_halaman": 400,
    "kategori": "Programming",
    "isbn": "9781234567890",
    "status": "Tersedia",
    "created_at": "2025-11-17T11:00:00Z",
    "updated_at": "2025-11-17T11:00:00Z"
  }
}
```

**Response (422) - Validation Error:**
```json
{
  "success": false,
  "message": "Validasi gagal",
  "errors": {
    "isbn": ["ISBN sudah terdaftar"]
  }
}
```

---

### 3️⃣ **GET - Ambil Detail Buku**
**Endpoint:** `GET /api/books/{id}`

**CURL:**
```bash
curl -X GET http://localhost:8000/api/books/1 \
  -H "Content-Type: application/json" \
  -H "Accept: application/json"
```

**PowerShell:**
```powershell
$response = Invoke-RestMethod -Uri "http://localhost:8000/api/books/1" `
  -Method Get `
  -Headers @{"Content-Type" = "application/json"; "Accept" = "application/json"}
$response | ConvertTo-Json -Depth 10
```

**Response (200):**
```json
{
  "success": true,
  "message": "Detail buku berhasil diambil",
  "data": {
    "id": 1,
    "judul": "Clean Code",
    "pengarang": "Robert C. Martin",
    "penerbit": "Prentice Hall",
    "tahun_terbit": 2008,
    "jumlah_halaman": 464,
    "kategori": "Programming",
    "isbn": "9780132350884",
    "status": "Tersedia",
    "created_at": "2025-11-17T10:30:00Z",
    "updated_at": "2025-11-17T10:30:00Z"
  }
}
```

**Response (404):**
```json
{
  "success": false,
  "message": "Buku tidak ditemukan"
}
```

---

### 4️⃣ **PUT - Update Buku**
**Endpoint:** `PUT /api/books/{id}`

**CURL:**
```bash
curl -X PUT http://localhost:8000/api/books/1 \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "status": "Dipinjam",
    "jumlah_halaman": 500
  }'
```

**PowerShell:**
```powershell
$body = @{
    status = "Dipinjam"
    jumlah_halaman = 500
} | ConvertTo-Json

$response = Invoke-RestMethod -Uri "http://localhost:8000/api/books/1" `
  -Method Put `
  -Headers @{"Content-Type" = "application/json"; "Accept" = "application/json"} `
  -Body $body

$response | ConvertTo-Json -Depth 10
```

**Response (200):**
```json
{
  "success": true,
  "message": "Buku berhasil diperbarui",
  "data": {
    "id": 1,
    "judul": "Clean Code",
    "pengarang": "Robert C. Martin",
    "penerbit": "Prentice Hall",
    "tahun_terbit": 2008,
    "jumlah_halaman": 500,
    "kategori": "Programming",
    "isbn": "9780132350884",
    "status": "Dipinjam",
    "created_at": "2025-11-17T10:30:00Z",
    "updated_at": "2025-11-17T11:15:00Z"
  }
}
```

---

### 5️⃣ **DELETE - Hapus Buku**
**Endpoint:** `DELETE /api/books/{id}`

**CURL:**
```bash
curl -X DELETE http://localhost:8000/api/books/1 \
  -H "Content-Type: application/json" \
  -H "Accept: application/json"
```

**PowerShell:**
```powershell
$response = Invoke-RestMethod -Uri "http://localhost:8000/api/books/1" `
  -Method Delete `
  -Headers @{"Content-Type" = "application/json"; "Accept" = "application/json"}
$response | ConvertTo-Json -Depth 10
```

**Response (200):**
```json
{
  "success": true,
  "message": "Buku berhasil dihapus"
}
```

**Response (404):**
```json
{
  "success": false,
  "message": "Buku tidak ditemukan"
}
```

---

## 🧪 Testing Script untuk PowerShell

Buat file `test-api.ps1` dan jalankan:

```powershell
# test-api.ps1

$BaseUrl = "http://localhost:8000/api"

# 1. Ambil semua buku
Write-Host "1. GET /books" -ForegroundColor Green
$books = Invoke-RestMethod -Uri "$BaseUrl/books" -Method Get
$books | ConvertTo-Json -Depth 10 | Write-Host

# 2. Tambah buku baru
Write-Host "`n2. POST /books" -ForegroundColor Green
$newBook = @{
    judul = "Test Book $(Get-Date -Format 'yyyyMMddHHmmss')"
    pengarang = "Test Author"
    penerbit = "Test Publisher"
    tahun_terbit = 2024
    jumlah_halaman = 300
    kategori = "Test"
    isbn = "999$(Get-Random -Minimum 1000000 -Maximum 9999999)"
    status = "Tersedia"
} | ConvertTo-Json

$response = Invoke-RestMethod -Uri "$BaseUrl/books" -Method Post `
  -Headers @{"Content-Type" = "application/json"} `
  -Body $newBook

$bookId = $response.data.id
Write-Host "✓ Buku baru dibuat dengan ID: $bookId" -ForegroundColor Yellow

# 3. Ambil detail buku
Write-Host "`n3. GET /books/$bookId" -ForegroundColor Green
$book = Invoke-RestMethod -Uri "$BaseUrl/books/$bookId" -Method Get
$book | ConvertTo-Json -Depth 10 | Write-Host

# 4. Update buku
Write-Host "`n4. PUT /books/$bookId" -ForegroundColor Green
$updateBook = @{
    status = "Dipinjam"
} | ConvertTo-Json

$response = Invoke-RestMethod -Uri "$BaseUrl/books/$bookId" -Method Put `
  -Headers @{"Content-Type" = "application/json"} `
  -Body $updateBook

Write-Host "✓ Buku berhasil diupdate" -ForegroundColor Yellow

# 5. Hapus buku
Write-Host "`n5. DELETE /books/$bookId" -ForegroundColor Green
$response = Invoke-RestMethod -Uri "$BaseUrl/books/$bookId" -Method Delete

Write-Host "✓ Buku berhasil dihapus" -ForegroundColor Yellow

Write-Host "`n✅ Semua testing selesai!" -ForegroundColor Cyan
```

**Jalankan:**
```powershell
.\test-api.ps1
```

---

## 📊 Validasi Request

### Required Fields untuk POST/PUT:
- `judul` - string, max 255 karakter
- `pengarang` - string, max 255 karakter
- `penerbit` - string, max 255 karakter
- `tahun_terbit` - integer, 1000-2026
- `jumlah_halaman` - integer, minimal 1
- `kategori` - string, max 255 karakter
- `isbn` - string, max 20, unique
- `status` - enum: "Tersedia" atau "Dipinjam" (optional, default: "Tersedia")

### Error Responses:
- **400 Bad Request** - Format request salah
- **404 Not Found** - Resource tidak ditemukan
- **422 Unprocessable Entity** - Validasi gagal
- **500 Internal Server Error** - Error server

---

## 💡 Tips Debugging

1. **Cek status server:**
   ```bash
   curl http://localhost:8000/api/books
   ```

2. **Jika gagal koneksi**, pastikan:
   - Laravel server berjalan: `php artisan serve`
   - Port 8000 tidak digunakan oleh aplikasi lain
   - Firewall tidak memblokir lokal access

3. **Database error?** Jalankan:
   ```bash
   php artisan migrate:fresh --seed
   ```

4. **Log errors:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

