<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Beasaku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <h2>Welcome To Beasaku!</h2>
    <h3>Sign In To Your Account</h3>

    <form action="./process/register_process.php" method="POST">
        <label for="username">Username</label><br>
        <input type="text" id="username" name="username" required> <br><br>

        <label for="email">Email</label><br>
        <input type="email" id="email" name="email" placeholder="sukmaul@gmail.com" required> <br><br>

        <label for="password">Password</label><br>
        <input type="password" id="password" name="password" required> <br><br>

        <button type="submit" name="register">Sign Up</button>

        <input type="checkbox" id="remember" name="remember">
        <label for="remember"> Remember Me</label><br><br>
    </form>

    <p>
        <!-- <a href="./forgot_password.php">Forgot Password?</a><br> -->
        Don't have an account? <a href="./register.php">Register here</a>
    </p>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
