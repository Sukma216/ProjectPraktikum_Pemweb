<?php 
    session_start();
    require_once '../koneksi/koneksi.php';
    
    $query = "SELECT * FROM panduan";
    $hasil = mysqli_query($db, $query);


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
        
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .row .title h2{
            margin-top: 20px;
            margin-bottom: 20px;
            color : #F27141;
            font-weight: bold;
            text-shadow: 0px 1.5px 1px rgba(0, 0, 0, 0.4);
        }
        .custom-button { 
            border-radius: 14px;        
            background-color: #FFCFB5; 
            padding: 8px 16px;   
            margin-bottom:10px;       
        }
        .button-text {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 500;
            color: #828282;
        }
        .custom-button:hover {
            background-color: #FFA65D;   
        }
        .hr-full {
            border: none;                   
            border-top: 2px solid #000;  
            width: 100vw;                  
                        
        }
        .panduan-img {
            height: 120px;
            width: 100%;
            object-fit: cover;
        }
        .link_panduan {
            text-decoration: none;
            color: inherit;
            transition: color 0.2s ease;
        }
        .link_panduan:hover { color: #F27141;}
        .card {
            margin: 0 auto;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .card-body { align-items: center; justify-content: center; }
        .card-title {
            font-size: 1rem;
            font-weight: 600;
            line-height: 1.3;
            text-align: center;
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
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
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
                        <a class="nav-link active " href="panduan.php">Panduan</a>
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
    <section class="panduan-1">
        <div class="container text-center">
            <div class="row ">
                <center>
                    <div class="title">
                        <h2 >Akses Berbagai Contoh <br>
                        Dokumen Beasiswa</h2>
                    </div>
                    <div class="button-cari">
                    <!-- <form method="GET" action="panduan.php" class="mb-4 text-center">
                        <input type="text" name="search" placeholder="Cari dokumen..." class="form-control d-inline-block" style="width: 300px;">
                    </form> -->
                                            
                    </div>
                </center>
                <hr class="hr-full">
            </div>

            <div class="row">
                <div class="row justify-content-center">
                    <?php while($row = mysqli_fetch_assoc($hasil)): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-lg" style="width: 20rem;">
                            <img src="../<?php echo $row['gambar_path']; ?>" class="card-img-top panduan-img" alt="<?php echo $row['Nama_panduan']; ?>">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="<?php echo $row['link_panduan']; ?>" target="_blank" class="link_panduan">
                                        <?php echo $row['Nama_panduan']; ?></a>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </section>

    <footer class="text-white py-5" style="background-color: #F27141;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <img src="../assets/logo/orange-nobg.png" alt="Logo Beasaku" style="width: 200px; height: auto;">
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