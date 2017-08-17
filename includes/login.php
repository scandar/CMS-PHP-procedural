<?php
  ob_start();
  include "db.php";
  include "../functions.php";
  session_start();

  if(isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    loginUser($username,$password);
  }
