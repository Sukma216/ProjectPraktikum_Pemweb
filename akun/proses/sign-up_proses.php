<?php

require "../../koneksi/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $phone_number = $_POST["phone_number"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password !== $confirm_password) {
        echo "<script>
            alert('Gagal : Password Tidak Cocok!');
            window.location.href = '../sign-up.php';
        </script>";
        exit;
    }

    $check = $db->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $check->bind_param("ss", $email, $username);
    $check->execute();
    $check->store_result(); 

    if ($check->num_rows > 0) {
        echo "<script>
            alert('Gagal : Email/Username sudah terdaftar. Silahkan gunakan yang lain!');
            window.location.href = '../sign-up.php';
            </script>";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO users (username, phone_number, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $phone_number, $email, $hashedPassword);

        if ($stmt->execute()) {
            echo "Registrasi berhasil!";
            header("Location: ../sign-in.php");
        } else {
            echo "Error occured: " . $db->error;
        }
        $stmt->close();
    }

    $check->close();
}