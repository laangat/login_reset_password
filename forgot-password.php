
<?php
session_start();
$errors = array();
$db = mysqli_connect('localhost', 'root', '', 'students');

if (isset($_POST['forgot-password'])) {
  $email = mysqli_real_escape_string($db, $_POST['email']);
  if (empty($email)) {
    array_push($errors, "Email is required");
  }
  if (count($errors) == 0) {
    $token = bin2hex(random_bytes(50));
    $query = "INSERT INTO password_resets (email, token) VALUES ('$email', '$token')";
    mysqli_query($db, $query);

    $to = $email;
    $subject = "Reset your password on example.com";
    $msg = "Hi there, click on this <a href=\"http://localhost/reset-password.php?token=$token\">link</a> to reset your password on our site";
    $msg = wordwrap($msg,70);
    $headers = "From: webmaster@example.com" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    mail($to,$subject,$msg,$headers);
    header('location: pending.php?email=' . $email);
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Forgot Password</title>
  <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
  <h2>Forgot Password</h2>
  <form method="post" action="forgot-password.php">
    <?php include('errors.php'); ?>
    <div>
      <label>Email</label>
      <input type="email" name="email">
    </div>
    <button type="submit" name="forgot-password">Reset Password</button>
  
    <p><a href="login.php">Back to login</a></p>
</form>
</body>
</html>
