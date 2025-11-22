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

if (!isset($_POST['review_id']) || !isset($_POST['latar_belakang']) || !isset($_POST['description'])) {
    header("Location: ../about.php#about-3");
    exit;
}

$review_id = (int)$_POST['review_id'];
$latar_belakang = trim($_POST['latar_belakang']);
$description = trim($_POST['description']);

$check = $db->prepare("SELECT user_id FROM reviews WHERE id = ?");
$check->bind_param("i", $review_id);
$check->execute();
$check_result = $check->get_result();

if ($check_result->num_rows === 0) {
    echo "<script>alert('Ulasan tidak ditemukan!');
        window.location='../about.php#about-3';
        </script>";
    exit;
}
$review = $check_result->fetch_assoc();

$update_stmt = $db->prepare("UPDATE reviews SET latar_belakang = ?, description = ? WHERE id = ?");
$update_stmt->bind_param("ssi", $latar_belakang, $description, $review_id);

if ($update_stmt->execute()) {
    echo "<script>
        alert('Ulasan berhasil diubah!'); 
        window.location= '../about.php#about-3';
        </script>";
    exit;
} else {
    echo "<script>
        alert('Ulasan gagal diubah!'); 
        window.location= '../about.php#about-3';
        </script>";
    exit;
}

$update_stmt->close();
$check->close();
$stmt->close();
$db->close();
?>