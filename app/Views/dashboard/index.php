<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- 1. Hero Welcome Banner (Kompak di HP, Elegan di Laptop) -->
<div class="p-3 p-md-4 mb-3 rounded-4 position-relative overflow-hidden shadow-sm" 
     style="background: linear-gradient(135deg, #ede9fe 0%, #e0e7ff 100%); border-radius: 20px;">
    <div class="row align-items-center">
        <div class="col-12 col-md-8">
            <h3 class="fw-bold text-dark mb-1 fs-4">
                Hi, <?= esc(session()->get('name') ?? 'Administrator') ?> 👋
            </h3>
            <p class="text-secondary small mb-3" style="max-width: 480px; line-height: 1.5;">
                Selamat datang di <strong>DAF Sistem Arsip Dokumen</strong>. Seluruh berkas digital Anda aman dan terkelola dengan baik.
            </p>
            <div class="d-flex flex-wrap gap-2">
                <a href="<?= base_url('/arsip/create') ?>" class="btn btn-dark btn-sm px-3 py-2 rounded-pill fw-semibold shadow-sm">
                    <i class="bi bi-cloud-arrow-up-fill me-1 text-warning"></i> Upload Berkas
                </a>
                <a href="<?= base_url('/arsip') ?>" class="btn btn-white bg-white border text-dark btn-sm px-3 py-2 rounded-pill fw-semibold shadow-sm">
                    <i class="bi bi-folder2-open me-1 text-primary"></i> Semua Arsip
                </a>
            </div>
        </div>
        <div class="col-md-4 d-none d-md-flex justify-content-end">
            <!-- Ilustrasi Vektor di Laptop -->
            <svg width="150" height="110" viewBox="0 0 200 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="20" y="25" width="160" height="105" rx="18" fill="#ffffff" fill-opacity="0.9"/>
                <circle cx="100" cy="65" r="26" fill="#6366f1" fill-opacity="0.2"/>
                <path d="M100 48V82M83 65H117" stroke="#4f46e5" stroke-width="4.5" stroke-linecap="round"/>
                <rect x="45" y="105" width="110" height="8" rx="4" fill="#c7d2fe"/>
            </svg>
        </div>
    </div>
</div>

<!-- 2. Overview 4 Kartu Metrik: POLA 2x2 GRID (Kanan-Kiri Atas & Kanan-Kiri Bawah) -->
<div class="d-flex align-items-center justify-content-between mb-2 px-1">
    <span class="text-secondary fw-bold small text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em;">
        <i class="bi bi-bar-chart-fill me-1 text-primary"></i> Statistik Arsip
    </span>
    <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 0.7rem;">Realtime</span>
</div>

<div class="row g-2 g-md-3 mb-4">
    <!-- BARIS 1 (KIRI) : Total Arsip Dokumen (Kuning Emas) -->
    <div class="col-6">
        <div class="p-3 p-md-4 rounded-4 shadow-sm text-dark h-100 d-flex flex-column justify-content-between border border-warning-subtle" 
             style="background: linear-gradient(135deg, #fef08a 0%, #facc15 100%); min-height: 110px;">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="small fw-bold text-dark text-opacity-75" style="font-size: 0.78rem;">Total Arsip</span>
                <div class="rounded-circle bg-white bg-opacity-40 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                    <i class="bi bi-folder-fill fs-6 text-dark"></i>
                </div>
            </div>
            <div>
                <h2 class="fw-bolder mb-0 mt-1" style="font-size: 1.85rem; font-weight: 800;"><?= $totalArchives ?></h2>
                <small class="text-dark text-opacity-75 d-block" style="font-size: 0.7rem;">Berkas tersimpan</small>
            </div>
        </div>
    </div>

    <!-- BARIS 1 (KANAN) : Kategori Arsip (Ungu Tua / Deep Violet) -->
    <div class="col-6">
        <div class="p-3 p-md-4 rounded-4 shadow-sm text-white h-100 d-flex flex-column justify-content-between" 
             style="background: linear-gradient(135deg, #3730a3 0%, #312e81 100%); min-height: 110px;">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="small fw-semibold text-white text-opacity-75" style="font-size: 0.78rem;">Kategori</span>
                <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                    <i class="bi bi-tags-fill fs-6 text-white"></i>
                </div>
            </div>
            <div>
                <h2 class="fw-bolder mb-0 mt-1 text-white" style="font-size: 1.85rem; font-weight: 800;"><?= $totalCategories ?></h2>
                <small class="text-white text-opacity-75 d-block" style="font-size: 0.7rem;">Jenis kategori</small>
            </div>
        </div>
    </div>

    <!-- BARIS 2 (KIRI) : Pengguna Aktif (Coral Pink) -->
    <div class="col-6">
        <div class="p-3 p-md-4 rounded-4 shadow-sm text-white h-100 d-flex flex-column justify-content-between" 
             style="background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%); min-height: 110px;">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="small fw-semibold text-white text-opacity-75" style="font-size: 0.78rem;">Pengguna</span>
                <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                    <i class="bi bi-people-fill fs-6 text-white"></i>
                </div>
            </div>
            <div>
                <h2 class="fw-bolder mb-0 mt-1 text-white" style="font-size: 1.85rem; font-weight: 800;"><?= $totalUsers ?></h2>
                <small class="text-white text-opacity-75 d-block" style="font-size: 0.7rem;">Petugas terdaftar</small>
            </div>
        </div>
    </div>

    <!-- BARIS 2 (KANAN) : Format Dokumen (Soft Periwinkle / Lavender) -->
    <div class="col-6">
        <div class="p-3 p-md-4 rounded-4 shadow-sm text-dark h-100 d-flex flex-column justify-content-between" 
             style="background: linear-gradient(135deg, #c7d2fe 0%, #a5b4fc 100%); min-height: 110px;">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="small fw-bold text-dark text-opacity-75" style="font-size: 0.78rem;">PDF & Gambar</span>
                <div class="rounded-circle bg-white bg-opacity-40 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                    <i class="bi bi-file-earmark-check-fill fs-6 text-dark"></i>
                </div>
            </div>
            <div>
                <h2 class="fw-bolder mb-0 mt-1" style="font-size: 1.85rem; font-weight: 800;"><?= $totalPdf + $totalImg ?></h2>
                <small class="text-dark text-opacity-75 d-block" style="font-size: 0.7rem;"><?= $totalPdf ?> PDF • <?= $totalImg ?> Gambar</small>
            </div>
        </div>
    </div>
