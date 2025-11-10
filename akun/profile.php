<?php

require './koneksi/koneksi.php'; 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ./sign-in.php");
    exit();
}

$username_session = $_SESSION['username'];
$stmt = $db->prepare("SELECT username, email, phone_number FROM users WHERE username = ?");
$stmt->bind_param("s", $username_session);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    session_destroy();
    header("Location: ./sign-in.php");
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - <?php echo htmlspecialchars($user['username']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./style/style-profile.css"> 
</head>
<body>
    <div class="container">
        <div class="header-wrapper">
            <div>
                <h1 class="title">Profile</h1>
                <h3 class="sub-title"><?php echo htmlspecialchars($user['username']); ?></h3>
            </div>
            <a href="logout.php" class="btn btn-logout" role="button">Logout</a>
        </div>
        <form action="./proses/update_proses.php" method="POST">
            <input type="hidden" name="update_profile" value="1">

            <div class="mb-3">
                <label for="" class="form-label">Username:</label>
                <input type="text" class="form-control" name="username" 
                       value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" 
                       value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Phone Number:</label>
                <input type="text" class="form-control" name="phone_number" 
                       value="<?php echo htmlspecialchars($user['phone_number']); ?>">
            </div>
            
            <div class="mb-3">
                <label for="" class="form-label">Change Password:</label>
                <input type="password" class="form-control" name="password">
            </div>

             <div class="mb-3">
                <label for="" class="form-label">Confirm Password:</label>
                <input type="password" class="form-control" name="confirm_password">
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-save flex-grow-1 me-2">Save</button>
                <a href="profile.php" class="btn btn-cancel flex-grow-1 ms-2" role="button">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>