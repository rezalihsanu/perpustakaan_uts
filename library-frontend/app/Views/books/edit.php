<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="bi bi-pencil"></i> Edit Buku
                </h5>
            </div>
            <div class="card-body">
                <!-- Error Messages -->
                <?php if (session()->has('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong><i class="bi bi-exclamation-triangle"></i> Validasi Gagal!</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('message')): ?>
                    <?php $message = session('message'); ?>
                    <div class="alert alert-<?= esc($message['type']) ?> alert-dismissible fade show">
                        <?= esc($message['text']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Form -->
                <form action="<?= base_url('book/update/' . $book['id']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="judul" class="form-label">Judul Buku <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?= session('errors.judul') ? 'is-invalid' : '' ?>" 
                                   id="judul" 
                                   name="judul" 
                                   value="<?= old('judul', $book['judul']) ?>"
                                   placeholder="Masukkan judul buku"
                                   required>
                            <?php if (session('errors.judul')): ?>
                                <div class="invalid-feedback"><?= session('errors.judul') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="pengarang" class="form-label">Pengarang <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?= session('errors.pengarang') ? 'is-invalid' : '' ?>" 
                                   id="pengarang" 
                                   name="pengarang" 
                                   value="<?= old('pengarang', $book['pengarang']) ?>"
                                   placeholder="Nama pengarang"
                                   required>
                            <?php if (session('errors.pengarang')): ?>
                                <div class="invalid-feedback"><?= session('errors.pengarang') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="penerbit" class="form-label">Penerbit <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?= session('errors.penerbit') ? 'is-invalid' : '' ?>" 
                                   id="penerbit" 
                                   name="penerbit" 
                                   value="<?= old('penerbit', $book['penerbit']) ?>"
                                   placeholder="Nama penerbit"
                                   required>
                            <?php if (session('errors.penerbit')): ?>
                                <div class="invalid-feedback"><?= session('errors.penerbit') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="tahun_terbit" class="form-label">Tahun Terbit <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control <?= session('errors.tahun_terbit') ? 'is-invalid' : '' ?>" 
                                   id="tahun_terbit" 
                                   name="tahun_terbit" 
                                   value="<?= old('tahun_terbit', $book['tahun_terbit']) ?>"
                                   placeholder="2024"
                                   min="1000"
                                   max="<?= date('Y') + 1 ?>"
                                   required>
                            <?php if (session('errors.tahun_terbit')): ?>
                                <div class="invalid-feedback"><?= session('errors.tahun_terbit') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="jumlah_halaman" class="form-label">Jumlah Halaman <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control <?= session('errors.jumlah_halaman') ? 'is-invalid' : '' ?>" 
                                   id="jumlah_halaman" 
                                   name="jumlah_halaman" 
                                   value="<?= old('jumlah_halaman', $book['jumlah_halaman']) ?>"
                                   placeholder="250"
                                   min="1"
                                   required>
                            <?php if (session('errors.jumlah_halaman')): ?>
                                <div class="invalid-feedback"><?= session('errors.jumlah_halaman') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select <?= session('errors.kategori') ? 'is-invalid' : '' ?>" 
                                    id="kategori" 
                                    name="kategori" 
                                    required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Fiksi" <?= old('kategori', $book['kategori']) === 'Fiksi' ? 'selected' : '' ?>>Fiksi</option>
                                <option value="Non-Fiksi" <?= old('kategori', $book['kategori']) === 'Non-Fiksi' ? 'selected' : '' ?>>Non-Fiksi</option>
                                <option value="Komik" <?= old('kategori', $book['kategori']) === 'Komik' ? 'selected' : '' ?>>Komik</option>
                                <option value="Biografi" <?= old('kategori', $book['kategori']) === 'Biografi' ? 'selected' : '' ?>>Biografi</option>
                                <option value="Sejarah" <?= old('kategori', $book['kategori']) === 'Sejarah' ? 'selected' : '' ?>>Sejarah</option>
                                <option value="Sains" <?= old('kategori', $book['kategori']) === 'Sains' ? 'selected' : '' ?>>Sains</option>
                                <option value="Teknologi" <?= old('kategori', $book['kategori']) === 'Teknologi' ? 'selected' : '' ?>>Teknologi</option>
                                <option value="Pendidikan" <?= old('kategori', $book['kategori']) === 'Pendidikan' ? 'selected' : '' ?>>Pendidikan</option>
                            </select>
                            <?php if (session('errors.kategori')): ?>
                                <div class="invalid-feedback"><?= session('errors.kategori') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-8 mb-3">
                            <label for="isbn" class="form-label">ISBN <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?= session('errors.isbn') ? 'is-invalid' : '' ?>" 
                                   id="isbn" 
                                   name="isbn" 
                                   value="<?= old('isbn', $book['isbn']) ?>"
                                   placeholder="978-1234567890"
                                   required>
                            <?php if (session('errors.isbn')): ?>
                                <div class="invalid-feedback"><?= session('errors.isbn') ?></div>
                            <?php endif; ?>
                            <small class="text-muted">Format: xxx-xxxxxxxxxx</small>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select <?= session('errors.status') ? 'is-invalid' : '' ?>" 
                                    id="status" 
                                    name="status" 
                                    required>
                                <option value="Tersedia" <?= old('status', $book['status']) === 'Tersedia' ? 'selected' : '' ?>>Tersedia</option>
                                <option value="Dipinjam" <?= old('status', $book['status']) === 'Dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
                            </select>
                            <?php if (session('errors.status')): ?>
                                <div class="invalid-feedback"><?= session('errors.status') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('book') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save"></i> Update Buku
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>