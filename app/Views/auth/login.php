<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Sistem Arsip Dokumen</title>
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --daf-orange: #ff5e00;
            --daf-orange-hover: #e05300;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 50%, #fed7aa 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 1rem;
            color: #2b2f3a;
        }

        /* Card Container (Bersih & Elegan) */
        .login-box {
            background: #ffffff;
            border-radius: 36px;
            box-shadow: 0 25px 60px rgba(255, 94, 0, 0.12);
            max-width: 420px;
            width: 100%;
            padding: 2.75rem 2.25rem 2.25rem;
            text-align: center;
        }

        /* Input Pill Style */
        .form-control-pill {
            border-radius: 50px;
            padding: 0.85rem 1.4rem;
            border: 1.5px solid #e2e8f0;
            font-size: 0.95rem;
            background-color: #fdfdfd;
            transition: all 0.2s;
        }
        .form-control-pill:focus {
            border-color: var(--daf-orange);
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(255, 94, 0, 0.12);
        }

        /* Tombol Utama Oranye */
        .btn-daf-primary {
            background: linear-gradient(135deg, #ff5e00 0%, #ff7700 100%);
            color: #ffffff;
            font-weight: 700;
            font-size: 1rem;
            padding: 0.85rem;
            border-radius: 50px;
            border: none;
            box-shadow: 0 8px 20px rgba(255, 94, 0, 0.28);
            transition: all 0.2s;
        }
        .btn-daf-primary:hover {
            background: linear-gradient(135deg, #e05300 0%, #ff5e00 100%);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(255, 94, 0, 0.35);
        }
    </style>
</head>
<body>

<div class="login-box">
    <!-- Judul Header -->
    <h2 class="fw-bold text-dark mb-1" style="font-size: 2rem;">Masuk Akun</h2>
    <p class="text-muted small mb-4">Sistem Pengelolaan Arsip Dokumen Digital</p>

    <!-- Alert Notifikasi -->
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger py-2 small rounded-pill border-0 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-1"></i> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success py-2 small rounded-pill border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-1"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- Form Login Email & Password -->
    <form action="<?= base_url('/loginProcess') ?>" method="POST" autocomplete="off">
        <?= csrf_field() ?>

        <div class="mb-3 text-start">
            <input type="email" name="email" id="email" class="form-control form-control-pill" 
                   placeholder="Alamat email" value="<?= old('email', 'admin@arsip.com') ?>" required autofocus>
        </div>

        <div class="mb-4 text-start position-relative">
            <input type="password" name="password" id="password" class="form-control form-control-pill pe-5" 
                   placeholder="Kata sandi" value="password123" required autocomplete="current-password">
            <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted me-3 p-0" 
                    id="togglePassword" style="box-shadow: none;">
                <i class="bi bi-eye" id="eyeIcon"></i>
            </button>
        </div>

        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-daf-primary">
                Masuk Sekarang
            </button>
        </div>
    </form>

    <!-- Keterangan Akun Pengujian (Untuk Evaluator / Reviewer) -->
    <div class="p-2 rounded-4 bg-light border text-muted small" style="font-size: 0.78rem;">
        <span class="fw-semibold text-dark">Akun Demo Penguji:</span> admin@arsip.com / password123
    </div>
</div>

<script>
    // Fitur Lihat / Sembunyikan Password
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        eyeIcon.classList.toggle('bi-eye');
        eyeIcon.classList.toggle('bi-eye-slash');
    });
</script>

</body>
</html>