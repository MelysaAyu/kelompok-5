<?php
require_once __DIR__ . '/db.php';
session_start();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $full_name = trim($_POST['full_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Masukkan email yang valid.';
    }
    if ($username === '' || strlen($username) < 3) {
        $errors[] = 'Username minimal 3 karakter.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Password minimal 6 karakter.';
    }
    if ($password !== $confirm) {
        $errors[] = 'Password dan konfirmasi tidak cocok.';
    }

    if (empty($errors)) {
        $pdo = getPDO();

        // check email or username uniqueness
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email OR username = :username LIMIT 1');
        $stmt->execute([':email' => $email, ':username' => $username]);
        $exists = $stmt->fetch();
        if ($exists) {
            $errors[] = 'Email atau username sudah dipakai.';
        } else {
            $pwHash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare('INSERT INTO users (email, username, password_hash, full_name) VALUES (:email, :username, :password_hash, :full_name)');
            $insert->execute([
                ':email' => $email,
                ':username' => $username,
                ':password_hash' => $pwHash,
                ':full_name' => $full_name
            ]);
            $userId = $pdo->lastInsertId();

            // create empty profile row (optional)
            $p = $pdo->prepare('INSERT INTO profiles (user_id, bio) VALUES (:user_id, :bio)');
            $p->execute([':user_id' => $userId, ':bio' => '']);

            $_SESSION['flash_success'] = 'Registrasi berhasil. Silakan masuk.';
            redirect('signin.php');
        }
    }
}

?>

<!-- 
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Sign Up</title>
  <style>

  </style>
</head>
<body>
  
</body>
</html>
-->