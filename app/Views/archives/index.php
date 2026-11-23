<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Header Atas: Pencarian & Tombol Upload -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Semua Berkas Arsip</h4>
        <p class="text-muted small mb-0">Total <strong><?= count($archives) ?></strong> dokumen tersimpan dalam sistem</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('/arsip/create') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm fw-semibold">
            <i class="bi bi-plus-lg me-1"></i> Upload Dokumen Baru
        </a>
    </div>
</div>

<!-- Filter Kategori Berbentuk Tab Pills Modern -->
<div class="mb-4 d-flex align-items-center gap-2 overflow-auto pb-2">
    <a href="<?= base_url('/arsip') ?>" 
       class="btn btn-sm rounded-pill px-3 fw-semibold <?= empty($selectedCategory) ? 'btn-dark' : 'btn-light border' ?>">
        Semua Kategori
    </a>
    <?php foreach ($categories as $cat) : ?>
        <a href="<?= base_url('/arsip?category_id=' . $cat['id']) ?>" 
           class="btn btn-sm rounded-pill px-3 fw-semibold <?= ($selectedCategory == $cat['id']) ? 'btn-dark' : 'btn-light border text-secondary' ?>">
            <?= esc($cat['name']) ?>
        </a>
    <?php endforeach; ?>
</div>

<!-- Daftar Arsip dalam Bentuk Kartu Modern (Persis Foto ke-2) -->
<div class="d-flex flex-column gap-3">
    <?php if (empty($archives)) : ?>
        <div class="p-5 text-center bg-white rounded-4 shadow-sm text-muted">
            <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
            Tidak ada dokumen yang ditemukan.
            <div class="mt-2">
                <a href="<?= base_url('/arsip/create') ?>" class="btn btn-sm btn-primary rounded-pill">
                    <i class="bi bi-cloud-arrow-up-fill me-1"></i> Upload Arsip Pertama
                </a>
            </div>
        </div>
    <?php else : ?>
        <?php foreach ($archives as $arc) : ?>
            <div class="p-3 p-md-4 bg-white rounded-4 shadow-sm d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 border border-light">
                <div class="d-flex align-items-center gap-3">
                    <!-- Box Thumbnail Berwarna Cerah -->
                    <div class="rounded-4 d-flex align-items-center justify-content-center shadow-sm" 
                         style="width: 60px; height: 60px; min-width: 60px; background: <?= str_contains($arc['file_type'], 'pdf') ? '#fee2e2' : '#fef3c7' ?>;">
                        <?php if (str_contains($arc['file_type'], 'pdf')) : ?>
                            <i class="bi bi-file-earmark-pdf-fill fs-3 text-danger"></i>
                        <?php else : ?>
                            <i class="bi bi-file-earmark-image-fill fs-3 text-warning"></i>
                        <?php endif; ?>
                    </div>

                    <div>
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 1.05rem;"><?= esc($arc['title']) ?></h6>
                        <?php if (!empty($arc['description'])) : ?>
                            <p class="text-secondary small mb-1 text-truncate" style="max-width: 500px;"><?= esc($arc['description']) ?></p>
                        <?php endif; ?>
                        
                        <div class="d-flex flex-wrap align-items-center gap-2 text-muted small">
                            <span class="badge bg-light text-dark border px-2 py-1">
                                <i class="bi bi-tag-fill me-1 text-primary"></i><?= esc($arc['category_name'] ?? 'Umum') ?>
                            </span>
                            <span>•</span>
                            <span><i class="bi bi-paperclip me-1"></i><?= esc($arc['original_file_name']) ?></span>
                            <span>•</span>
                            <span><?= $arc['file_size'] ?> KB</span>
                            <span>•</span>
                            <span><i class="bi bi-calendar3 me-1"></i><?= date('d M Y', strtotime($arc['created_at'])) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi Bersih (Lihat, Download, Edit, Hapus) -->
                <div class="d-flex align-items-center gap-2 justify-content-end">
                    <a href="<?= base_url('/arsip/preview/' . $arc['id']) ?>" target="_blank" class="btn btn-light rounded-pill px-3 py-1 btn-sm border" title="Lihat Dokumen">
                        <i class="bi bi-eye me-1 text-primary"></i> Lihat
                    </a>
                    <a href="<?= base_url('/arsip/download/' . $arc['id']) ?>" class="btn btn-light rounded-pill px-3 py-1 btn-sm border" title="Unduh Dokumen">
                        <i class="bi bi-download me-1 text-success"></i> Unduh
                    </a>
                    <a href="<?= base_url('/arsip/edit/' . $arc['id']) ?>" class="btn btn-outline-secondary rounded-circle btn-sm d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="<?= base_url('/arsip/delete/' . $arc['id']) ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus arsip dokumen <?= esc($arc['title']) ?>?');">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-outline-danger rounded-circle btn-sm d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>