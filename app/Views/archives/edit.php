<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Dokumen Arsip</h6>
                <a href="<?= base_url('/arsip') ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="card-body p-4">
                <form action="<?= base_url('/arsip/update/' . $archive['id']) ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <!-- Judul Arsip -->
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">Judul Arsip <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" value="<?= old('title', $archive['title']) ?>" required>
                    </div>

                    <!-- Kategori Arsip -->
                    <div class="mb-3">
                        <label for="category_id" class="form-label fw-semibold">Kategori Arsip <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($categories as $cat) : ?>
                                <option value="<?= $cat['id'] ?>" <?= (old('category_id', $archive['category_id']) == $cat['id']) ? 'selected' : '' ?>>
                                    <?= esc($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Deskripsi Arsip (Opsional) -->
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Deskripsi Arsip <span class="text-muted fw-normal">(Opsional)</span></label>
                        <textarea name="description" id="description" class="form-control" rows="3"><?= old('description', $archive['description']) ?></textarea>
                    </div>

                    <!-- File Saat Ini -->
                    <div class="mb-3 p-3 bg-light rounded border">
                        <label class="form-label fw-semibold small mb-1">File Dokumen Saat Ini:</label>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <i class="bi bi-file-earmark-check-fill text-success fs-5 me-2"></i>
                                <span class="fw-semibold text-dark"><?= esc($archive['original_file_name']) ?></span>
                                <span class="text-muted small ms-2">(<?= $archive['file_size'] ?> KB)</span>
                            </div>
                            <a href="<?= base_url('/arsip/preview/' . $archive['id']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye me-1"></i> Preview File
                            </a>
                        </div>
                    </div>

                    <!-- Ganti File Dokumen (Opsional) -->
                    <div class="mb-4">
                        <label for="document" class="form-label fw-semibold">Ganti File Dokumen <span class="text-muted fw-normal">(Biarkan kosong jika tidak ingin mengganti file)</span></label>
                        <input type="file" name="document" id="document" class="form-control" accept=".pdf, .jpg, .jpeg, .png">
                        <div class="form-text text-muted mt-2">
                            <i class="bi bi-info-circle me-1"></i>Format yang diizinkan: <strong>PDF, JPG, JPEG, PNG</strong>. Maksimal ukuran file: <strong>5 MB</strong>.
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('/arsip') ?>" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
