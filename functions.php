<?php
function adminActions($x) {
  GLOBAL $connection;
  if (isset($_SESSION['user_role'])) {
    if ($_SESSION['user_role'] == 'admin' && isset($_GET['p_id'])) {
      echo "<a href='admin/posts.php?source=edit_post&p_id={$x}'
               class='btn btn-info'>Edit<a>";
      echo "<a href='admin/posts.php?delete={$x}'
               class='btn btn-danger'>Delete<a>";
    }
  }
}

function profile_adminActions($x) {
  if (isset($_SESSION['user_role'])) {
    if ($_SESSION['user_role'] == 'admin' && isset($x)) {
      echo "<a href='admin/users.php?source=edit_user&u_id={$x}'
               class='btn btn-info'>Edit<a>";
      echo "<a href='admin/users.php?delete={$x}'
               class='btn btn-danger'>Delete<a>";
    }
  }
}

function loginUser($username,$password) {
  global $connection;
  $username = mysqli_real_escape_string($connection, $username);
  $password = mysqli_real_escape_string($connection, $password);

  $query = "SELECT * FROM users WHERE username = '{$username}' ";
  $select_user = mysqli_query($connection, $query);
  if(!$select_user) {
    die(mysqli_error($connection));
  }
  while($row = mysqli_fetch_assoc($select_user)) {
    $db_user_id        = $row['user_id'];
    $db_username       = $row['username'];
    $db_user_password  = $row['user_password'];
    $db_user_firstname = $row['user_firstname'];
    $db_user_lastname  = $row['user_lastname'];
    $db_user_role      = $row['user_role'];
  }
  if(password_verify($password,$db_user_password)) {
    $_SESSION['username']  = $db_username;
    $_SESSION['user_id']  = $db_user_id;
    $_SESSION['firstname'] = $db_user_firstname;
    $_SESSION['lastname']  = $db_user_lastname;
    $_SESSION['user_role'] = $db_user_role;

    header("Location: ../admin");
  } else {
    header("Location: ../");
  }
}

function registerUser($username,$email,$password) {
  global $connection;
  if (!empty($username) && !empty($email) && !empty($password)) {
    //escaping
    $username = mysqli_real_escape_string($connection, $username);
    $email    = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);
    // new password encryption
    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10 ));

    $query = "INSERT INTO users(username, user_email, user_password, user_role) ";
    $query .= "VALUES('{$username}', '{$email}', '{$password}', 'subscriber')";
    $register = mysqli_query($connection, $query);
    if (!$register) {
      die(mysqli_error($connection));
    }
  }
}

function usernameExists($username) {
  global $connection;
  $query = "SELECT username FROM users WHERE username = '$username' ";
  $sendQuery = mysqli_query($connection,$query);
  $count = mysqli_num_rows($sendQuery);
  if($count != 0) {
    return true;
  }
}

function emailExists($email) {
  global $connection;
  $query = "SELECT user_email FROM users WHERE user_email = '$email' ";
  $sendQuery = mysqli_query($connection,$query);
  $count = mysqli_num_rows($sendQuery);
  if($count != 0) {
    return true;
  }
}

function matchPassword($password,$confirmPassword) {
  if ($password == $confirmPassword) {
    return true;
  } else {
    return false;
  }
}
