<?php
session_start();
include 'konek.php';

$email = $_POST['email'];
$fullname = $_POST['fullname'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// cek username duplikat
$check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
if (mysqli_num_rows($check) > 0) {
    echo "Username sudah digunakan!";
    exit;
}

$query = "INSERT INTO users(email, fullname, username, password, role) 
          VALUES('$email', '$fullname', '$username', '$password', 'student')";

if (mysqli_query($conn, $query)) {
    header("Location: ../signin.php");
} else {
    echo "Gagal daftar!";
}
?>


<!DOCTYPE html>
<head>
  <link href="https://fonts.googleapis.com/css2?family=Irish+Grover&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <title>Sign Up</title>
</head>
<body>
  <div class="form-box">
    <h1>Sign Up</h1>

    <div class="input-field">Email</div>
    <div class="input-field">Full Name</div>
    <div class="input-field">Username</div>
    <div class="input-field">Password</div>

  </div>
</body>
</html>
