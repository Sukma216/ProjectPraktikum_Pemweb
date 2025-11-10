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
    <h3>Register Your Account</h3>

    <form action="./process/register_process.php" method="POST">
        <!-- Username -->
        <label for="username">Username</label><br>
        <input type="text" id="username" name="username" required> <br><br>

        <!-- Email -->
        <label for="email">Email</label><br>
        <input type="email" id="email" name="email" placeholder="sukmaul@gmail.com" required> <br><br>

        <!-- Telepon -->
        <label for="telepon">Telepon</label><br>
        <input type="tel" id="telepon" name="telepon" pattern="[0-9]{10,15}" placeholder="081234567890" required> <br><br>

        <!-- Password -->
        <label for="password">Password</label><br>
        <input type="password" id="password" name="password" required> <br><br>

        <!-- Confirm Password -->
        <label for="confirm_password">Confirm Password</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required> <br><br>

        <button type="submit" name="register">Sign Up</button>
    </form>

    <p>Already have an account? <a href="./login.php">Sign In here</a></p>

    <script>
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            if(password !== confirmPassword) {
                alert('Password dan Confirm Password tidak sama!');
                e.preventDefault(); // hentikan submit
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
