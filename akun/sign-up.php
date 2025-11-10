<?php

session_start();

if (isset($_SESSION['username'])) {
    header("Location: ./profile.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="./style/style-sign.css">
    <title>SIGN UP</title>
</head>
<body>
    <div class="container text-center">
        <div class="row align-items-center">
            <div class="col">
                <img src="../img-beasaku/img-sign.jpg" class="img-up">
            </div>

            <div class="col">
                <h1 class="title-up">Welcome to Beasaku!</h1>
                <h5>Register your account</h5>
                <form action="./proses/sign-up_proses.php" method="POST">
                    <label for="" class="form-label-up">Username:</label>
                    <input type="text" name="username" class="form-input-up" required>

                    <label for="" class="form-label-up">Phone Number:</label>
                    <input type="text" name="phone_number" class="form-input-up" required>

                    <label for="" class="form-label-up">Email:</label>
                    <input type="email" name="email" class="form-input-up" required>

                    <label for="" class="form-label-up">Password:</label>
                    <input type="password" name="password" class="form-input-up" required>

                    <label for="" class="form-label-up">Confirm Password:</label>
                    <input type="password" name="confirm_password" class="form-input-up" required>
                    
                    <button type="submit" class="btn-sign">Register</button>
                    <p>Already have an account? <a href = "sign-in.php">SIGN IN</a></p>
            </div>
        </div>
    </div>
</body>
</html>