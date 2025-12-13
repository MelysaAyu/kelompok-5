<?php
session_start();
include 'konek.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    $user = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['role'] = $user['role'];

        header("Location: home.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <link href="https://fonts.googleapis.com/css2?family=Irish+Grover&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <title>Sign In</title>
</head>
<body>

<div class="form-box">
  <h1>Sign In</h1>

  <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>

  <form method="POST">
    <input type="text" name="username" placeholder="Username" class="input-field" required>
    <input type="password" name="password" placeholder="Password" class="input-field" required>

    <button type="submit" name="login">Login</button>
  </form>

  <p style="margin-top:20px;">
    Belum punya akun?
    <a href="signup.php" class="link">Daftar sekarang</a>
  </p>
</div>

</body>
</html>
