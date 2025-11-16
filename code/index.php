<?php

require '../koneksi/koneksi.php';
session_start();

if(!isset($_SESSION['username'])){
    header("Location: ../akun/sign-in.php");
    exit;
}

$username_session = $_SESSION['username'];
$stmt = $db->prepare("SELECT username FROM users WHERE username = ?");
$stmt->bind_param("s", $username_session);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    session_unset();
    session_destroy();
    header("Location: ../akun/sign-in.php");
    exit;
}

$reviews = [];
$sql_reviews = "
    SELECT
        u.username AS nama,
        r.latar_belakang,
        r.description
    FROM
        reviews r
    JOIN
        users u ON r.user_id = u.id
    ORDER BY
        r.id DESC
    LIMIT 3
";

$stmt_reviews = $db->prepare($sql_reviews);

if ($stmt_reviews) {
    $stmt_reviews->execute();
    $result_reviews = $stmt_reviews->get_result();

    while ($row = $result_reviews->fetch_assoc()) {
        $reviews[] = $row;
    }
    $stmt_reviews->close();
} else {
    echo "Error preparing statement: " . $db->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - <?php echo htmlspecialchars($user['username']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        .home-1 {
            background-image: url("../assets/home/beasaku-bg.avif");
            background-size: cover;       
            background-position: center;  
            background-repeat: no-repeat;
            min-height: 100vh;            
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logo-landing {
            width: 700px;
            max-width: 100%;
            height: auto;
            z-index: 2;
        }
        .home-2 {
            background-color: #f7e6db;
        }
        .home-2 .why-beasaku {
            padding: 15px;
        }
        .home-2 .d-flex.justify-content-center.gap-3 {
            gap: 15px; 
        }
        .home-2 .card-benefit {
            width: 100%; 
            max-width: 15rem;
            margin: 10px 0;
            overflow: hidden;
        }
        .home-2 .card-benefit .card-img-top {
            padding: 0 !important;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 200px;
            background-color: #fff;
        }
        @media (max-width: 768px) {
            .beasiswa-card {
                padding: 15px 15px 15px 20px;
            }
            
            .beasiswa-title {
                font-size: 0.95rem;
            }
            
            .beasiswa-desc {
                font-size: 0.85rem;
            }
        }
        .cepat-akurat {
            width: 100% !important; 
            height: 200px !important; 
            object-fit: cover !important;
            display: block !important;
            margin: 0 !important;
            border-radius: 0 !important;
        }
        .beasiswa-card {
            position: relative;
            background: white;
            border-radius: 12px;
            padding: 20px 20px 20px 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        .beasiswa-card:hover {
            box-shadow: 0 8px 20px rgba(242, 113, 65, 0.15);
            transform: translateY(-4px);
        }
        .beasiswa-border {
            position: absolute;
            left: 0;
            top: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(180deg, #F27141 0%, #ff9068 100%);
            transition: width 0.3s ease;
        }
        .beasiswa-card:hover .beasiswa-border { width: 8px; }
        .beasiswa-content {
            position: relative;
            z-index: 1;
        }
        .beasiswa-title {
            color: #2c3e50 !important;
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 1rem;
            line-height: 1.4;
            transition: color 0.3s ease;
        }.beasiswa-card:hover .beasiswa-title { color: #F27141; }
        .beasiswa-desc {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 12px;
            line-height: 1.6;
        }
        .home-6 {
            background-color: #f8f9fa;
            padding: 20px 0;
        }
        .home-6 .home-6-title {
            margin-bottom: 40px;
        }
        .testimonial-card {
            background-color: #fff0e7;
            border: none;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            height: 100%;
        }
        .testimonial-card .card-text {
            font-style: italic;
            color: #555c62ff;
            margin-bottom: 25px;
            font-size: 1rem;
            line-height: 1.6;
        }
        .testimonial-card .card-name {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 2px;
        }
        .testimonial-card .card-role {
            font-size: 0.85rem;
            font-weight: 500;
            color: #50555aff;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <img src="../assets/logo/logoputih.png" alt="">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="about.php">About</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">Calender Beasiswa</a>
                        <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="S1.php">Beasiswa S1</a></li>
                                <li><a class="dropdown-item" href="S2.php">Beasiswa S2</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="panduan.php">Panduan</a>
                    </li>
                    <li class="nav-item active">
                        <button class="btn-profil" type="button" name="username">
                            <a href="../akun/profile.php">
                                <?php echo htmlspecialchars($user['username']); ?>
                            </a>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="home-1 text-center py-5">
        <div class="overlay">  
            <div class="container d-flex flex-column align-items-center justify-content-center">
                <img class="logo-landing" src="../assets/logo/orange-nobg.png" alt="logo beasaku">
                <button class="btn-seemore" type="button"><a href="calender.php">Lihat Beasiswa</a></button>
            </div>
        </div>
    </section>

    <section class="home-2 py-5" style="background-color: #f7e6db;">
        <div class="container">
            <div class="row align-items-center">
                
                <div class="col-md-6 mb-4">
                    <div class="why-beasaku text-center">
                        <h1 class="fw-bold mb-4" 
                            style="color: #F27141;
                            text-shadow: 2px 2px 3px rgba(0, 0, 0, 0.2); ">
                            Apa Itu Beasaku?</h1>
                        <p class="lead">
                            Beasaku adalah platform terdepan yang menghubungkan impianmu dengan ribuan peluang beasiswa, 
                            baik di dalam maupun luar negeri. Kami berkomitmen menjadikan pencarian dan pengajuan beasiswa 
                            lebih mudah, cepat, dan terarah.
                        </p>
                        <p class="fst-italic fw-bold mt-4 mb-4">“Temukan beasiswa, capai asamu.”</p>
                        <button class="btn-seemore"  type="button"><a href="calender.php">Selengkapnya</a></button>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="why-beasaku text-center">
                        <h1 class="fw-bold mb-4"
                            style="color: #F27141;
                            text-shadow: 2px 2px 3px rgba(0, 0, 0, 0.2);">
                            Kenapa Pilih Beasaku?</h1> 
                        <div class="d-flex justify-content-center gap-3">
                            <div class="card shadow-lg h-100 card-benefit">
                                <div class="card-img-top p-4 text-center">
                                    <img class="cepat-akurat" src="../assets/home/cepat.jpg" alt="cepat dan akurat">
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title-2 fw-bold" 
                                        style="color: #F27141;
                                        text-align: left;">Filter Cepat dan Akurat</h6>
                                    <p class="card-text small" style="text-align : justify;">Cari beasiswa berdasarkan jenjang, negara, atau
                                         bidang studi hanya dalam hitungan detik. Hemat waktu berharga Anda!</p>
                                </div>
                            </div>
                            
                            <div class="card shadow-lg h-100 card-benefit">
                                <div class="card-img-top p-4 text-center">
                                    <img class="cepat-akurat" src="../assets/home/terverifikasi.jpg" alt="">
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title-2 fw-bold" 
                                        style="color: #F27141;
                                        text-align: left;">Info Terverifikasi</h6>
                                    <p class="card-text small" style="text-align : justify;">Data diperiksa secara berkala langsung dari sumber
                                         resmi penyedia. Kami dapat memastikan informasi valid dan tepat waktu.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-4">
        <div class="container py-5">
            <h1 class="home-4-title text-center mb-5 fw-bold" 
                style="color : #F27141 ; 
                text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.2);">Beasiswa Terbaru</h1>
            <div class="row align-items-center">
                <div class="col-md-7 mb-4">
                    <div class="beasiswa-card mb-3">
                        <div class="beasiswa-border"></div>
                        <a href="https://dealls.com/sfl" class="text-decoration-none">
                            <div class="beasiswa-content"> 
                                <h6 class="beasiswa-title">Beasiswa SejutaCita Future Leaders 2025</h6>
                                <p class="beasiswa-desc">Untuk jenjang S1 dan S2, termasuk kesempatan edutrip ke Tiongkok.</p>
                            </div>
                        </a>
                    </div>
                    <div class="beasiswa-card mb-3">
                        <div class="beasiswa-border"></div>
                        <a href="https://beasiswa.kemdikbud.go.id/" class="text-decoration-none">
                            <div class="beasiswa-content">
                                <h6 class="beasiswa-title">Beasiswa Pendidikan Indonesia (BPI) – Program Doktoral & Dosen</h6>
                                <p class="beasiswa-desc">Mendukung studi lanjut bagi tenaga pendidik dan dosen di Indonesia agar mampu berkontribusi lebih besar dalam kemajuan ilmu pengetahuan dan pendidikan.</p>
                            </div>
                        </a>
                    </div>
                    <div class="beasiswa-card mb-3">
                        <div class="beasiswa-border"></div>
                        <a href="https://www.cimbniaga.co.id/id/kejar-mimpi/beasiswa-cimb-niaga" class="text-decoration-none">
                            <div class="beasiswa-content">
                                <h6 class="beasiswa-title">Beasiswa CIMB Niaga 2025</h6>
                                <p class="beasiswa-desc">Program bantuan biaya kuliah dengan pendaftaran via website resmi CIMB Niaga.</p>
                            </div>
                        </a>
                    </div>    
                    <div class="beasiswa-card mb-3">
                        <div class="beasiswa-border"></div>
                        <a href="https://www.paragon-innovation.com/scholarship" class="text-decoration-none">
                            <div class="beasiswa-content">    
                                <h6 class="beasiswa-title">Paragon Scholarship Program 2025</h6>
                                <p class="beasiswa-desc">Beasiswa untuk mahasiswa berprestasi yang memiliki kontribusi sosial tinggi.</p>
                            </div>
                        </a>
                    </div>
                    <div class="beasiswa-card mb-3">
                        <div class="beasiswa-border"></div>
                        <a href="https://djarumbeasiswaplus.org/tentang_kami/persyaratan-untuk-menjadi-penerima-program-djarum-beasiswa-plus" class="text-decoration-none">
                            <div class="beasiswa-content">
                                <h6 class="beasiswa-title">Beasiswa Djarum Plus 2025</h6>
                                <p class="beasiswa-desc">Beasiswa bagi mahasiswa berprestasi yang aktif dalam kegiatan sosial, kepemimpinan, dan pengembangan diri.</p>
                            </div>
                        </a>
                    </div>
                    <div class="mt-4">
                        <button class="btn-seemore" type="button">
                            <a href="calender.php">Selengkapnya</a></button>
                    </div>
                </div>
                <div class="col-md-5 mb-4 text-center">
                    <img src="../assets/home/artis-cumlaude.jpg" alt="Artis Cumlaude" class="img-fluid rounded shadow-lg home4-img" >
                </div>
            </div>
        </div>
    </section>

    <section class="home-5">
        <div id="beasiswaTrending" class="carousel slide" style="background-color: #f7e6db; padding: 50px 0;">
            <div class="container">
                <div class="text-center mb-5">
                    <h1 class="title-tren fw-bold" 
                        style="color: #F27141;
                        text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.2);">Trending</h1>
                    <h3 class="sub-title" 
                        style="font-family: monospace;
                        color: #6c757d">Beasiswa paling ditunggu :</h3>
                </div>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container">
                        <div class="row justify-content-center g-2">
                            <div class="col-md-6 mb-4 px-2">
                                <div class="card h-100 border-0 shadow-sm" style="transform: scale(0.9);">
                                    <div class="card-img-top bg-white p-2 text-center">
                                        <img src="../assets/LOGO_BEASISWA/lpdp.jpeg" alt="Logo LPDP" style="width: 100%; height: 200px; object-fit: cover;">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title font-weight-bold">Beasiswa Lembaga Pengelola Dana Pendidikan 2025</h5>
                                        <p class="card-text text-muted">Beasiswa paling bergengsi yang fokus pada pembangunan 
                                            pemimpin masa depan Indonesia. **Wajib apply untuk studi di kampus top dunia**.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 px-2">
                                <div class="card h-100 border-0 shadow-sm" style="transform: scale(0.9);">
                                    <div class="card-img-top bg-white p-2 text-center">
                                        <img src="../assets/LOGO_BEASISWA/dalam/D1-S1.png" alt="Banner Beasiswa Unggulan 2025" style="width: 100%; height: 200px; object-fit: cover;">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title font-weight-bold">Beasiswa Unggulan 2025</h5>
                                        <p class="card-text text-muted">Beasiswa dari Kemendikbudristek untuk jenjang S1, S2, dan S3 di 
                                            perguruan tinggi dalam negeri. Tersedia untuk calon mahasiswa baru dan yang sudah berjalan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container">
                        <div class="row justify-content-center g-2">
                            <div class="col-md-6 mb-4 px-2">
                                <div class="card h-100 border-0 shadow-sm" style="transform: scale(0.9);">
                                <div class="card-img-top bg-white p-2 text-center">
                                        <img src="../assets/LOGO_BEASISWA/luar_negeri/gks.png" alt="Logo LPDP" style="width: 100%; height: 200px; object-fit: cover;">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title font-weight-bold">Global Korea Scholarship (GKS) 2025</h5>
                                        <p class="card-text text-muted">Beasiswa dari Pemerintah Korea (NIIED) untuk jenjang S1, S2, dan S3. 
                                            Memberikan tunjangan hidup, biaya kuliah, dan pelatihan bahasa. Sangat populer di kalangan pelajar Asia.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 px-2">
                                <div class="card h-100 border-0 shadow-sm" style="transform: scale(0.9);">
                                <div class="card-img-top bg-white p-2 text-center">
                                        <img src="../assets/LOGO_BEASISWA/luar_negeri/AAS.jpg" alt="Logo LPDP" style="width: 100%; height: 200px; object-fit: cover;">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title font-weight-bold">Australia Awards Scholarship (AAS) 2025</h5>
                                        <p class="card-text text-muted">Program unggulan dari Pemerintah Australia untuk pengembangan pemimpin global, 
                                            terbuka untuk S2 dan S3. Sering menargetkan calon dari sektor pemerintahan atau pembangunan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <button class="carousel-control-prev" type="button" data-bs-target="#beasiswaTrending" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            
            <button class="carousel-control-next" type="button" data-bs-target="#beasiswaTrending" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <section class="home-6">
        <div class="container py-4">
            <div class="home-6-title text-center">
                <h1 class="title-rev fw-bold" style="color: #F27141;
                    text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.2);">Ratusan Mahasiswa Menggunakan Beasaku</h1>
                <h3 class="sub-title" 
                    style="font-family: monospace;
                    color: #6c757d;">Mereka berkata : </h3>
            </div>

            <div class="row justify-content-center">
                <?php if (count($reviews) > 0): ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="col-md-4 mb-4">
                            <div class="testimonial-card">
                                <p class="card-text">"<?php echo htmlspecialchars($review['description']); ?>"</p>
                                <div class="card-footer-custom">
                                    <div class="card-name"><?php echo htmlspecialchars($review['nama']); ?></div>
                                    <div class="card-role"><?php echo htmlspecialchars($review['latar_belakang']); ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="text-end mt-4">
                <button class="btn btn-light shadow-sm" 
                    style="background-color: #e0e0e0;
                    border-radius: 20px;">
                    <a href="about.php"
                        style="color: #495057;
                        text-decoration: none">Lebih banyak...</a></button>
            </div>
        </div>
    </section>

    <footer class="text-white py-5" style="background-color: #F27141;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <img src="../assets/logo/logoorange.jpg" alt="Logo Beasaku" style="width: 200px; height: auto;">
                </div>

                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="fw-bold mb-3">Follow Us</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="https://instagram.com/beasaku.idn" class="text-white text-decoration-none" style="font-size: 0.9rem;">
                                <i class="bi bi-instagram me-2"></i> @beasaku.idn
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="https://facebook.com/beasakuidn" class="text-white text-decoration-none" style="font-size: 0.9rem;">
                                <i class="bi bi-facebook me-2"></i> beasakuidn
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="fw-bold mb-3">Contact Us</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="tel:08123456789" class="text-white text-decoration-none" style="font-size: 0.9rem;">
                                <i class="bi bi-whatsapp me-2"></i> 0812 3456 789
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="mailto:beasaku.idn@gmail.com" class="text-white text-decoration-none" style="font-size: 0.9rem;">
                                <i class="bi bi-envelope-fill me-2"></i> beasaku.idn@gmail.com
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="fw-bold mb-3">Help</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="faq.php" class="text-white text-decoration-none" style="font-size: 0.9rem;">FAQ</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none" style="font-size: 0.9rem;">Review</a></li>
                    </ul>
                </div>
            </div>
            <div class="row pt-2 border-top border-white border-opacity-25">
                <div class="col-12 text-center" style="font-size: 0.8rem;">
                    &copy; 2025 Beasaku. All Rights Reserved.
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>