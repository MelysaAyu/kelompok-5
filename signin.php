<?php
require_once __DIR__ . '/db.php';
session_start();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['identifier'] ?? ''); // username or email
    $password = $_POST['password'] ?? '';

    if ($identifier === '' || $password === '') {
        $errors[] = 'Masukkan username/email dan password.';
    } else {
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT id, username, email, password_hash, full_name, role FROM users WHERE username = :id OR email = :id LIMIT 1');
        $stmt->execute([':id' => $identifier]);
        $user = $stmt->fetch();
        if (!$user || !password_verify($password, $user['password_hash'])) {
            $errors[] = 'Kredensial tidak cocok.';
        } else {
            // login success
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];
            redirect('dashboard.php');
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
  <title>Sign In</title>
  <style>

  </style>
</head>
<body>
  
</body>
</html>
--
