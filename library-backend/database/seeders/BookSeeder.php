<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'judul' => 'Clean Code',
                'pengarang' => 'Robert C. Martin',
                'penerbit' => 'Prentice Hall',
                'tahun_terbit' => 2008,
                'jumlah_halaman' => 464,
                'kategori' => 'Programming',
                'isbn' => '9780132350884',
                'status' => 'Tersedia'
            ],
            [
                'judul' => 'The Pragmatic Programmer',
                'pengarang' => 'Andrew Hunt, David Thomas',
                'penerbit' => 'Addison-Wesley',
                'tahun_terbit' => 1999,
                'jumlah_halaman' => 352,
                'kategori' => 'Programming',
                'isbn' => '9780135957059',
                'status' => 'Tersedia'
            ],
            [
                'judul' => 'Design Patterns',
                'pengarang' => 'Gang of Four',
                'penerbit' => 'Addison-Wesley',
                'tahun_terbit' => 1994,
                'jumlah_halaman' => 395,
                'kategori' => 'Programming',
                'isbn' => '9780201633610',
                'status' => 'Dipinjam'
            ],
            [
                'judul' => 'Refactoring',
                'pengarang' => 'Martin Fowler',
                'penerbit' => 'Addison-Wesley',
                'tahun_terbit' => 2018,
                'jumlah_halaman' => 448,
                'kategori' => 'Programming',
                'isbn' => '9780134757599',
                'status' => 'Tersedia'
            ],
            [
                'judul' => 'Code Complete',
                'pengarang' => 'Steve McConnell',
                'penerbit' => 'Microsoft Press',
                'tahun_terbit' => 2004,
                'jumlah_halaman' => 960,
                'kategori' => 'Programming',
                'isbn' => '9780735619678',
                'status' => 'Tersedia'
            ],
            [
                'judul' => 'Introduction to Algorithms',
                'pengarang' => 'Thomas H. Cormen',
                'penerbit' => 'MIT Press',
                'tahun_terbit' => 2009,
                'jumlah_halaman' => 1312,
                'kategori' => 'Computer Science',
                'isbn' => '9780262033848',
                'status' => 'Dipinjam'
            ],
            [
                'judul' => 'The Hobbit',
                'pengarang' => 'J.R.R. Tolkien',
                'penerbit' => 'Allen & Unwin',
                'tahun_terbit' => 1937,
                'jumlah_halaman' => 310,
                'kategori' => 'Fiksi',
                'isbn' => '9780547928227',
                'status' => 'Tersedia'
            ],
            [
                'judul' => '1984',
                'pengarang' => 'George Orwell',
                'penerbit' => 'Penguin Books',
                'tahun_terbit' => 1949,
                'jumlah_halaman' => 328,
                'kategori' => 'Fiksi',
                'isbn' => '9780451524935',
                'status' => 'Tersedia'
            ]
        ];

        foreach ($books as $book) {
            Book::create($book);
        }

        echo "✓ " . count($books) . " buku berhasil ditambahkan\n";
    }
}
