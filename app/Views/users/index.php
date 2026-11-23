<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <div>
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-people-fill me-2 text-primary"></i>Manajemen Pengguna & Petugas</h6>
            <small class="text-muted">Kelola siapa saja yang memiliki akses untuk login dan mengelola sistem ini</small>
        </div>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah Pengguna Baru
        </button>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Pengguna</th>
                        <th>Alamat Email</th>
                        <th>Tanggal Dibuat</th>
                        <th class="text-center" style="width: 140px;">Status Akun</th>
                        <th class="text-center" style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)) : ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada pengguna lain.</td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1; foreach ($users as $u) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="fw-bold text-dark">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; font-weight: 600;">
                                            <?= strtoupper(substr($u['name'], 0, 1)) ?>
                                        </div>
                                        <span><?= esc($u['name']) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <i class="bi bi-envelope text-secondary me-1"></i>
                                    <?= esc($u['email']) ?>
                                </td>
                                <td>
                                    <small class="text-muted"><?= date('d/m/Y H:i', strtotime($u['created_at'])) ?></small>
                                </td>
                                <td class="text-center">
                                    <?php if ($u['id'] == session()->get('id')) : ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                            <i class="bi bi-check2-circle me-1"></i>Akun Anda
                                        </span>
                                    <?php else : ?>
                                        <span class="badge bg-secondary-subtle text-secondary border px-2 py-1">
                                            Petugas
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <!-- Tombol Edit -->
                                        <button type="button" class="btn btn-sm btn-warning text-dark" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalEditUser<?= $u['id'] ?>" 
                                                title="Edit Pengguna">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>

                                        <!-- Tombol Hapus (Hanya untuk akun orang lain) -->
                                        <?php if ($u['id'] != session()->get('id')) : ?>
                                            <form action="<?= base_url('/pengguna/delete/' . $u['id']) ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun <?= esc($u['name']) ?>?');">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Pengguna">
                                                    <i class="bi bi-trash-fill"></i> Hapus
                                                </button>
                                            </form>
                                        <?php else : ?>
                                            <span class="badge bg-secondary-subtle text-secondary border px-2 py-1" title="Anda sedang login dengan akun ini">
                                                <i class="bi bi-lock-fill me-1"></i> Aktif
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Edit Pengguna -->
                            <div class="modal fade" id="modalEditUser<?= $u['id'] ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="<?= base_url('/pengguna/update/' . $u['id']) ?>" method="POST" autocomplete="off">
                                            <?= csrf_field() ?>
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Pengguna</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label small fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                                    <input type="text" name="name" class="form-control" value="<?= esc($u['name']) ?>" required autocomplete="off">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                                                    <input type="email" name="email" class="form-control" value="<?= esc($u['email']) ?>" required autocomplete="off">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-semibold">Ganti Password Baru</label>
                                                    <div class="input-group">
                                                        <input type="password" name="password" id="inputPassEdit<?= $u['id'] ?>" class="form-control" placeholder="••••••••" autocomplete="new-password">
                                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePass('inputPassEdit<?= $u['id'] ?>', this)">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                    </div>
                                                    <div class="form-text small text-muted">Kosongkan jika tidak ingin mengubah password lama.</div>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check-lg me-1"></i>Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Pengguna Baru -->
<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url('/pengguna/store') ?>" method="POST" autocomplete="off">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="bi bi-person-plus-fill me-2 text-primary"></i>Tambah Pengguna Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Budi Santoso" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Alamat Email (Untuk Login) <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" name="password" id="inputPassTambah" class="form-control" placeholder="Minimal 6 karakter" required autocomplete="new-password">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePass('inputPassTambah', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePass(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>

<?= $this->endSection() ?>