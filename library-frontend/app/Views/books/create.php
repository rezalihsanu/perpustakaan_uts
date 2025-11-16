<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <!-- Header Card -->
        <div class="card mb-4" style="border: none; background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <div class="card-body text-white text-center py-4">
                <i class="bi bi-plus-circle-fill" style="font-size: 3rem; opacity: 0.9;"></i>
                <h2 class="mt-3 mb-2 fw-bold">Tambah Buku Baru</h2>
                <p class="mb-0 opacity-75">Lengkapi informasi buku yang akan ditambahkan ke perpustakaan</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card" style="border: none;">
            <div class="card-body p-4 p-md-5">
                <!-- Error Messages -->
                <?php if (session()->has('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                            <div>
                                <strong>Validasi Gagal!</strong>
                                <ul class="mb-0 mt-2">
                                    <?php foreach (session('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('message')): ?>
                    <?php $message = session('message'); ?>
                    <div class="alert alert-<?= esc($message['type']) ?> alert-dismissible fade show">
                        <i class="bi bi-check-circle-fill"></i> <?= esc($message['text']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Form -->
                <form action="<?= base_url('book/store') ?>" method="post" id="bookForm">
                    <?= csrf_field() ?>

                    <!-- Section: Informasi Dasar -->
                    <div class="mb-5">
                        <h5 class="fw-bold mb-4" style="color: #6366f1;">
                            <i class="bi bi-info-circle-fill"></i> Informasi Dasar
                        </h5>
                        
                        <div class="mb-4">
                            <label for="judul" class="form-label">
                                Judul Buku <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; border: none;">
                                    <i class="bi bi-book-fill"></i>
                                </span>
                                <input type="text" 
                                       class="form-control <?= session('errors.judul') ? 'is-invalid' : '' ?>" 
                                       id="judul" 
                                       name="judul" 
                                       value="<?= old('judul') ?>"
                                       placeholder="Masukkan judul buku"
                                       required>
                                <?php if (session('errors.judul')): ?>
                                    <div class="invalid-feedback"><?= session('errors.judul') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="pengarang" class="form-label">
                                    Pengarang <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; border: none;">
                                        <i class="bi bi-person-fill"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control <?= session('errors.pengarang') ? 'is-invalid' : '' ?>" 
                                           id="pengarang" 
                                           name="pengarang" 
                                           value="<?= old('pengarang') ?>"
                                           placeholder="Nama pengarang"
                                           required>
                                    <?php if (session('errors.pengarang')): ?>
                                        <div class="invalid-feedback"><?= session('errors.pengarang') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="penerbit" class="form-label">
                                    Penerbit <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; border: none;">
                                        <i class="bi bi-building"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control <?= session('errors.penerbit') ? 'is-invalid' : '' ?>" 
                                           id="penerbit" 
                                           name="penerbit" 
                                           value="<?= old('penerbit') ?>"
                                           placeholder="Nama penerbit"
                                           required>
                                    <?php if (session('errors.penerbit')): ?>
                                        <div class="invalid-feedback"><?= session('errors.penerbit') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Detail Publikasi -->
                    <div class="mb-5">
                        <h5 class="fw-bold mb-4" style="color: #8b5cf6;">
                            <i class="bi bi-calendar-check-fill"></i> Detail Publikasi
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="tahun_terbit" class="form-label">
                                    Tahun Terbit <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background: linear-gradient(135deg, #8b5cf6, #a78bfa); color: white; border: none;">
                                        <i class="bi bi-calendar3"></i>
                                    </span>
                                    <input type="number" 
                                           class="form-control <?= session('errors.tahun_terbit') ? 'is-invalid' : '' ?>" 
                                           id="tahun_terbit" 
                                           name="tahun_terbit" 
                                           value="<?= old('tahun_terbit', date('Y')) ?>"
                                           placeholder="2024"
                                           min="1000"
                                           max="<?= date('Y') + 1 ?>"
                                           required>
                                    <?php if (session('errors.tahun_terbit')): ?>
                                        <div class="invalid-feedback"><?= session('errors.tahun_terbit') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="jumlah_halaman" class="form-label">
                                    Jumlah Halaman <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background: linear-gradient(135deg, #8b5cf6, #a78bfa); color: white; border: none;">
                                        <i class="bi bi-file-text"></i>
                                    </span>
                                    <input type="number" 
                                           class="form-control <?= session('errors.jumlah_halaman') ? 'is-invalid' : '' ?>" 
                                           id="jumlah_halaman" 
                                           name="jumlah_halaman" 
                                           value="<?= old('jumlah_halaman') ?>"
                                           placeholder="250"
                                           min="1"
                                           required>
                                    <?php if (session('errors.jumlah_halaman')): ?>
                                        <div class="invalid-feedback"><?= session('errors.jumlah_halaman') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="kategori" class="form-label">
                                    Kategori <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background: linear-gradient(135deg, #8b5cf6, #a78bfa); color: white; border: none;">
                                        <i class="bi bi-tag-fill"></i>
                                    </span>
                                    <select class="form-select <?= session('errors.kategori') ? 'is-invalid' : '' ?>" 
                                            id="kategori" 
                                            name="kategori" 
                                            required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="Fiksi" <?= old('kategori') === 'Fiksi' ? 'selected' : '' ?>>Fiksi</option>
                                        <option value="Non-Fiksi" <?= old('kategori') === 'Non-Fiksi' ? 'selected' : '' ?>>Non-Fiksi</option>
                                        <option value="Komik" <?= old('kategori') === 'Komik' ? 'selected' : '' ?>>Komik</option>
                                        <option value="Biografi" <?= old('kategori') === 'Biografi' ? 'selected' : '' ?>>Biografi</option>
                                        <option value="Sejarah" <?= old('kategori') === 'Sejarah' ? 'selected' : '' ?>>Sejarah</option>
                                        <option value="Sains" <?= old('kategori') === 'Sains' ? 'selected' : '' ?>>Sains</option>
                                        <option value="Teknologi" <?= old('kategori') === 'Teknologi' ? 'selected' : '' ?>>Teknologi</option>
                                        <option value="Pendidikan" <?= old('kategori') === 'Pendidikan' ? 'selected' : '' ?>>Pendidikan</option>
                                    </select>
                                    <?php if (session('errors.kategori')): ?>
                                        <div class="invalid-feedback"><?= session('errors.kategori') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Identifikasi -->
                    <div class="mb-5">
                        <h5 class="fw-bold mb-4" style="color: #10b981;">
                            <i class="bi bi-upc-scan"></i> Identifikasi & Status
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-8 mb-4">
                                <label for="isbn" class="form-label">
                                    ISBN <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background: linear-gradient(135deg, #10b981, #059669); color: white; border: none;">
                                        <i class="bi bi-upc"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control <?= session('errors.isbn') ? 'is-invalid' : '' ?>" 
                                           id="isbn" 
                                           name="isbn" 
                                           value="<?= old('isbn') ?>"
                                           placeholder="978-1234567890"
                                           required>
                                    <?php if (session('errors.isbn')): ?>
                                        <div class="invalid-feedback"><?= session('errors.isbn') ?></div>
                                    <?php endif; ?>
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-info-circle"></i> Format: xxx-xxxxxxxxxx
                                </small>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="status" class="form-label">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background: linear-gradient(135deg, #10b981, #059669); color: white; border: none;">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </span>
                                    <select class="form-select <?= session('errors.status') ? 'is-invalid' : '' ?>" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        <option value="Tersedia" <?= old('status') === 'Tersedia' ? 'selected' : '' ?>>Tersedia</option>
                                        <option value="Dipinjam" <?= old('status') === 'Dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
                                    </select>
                                    <?php if (session('errors.status')): ?>
                                        <div class="invalid-feedback"><?= session('errors.status') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="<?= base_url('book') ?>" class="btn btn-secondary btn-lg px-5">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="bi bi-save-fill"></i> Simpan Buku
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Form validation feedback
    document.getElementById('bookForm').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<span class="loading"></span> Menyimpan...';
        submitBtn.disabled = true;
    });

    // Auto-format ISBN
    document.getElementById('isbn').addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^0-9]/g, '');
        if (value.length > 3) {
            value = value.substring(0, 3) + '-' + value.substring(3);
        }
        e.target.value = value;
    });
</script>

<?= $this->endSection() ?>