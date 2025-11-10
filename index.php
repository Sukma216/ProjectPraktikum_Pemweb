<?php
// session_start();
// // Cek apakah user sudah login
// if(!isset($_SESSION['username'])){
//     header("Location: login.php");
//     exit;
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        .home-1 {
            background-image: url("assets/beasaku-bg.avif");
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
        .home4-img {
            max-width: 90%; 
            display: block; 
            margin-left: auto;
            margin-right: auto;
        }
        /* APA ITU BEASAKU */
        .cepat-akurat {
            width: 80px; 
            height: 80px; 
            object-fit: cover; 
        }

        /* Media query untuk tampilan mobile */
        /* @media (max-width: 768px) {
            .home4-img {
                max-width: 100%; 
            }
        } */
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <img src="assets/logoputih.png" alt="">
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
                    <li class="nav-item">
                    <a class="nav-link " href="calender.php">Calender Beasiswa</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link " href="panduan.php">Panduan</a>
                    </li>
                    <li class="nav-item active">
                        <button class="btn btn-profil" type="button" name="username">SukmaAul</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="home-1 text-center py-5">
        <div class="overlay">  
            <div class="container d-flex flex-column align-items-center justify-content-center">
                <img class="logo-landing" src="assets/orange-nobg.png" alt="logo beasaku">
                <button class="btn seemore" type="button" name="seemore">Lihat Beasiswa</button>
            </div>
        </div>
    </section>

    <section class="home-2 py-5" style="background-color: #f7e6db;">
        <div class="container">
            <div class="row align-items-center">
                
                <div class="col-md-6 mb-4">
                    <div class="beasaku">
                        <h1 class="fw-bold" 
                            style="color: #ff8c6b;
                            text-shadow: 2px 2px 3px rgba(0, 0, 0, 0.4); ">
                            Apa Itu Beasaku?</h1>
                        <p class="lead">
                            Beasaku adalah platform terdepan yang menghubungkan impianmu dengan ribuan peluang beasiswa, 
                            baik di dalam maupun luar negeri. Kami berkomitmen menjadikan pencarian dan pengajuan beasiswa 
                            lebih mudah, cepat, dan terarah.
                        </p>
                        <p class="fst-italic fw-bold mt-4 mb-4">“Temukan beasiswa, capai asamu.”</p>
                        <button class="btn seemore"  type="button" name="seemore">Selengkapnya </button>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="why-beasaku text-center">
                        <h2 class="fw-bold mb-4" style="color: #F27141;">Kenapa Pilih Beasaku?</h2> 
                        <div class="d-flex justify-content-center gap-3">
                            <div class="card shadow-lg h-100" style="width: 15rem;">
                                <div class="card-img-top p-4 text-center">
                                    <img class="cepat-akurat" src="assets/cepat.jpg" alt="cepat dan akurat">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title fw-bold" style="color: #ff8c6b;">Filter Cepat dan Akurat</h5>
                                    <p class="card-text small" style="text-align : justify;">Cari beasiswa berdasarkan jenjang, negara, atau
                                         bidang studi hanya dalam hitungan detik. Hemat waktu berharga Anda!</p>
                                </div>
                            </div>
                            
                            <div class="card shadow-lg h-100" style="width: 15rem;">
                                <div class="card-img-top p-4 text-center">
                                    <img class="cepat-akurat" src="assets/info.jpg" alt="">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title fw-bold" style="color: #ff8c6b;">Info Terverifikasi</h5>
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
            <h2 class="home-4-title text-center mb-5 fw-bold" 
                style="color : #F27141 ; text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.2);">Beasiswa Terbaru</h2>

            <div class="row align-items-center">
                <div class="col-md-7 mb-4">
                    <div class="list-group shadow-lg">
                        <div class="list-group-item list-group-item-action">
                            <a href="https://dealls.com/sfl" class="text-decoration-none text-dark"><h6 class="mb-1 fw-bold">Beasiswa SejutaCita Future Leaders 2025</h6></a>
                            <p class="mb-1 text-muted">Untuk jenjang S1 dan S2, termasuk kesempatan edutrip ke Tiongkok.</p>
                        </div>
                        <div class="list-group-item list-group-item-action">
                            <a href="https://beasiswa.kemdikbud.go.id/" class="text-decoration-none text-dark"><h6 class="mb-1 fw-bold">Beasiswa Pendidikan Indonesia (BPI) – Program Doktoral & Dosen</h6></a>
                            <p class="mb-1 text-muted">Mendukung studi lanjut bagi tenaga pendidik dan dosen di Indonesia agar mampu berkontribusi lebih besar dalam kemajuan ilmu pengetahuan dan pendidikan.</p>
                        </div>
                        <div class="list-group-item list-group-item-action">
                            <a href="https://www.cimbniaga.co.id/id/kejar-mimpi/beasiswa-cimb-niaga" class="text-decoration-none text-dark"><h6 class="mb-1 fw-bold">Beasiswa CIMB Niaga 2025</h6></a>
                            <p class="mb-1 text-muted">Program bantuan biaya kuliah dengan pendaftaran via website resmi CIMB Niaga.</p>
                        </div>
                        <div class="list-group-item list-group-item-action">
                            <a href="https://www.paragon-innovation.com/scholarship" class="text-decoration-none text-dark"><h6 class="mb-1 fw-bold">Paragon Scholarship Program 2025</h6></a>
                            <p class="mb-1 text-muted">Beasiswa untuk mahasiswa berprestasi yang memiliki kontribusi sosial tinggi.</p>
                        </div>
                        <div class="list-group-item list-group-item-action">
                            <a href="https://djarumbeasiswaplus.org/tentang_kami/persyaratan-untuk-menjadi-penerima-program-djarum-beasiswa-plus" 
                                class="text-decoration-none text-dark"><h6 class="mb-1 fw-bold">Beasiswa Djarum Plus 2025</h6></a>
                            <p class="mb-1 text-muted">Beasiswa bagi mahasiswa berprestasi yang aktif dalam kegiatan sosial, kepemimpinan, dan pengembangan diri.</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="btn seemore" type="button" name="see-more">Selengkapnya</button>
                    </div>
                </div>
                <div class="col-md-5 mb-4 text-center">
                    <img src="assets/home/artis-cumlaude.jpg" alt="Artis Cumlaude" class="img-fluid rounded shadow-lg home4-img" >
                </div>
            </div>
        </div>
    </section>

    <section class="home-5">
        <div id="beasiswaTrending" class="carousel slide" style="background-color: #f7e6db; padding: 50px 0;">
            <div class="container">
                <div class="text-center mb-5">
                    <h1 class="display-4 font-weight-bold" style="color: #ff8c6b;">Trending</h1>
                    <p class="lead">Beasiswa paling ditunggu :</p>
                </div>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container">
                        <div class="row justify-content-center g-2">
                            <div class="col-md-6 mb-4 px-2">
                                <div class="card h-100 border-0 shadow-sm" style="transform: scale(0.9);">
                                    <div class="card-img-top bg-white p-2 text-center">
                                        <img src="assets/LOGO_BEASISWA/lpdp.jpeg" alt="Logo LPDP" style="width: 100%; height: 200px; object-fit: cover;">
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
                                        <img src="assets/LOGO_BEASISWA/dalam/beasiswa-unggulan.png" alt="Banner Beasiswa Unggulan 2025" style="width: 100%; height: 200px; object-fit: cover;">
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
                                        <img src="assets/LOGO_BEASISWA/luar_negeri/gks.png" alt="Logo LPDP" style="width: 100%; height: 200px; object-fit: cover;">
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
                                        <img src="assets/LOGO_BEASISWA/luar_negeri/AAS.jpg" alt="Logo LPDP" style="width: 100%; height: 200px; object-fit: cover;">
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
        <div class="home-6-title">
            <h2>Ratusan Mahasiswa Menggunakan Beasaku</h2>
            <h3>Mereka berkata : </h3>

        </div>
        <div>
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                    ]</div>
            </div>
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                    ]</div>
            </div>
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                    ]</div>
            </div>
        </div>
    </section>

    <footer class="text-white py-5" style="background-color: #F27141;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <img src="assets/logoorange.jpg" alt="Logo Beasaku" style="width: 200px; height: auto;">
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
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none" style="font-size: 0.9rem;">FAQ</a></li>
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