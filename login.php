<?php
session_start();
$errors = array();
$db = mysqli_connect('localhost', 'root', '', 'students');

if (isset($_POST['login'])) {
  $regNo = mysqli_real_escape_string($db, $_POST['regNo']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($regNo)) {
    array_push($errors, "Registration number is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    $query = "SELECT * FROM users WHERE regNo='$regNo' AND password='$password'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
      $_SESSION['regNo'] = $regNo;
      $_SESSION['success'] = "You are now logged in";
      header('location: home.php');
    } else {
      array_push($errors, "Wrong registration number/password combination");
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
  
  <form method="post" action="login.php">
    <?php include('errors.php'); ?>
    <h2 style = "text-align: center;">Login</h2>
    <div>
      <label>Registration Number</label>
      <input type="text" name="regNo">
    </div>
    <div>
      <label>Password</label>
      <input type="password" name="password">
    </div>
    <button type="submit" name="login">Login</button>
  
    <p>Forgot your password? <a href="forgot-password.php">Reset it here</a></p>
    <p><a href="signup.php">Go to Signup</a></p>
</form>
  
</body>
</html>
