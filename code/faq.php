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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Beasaku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .faq-section {
            padding: 60px 20px;
            background: linear-gradient(135deg, white 0%, #deb6a1ff 100%);
            min-height: 100vh;
        }

        .faq-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .faq-header {
            text-align: center;
            color: #F27141;
            margin-bottom: 50px;
        }
        
        .faq-header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .faq-header p {
            font-size: 1.1em;
            font-weight: 500;
            color: #6c757d;
            opacity: 0.9;
        }

        .faq-item {
            background: #F27141;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: box-shadow 0.3s ease;
        }

        .faq-item:hover {
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        .faq-question {
            width: 100%;
            padding: 20px;
            background: #FFF3EB;
            border: none;
            text-align: left;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.3s ease;
        }

        .faq-question:hover {
            background-color: #e7b9a1ff;
        }

        .faq-question.active {
            background-color: #e7b9a1ff;
            color: white;
        }

        .faq-question-text {
            flex: 1;
            padding-right: 20px;
            color: #000000;
        }

        .faq-question.active .faq-question-text {
            color: #000000;
        }

        .toggle-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: transform 0.3s ease;
            color: #F27141;
            flex-shrink: 0;
        }

        .faq-question.active .toggle-icon {
            transform: rotate(180deg);
            color: white;
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
            background-color: #FFF3EB;
        }

        .faq-answer.show {
            max-height: 500px;
            padding: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .faq-answer p {
            color: #000000;
            line-height: 1.6;
            font-size: 0.95em;
        }

        .contact-section {
            background: #FFF3EB;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            margin-top: 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .contact-section h3 {
            color: #333;
            margin-bottom: 15px;
        }

        .btn-contact {
            background-color: #F27141;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 1em;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: 600;
        }

        .btn-contact:hover {
            background-color: #c95e37;
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
                        <a class="nav-link" href="index.php">Home</a>
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

    <div class="faq-section">
        <div class="faq-container">
            <div class="faq-header">
                <h1>Pertanyaan Yang Sering Diajukan</h1>
                <p>Temukan jawaban atas pertanyaan umum Tentang Beasaku</p>
            </div>

            <div id="faq-list"></div>

            <div class="contact-section">
                <h3>Masih ada pertanyaan yang belum terjawab?</h3>
                <button class="btn-contact" onclick="contactWA()">💬 Hubungi via WhatsApp</button>
            </div>
        </div>
    </div>

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
    <script>
        const faqs = [
            {   question: "Apakah informasi beasiswa di Beasaku sudah terverifikasi?",
                answer: "Ya. Semua informasi beasiswa, terutama tanggal penting dan persyaratan, diperiksa dan diperbarui secara berkala melalui sumber resmi penyelenggara (Kedutaan, Kementerian, atau Lembaga Pendidikan)."
            }, {
                question : "Bagaimana cara menemukan beasiswa yang paling cocok untuk saya?",
                answer : "Gunakan fitur 'Filter' kami. Anda dapat mencari berdasarkan jenjang studi (S1 dan S2) dan Beasiswa Dalam atau Luar Negeri."
            }, {
                question : "Apa yang harus saya lakukan jika menemukan link atau informasi yang tidak aktif?",
                answer : "Kami berterima kasih atas bantuan Anda! Segera laporkan melalui fitur 'Contact Us' atau email ke [email Anda]. Tim kami akan segera memverifikasi dan memperbarui data tersebut."
            }, {
                question : "Jika saya sudah diterima di kampus, apakah saya masih bisa mendaftar beasiswa?",
                answer : "Ya. Banyak beasiswa, seperti Beasiswa Unggulan atau beberapa skema LPDP, memperbolehkan pendaftar yang sudah memiliki LoA (Letter of Acceptance) atau bahkan yang sudah menjalani perkuliahan (on-going). Cek persyaratan spesifik di halaman beasiswa terkait."
            }, {
                question : "Apakah sertifikat bahasa (IELTS/TOEFL) wajib untuk semua beasiswa?",
                answer : "Tidak semua, namun sebagian besar beasiswa luar negeri (seperti Chevening, AAS, dan MEXT) mewajibkan skor bahasa yang tinggi. Beberapa beasiswa dalam negeri atau beasiswa Asia tertentu mungkin lebih fleksibel. Selalu cek persyaratan spesifik setiap beasiswa."
            }, {
                question : "Apakah saya bisa mendaftar beasiswa meskipun IPK saya di bawah 3.0?",
                answer : "Beberapa beasiswa memang memiliki syarat minimal IPK yang tinggi. Namun, ada juga beasiswa yang lebih fokus pada potensi kepemimpinan, pengalaman organisasi, atau kontribusi sosial. Gunakan filter kami untuk mencari beasiswa yang IPK-nya lebih fleksibel."
            }, {
                question : "Dokumen apa yang paling sering diminta dalam aplikasi beasiswa?",
                answer : "Dokumen utama yang harus disiapkan adalah Ijazah dan Transkrip Nilai (legalisir), Curriculum Vitae (CV) terbaru, Personal Statement atau Esai Motivasi, dan Surat Rekomendasi (dari Dosen atau Atasan)."
            }, {
                question : "Bagaimana cara mendapatkan Letter of Acceptance (LoA) dari universitas?",
                answer : "LoA didapatkan dengan mendaftar langsung ke universitas tujuan. Beberapa beasiswa (seperti LPDP Targeted) mewajibkan LoA Unconditional sebelum mendaftar beasiswa, sementara yang lain memperbolehkan LoA Conditional."
            }, {
                question : "Apakah usia menjadi faktor penting dalam seleksi beasiswa?",
                answer : "Beberapa beasiswa memiliki batas usia maksimal, terutama untuk jenjang S2. Namun, banyak beasiswa bergengsi (seperti Fulbright dan Chevening) tidak memiliki batas usia ketat selama Anda memiliki pengalaman profesional dan potensi kepemimpinan yang kuat."
            }, {
                question : "Apa yang harus saya lakukan setelah dinyatakan Lolos Seleksi Beasiswa?",
                answer : "Anda harus segera mengonfirmasi penerimaan beasiswa (biasanya ada batas waktu) dan mulai mengurus visa pelajar, asuransi, dan persiapan keberangkatan sesuai dengan panduan yang diberikan oleh penyelenggara beasiswa."
            }
        ];

        function renderFAQ(){
            const container = document.getElementById('faq-list');
            container.innerHTML = '';

            faqs.forEach((faq, index) => {
                const faqItem = document.createElement('div');
                faqItem.className = 'faq-item';

                const question = document.createElement('button');
                question.className = 'faq-question';
                question.onclick = () => toggleFAQ(index);

                const questionText = document.createElement('span');
                questionText.className = 'faq-question-text';
                questionText.textContent = faq.question;

                const icon = document.createElement('span');
                icon.className = 'toggle-icon';
                icon.textContent = '▼';

                question.appendChild(questionText);
                question.appendChild(icon);

                const answer = document.createElement('div');
                answer.className = 'faq-answer';
                answer.id = 'answer-' + index;

                const answerContent = document.createElement('p');
                answerContent.textContent = faq.answer;
                answer.appendChild(answerContent);

                faqItem.appendChild(question);
                faqItem.appendChild(answer);
                container.appendChild(faqItem);
            });
        }

        function toggleFAQ(index){
            const answer = document.getElementById('answer-' + index);
            const question = answer.previousElementSibling;

            document.querySelectorAll('.faq-answer').forEach((el, i) => {
                if (i !== index) {
                    el.classList.remove('show');
                    el.previousElementSibling.classList.remove('active');
                }
            });

            answer.classList.toggle('show');
            question.classList.toggle('active');
        }

        function contactWA() {
            const phoneNumber = '628123456789'; // Ganti dengan nomor WhatsApp Anda
            const message = 'Halo, saya memiliki pertanyaan mengenai beasiswa.';
            const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
            window.open(url, '_blank');
        }

        renderFAQ();
    </script>
</body>
</html>