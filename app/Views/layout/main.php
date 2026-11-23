<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= esc($title ?? 'Dashboard') ?> - DAF Arsip Dokumen</title>
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-body: #f7f8fc;
            --sidebar-width: 260px;
            --primary-purple: #635bff;
            --primary-soft: #f0edff;
            --card-radius: 18px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: #2b2f3a;
            overflow-x: hidden;
        }

        /* Sidebar Desktop */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: #ffffff;
            border-right: 1px solid #edf0f7;
            padding: 1.5rem 1.25rem 2rem;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px dashed #edf0f7;
        }

        /* Create Button */
        .btn-create-pitch {
            background: #635bff;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.88rem;
            padding: 0.7rem 1.25rem;
            border-radius: 50px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            box-shadow: 0 4px 14px rgba(99, 91, 255, 0.25);
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-create-pitch .icon-plus {
            background: rgba(255, 255, 255, 0.2);
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Nav Links */
        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-nav .nav-item {
            margin-bottom: 0.3rem;
        }
        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.75rem 1rem;
            color: #64748b;
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: 12px;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .sidebar-nav .nav-link:hover, .sidebar-nav .nav-link.active {
            color: var(--primary-purple);
            background: var(--primary-soft);
        }

        /* Main Wrapper */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .top-header {
            padding: 1.75rem 2.5rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .top-header .page-title {
            font-weight: 800;
            font-size: 1.5rem;
            color: #1e1b4b;
            margin: 0;
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #ffffff;
            padding: 6px 14px 6px 6px;
            border-radius: 50px;
            border: 1px solid #edf0f7;
            color: #1e1b4b;
        }
        .user-avatar-initials {
            width: 36px;
            height: 36px;
            background: #e0e7ff;
            color: #4338ca;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .page-content {
            padding: 1rem 2.5rem 3rem;
            flex-grow: 1;
        }

        /* Backdrop Gelap Layar HP */
        .sidebar-backdrop {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(3px);
            z-index: 1040;
            display: none;
        }
        .sidebar-backdrop.show-mobile {
            display: block;
        }

        /* ========================================= */
        /* PERBAIKAN KHUSUS LAYAR HP (Mobile Polish) */
        /* ========================================= */
        @media (max-width: 991.98px) {
            .sidebar {
                width: 82vw;
                max-width: 300px;
                transform: translateX(-100%);
                border-top-right-radius: 28px;
                border-bottom-right-radius: 28px;
                box-shadow: 12px 0 40px rgba(0,0,0,0.2);
                padding: 1.25rem 1.25rem 2.5rem; /* Padding bawah ekstra agar logout tidak terpotong */
            }
            .sidebar.show-mobile {
                transform: translateX(0);
            }
            .main-wrapper {
                margin-left: 0;
            }
            .top-header {
                display: none;
            }
            .page-content {
                padding: 1rem 0.85rem 3rem;
            }
        }
    </style>
</head>
<body>

<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<!-- Top Navbar HP (Minimalis & Elegan) -->
<nav class="d-lg-none bg-white border-bottom px-3 py-2 d-flex justify-content-between align-items-center sticky-top shadow-sm">
    <div class="d-flex align-items-center gap-2">
        <button class="btn btn-light border p-1 px-2 rounded-3 d-flex align-items-center justify-content-center" id="mobileMenuToggle" type="button">
            <i class="bi bi-list fs-3 text-dark"></i>
        </button>
        <span class="fw-bold text-dark fs-6" style="letter-spacing: -0.3px;">DAF ARSIP</span>
    </div>

    <div class="user-avatar-initials" style="width: 32px; height: 32px; font-size: 0.75rem;">
        <?= strtoupper(substr(session()->get('name') ?? 'A', 0, 2)) ?>
    </div>
</nav>

<!-- Sidebar Drawer -->
<aside class="sidebar" id="appSidebar">
    <div>
        <!-- Baris Atas HP: Label & Tombol Tutup Silang (✕) yang Rapi -->
        <div class="d-lg-none d-flex justify-content-between align-items-center mb-3 pt-1">
            <span class="text-muted small fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.05em;">Menu Navigasi</span>
            <button class="btn btn-sm btn-light border rounded-circle d-flex align-items-center justify-content-center" id="sidebarCloseBtn" type="button" style="width: 32px; height: 32px;">
                <i class="bi bi-x-lg text-secondary"></i>
            </button>
        </div>

        <!-- Logo DAF Vektor -->
        <div class="sidebar-brand">
            <svg viewBox="0 0 280 180" width="120" height="72" xmlns="http://www.w3.org/2000/svg">
                <text x="45" y="125" font-family="'Arial Black', 'Impact', sans-serif" font-size="78" font-weight="900" fill="#FFDC00" letter-spacing="1">DAF</text>
                <path d="M 180,62 C 120,28 65,30 35,55 C 10,75 5,105 25,128 C 50,155 105,178 180,188 C 225,193 260,182 272,165" 
                      fill="none" stroke="#FF5E00" stroke-width="4" stroke-linecap="round"/>
                <path d="M 38,58 C 70,36 125,36 175,62 C 120,44 72,46 45,67 C 22,86 18,112 36,133 C 60,158 115,178 190,182 C 235,184 265,172 272,162 C 265,178 230,195 180,195 C 105,195 48,172 22,140 C -2,112 2,78 38,58 Z" 
                      fill="#FF5E00"/>
            </svg>
            <span class="badge bg-warning bg-opacity-25 text-dark fw-bold px-2 py-1 mt-1" style="font-size: 0.68rem; letter-spacing: 0.04em;">SISTEM ARSIP DOKUMEN</span>
        </div>

        <a href="<?= base_url('/arsip/create') ?>" class="btn-create-pitch">
            <span>Upload Arsip</span>
            <span class="icon-plus"><i class="bi bi-plus-lg"></i></span>
        </a>

        <!-- Links Navigasi -->
        <ul class="sidebar-nav">
            <li class="nav-item">
                <a href="<?= base_url('/dashboard') ?>" class="nav-link <?= (uri_string() == 'dashboard' || uri_string() == '') ? 'active' : '' ?>">
                    <i class="bi bi-grid-1x2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('/arsip') ?>" class="nav-link <?= (str_contains(uri_string(), 'arsip')) ? 'active' : '' ?>">
                    <i class="bi bi-folder2-open"></i>
                    <span>Daftar Arsip</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('/kategori') ?>" class="nav-link <?= (str_contains(uri_string(), 'kategori')) ? 'active' : '' ?>">
                    <i class="bi bi-tags"></i>
                    <span>Kategori Arsip</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('/pengguna') ?>" class="nav-link <?= (str_contains(uri_string(), 'pengguna')) ? 'active' : '' ?>">
                    <i class="bi bi-people"></i>
                    <span>Pengguna Web</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Bagian Bawah: Profil & Tombol Logout yang Nyaman di HP -->
    <div class="p-3 bg-light rounded-4 text-center mt-3 border">
        <div class="fw-bold text-dark text-truncate small"><?= esc(session()->get('name') ?? 'Admin') ?></div>
        <span class="badge bg-primary-subtle text-primary" style="font-size: 0.7rem;">Administrator</span>
        <div class="mt-2 pt-2 border-top">
            <a href="<?= base_url('/logout') ?>" class="btn btn-sm btn-danger w-100 rounded-pill py-1 shadow-sm" onclick="return confirm('Apakah Anda yakin ingin logout?');">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </a>
        </div>
    </div>
</aside>

<!-- Main Wrapper -->
<div class="main-wrapper">
    <header class="top-header">
        <div>
            <h1 class="page-title"><?= esc($title ?? 'Dashboard') ?></h1>
            <div class="page-date"><i class="bi bi-calendar-event me-1"></i><?= date('l, d F Y') ?></div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <div class="user-pill">
                <div class="user-avatar-initials">
                    <?= strtoupper(substr(session()->get('name') ?? 'A', 0, 2)) ?>
                </div>
                <div>
                    <div class="fw-bold text-dark" style="font-size: 0.88rem; line-height: 1.2;"><?= esc(session()->get('name') ?? 'Admin') ?></div>
                    <small class="text-muted" style="font-size: 0.75rem;"><?= esc(session()->get('email') ?? '') ?></small>
                </div>
            </div>
        </div>
    </header>

    <main class="page-content">
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success border-0 shadow-sm rounded-4 alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-check-circle-fill me-2 text-success"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-4 alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 text-danger"></i> <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </main>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script Drawer HP -->
<script>
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const appSidebar = document.getElementById('appSidebar');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');
    const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');

    function openSidebar() {
        appSidebar.classList.add('show-mobile');
        sidebarBackdrop.classList.add('show-mobile');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        appSidebar.classList.remove('show-mobile');
        sidebarBackdrop.classList.remove('show-mobile');
        document.body.style.overflow = '';
    }

    mobileMenuToggle?.addEventListener('click', openSidebar);
    sidebarBackdrop?.addEventListener('click', closeSidebar);
    sidebarCloseBtn?.addEventListener('click', closeSidebar);
</script>

<?= $this->renderSection('scripts') ?>

</body>
</html>