# Test API Script untuk Library Backend
# Jalankan dari terminal PowerShell: .\test-api.ps1

param(
    [string]$BaseUrl = "http://localhost:8000/api",
    [string]$Action = "all"
)

function Write-Header {
    param([string]$Text)
    Write-Host "`n" + ("=" * 60) -ForegroundColor Cyan
    Write-Host $Text -ForegroundColor Cyan
    Write-Host ("=" * 60) -ForegroundColor Cyan
}

function Write-Success {
    param([string]$Text)
    Write-Host "✓ $Text" -ForegroundColor Green
}

function Write-Error {
    param([string]$Text)
    Write-Host "✗ $Text" -ForegroundColor Red
}

function Test-Connection {
    Write-Header "Testing API Connection"
    
    try {
        $response = Invoke-RestMethod -Uri "$BaseUrl/books" -Method Get -ErrorAction Stop
        Write-Success "API server is running at $BaseUrl"
        return $true
    } catch {
        Write-Error "Cannot connect to API server at $BaseUrl"
        Write-Error "Error: $($_.Exception.Message)"
        return $false
    }
}

function Get-AllBooks {
    Write-Header "GET /books - Ambil Semua Buku"
    
    try {
        $response = Invoke-RestMethod -Uri "$BaseUrl/books" -Method Get `
            -Headers @{"Content-Type" = "application/json"; "Accept" = "application/json"}
        
        if ($response.success) {
            Write-Success "Total buku: $($response.data.Count)"
            
            $response.data | ForEach-Object {
                Write-Host "- ID: $($_.id), Judul: $($_.judul), Status: $($_.status)" -ForegroundColor White
            }
        } else {
            Write-Error $response.message
        }
        
        return $response
    } catch {
        Write-Error "Failed to get books: $($_.Exception.Message)"
        return $null
    }
}

function Create-Book {
    Write-Header "POST /books - Tambah Buku Baru"
    
    $timestamp = Get-Date -Format "yyyyMMddHHmmss"
    $randomIsbn = "998" + (Get-Random -Minimum 1000000 -Maximum 9999999)
    
    $bookData = @{
        judul = "Test Book $timestamp"
        pengarang = "Test Author"
        penerbit = "Test Publisher"
        tahun_terbit = 2024
        jumlah_halaman = 300
        kategori = "Testing"
        isbn = $randomIsbn
        status = "Tersedia"
    }
    
    try {
        $response = Invoke-RestMethod -Uri "$BaseUrl/books" -Method Post `
            -Headers @{"Content-Type" = "application/json"; "Accept" = "application/json"} `
            -Body ($bookData | ConvertTo-Json)
        
        if ($response.success) {
            Write-Success "Buku berhasil dibuat dengan ID: $($response.data.id)"
            return $response.data
        } else {
            Write-Error $response.message
            if ($response.errors) {
                $response.errors | ConvertTo-Json | Write-Host -ForegroundColor Yellow
            }
            return $null
        }
    } catch {
        Write-Error "Failed to create book: $($_.Exception.Message)"
        return $null
    }
}

function Get-BookDetail {
    param([int]$BookId)
    
    Write-Header "GET /books/$BookId - Ambil Detail Buku"
    
    try {
        $response = Invoke-RestMethod -Uri "$BaseUrl/books/$BookId" -Method Get `
            -Headers @{"Content-Type" = "application/json"; "Accept" = "application/json"}
        
        if ($response.success) {
            Write-Success "Detail buku berhasil diambil"
            Write-Host "Judul: $($response.data.judul)" -ForegroundColor White
            Write-Host "Pengarang: $($response.data.pengarang)" -ForegroundColor White
            Write-Host "Status: $($response.data.status)" -ForegroundColor White
            return $response.data
        } else {
            Write-Error $response.message
            return $null
        }
    } catch {
        Write-Error "Failed to get book detail: $($_.Exception.Message)"
        return $null
    }
}

function Update-Book {
    param([int]$BookId, [string]$NewStatus)
    
    Write-Header "PUT /books/$BookId - Update Buku"
    
    $updateData = @{
        status = $NewStatus
    }
    
    try {
        $response = Invoke-RestMethod -Uri "$BaseUrl/books/$BookId" -Method Put `
            -Headers @{"Content-Type" = "application/json"; "Accept" = "application/json"} `
            -Body ($updateData | ConvertTo-Json)
        
        if ($response.success) {
            Write-Success "Buku berhasil diupdate. Status baru: $($response.data.status)"
            return $response.data
        } else {
            Write-Error $response.message
            return $null
        }
    } catch {
        Write-Error "Failed to update book: $($_.Exception.Message)"
        return $null
    }
}

function Delete-Book {
    param([int]$BookId)
    
    Write-Header "DELETE /books/$BookId - Hapus Buku"
    
    try {
        $response = Invoke-RestMethod -Uri "$BaseUrl/books/$BookId" -Method Delete `
            -Headers @{"Content-Type" = "application/json"; "Accept" = "application/json"}
        
        if ($response.success) {
            Write-Success $response.message
            return $true
        } else {
            Write-Error $response.message
            return $false
        }
    } catch {
        Write-Error "Failed to delete book: $($_.Exception.Message)"
        return $false
    }
}

# Main Execution
Write-Host "
╔════════════════════════════════════════════════════╗
║      Library Backend API Testing Script           ║
║                                                    ║
║      Base URL: $BaseUrl
║      Action: $Action
╚════════════════════════════════════════════════════╝
" -ForegroundColor Cyan

# Test connection
if (-not (Test-Connection)) {
    exit 1
}

# Execute actions
switch ($Action) {
    "all" {
        # Get all books
        $allBooks = Get-AllBooks
        
        # Create new book
        $newBook = Create-Book
        
        if ($newBook) {
            # Get book detail
            Get-BookDetail -BookId $newBook.id
            
            # Update book
            Update-Book -BookId $newBook.id -NewStatus "Dipinjam"
            
            # Delete book
            Delete-Book -BookId $newBook.id
        }
    }
    
    "list" {
        Get-AllBooks
    }
    
    "create" {
        Create-Book
    }
    
    default {
        Write-Host "
Usage: .\test-api.ps1 -BaseUrl <url> -Action <action>

Actions:
  all     - Run all tests (default)
  list    - Get all books
  create  - Create new book
  
Example:
  .\test-api.ps1 -Action list
  .\test-api.ps1 -BaseUrl http://localhost:8000/api -Action create
" -ForegroundColor Yellow
    }
}

Write-Header "Testing Complete"
Write-Host ""
