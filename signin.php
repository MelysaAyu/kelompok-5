<?php
session_start();
include 'konek.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$user = mysqli_fetch_assoc($query);

if ($user && password_verify($password, $user['password'])) {

    $_SESSION['username'] = $user['username'];
    $_SESSION['fullname'] = $user['fullname'];
    $_SESSION['role'] = $user['role'];

    header("Location: ../home.php");
} else {
    echo "Username atau password salah!";
}
?>


<!DOCTYPE html>
<head>
  <link href="https://fonts.googleapis.com/css2?family=Irish+Grover&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <title>Sign In</title>
</head>
<body>
  <div class="form-box">
    <h1>Sign In</h1>

    <div class="input-field">Username</div>
    <div class="input-field">Password</div>

    <p style="margin-top:20px;">
      Belum punya akun?
      <a href="signup.html" class="link">Daftar sekarang</a>
    </p>
  </div>
</body>
</html>
