@echo off
REM ============================================================================
REM Setup Script untuk Library Backend API
REM Lokasi: library_uts/library-backend
REM ============================================================================

echo.
echo ======================================================================
echo   SETUP LIBRARY BACKEND API
echo ======================================================================
echo.

REM Cek jika file composer.json ada
if not exist "composer.json" (
    echo ERROR: File composer.json tidak ditemukan!
    echo Pastikan script dijalankan dari direktori library_uts\library-backend
    pause
    exit /b 1
)

REM 1. Install dependencies
echo [1/5] Installing PHP dependencies dengan Composer...
echo.
call composer install
if errorlevel 1 (
    echo ERROR: Composer install gagal!
    pause
    exit /b 1
)
echo ✓ Composer install berhasil
echo.

REM 2. Copy .env file
echo [2/5] Setting up .env file...
echo.
if not exist ".env" (
    if exist ".env.example" (
        copy ".env.example" ".env"
        echo ✓ .env file berhasil dibuat dari .env.example
    ) else (
        echo ERROR: .env.example tidak ditemukan!
        pause
        exit /b 1
    )
) else (
    echo ✓ .env file sudah ada
)
echo.

REM 3. Generate APP_KEY
echo [3/5] Generating APP_KEY...
echo.
call php artisan key:generate
if errorlevel 1 (
    echo ERROR: APP_KEY generation gagal!
    pause
    exit /b 1
)
echo ✓ APP_KEY berhasil dibuat
echo.

REM 4. Run migrations
echo [4/5] Running database migrations...
echo.
call php artisan migrate --force
if errorlevel 1 (
    echo ERROR: Migration gagal!
    pause
    exit /b 1
)
echo ✓ Database migrations berhasil
echo.

REM 5. (Optional) Seed database
echo [5/5] Seeding database (opsional)...
echo.
call php artisan db:seed
if errorlevel 1 (
    echo INFO: Database seeding lewat (opsional)
) else (
    echo ✓ Database seeding berhasil
)
echo.

REM Info lengkap
echo.
echo ======================================================================
echo   SETUP SELESAI!
echo ======================================================================
echo.
echo Untuk menjalankan server:
echo   cd library_uts\library-backend
echo   php artisan serve
echo.
echo Server akan berjalan di: http://localhost:8000
echo API Base URL: http://localhost:8000/api
echo.
echo Endpoints yang tersedia:
echo   GET    /api/books           - Ambil semua buku
echo   POST   /api/books           - Tambah buku baru
echo   GET    /api/books/{id}      - Ambil detail buku
echo   PUT    /api/books/{id}      - Update buku
echo   DELETE /api/books/{id}      - Hapus buku
echo.
echo Untuk testing, gunakan Postman atau Insomnia
echo.
pause
