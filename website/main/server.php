<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'dbms_online');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form safely
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  $address_1 = mysqli_real_escape_string($db, $_POST['address_1']);
  $address_2 = mysqli_real_escape_string($db, $_POST['address_2']);
  $city = mysqli_real_escape_string($db, $_POST['city']);
  $state = mysqli_real_escape_string($db, $_POST['state']);
  $zip = mysqli_real_escape_string($db, $_POST['zip']);

  // form validation
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if (empty($address_1)) { array_push($errors, "Address 1 is required"); }
  if (empty($city)) { array_push($errors, "City is required"); }
  if (empty($zip)) { array_push($errors, "Zip is required"); }
  if ($password_1 != $password_2) {
    array_push($errors, "The two passwords do not match");
  }

  // check if user already exists
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }
    if ($user['email'] === $email) {
      array_push($errors, "Email already exists");
    }
  }

  // register the user if there are no errors
  if (count($errors) == 0) {
    $password = password_hash($password_1, PASSWORD_DEFAULT); // more secure than md5

    $query = "INSERT INTO users (username, email, password, address_1, address_2, city, state, zip) 
              VALUES('$username', '$email', '$password', '$address_1', '$address_2', '$city', '$state', '$zip')";
    mysqli_query($db, $query);

    $_SESSION['username'] = $username;
    $_SESSION['success'] = "You are now registered and logged in";
    header('location: index.php');
    exit();
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
    array_push($errors, "Username is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    $query = "SELECT * FROM users WHERE username='$username'";
    $results = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($results);

    if ($user && password_verify($password, $user['password'])) {
      $_SESSION['username'] = $username;
      $_SESSION['success'] = "You are now logged in";
      header('location: index.php');
      exit();
    } else {
      array_push($errors, "Wrong username/password combination");
    }
  }
}
?>