</div>

<!-- 3. Daftar Berkas Arsip Terbaru (Sangat Bersih di HP) -->
<div class="d-flex align-items-center justify-content-between mb-3 px-1">
    <h6 class="fw-bold text-dark mb-0 fs-6">
        <i class="bi bi-clock-history me-1 text-primary"></i> Berkas Arsip Terbaru
    </h6>
    <a href="<?= base_url('/arsip') ?>" class="text-decoration-none fw-semibold text-primary small" style="font-size: 0.8rem;">
        Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
    </a>
</div>

<div class="d-flex flex-column gap-2">
    <?php if (empty($recentArchives)) : ?>
        <div class="p-4 text-center bg-white rounded-4 shadow-sm text-muted small">
            <i class="bi bi-inbox fs-2 d-block mb-1 text-secondary"></i>
            Belum ada arsip dokumen yang diunggah.
            <div class="mt-2">
                <a href="<?= base_url('/arsip/create') ?>" class="btn btn-sm btn-primary rounded-pill px-3">
                    <i class="bi bi-plus-lg me-1"></i> Upload Pertama
                </a>
            </div>
        </div>
    <?php else : ?>
        <?php foreach ($recentArchives as $arc) : ?>
            <div class="p-3 bg-white rounded-4 shadow-sm border border-light d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-2">
                <!-- Info Dokumen -->
                <div class="d-flex align-items-center gap-2 overflow-hidden w-100">
                    <!-- Icon Format File -->
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" 
                         style="width: 44px; height: 44px; background: <?= str_contains($arc['file_type'], 'pdf') ? '#fee2e2' : '#fef3c7' ?>;">
                        <?php if (str_contains($arc['file_type'], 'pdf')) : ?>
                            <i class="bi bi-file-earmark-pdf-fill fs-4 text-danger"></i>
                        <?php else : ?>
                            <i class="bi bi-file-earmark-image-fill fs-4 text-warning"></i>
                        <?php endif; ?>
                    </div>

                    <div class="overflow-hidden">
                        <div class="fw-bold text-dark text-truncate" style="font-size: 0.92rem;"><?= esc($arc['title']) ?></div>
                        <div class="d-flex align-items-center gap-1 text-muted small" style="font-size: 0.75rem;">
                            <span class="badge bg-light text-dark border px-1 py-0"><?= esc($arc['category_name'] ?? 'Umum') ?></span>
                            <span>•</span>
                            <span><?= $arc['file_size'] ?> KB</span>
                            <span>•</span>
                            <span><?= date('d/m/y', strtotime($arc['created_at'])) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi HP (Lebar Pas & Sentuhan Nyaman) -->
                <div class="d-flex align-items-center gap-1 w-100 justify-content-end pt-2 pt-sm-0 border-top border-sm-0">
                    <a href="<?= base_url('/arsip/preview/' . $arc['id']) ?>" target="_blank" class="btn btn-light rounded-pill px-3 py-1 btn-sm border" style="font-size: 0.75rem;">
                        <i class="bi bi-eye me-1 text-primary"></i> Lihat
                    </a>
                    <a href="<?= base_url('/arsip/download/' . $arc['id']) ?>" class="btn btn-light rounded-pill px-3 py-1 btn-sm border" style="font-size: 0.75rem;">
                        <i class="bi bi-download me-1 text-success"></i> Unduh
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>