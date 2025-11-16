<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    // Kolom yang dapat diisi (harus sesuai dengan form CodeIgniter & controller Laravel)
    protected $fillable = [
        'judul',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'jumlah_halaman',
        'kategori',
        'isbn',
        'status'
    ];
}
