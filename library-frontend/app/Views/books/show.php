<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Back Button -->
        <div class="mb-3">
            <a href="<?= base_url('book') ?>" class="btn btn-light">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>

        <!-- Main Detail Card -->
        <div class="card" style="border: none; overflow: hidden;">
            <!-- Header with Gradient -->
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 3rem 2rem; position: relative; overflow: hidden;">
                <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                
                <div class="row align-items-center position-relative">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center mb-3">
                            <?php if ($book['status'] === 'Tersedia'): ?>
                                <span class="badge bg-success fs-6 px-4 py-2 me-3">
                                    <i class="bi bi-check-circle-fill"></i> Tersedia
                                </span>
                            <?php else: ?>
                                <span class="badge bg-warning fs-6 px-4 py-2 me-3">
                                    <i class="bi bi-hourglass-split"></i> Dipinjam
                                </span>
                            <?php endif; ?>
                            <span class="badge text-white fs-6 px-4 py-2" style="background: rgba(255,255,255,0.2);">
                                <?= esc($book['kategori']) ?>
                            </span>
                        </div>
                        <h1 class="text-white fw-bold mb-3" style="font-size: 2.5rem;">
                            <?= esc($book['judul']) ?>
                        </h1>
                        <p class="text-white opacity-75 fs-5 mb-0">
                            <i class="bi bi-person-fill"></i> <?= esc($book['pengarang']) ?>
                        </p>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="bg-white bg-opacity-10 rounded-4 p-4" style="backdrop-filter: blur(10px);">
                            <i class="bi bi-book-fill text-white" style="font-size: 5rem; opacity: 0.9;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <!-- Information Grid -->
                <div class="row g-4 mb-5">
                    <!-- Penerbit -->
                    <div class="col-md-6">
                        <div class="info-card p-4 h-100" style="background: linear-gradient(135deg, #f3f4f6, #e5e7eb); border-radius: 15px;">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-building text-white fs-4"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Penerbit</small>
                                    <strong class="fs-5"><?= esc($book['penerbit']) ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tahun Terbit -->
                    <div class="col-md-6">
                        <div class="info-card p-4 h-100" style="background: linear-gradient(135deg, #f3f4f6, #e5e7eb); border-radius: 15px;">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #8b5cf6, #a78bfa); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-calendar-check text-white fs-4"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Tahun Terbit</small>
                                    <strong class="fs-5"><?= esc($book['tahun_terbit']) ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jumlah Halaman -->
                    <div class="col-md-6">
                        <div class="info-card p-4 h-100" style="background: linear-gradient(135deg, #f3f4f6, #e5e7eb); border-radius: 15px;">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-file-text text-white fs-4"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Jumlah Halaman</small>
                                    <strong class="fs-5"><?= number_format($book['jumlah_halaman']) ?> halaman</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ISBN -->
                    <div class="col-md-6">
                        <div class="info-card p-4 h-100" style="background: linear-gradient(135deg, #f3f4f6, #e5e7eb); border-radius: 15px;">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #f59e0b, #f97316); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-upc-scan text-white fs-4"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">ISBN</small>
                                    <strong class="fs-6"><code style="background: rgba(99, 102, 241, 0.1); padding: 0.25rem 0.75rem; border-radius: 8px;"><?= esc($book['isbn']) ?></code></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Metadata Timeline -->
                <div class="p-4 mb-4" style="background: linear-gradient(135deg, #fef3c7, #fde68a); border-radius: 15px; border-left: 4px solid #f59e0b;">
                    <h6 class="fw-bold mb-3" style="color: #92400e;">
                        <i class="bi bi-clock-history"></i> Riwayat
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Ditambahkan</small>
                            <strong><?= date('d M Y, H:i', strtotime($book['created_at'])) ?> WIB</strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Terakhir Diupdate</small>
                            <strong><?= date('d M Y, H:i', strtotime($book['updated_at'])) ?> WIB</strong>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex flex-wrap gap-3 justify-content-center">
                    <a href="<?= base_url('book/edit/' . $book['id']) ?>" class="btn btn-warning btn-lg px-5" style="border-radius: 50px;">
                        <i class="bi bi-pencil-fill"></i> Edit Buku
                    </a>
                    <button type="button" class="btn btn-danger btn-lg px-5" style="border-radius: 50px;" onclick="confirmDelete()">
                        <i class="bi bi-trash-fill"></i> Hapus Buku
                    </button>
                    <a href="<?= base_url('book') ?>" class="btn btn-secondary btn-lg px-5" style="border-radius: 50px;">
                        <i class="bi bi-list"></i> Lihat Semua Buku
                    </a>
                </div>
            </div>
        </div>

        <!-- Additional Info Cards -->
        <div class="row g-4 mt-2">
            <div class="col-md-4">
                <div class="card h-100 text-center" style="border: none; background: linear-gradient(135deg, #dbeafe, #bfdbfe);">
                    <div class="card-body py-4">
                        <i class="bi bi-star-fill" style="font-size: 2.5rem; color: #3b82f6;"></i>
                        <h6 class="mt-3 mb-0">Buku Populer</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center" style="border: none; background: linear-gradient(135deg, #d1fae5, #a7f3d0);">
                    <div class="card-body py-4">
                        <i class="bi bi-bookmark-check-fill" style="font-size: 2.5rem; color: #10b981;"></i>
                        <h6 class="mt-3 mb-0">Tersimpan</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center" style="border: none; background: linear-gradient(135deg, #fce7f3, #fbcfe8);">
                    <div class="card-body py-4">
                        <i class="bi bi-share-fill" style="font-size: 2.5rem; color: #ec4899;"></i>
                        <h6 class="mt-3 mb-0">Bagikan</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 20px;">
            <div class="modal-body text-center p-5">
                <div class="mb-4">
                    <i class="bi bi-exclamation-triangle-fill" style="font-size: 5rem; color: #ef4444;"></i>
                </div>
                <h4 class="fw-bold mb-3">Hapus Buku?</h4>
                <p class="text-muted mb-4">
                    Apakah Anda yakin ingin menghapus buku<br>
                    <strong>"<?= esc($book['judul']) ?>"</strong>?<br>
                    Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="d-flex gap-3 justify-content-center">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                    <a href="<?= base_url('book/delete/' . $book['id']) ?>" class="btn btn-danger px-4">
                        <i class="bi bi-trash-fill"></i> Ya, Hapus
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .info-card {
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .icon-box {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
</style>

<script>
    function confirmDelete() {
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>

<?= $this->endSection() ?>