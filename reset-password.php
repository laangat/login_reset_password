<?php
session_start();
$errors = array();
$db = mysqli_connect('localhost', 'root', '', 'students');

if (isset($_POST['reset-password'])) {
  $newPassword = mysqli_real_escape_string($db, $_POST['newPassword']);
  $newPasswordConfirm = mysqli_real_escape_string($db, $_POST['newPasswordConfirm']);
  $token = mysqli_real_escape_string($db, $_POST['token']);

  if (empty($newPassword) || empty($newPasswordConfirm)) {
    array_push($errors, "Password is required");
  }
  if ($newPassword !== $newPasswordConfirm) {
    array_push($errors, "Passwords do not match");
  }

  if (count($errors) == 0) {
    $query = "UPDATE users SET password='$newPassword' WHERE token='$token'";
    mysqli_query($db, $query);
    header('location: login.php');
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Reset Password</title>
  <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
  <h2>Reset Password</h2>
  <form method="post" action="reset-password.php">
    <?php include('errors.php'); ?>
    <div>
      <label>New Password</label>
      <input type="password" name="newPassword">
    </div>
    <div>
      <label>Confirm New Password</label>
      <input type="password" name="newPasswordConfirm">
    </div>
    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
    <button type="submit" name="reset-password">Reset Password</button>
  

    <p>Forgot your password? <a href="login.php">Reset it here</a></p></form>
</body>
</html>
