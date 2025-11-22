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
function process_list_data($text) {
    if (empty($text)) {
        return [];
    }
    $list = array_filter(array_map('trim', explode("\n", $text)));
    return $list;
}

$filter = "dalamnegeri";
$beasiswa_data = null; // Data untuk mode detail
$show_detail = false; // Flag mode

if (isset($_GET['location'])) {
    if ($_GET['location'] == "luarnegeri") {
        $filter = "luarnegeri";
    }
}
$location = $filter; 
if (isset($_GET['id'])) {
    $beasiswa_id = (int)$_GET['id'];
    $show_detail = true;

    // Query untuk mengambil detail S2
    $detail_query = $db->prepare("
        SELECT * FROM beasiswa 
        WHERE id = ? AND jenjang = 'S1' 
    ");
    $detail_query->bind_param("i", $beasiswa_id);
    $detail_query->execute();
    $detail_result = $detail_query->get_result();

    if ($detail_result->num_rows === 1) {
        $beasiswa_data = $detail_result->fetch_assoc();
    } else {
        $show_detail = false;
    }
}

if (!$show_detail) {
    if ($filter == "dalamnegeri") {
        $query = $db->prepare("
            SELECT * FROM beasiswa 
            WHERE negara = 'Indonesia'
            AND jenjang = 'S1'
        ");
    } else {
        $query = $db->prepare("
            SELECT * FROM beasiswa 
            WHERE negara != 'Indonesia'
            AND jenjang = 'S1'
        ");
    }

    $query->execute();
    $data = $query->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Beasiswa S2</title> 
    <style>
        .title { margin-top: 30px;}

        .toggle-switch {
            position: relative;
            width: 260px;                
            background: #f1f1f1;
            padding: 4px;
            border-radius: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .toggle-switch input[type="radio"] { display: none;}
        .option-label {
            width: 50%;
            text-align: center;
            cursor: pointer;
            font-size: 14px;
            color: #666;
            z-index: 2;
            padding: 8px 0;
            user-select: none;
        }

        .slider {
            position: absolute;
            top: 4px;
            bottom: 4px;
            width: calc(50% - 4px);
            left: 4px;
            background: #ff9551;         
            border-radius: 40px;
            transition: 0.3s ease;
            z-index: 1;
        }

        #luarnegeri:checked ~ .slider { transform: translateX(126px);}
        #dalamnegeri:checked + label { color: white; font-weight: 600; }

        #luarnegeri:checked + label + input + label {
            color: white;
            font-weight: 600;
        }
        .bea-1 .title h1 {
            margin-top: 20px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .horizontal-card {
            border: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: left;
            transition: transform 0.2s;
            padding: 15px !important; 
        }
        .horizontal-card:hover { transform: translateY(-5px);}
        .card-image-wrapper {
            height: 100%; 
            max-height: 300px; 
            overflow: hidden;
        }
        .card-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }
        .card-body-content { padding-left: 20px; }
        .card h5 {
            font-weight: bold;
            color: #333;
            margin-top: 0;
        }
        .card p strong { color: #F27141; }
        .deskripsi-text {
            color: #666;
            margin-top: 10px;
            margin-bottom: 15px;
            line-height: 1.4;
            font-size: 0.95rem;
            max-height: 70px; 
            overflow: hidden;
        }
        .btn-warning {
            background-color: #ff9551;
            border-color: #ff9551;
            color: white;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 8px;
        }
        .btn-warning:hover { background-color: #e06d3d; border-color: #e06d3d; }
        .bea-1 .container { max-width: 1100px; }
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
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="about.php">About</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="calender.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">Calender Beasiswa</a>
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

    <section class="bea-1">
        <div class="container text-center">
        
        <?php 
        if ($show_detail && $beasiswa_data) : 
            $persyaratan = process_list_data($beasiswa_data['persyaratan'] ?? '');
            $dokumen = process_list_data($beasiswa_data['dokumen'] ?? '');
            $seleksi = process_list_data($beasiswa_data['seleksi'] ?? '');
        ?>
            <div class="row align-items-start">
                <div class="col">
                    <h1 class="title">Detail Beasiswa: <?= htmlspecialchars($beasiswa_data['nama_beasiswa']) ?></h1> <br>
                    <p class="text-start mb-4">
                        <a href="S1.php?location=<?= urlencode($location) ?>" class="text-decoration-none btn-seemore">
                            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Opsi
                        </a>
                    </p>
                </div>
            </div>
            
            <div class="row mt-3 text-start">
                <div class="col-12">
                    
                    <div class="card p-4 mb-4 horizontal-card">
                        <h4>Informasi Dasar & Deskripsi</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Penyelenggara:</strong> <?= htmlspecialchars($beasiswa_data['penyelenggara']) ?></p>
                                <p class="mb-1"><strong>Negara:</strong> <?= htmlspecialchars($beasiswa_data['negara']) ?></p>
                                <p class="mb-1"><strong>Jenjang:</strong> <?= htmlspecialchars($beasiswa_data['jenjang']) ?></p>
                                <p class="mb-1"><strong>Deadline:</strong> <?= htmlspecialchars($beasiswa_data['deadline']) ?></p>
                            </div>
                            <?php if (!empty($beasiswa_data['image'])) : ?>
                            <div class="col-md-6 text-center">
                                <img src="../<?= htmlspecialchars($beasiswa_data['image']) ?>" alt="Gambar Beasiswa" style="max-height: 200px; width: auto; object-fit: contain; border-radius: 8px;">
                            </div>
                            <?php endif; ?>
                        </div>
                        <hr>
                        <h5>Deskripsi Beasiswa</h5>
                        <p style="white-space: pre-wrap;"><?= nl2br(htmlspecialchars($beasiswa_data['deskripsi'])) ?></p>
                    </div>

                    <div class="card p-4 mb-4 horizontal-card">
                        <h4>Persyaratan Umum</h4>
                        <?php if (!empty($persyaratan)): ?>
                            <ul>
                                <?php foreach ($persyaratan as $syarat_item) : ?>
                                    <li><?= htmlspecialchars($syarat_item) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted">Data persyaratan belum tersedia.</p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card p-4 mb-4 horizontal-card">
                        <h4>Dokumen yang Dibutuhkan</h4>
                        <?php if (!empty($dokumen)): ?>
                            <ul>
                                <?php foreach ($dokumen as $dokumen_item) : ?>
                                    <li><?= htmlspecialchars($dokumen_item) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted">Data dokumen belum tersedia.</p>
                        <?php endif; ?>
                    </div>

                    <div class="card p-4 mb-4 horizontal-card">
                        <h4>Tahapan Seleksi</h4>
                        <?php if (!empty($seleksi)): ?>
                            <ol>
                                <?php foreach ($seleksi as $seleksi_item) : ?>
                                    <li><?= htmlspecialchars($seleksi_item) ?></li> 
                                <?php endforeach; ?>
                            </ol>
                        <?php else: ?>
                            <p class="text-muted">Data tahapan seleksi belum tersedia.</p>
                        <?php endif; ?>
                    </div>

                    <div class="text-center mb-5">
                        <a href="<?= htmlspecialchars($beasiswa_data['link_daftar']) ?>" target="_blank" class="btn btn-seemore">
                            DAFTAR SEKARANG <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    </div>
                </div>
            </div>

        <?php 
        else : 
        ?>
            <div class="row align-items-start">
                <div class="col">
                    <h1 class="title">Beasiswa S1</h1>

                    <form method="GET" action="S1.php">
                        <div class="toggle-switch">

                            <input type="radio" id="dalamnegeri" name="location" value="dalamnegeri"
                                onchange="this.form.submit()" <?= ($location == "dalamnegeri") ? 'checked' : '' ?>>
                            <label for="dalamnegeri" class="option-label">Dalam negeri</label>

                            <input type="radio" id="luarnegeri" name="location" value="luarnegeri"
                                onchange="this.form.submit()" <?= ($location == "luarnegeri") ? 'checked' : '' ?>>
                            <label for="luarnegeri" class="option-label">Luar negeri</label>

                            <div class="slider"></div>
                        </div>
                    </form>
                </div>

            </div>

            <div class="row mt-5" id="list-beasiswa">
                <?php if ($data->num_rows > 0): ?>
                    <?php while ($row = $data->fetch_assoc()) { ?>
                        <div class="col-12 mb-5">
                            <div class="card horizontal-card">
                                <div class="row g-0 align-items-center">
                                    
                                    <div class="col-md-4 col-lg-3">
                                        <div class="card-image-wrapper">
                                            <?php if (!empty($row['image'])) { ?>
                                                <img src="../<?= htmlspecialchars($row['image']) ?>" 
                                                    alt="<?= htmlspecialchars($row['nama_beasiswa']) ?>">
                                            <?php } else { ?>
                                                <div style="height: 180px; background-color: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #aaa;">
                                                    [Image Placeholder]
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-md-8 col-lg-9">
                                        <div class="card-body-content">
                                            <h5><?= htmlspecialchars($row['nama_beasiswa']) ?></h5>

                                            <p class="mb-1"><strong>Penyelenggara:</strong> 
                                                <?= htmlspecialchars($row['penyelenggara']) ?>
                                            </p>

                                            <p class="mb-1"><strong>Negara:</strong>
                                                <?= htmlspecialchars($row['negara']) ?>
                                            </p>

                                            <p class="mb-1"><strong>Deadline:</strong>
                                                <?= htmlspecialchars($row['deadline']) ?>
                                            </p>

                                            <p class="deskripsi-text">
                                                <?= htmlspecialchars(substr($row['deskripsi'], 0, 200)) . (strlen($row['deskripsi']) > 200 ? '...' : '') ?>
                                            </p>

                                            <a href="S1.php?id=<?= htmlspecialchars($row['id']) ?>&location=<?= urlencode($location) ?>" 
                                                class="text-decoration-none btn-seemore">
                                                Selengkapnya
                                            </a>
                                            
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php else: ?>
                    <div class="col-12 text-center mt-5">
                        <p class="fs-5 text-muted">Belum ada data beasiswa S2 untuk lokasi ini.</p>
                        <p>Silakan coba cek Beasiswa S2 Luar Negeri.</p>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?> </div>
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
                        <li class="mb-2"><a href="about.php #about-3" class="text-white text-decoration-none" style="font-size: 0.9rem;">Review</a></li>
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