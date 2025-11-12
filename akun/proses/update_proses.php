<?php

session_start();
require "../../koneksi/koneksi.php"; 

if (!isset($_SESSION['username'])) {
    header("Location: ../sign-in.php");
    exit();
}

if (isset($_POST['update_profile'])) {
    
    $username_lama = $_SESSION['username'];
    
    $username_baru = trim($_POST['username']);
    $email_baru = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);
    $password_baru = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!empty($password_baru) && $password_baru !== $confirm_password) {
        echo "<script>
            alert('Error: Konfirmasi password tidak cocok.');
            window.location.href = '../profile.php';
        </script>";
        exit;
    }

    try {
        $check = $db->prepare("SELECT id, email FROM users WHERE username = ?");
        $check->bind_param("s", $username_lama);
        $check->execute();
        $result = $check->get_result();
        
        if ($result->num_rows === 0) {
            echo "<script>
                alert('Error: Pengguna tidak ditemukan.');
                window.location.href = '.../code/index.php';
            </script>";
            exit;
        }
        
        $old_data = $result->fetch_assoc();
        $old_email = $old_data['email'];
        $check->close();
        
        if ($username_baru !== $username_lama) {
            $check_username = $db->prepare("SELECT id FROM users WHERE username = ?");
            $check_username->bind_param("s", $username_baru);
            $check_username->execute();
            if ($check_username->get_result()->num_rows > 0) {
                echo "<script>
                    alert('Gagal : Username \'$username_baru\' sudah digunakan oleh akun lain.');
                    window.location.href = '../profile.php';
                </script>";
                exit;
            }
            $check_username->close();
        }

        if ($email_baru !== $old_email) {
            $check_email = $db->prepare("SELECT id FROM users WHERE email = ?");
            $check_email->bind_param("s", $email_baru);
            $check_email->execute();
            if ($check_email->get_result()->num_rows > 0) {
                echo "<script>
                    alert('Gagal : Email \'$email_baru\' sudah terdaftar pada akun lain.');
                    window.location.href = '../profile.php';
                </script>";
                exit;
            }
            $check_email->close();
        }

        if (!empty($password_baru)) {
            $hashedPassword = password_hash($password_baru, PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE users SET username = ?, email = ?, phone_number = ?, password = ? WHERE username = ?");
            $stmt->bind_param("sssss", $username_baru, $email_baru, $phone_number, $hashedPassword, $username_lama);
        } else {
            $stmt = $db->prepare("UPDATE users SET username = ?, email = ?, phone_number = ? WHERE username = ?");
            $stmt->bind_param("ssss", $username_baru, $email_baru, $phone_number, $username_lama);
        }

        $stmt->execute();
        $stmt->close();
        
        if ($username_lama !== $username_baru) {
            $_SESSION['username'] = $username_baru;
        }
        
        echo "<script>
            alert('Profil berhasil diperbarui!');
            window.location.href = '../profile.php';
        </script>";
        exit;

    } catch (mysqli_sql_exception $e){
        echo "<script>
            alert('Error : Gagal memperbarui data. Rincian error: " . $e->getMessage() . "');
            window.location.href = '../profile.php';
        </script>";
        exit;
    }
} else {
    header("Location: ../profile.php");
}
?>