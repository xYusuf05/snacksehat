<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SnackCheck – Smart Nutri-Check & Klasifikasi Nutrisi Snack</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --accent-cyan: #22d3ee;
            --accent-indigo: #6366f1;
            --bg-dark: #0f172a;
            --bg-card: rgba(30, 41, 59, 0.7);
            --border-glass: rgba(255, 255, 255, 0.1);
        }

        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--bg-dark);
            color: #f8fafc;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient Glow Background */
        .ambient-glow {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }
        .glow-1 {
            position: absolute;
            top: -10%;
            left: 15%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(34, 211, 238, 0.15) 0%, rgba(15, 23, 42, 0) 70%);
            border-radius: 50%;
        }
        .glow-2 {
            position: absolute;
            top: 25%;
            right: -5%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(15, 23, 42, 0) 70%);
            border-radius: 50%;
        }
        .glow-3 {
            position: absolute;
            bottom: 10%;
            left: 20%;
            width: 550px;
            height: 550px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.12) 0%, rgba(15, 23, 42, 0) 70%);
            border-radius: 50%;
        }

        /* Navbar Styling */
        .navbar-custom {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-glass);
            transition: all 0.3s ease;
        }
        .brand-logo {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--accent-cyan), var(--accent-indigo));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: #fff;
            box-shadow: 0 4px 20px rgba(34, 211, 238, 0.3);
        }
        .brand-text {
            font-weight: 800;
            font-size: 1.35rem;
            background: linear-gradient(135deg, #ffffff 30%, var(--accent-cyan) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }

        .nav-link {
            color: #94a3b8 !important;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.5rem 1rem !important;
            transition: color 0.2s ease;
        }
        .nav-link:hover {
            color: #ffffff !important;
        }

        /* Buttons */
        .btn-gradient-primary {
            background: linear-gradient(135deg, var(--accent-cyan), var(--accent-indigo));
            border: none;
            color: #ffffff;
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            border-radius: 50rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 25px rgba(34, 211, 238, 0.35);
        }
        .btn-gradient-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(34, 211, 238, 0.5);
            color: #ffffff;
        }

        .btn-outline-glass {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-glass);
            color: #f1f5f9;
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            border-radius: 50rem;
            backdrop-filter: blur(10px);
            transition: all 0.2s ease;
        }
        .btn-outline-glass:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.25);
            color: #ffffff;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero-section {
            padding-top: 9rem;
            padding-bottom: 5rem;
            position: relative;
            z-index: 1;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 1rem;
            background: rgba(34, 211, 238, 0.1);
            border: 1px solid rgba(34, 211, 238, 0.25);
            border-radius: 50rem;
            color: var(--accent-cyan);
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .hero-title {
            font-size: 3.25rem;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -1px;
            margin-bottom: 1.25rem;
        }
        .hero-subtitle {
            font-size: 1.15rem;
            color: #94a3b8;
            line-height: 1.6;
            margin-bottom: 2rem;
            max-width: 600px;
        }

        /* Glassmorphism Card */
        .glass-card {
            background: var(--bg-card);
            border: 1px solid var(--border-glass);
            border-radius: 1.5rem;
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease, border-color 0.3s ease;
        }
        .glass-card:hover {
            border-color: rgba(34, 211, 238, 0.3);
        }

        /* Feature Card */
        .feature-card {
            padding: 2rem;
            height: 100%;
        }
        .feature-icon-wrapper {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.25rem;
        }

        /* Nutri-Grade Badges */
        .grade-badge-a { background: #059669; color: #fff; }
        .grade-badge-b { background: #0284c7; color: #fff; }
        .grade-badge-c { background: #d97706; color: #fff; }
        .grade-badge-d { background: #dc2626; color: #fff; }

        .grade-card {
            padding: 1.5rem;
            border-radius: 1.25rem;
            border: 1px solid var(--border-glass);
            background: rgba(15, 23, 42, 0.6);
            transition: transform 0.25s ease;
        }
        .grade-card:hover {
            transform: translateY(-4px);
        }

        /* Stats Row */
        .stat-item {
            text-align: center;
            padding: 1.5rem;
        }
        .stat-number {
            font-size: 2.25rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 0.25rem;
        }
        .stat-label {
            font-size: 0.85rem;
            color: #94a3b8;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Step Card */
        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-cyan), var(--accent-indigo));
            color: #fff;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        /* CTA Section */
        .cta-box {
            background: linear-gradient(135deg, rgba(34, 211, 238, 0.15), rgba(99, 102, 241, 0.15));
            border: 1px solid rgba(34, 211, 238, 0.3);
            border-radius: 2rem;
            padding: 3.5rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* Footer */
        footer {
            border-top: 1px solid var(--border-glass);
            padding: 2.5rem 0;
            color: #64748b;
            font-size: 0.9rem;
        }

        @media (max-width: 991.98px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-section {
                padding-top: 7rem;
            }
        }
    </style>
</head>
<body>

    <!-- Ambient Glow Effects -->
    <div class="ambient-glow">
        <div class="glow-1"></div>
        <div class="glow-2"></div>
        <div class="glow-3"></div>
    </div>

    <!-- Navigation Header -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-custom py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="{{ url('/') }}">
                <div class="brand-logo">
                    <i class="bi bi-pie-chart-fill"></i>
                </div>
                <span class="brand-text">SnackCheck</span>
            </a>

            <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <i class="bi bi-list fs-2"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#fitur">Fitur Unggulan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#nutrigrade">Standar Nutri-Grade</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#carakerja">Cara Kerja</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-gradient-primary">
                            <i class="bi bi-speedometer2 me-2"></i>Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-glass me-1">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-gradient-primary">
                                <i class="bi bi-person-plus me-1"></i> Daftar Akun
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center gy-5">
                <div class="col-lg-6">
                    <div class="hero-badge">
                        <i class="bi bi-stars"></i> Smart Nutri-Check System
                    </div>
                    <h1 class="hero-title">
                        Ketahui Kandungan Nutrisi Snack Sebelum Dikonsumsi
                    </h1>
                    <p class="hero-subtitle">
                        SnackCheck membantu Anda menganalisis kadar Gula, Garam, Lemak, dan Kalori snack favorit Anda secara otomatis dengan skor klasifikasi <strong>Nutri-Grade A hingga D</strong>.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-gradient-primary btn-lg">
                                <i class="bi bi-rocket-takeoff me-2"></i> Mulai Analisis Sekarang
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-gradient-primary btn-lg">
                                <i class="bi bi-rocket-takeoff me-2"></i> Coba Sekarang
                            </a>
                        @endauth
                        <a href="#nutrigrade" class="btn btn-outline-glass btn-lg">
                            <i class="bi bi-info-circle me-2"></i> Pelajari Nutri-Grade
                        </a>
                    </div>
                </div>

                <!-- Hero Interactive Preview Card -->
                <div class="col-lg-6">
                    <div class="glass-card p-4 p-md-5 position-relative">
                        <!-- Top Tag -->
                        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-white-10">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-cyan-soft rounded-circle p-2 d-flex text-info">
                                    <i class="bi bi-upc-scan fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-700 text-white">Sampel Analisis Snack</h6>
                                    <small class="text-white-50">Keripik Kentang Renyah</small>
                                </div>
                            </div>
                            <span class="badge grade-badge-b fs-6 px-3 py-2 rounded-pill fw-bold">
                                <i class="bi bi-patch-check-fill me-1"></i> Grade B
                            </span>
                        </div>

                        <!-- Nutrition Grid -->
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <div class="p-3 rounded-4 bg-dark bg-opacity-50 border border-white-10">
                                    <span class="text-white-50 fs-7 d-block mb-1"><i class="bi bi-lightning-charge text-warning me-1"></i> Kalori</span>
                                    <span class="fs-4 fw-bold text-white">150 <small class="fs-7 fw-normal text-white-50">kcal</small></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-4 bg-dark bg-opacity-50 border border-white-10">
                                    <span class="text-white-50 fs-7 d-block mb-1"><i class="bi bi-cup-straw me-1" style="color:var(--accent-cyan)"></i> Gula</span>
                                    <span class="fs-4 fw-bold text-white">2.5 <small class="fs-7 fw-normal text-white-50">gram</small></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-4 bg-dark bg-opacity-50 border border-white-10">
                                    <span class="text-white-50 fs-7 d-block mb-1"><i class="bi bi-droplet-half text-danger me-1"></i> Lemak</span>
                                    <span class="fs-4 fw-bold text-white">7.0 <small class="fs-7 fw-normal text-white-50">gram</small></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-4 bg-dark bg-opacity-50 border border-white-10">
                                    <span class="text-white-50 fs-7 d-block mb-1"><i class="bi bi-moisture text-primary me-1"></i> Garam / Sodium</span>
                                    <span class="fs-4 fw-bold text-white">120 <small class="fs-7 fw-normal text-white-50">mg</small></span>
                                </div>
                            </div>
                        </div>

                        <!-- Status Notice -->
                        <div class="p-3 rounded-3 bg-info bg-opacity-10 border border-info border-opacity-25 d-flex align-items-center gap-3">
                            <i class="bi bi-check-circle-fill text-info fs-3"></i>
                            <div>
                                <h6 class="mb-0 text-info fw-bold fs-7">Rekomendasi Konsumsi</h6>
                                <p class="mb-0 fs-8 text-white-50">Aman dikonsumsi harian dalam batas porsi wajar.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stat Counter Bar -->
    <section class="py-4 border-top border-bottom border-white-10 bg-dark bg-opacity-50">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">4 Level</div>
                        <div class="stat-label">Klasifikasi Nutri-Grade (A-D)</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Otomatis & Akurat</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">PDF & Excel</div>
                        <div class="stat-label">Ekspor Laporan Ringkas</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">Real-Time</div>
                        <div class="stat-label">Pencatatan & Riwayat</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-5 my-5">
        <div class="container">
            <div class="text-center max-w-700 mx-auto mb-5">
                <span class="text-info fw-bold text-uppercase fs-8 letter-spacing-1">Solusi Sehat</span>
                <h2 class="fw-800 fs-1 text-white mt-1">Mengapa Menggunakan SnackCheck?</h2>
                <p class="text-white-50 fs-6">Sistem terpadu untuk menjaga pola konsumsi jajanan yang seimbang bagi Anda dan keluarga.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="glass-card feature-card">
                        <div class="feature-icon-wrapper bg-info bg-opacity-10 text-info">
                            <i class="bi bi-cpu-fill"></i>
                        </div>
                        <h5 class="fw-700 text-white mb-2">Klasifikasi Cerdas</h5>
                        <p class="text-white-50 fs-7 mb-0">Algoritma otomatis yang menilai komposisi snack berdasarkan kadar Gula, Garam, dan Lemak.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="glass-card feature-card">
                        <div class="feature-icon-wrapper bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-shield-exclamation"></i>
                        </div>
                        <h5 class="fw-700 text-white mb-2">Peringatan Kritis</h5>
                        <p class="text-white-50 fs-7 mb-0">Deteksi langsung jika snack tergolong tinggi gula atau lemak jenuh berlebih.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="glass-card feature-card">
                        <div class="feature-icon-wrapper bg-success bg-opacity-10 text-success">
                            <i class="bi bi-file-earmark-arrow-down-fill"></i>
                        </div>
                        <h5 class="fw-700 text-white mb-2">Ekspor Laporan</h5>
                        <p class="text-white-50 fs-7 mb-0">Unduh data riwayat dan statistik snack dalam format PDF atau Excel dengan sekali klik.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="glass-card feature-card">
                        <div class="feature-icon-wrapper bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <h5 class="fw-700 text-white mb-2">Riwayat & Analitik</h5>
                        <p class="text-white-50 fs-7 mb-0">Lacak tren konsumsi snack Anda dari waktu ke waktu dengan dashboard yang interaktif.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nutri-Grade Standard Section -->
    <section id="nutrigrade" class="py-5 my-5 border-top border-white-10">
        <div class="container">
            <div class="text-center max-w-700 mx-auto mb-5">
                <span class="text-info fw-bold text-uppercase fs-8 letter-spacing-1">Standar Penilaian</span>
                <h2 class="fw-800 fs-1 text-white mt-1">Memahami Klasifikasi Nutri-Grade</h2>
                <p class="text-white-50 fs-6">Sistem kategori gradasi warna untuk memudahkan Anda mengenali tingkat kesehatan produk makanan ringan.</p>
            </div>

            <div class="row g-4">
                <!-- Grade A -->
                <div class="col-md-6 col-lg-3">
                    <div class="grade-card h-100">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="badge grade-badge-a fs-5 px-3 py-2 rounded-pill fw-bold">Grade A</span>
                            <i class="bi bi-heart-pulse-fill text-success fs-3"></i>
                        </div>
                        <h6 class="fw-bold text-white mb-2">Sangat Sehat</h6>
                        <p class="text-white-50 fs-7 mb-0">Kandungan gula dan lemak sangat rendah. Sangat direkomendasikan untuk konsumsi harian.</p>
                    </div>
                </div>

                <!-- Grade B -->
                <div class="col-md-6 col-lg-3">
                    <div class="grade-card h-100">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="badge grade-badge-b fs-5 px-3 py-2 rounded-pill fw-bold">Grade B</span>
                            <i class="bi bi-hand-thumbs-up-fill text-info fs-3"></i>
                        </div>
                        <h6 class="fw-bold text-white mb-2">Sehat & Moderat</h6>
                        <p class="text-white-50 fs-7 mb-0">Nutrisi seimbang dengan tingkat gula dan garam dalam batas aman konsumsi harian.</p>
                    </div>
                </div>

                <!-- Grade C -->
                <div class="col-md-6 col-lg-3">
                    <div class="grade-card h-100">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="badge grade-badge-c fs-5 px-3 py-2 rounded-pill fw-bold">Grade C</span>
                            <i class="bi bi-exclamation-triangle-fill text-warning fs-3"></i>
                        </div>
                        <h6 class="fw-bold text-white mb-2">Perlu Dibatasi</h6>
                        <p class="text-white-50 fs-7 mb-0">Mengandung gula atau lemak sedang. Sebaiknya tidak dikonsumsi berlebihan.</p>
                    </div>
                </div>

                <!-- Grade D -->
                <div class="col-md-6 col-lg-3">
                    <div class="grade-card h-100">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="badge grade-badge-d fs-5 px-3 py-2 rounded-pill fw-bold">Grade D</span>
                            <i class="bi bi-x-circle-fill text-danger fs-3"></i>
                        </div>
                        <h6 class="fw-bold text-white mb-2">Tinggi Gula / Lemak</h6>
                        <p class="text-white-50 fs-7 mb-0">Kadar gula, garam, atau lemak jenuh tinggi. Sebaiknya dikonsumsi sesekali saja.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="carakerja" class="py-5 my-5">
        <div class="container">
            <div class="text-center max-w-700 mx-auto mb-5">
                <span class="text-info fw-bold text-uppercase fs-8 letter-spacing-1">Alur Penggunaan</span>
                <h2 class="fw-800 fs-1 text-white mt-1">3 Langkah Mudah Menganalisis Snack</h2>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="glass-card p-4 h-100">
                        <div class="step-number">1</div>
                        <h5 class="fw-700 text-white mb-2">Input Komposisi Gizi</h5>
                        <p class="text-white-50 fs-7 mb-0">Masukkan angka Kalori, Gula, Garam, dan Lemak dari kemasan produk snack Anda.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="glass-card p-4 h-100">
                        <div class="step-number">2</div>
                        <h5 class="fw-700 text-white mb-2">Analisis Otomatis</h5>
                        <p class="text-white-50 fs-7 mb-0">Sistem SnackCheck secara otomatis menghitung kalkulasi nutrisi dan skor batas konsumsi.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="glass-card p-4 h-100">
                        <div class="step-number">3</div>
                        <h5 class="fw-700 text-white mb-2">Lihat Hasil & Rekomendasi</h5>
                        <p class="text-white-50 fs-7 mb-0">Dapatkan Nutri-Grade (A-D) secara transparan beserta saran kesehatan secara rinci.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Banner -->
    <section class="py-5 my-4">
        <div class="container">
            <div class="cta-box">
                <h2 class="fw-800 fs-1 text-white mb-3">Siap Menjaga Pola Makan Lebih Sehat?</h2>
                <p class="text-white-50 fs-6 max-w-600 mx-auto mb-4">
                    Daftar akun SnackCheck sekarang untuk mulai mencatat, menganalisis, dan mengekspor riwayat gizi snack Anda secara gratis.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-gradient-primary btn-lg">
                            <i class="bi bi-speedometer2 me-2"></i> Ke Dashboard Anda
                        </a>
                    @else
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-gradient-primary btn-lg">
                                <i class="bi bi-person-plus-fill me-2"></i> Daftar Sekarang
                            </a>
                        @endif
                        <a href="{{ route('login') }}" class="btn btn-outline-glass btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Masuk Akun
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="brand-logo" style="width: 32px; height: 32px; font-size: 1rem;">
                        <i class="bi bi-pie-chart-fill"></i>
                    </div>
                    <span class="fw-bold text-white fs-6">SnackCheck</span>
                </div>
                <div>
                    <span>&copy; {{ date('Y') }} SnackCheck. Smart Nutri-Check & Classification System.</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
