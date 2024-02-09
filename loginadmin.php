<?php 
 
include 'koneksi.php';
 
session_start();
 
if (isset($_SESSION['username_admin'])) {
    header("Location: indexadmin.php");
}
 
if (isset($_POST['submit'])) {
    $username = $_POST['username_admin'];
    $password = $_POST['password_admin'];
 
    $sql = "SELECT * FROM admin WHERE username_admin='$username' AND password_admin='$password'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username_admin'] = $row['username_admin'];
        header("Location: indexadmin.php");
    } else {
        echo "<script>alert('Email atau password Anda salah. Silahkan coba lagi!')</script>";
    }
}
 
?>


<!DOCTYPE html>
<!-- Created By CodingLab - www.codinglabweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Login Admin Form | CodingLab</title> 
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
  </head>
  <body>
    <div class="container">
      <div class="wrapper">
        <div class="title">
          <span>Login Admin Form</span>
        </div>
        <form action="loginadmin.php" method ="POST">
          <div class="row">
            <i class="fas fa-user"></i>
            <input type="text" name="username_admin" placeholder="username admin" required>
          </div>
          <div class="row">
            <i class="fas fa-lock"></i>
            <input type="password" name="password_admin" placeholder="password admin" required>
          </div>
          <div class="pass"><a href="#">Forgot password?</a></div>
          <div class="row button">
            <input type="submit" value="Login as Admin" name="submit">
          </div>
          <div class="signup-link"> <a href="login.php">*Login as customer</a></div>
        </form>
      </div>
    </div>

  </body>
</html>
