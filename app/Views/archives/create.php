<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-cloud-arrow-up-fill me-2 text-primary"></i>Upload Dokumen Arsip Baru</h6>
                <a href="<?= base_url('/arsip') ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="card-body p-4">
                <form action="<?= base_url('/arsip/store') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <!-- Judul Arsip -->
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">Judul Arsip <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Contoh: Surat Perjanjian Kerjasama 2026" value="<?= old('title') ?>" required autofocus>
                    </div>

                    <!-- Kategori Arsip -->
                    <div class="mb-3">
                        <label for="category_id" class="form-label fw-semibold">Kategori Arsip <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($categories as $cat) : ?>
                                <option value="<?= $cat['id'] ?>" <?= (old('category_id') == $cat['id']) ? 'selected' : '' ?>>
                                    <?= esc($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Deskripsi Arsip (Opsional) -->
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Deskripsi Arsip <span class="text-muted fw-normal">(Opsional)</span></label>
                        <textarea name="description" id="description" class="form-control" rows="3" placeholder="Tuliskan ringkasan atau keterangan tambahan mengenai dokumen ini..."><?= old('description') ?></textarea>
                    </div>

                    <!-- Upload File Dokumen -->
                    <div class="mb-4">
                        <label for="document" class="form-label fw-semibold">File Dokumen <span class="text-danger">*</span></label>
                        <input type="file" name="document" id="document" class="form-control" accept=".pdf, .jpg, .jpeg, .png" required>
                        <div class="form-text text-muted mt-2">
                            <i class="bi bi-info-circle me-1"></i>Format yang diizinkan: <strong>PDF, JPG, JPEG, PNG</strong>. Maksimal ukuran file: <strong>5 MB</strong>.
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('/arsip') ?>" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-cloud-upload-fill me-1"></i> Simpan & Unggah Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
