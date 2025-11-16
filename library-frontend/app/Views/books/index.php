<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
            <div class="card-body text-white text-center py-5">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="bi bi-book-half"></i> Perpustakaan Digital
                </h1>
                <p class="lead mb-4">Kelola koleksi buku perpustakaan Anda dengan mudah dan efisien</p>
                <a href="<?= base_url('book/create') ?>" class="btn btn-light btn-lg px-5" style="border-radius: 50px; font-weight: 600;">
                    <i class="bi bi-plus-circle-fill"></i> Tambah Buku Baru
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Flash Messages -->
<?php if (session()->has('message')): ?>
    <?php $message = session('message'); ?>
    <div class="alert alert-<?= esc($message['type']) ?> alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i> <?= esc($message['text']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger alert-permanent" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i> <?= esc($error) ?>
    </div>
<?php endif; ?>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card h-100" style="border: none;">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="bi bi-book-fill" style="font-size: 3rem; background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                </div>
                <h3 class="fw-bold"><?= count($books) ?></h3>
                <p class="text-muted mb-0">Total Buku</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100" style="border: none;">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="bi bi-check-circle-fill" style="font-size: 3rem; color: #10b981;"></i>
                </div>
                <h3 class="fw-bold">
                    <?php 
                        $tersedia = array_filter($books, fn($b) => $b['status'] === 'Tersedia');
                        echo count($tersedia);
                    ?>
                </h3>
                <p class="text-muted mb-0">Buku Tersedia</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100" style="border: none;">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="bi bi-hourglass-split" style="font-size: 3rem; color: #f59e0b;"></i>
                </div>
                <h3 class="fw-bold">
                    <?php 
                        $dipinjam = array_filter($books, fn($b) => $b['status'] === 'Dipinjam');
                        echo count($dipinjam);
                    ?>
                </h3>
                <p class="text-muted mb-0">Buku Dipinjam</p>
            </div>
        </div>
    </div>
</div>

<!-- Books Grid/Table Toggle -->
<div class="row mb-3">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold text-white">
                <i class="bi bi-collection"></i> Koleksi Buku
            </h4>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-sm btn-light" id="gridView" onclick="toggleView('grid')">
                    <i class="bi bi-grid-3x3-gap-fill"></i> Grid
                </button>
                <button type="button" class="btn btn-sm btn-outline-light" id="tableView" onclick="toggleView('table')">
                    <i class="bi bi-table"></i> Table
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Books Display -->
<?php if (empty($books)): ?>
    <div class="row">
        <div class="col-12">
            <div class="card text-center py-5">
                <div class="card-body">
                    <i class="bi bi-inbox" style="font-size: 5rem; color: #d1d5db;"></i>
                    <h4 class="mt-4 mb-3">Belum Ada Buku</h4>
                    <p class="text-muted">Mulai tambahkan buku pertama Anda ke perpustakaan</p>
                    <a href="<?= base_url('book/create') ?>" class="btn btn-primary mt-3">
                        <i class="bi bi-plus-circle"></i> Tambah Buku Pertama
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <!-- Grid View -->
    <div id="booksGrid" class="row g-4">
        <?php foreach ($books as $book): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 book-card" style="border: none; cursor: pointer;" onclick="window.location='<?= base_url('book/show/' . $book['id']) ?>'">
                    <div class="position-relative">
                        <div class="card-img-top" style="height: 250px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-book-fill text-white" style="font-size: 5rem; opacity: 0.8;"></i>
                        </div>
                        <div class="position-absolute top-0 end-0 m-3">
                            <?php if ($book['status'] === 'Tersedia'): ?>
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle-fill"></i> Tersedia
                                </span>
                            <?php else: ?>
                                <span class="badge bg-warning">
                                    <i class="bi bi-hourglass-split"></i> Dipinjam
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-2"><?= esc($book['judul']) ?></h5>
                        <p class="card-text text-muted mb-2">
                            <i class="bi bi-person"></i> <?= esc($book['pengarang']) ?>
                        </p>
                        <p class="card-text text-muted mb-3">
                            <i class="bi bi-calendar"></i> <?= esc($book['tahun_terbit']) ?> | 
                            <i class="bi bi-file-text"></i> <?= number_format($book['jumlah_halaman']) ?> hal
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-secondary"><?= esc($book['kategori']) ?></span>
                            <div class="btn-group btn-group-sm">
                                <a href="<?= base_url('book/show/' . $book['id']) ?>" class="btn btn-info" title="Detail" onclick="event.stopPropagation()">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="<?= base_url('book/edit/' . $book['id']) ?>" class="btn btn-warning" title="Edit" onclick="event.stopPropagation()">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <a href="<?= base_url('book/delete/' . $book['id']) ?>" class="btn btn-danger" title="Hapus" onclick="event.stopPropagation(); return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Table View -->
    <div id="booksTable" style="display: none;">
        <div class="card" style="border: none;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Tahun</th>
                                <th>Kategori</th>
                                <th>ISBN</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($books as $book): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><strong><?= esc($book['judul']) ?></strong></td>
                                    <td><?= esc($book['pengarang']) ?></td>
                                    <td><?= esc($book['penerbit']) ?></td>
                                    <td><?= esc($book['tahun_terbit']) ?></td>
                                    <td>
                                        <span class="badge bg-secondary"><?= esc($book['kategori']) ?></span>
                                    </td>
                                    <td><small><?= esc($book['isbn']) ?></small></td>
                                    <td>
                                        <?php if ($book['status'] === 'Tersedia'): ?>
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle-fill"></i> Tersedia
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">
                                                <i class="bi bi-hourglass-split"></i> Dipinjam
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('book/show/' . $book['id']) ?>" class="btn btn-info" title="Detail">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            <a href="<?= base_url('book/edit/' . $book['id']) ?>" class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <a href="<?= base_url('book/delete/' . $book['id']) ?>" class="btn btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                                <i class="bi bi-trash-fill"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<style>
    .book-card {
        transition: all 0.3s ease;
    }
    
    .book-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3) !important;
    }

    .book-card .card-img-top {
        transition: all 0.3s ease;
    }

    .book-card:hover .card-img-top {
        transform: scale(1.05);
    }
</style>

<script>
    function toggleView(view) {
        const gridView = document.getElementById('booksGrid');
        const tableView = document.getElementById('booksTable');
        const gridBtn = document.getElementById('gridView');
        const tableBtn = document.getElementById('tableView');

        if (view === 'grid') {
            gridView.style.display = 'flex';
            tableView.style.display = 'none';
            gridBtn.classList.remove('btn-outline-light');
            gridBtn.classList.add('btn-light');
            tableBtn.classList.remove('btn-light');
            tableBtn.classList.add('btn-outline-light');
        } else {
            gridView.style.display = 'none';
            tableView.style.display = 'block';
            tableBtn.classList.remove('btn-outline-light');
            tableBtn.classList.add('btn-light');
            gridBtn.classList.remove('btn-light');
            gridBtn.classList.add('btn-outline-light');
        }
    }
</script>

<?= $this->endSection() ?>