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

$location = "dalamnegeri";

if (isset($_GET['location'])) {
    if ($_GET['location'] == "luarnegeri") {
        $location = "luarnegeri";
    }
}

if ($location == "dalamnegeri") {
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


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Beasiswa S1</title>
    <style>
        .toggle-switch {
            position: relative;
            width: 260px;                
            background: #f1f1f1;
            padding: 6px;
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
            width: 50%;
            left: 4px;
            background: #ff9551;         
            border-radius: 40px;
            transition: 0.3s ease;
            z-index: 1;
        }

        #luarnegeri:checked ~ .slider { transform: translateX(100%);}
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
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
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
            <div class="row align-items-start">
                <div class="col">
                    <h1 class="title">Beasiswa S1</h1>

                    <form method="GET">
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

                                            <a href="<?= htmlspecialchars($row['link_daftar']) ?>" 
                                                target="_blank" class="btn-seemore">
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
                        <p class="fs-5 text-muted">Belum ada data beasiswa S1 untuk lokasi ini.</p>
                        <p>Silakan coba cek Beasiswa S1 Luar Negeri.</p>
                    </div>
                <?php endif; ?>
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