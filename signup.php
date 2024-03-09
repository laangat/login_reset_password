<?php
session_start();
$errors = array();
$db = mysqli_connect('localhost', 'root', '', 'students');

if (isset($_POST['signup'])) {
  $phoneNo = mysqli_real_escape_string($db, $_POST['phoneNo']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $address = mysqli_real_escape_string($db, $_POST['address']);
  $regNo = mysqli_real_escape_string($db, $_POST['regNo']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($phoneNo)) { array_push($errors, "Phone number is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($address)) { array_push($errors, "Address is required"); }
  if (empty($regNo)) { array_push($errors, "Registration number is required"); }
  if (empty($password)) { array_push($errors, "Password is required"); }

  $user_check_query = "SELECT * FROM users WHERE regNo='$regNo' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) {
    if ($user['regNo'] === $regNo) {
      array_push($errors, "User already exists");
    }
  }

  if (count($errors) == 0) {
    $query = "INSERT INTO users (phoneNo, email, address, regNo, password) 
              VALUES('$phoneNo', '$email', '$address', '$regNo', '$password')";
    mysqli_query($db, $query);
    $_SESSION['regNo'] = $regNo;
    $_SESSION['success'] = "You are now logged in";
    header('location: home.php');
  }
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Sign Up</title>
  <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
  
  <form method="post" action="signup.php">
    <?php include('errors.php'); ?>
    <div>
    <h2 style ="text-align: center;">Sign Up</h2>
      <label>Mobile Phone Number</label>
      <input type="text" name="phoneNo">
    </div>
    <div>
      <label>Email</label>
      <input type="email" name="email">
    </div>
    <div>
      <label>Address</label>
      <input type="text" name="address">
    </div>
    <div>
      <label>Registration Number</label>
      <input type="text" name="regNo">
    </div>
    <div>
      <label>Password</label>
      <input type="password" name="password">
    </div>
    <button type="submit" name="signup">Sign Up</button>
  
    <p>Already have an account? <a href="login.php">Login here</a></p>
</form>
  
</body>
</html>
