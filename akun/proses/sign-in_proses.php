<?php

require "../../koneksi/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION["username"] = $row['username'];
            header("Location: ../../code/index.php");
            exit();
        } else {
            echo "<script>
                alert('Error : Invalid Password!');
                window.location.href = '../sign-in.php';
                </script>";
        }
    } else {
        echo "<script>
            alert('Error : User belum terdaftar!');
            window.location.href = '../sign-in.php';
            </script>";
    }
}