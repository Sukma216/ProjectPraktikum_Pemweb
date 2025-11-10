<?php

session_start();

if (isset($_SESSION['username'])) {
    header("Location: ../code/index.php");
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
    <title>SIGN IN</title>
</head>
<body>
    <div class="container text-center">
        <div class="row align-items-center">
            <div class="col">
                <img src="../assets/sign-in-up.jpeg" class="img-in">
            </div>

            <div class="col">
                <h1 class="title-in">Welcome to Beasaku!</h1>
                <form action="./proses/sign-in_proses.php" method="POST">
                    <label for="" class="form-label">Email:</label>
                    <input type="email" name="email" class="form-input" required>

                    <label for="" class="form-label">Password:</label>
                    <input type="password" name="password" class="form-input" required>
                    
                    <button type="submit" class="btn-sign">Login</button>
                    <p>Don't have an account? <a href = "sign-up.php">SIGN UP</a></p>
            </div>
        </div>
    </div>
</body>
</html>