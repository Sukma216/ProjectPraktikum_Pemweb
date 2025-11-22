<?php

require '../koneksi/koneksi.php';
session_start();

if(!isset($_SESSION['username'])){
    header("Location: ../akun/sign-in.php");
    exit;
}

$username_session = $_SESSION['username'];
$stmt = $db->prepare("SELECT id, username FROM users WHERE username = ?");
$stmt->bind_param("s", $username_session);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $user_id = $user['id'];
} else {
    session_unset();
    session_destroy();
    header("Location: ../akun/sign-in.php");
    exit;
}

if (!isset($_GET['review_id']) || !is_numeric($_GET['review_id'])) {
    header("Location: about.php");
    exit;
}
$review_id = (int)$_GET['review_id'];

$review_stmt = $db->prepare("
    SELECT r.id, r.latar_belakang, r.description, r.user_id
    FROM reviews r
    WHERE r.id = ?
");
$review_stmt->bind_param("i", $review_id);
$review_stmt->execute();
$review_result = $review_stmt->get_result();

if ($review_result->num_rows === 0) {
    header("Location: about.php");
    exit;
}

$review = $review_result->fetch_assoc();

if ($review['user_id'] != $user_id) {
    header("Location: about.php");
    exit;
}
$review_stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Review - <?php echo htmlspecialchars($user['username']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        body {
            background-color: #FFF3EB;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        .form-wrapper {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        .form-wrapper h2 {
            color: #F27141;
            margin-bottom: 30px;
            font-weight: bold;
            text-align: center;
            text-shadow: 2px 2px 3px rgba(0, 0, 0, 0.2);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            color: #333;
            font-weight: 600;
            margin-bottom: 10px;
            display: block;
        }
        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 0.95rem;
        }
        .form-control:focus {
            border-color: #F27141;
            box-shadow: 0 0 0 0.2rem rgba(242, 113, 65, 0.25);
            outline: none;
        }
        textarea.form-control {
            resize: vertical;
            min-height: 150px;
        }
        .form-buttons {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        .btn-cancel {
            flex: 1;
            background-color: #ccc;
            color: #333;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-cancel:hover {
            background-color: #bbb;
            text-decoration: none;
            color: #333;
        }
        .btn-save {
            flex: 1;
            background-color: #F27141;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-save:hover {
            background-color: #e05c2d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <h2>Edit Ulasan Anda</h2>
            
            <form action="proses/proses-edit.php" method="POST">
                <input type="hidden" name="review_id" value="<?= $review_id; ?>">
                
                <div class="form-group">
                    <label>Latar Belakang:</label>
                    <input type="text" class="form-control" name="latar_belakang" value="<?= htmlspecialchars($review['latar_belakang']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Ulasan:</label>
                    <textarea class="form-control" name="description" required><?= htmlspecialchars($review['description']); ?></textarea>
                </div>

                <div class="form-buttons">
                    <a href="about.php #about-3" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>