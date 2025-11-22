<?php
require '../../koneksi/koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../../akun/sign-in.php");
    exit;
}

$username = $_SESSION['username'];
$stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>
        alert('User tidak ditemukan!');
        window.location='../about.php#about-3';
        </script>";
    exit;
}

$user = $result->fetch_assoc();
$user_id = $user['id'];
$stmt->close();

if (!isset($_POST['latar_belakang']) || !isset($_POST['description'])) {
    header("Location: ../about.php#about-3");
    exit;
}

$latar_belakang = trim($_POST['latar_belakang']);
$description = trim($_POST['description']);

$stmt = $db->prepare("INSERT INTO reviews (user_id, latar_belakang, description) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $latar_belakang, $description);

if ($stmt->execute()){
    echo "<script>
        alert('Ulasan berhasil ditambahkan!');
        window.location= '../about.php#about-3';
        </script>";
    exit;
} else {
    echo "<script>
        alert('Ulasan gagal ditambahkan!');
        window.location= '../about.php#about-3';
        </script>";
    exit;
}

$stmt->close();
$db->close();
?>