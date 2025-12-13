<?php
session_start();
include 'konek.php';

if (isset($_POST['signup'])) {

    $email    = $_POST['email'];
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // cek username duplikat
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Username sudah digunakan!";
    } else {

        $query = "INSERT INTO users(email, fullname, username, password, role)
                  VALUES('$email', '$fullname', '$username', '$password', 'student')";

        if (mysqli_query($conn, $query)) {
            header("Location: signin.php");
            exit;
        } else {
            $error = "Gagal daftar!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <link href="https://fonts.googleapis.com/css2?family=Irish+Grover&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <title>Sign Up</title>
</head>
<body>

<div class="form-box">
  <h1>Sign Up</h1>

  <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>

  <form method="POST">

    <input type="email" name="email" placeholder="Email" class="input-field" required>

    <input type="text" name="fullname" placeholder="Full Name" class="input-field" required>

    <input type="text" name="username" placeholder="Username" class="input-field" required>

    <input type="password" name="password" placeholder="Password" class="input-field" required>

    <button type="submit" name="signup">Daftar</button>

  </form>
</div>

</body>
</html>
