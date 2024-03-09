<?php
session_start();
$errors = array();
$db = mysqli_connect('localhost', 'root', '', 'students');

if (isset($_POST['search'])) {
  $search = mysqli_real_escape_string($db, $_POST['search']);
  $query = "SELECT * FROM users WHERE regNo='$search'";
  $results = mysqli_query($db, $query);
  if (!$results) {
    array_push($errors, "Database query failed: " . mysqli_error($db));
  } else {
    if (mysqli_num_rows($results) > 0) {
      $user = mysqli_fetch_assoc($results);
      echo "Phone number: " . $user['phoneNo'] . "<br>";
      echo "Email: " . $user['email'] . "<br>";
      echo "Address: " . $user['address'] . "<br>";
      echo "Registration number: " . $user['regNo'] . "<br>";
    } else {
      echo "No user found";
    }
  }
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Home</title>
  <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
  <h2>Home</h2>
  <form method="post" action="home.php">
    <div>
      <label>Search by Registration Number</label>
      <input type="text" name="search">
    </div>
    <button type="submit" name="search">Search</button>
  </form>
</body>
</html>
