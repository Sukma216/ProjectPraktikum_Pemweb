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

if (!isset($_POST['review_id'])) {
    header("Location: ../about.php#about-3");
    exit;
}

$review_id = (int)$_POST['review_id'];

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

$delete_stmt = $db->prepare("DELETE FROM reviews WHERE id = ?");
$delete_stmt->bind_param("i", $review_id);

if ($delete_stmt->execute()) {
    echo "<script>
        alert('Ulasan berhasil dihapus!'); 
        window.location= '../about.php#about-3';
        </script>";
    exit;
} else {
    echo "<script>
        alert('Error: Ulasan gagal dihapus!');
        window.location='../about.php#about-3';
        </script>";
    exit;
}

$delete_stmt->close();
$check->close();
$stmt->close();
$db->close();
?>