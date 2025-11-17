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
    <title>About - <?php echo htmlspecialchars($user['username']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .about-1 {
            padding: 80px 0;
            background-color: #F27141;
        }
        .about-desc {
            font-size: 1.2rem;
            margin-bottom: 25px;
            text-align: justify;
        }
        .about-2 {
            padding: 10px 0;
            background-color: white;
        }
        .v-desc, .m-desc {
            font-size: 1.1em;
            line-height: 1.8;
            margin-bottom: 20px;
        }
        .about-3 {
            padding: 10px 0;
            background-color: #FFF3EB;
        }
        .testimonial-card {
            background-color: #FFCFB5;
            border: none;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
        <div class="container-fluid">
            <img src="../assets/logo/logoputih.png" alt="">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active" href="about.php">About</a>
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

    <section class="about-1">
        <div class="container text-center">
            <div class="row align-items-start">
                <div class="col-md-6 order-md-1 order-2 mt-4 mt-md-0">
                    <p class="about-desc">
                        <span style="font-weight :bold;">Selamat datang di Beasaku!</span><br>
                        Platform terdepan yang didedikasikan sebagai panduan terlengkap untuk
                        menjelajahi dan meraih peluang beasiswa. Kami hadir untuk mewadahi
                        setiap pelajar dan mahasiswa Indonesia dalam mempersiapkan
                        dan memuluskan jalan studi lanjut, baik di dalam maupun di 
                        luar negeri. Beasaku membantumu menemukan beasiswa yang
                        kamu butuhkan dan mewujudkan impian pendidikanmu.</p>
                </div>
                <div class="col-md-6 text-center order-md-2 order-1">
                    <img src="../assets/logo/nobg_about-b.png" alt=""
                        style="width: 60%; height: auto; display: block; 
                        margin: 0 auto; margin-bottom:30px;">
                    <button class="btn-moresee"><a href="#about-3">Apa Kata Mereka?</a></button>
                </div>
            </div>
        </div>
    </section>

    <section class="about-2">
        <div class="container py-5">
            <h1 class="text-center fw-bold mb-3"
                style="color: #F27141;
                text-shadow: 2px 2px 3px rgba(0, 0, 0, 0.2);">
                Visi & Misi Beasaku</h1>
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="vm-desc p-4">
                        <p class="v-desc">
                            <span style="font-weight :bold;">Visi</span><br>
                            “Menjadi Platform Pendidikan Digital Terdepan di Indonesia 
                            yang Menghubungkan Setiap Generasi Unggul dengan Peluang 
                            Beasiswa Terbaik di Seluruh Dunia, Mewujudkan Cita-cita 
                            Pendidikan Tinggi Tanpa Batas.”
                        </p>
                        <hr class="my-4">
                        <p class="m-desc">
                            <span style="font-weight :bold;">Misi</span><br>
                            <ol>
                                <li><span style="font-weight: bold;">Menyediakan Informasi yang Akurat dan Komprehensif: </span>
                                    Menyajikan data beasiswa (termasuk LPDP, Unggulan, dan beasiswa global lainnya) yang terverifikasi, 
                                    detail, dan diperbarui secara berkala, memastikan pengguna mendapatkan panduan yang benar.</li>
                                <li><span style="font-weight: bold;">Memudahkan Akses dan Pencarian: </span>
                                    Mengembangkan fitur pencarian dan filter yang intuitif untuk membantu pengguna 
                                    menemukan beasiswa yang paling sesuai dengan profil, minat, dan jenjang studi mereka dengan cepat.</li>
                                <li><span style="font-weight: bold;">Memberikan Panduan Persiapan Holistik: </span>
                                    Menyediakan sumber daya dan panduan berkualitas tinggi (seperti contoh esai, tips 
                                    wawancara, dan strategi personal branding) untuk meningkatkan peluang keberhasilan pelamar.</li>
                                <li><span style="font-weight: bold;">Membangun Komunitas Berbasis Aspirasi: </span>
                                    Menciptakan ruang interaktif yang memungkinkan calon penerima beasiswa dan Awardee 
                                    berbagi pengalaman, motivasi, dan tips sukses.</li>
                            </ol>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-3" id="about-3">
        <div class="container py-5">
            <h1 class="text-center fw-bold mb-5"
                style="color: #F27141;
                text-shadow: 2px 2px 3px rgba(0, 0, 0, 0.2); ">
                Apa Kata Mereka Tentang Beasaku?</h1>
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
                        <li class="mb-2"><a href="#about-3" class="text-white text-decoration-none" style="font-size: 0.9rem;">Review</a></li>
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