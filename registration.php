<?php  include "includes/header.php"; ?>
<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>
<?php
$message = "";

if (isset($_POST['submit'])) {
  $username = trim($_POST['username']);
  $email    = trim($_POST['email']);
  $password = trim($_POST['password']);
  $confirm_password = trim($_POST['confirm_password']);
  $error = [
    'username'=> '',
    'email'=> '',
    'password'=> ''
  ];

  //username validation
  if(empty($username)) {
    $error['username'] = "username can't be empty";
  } elseif (strlen($username) < 4) {
    $error['username'] = "username must be longer than 4 characters";
  } elseif (usernameExists($username)) {
    $error['username'] = "username already exists";
  }

  //email validation
  if(empty($email)) {
    $error['email'] = "email can't be empty";
  } elseif (emailExists($email)) {
    $error['email'] = "email already exists";
  }

  //password validation
  if(empty($password)) {
    $error['password'] = "password can't be empty";
  } elseif (strlen($password) < 6) {
    $error['password'] = "password must be longer than 5 characters";
  } elseif (!matchPassword($password,$confirm_password)) {
    $error['password'] = "both password fields must match";
  }

  //unsetting error Array
  foreach ($error as $key => $value) {
    if(empty($value)) {
      unset($error[$key]);
    }
  }
  if (empty($error)) {
    registerUser($username,$email,$password);
    loginUser($username,$password);
  }
}

 ?>
    <!-- Page Content -->
<div class="container">
  <section id="login">
      <div class="container">
          <div class="row">
              <div class="col-xs-6 col-xs-offset-3">
                  <div class="form-wrap">
                  <h1>Register</h1>
                      <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                          <div class="form-group">
                              <label for="username" class="sr-only">username</label>
                              <p class="text-danger"><?php echo isset($error['username'])? $error['username'] : '' ; ?></p>
                              <input value="<?php echo isset($username)? $username : '' ?>" type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                          </div>
                           <div class="form-group">
                              <label for="email" class="sr-only">Email</label>
                              <p class="text-danger"><?php echo isset($error['email'])? $error['email'] : '' ; ?></p>
                              <input value="<?php echo isset($email)? $email : '' ?>" type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                          </div>
                           <div class="form-group">
                              <label for="password" class="sr-only">Password</label>
                              <p class="text-danger"><?php echo isset($error['password'])? $error['password'] : '' ; ?></p>
                              <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                          </div>
                           <div class="form-group">
                              <label for="password" class="sr-only">Confirm password</label>
                              <input type="password" name="confirm_password" id="key" class="form-control" placeholder="re-enter password">
                          </div>

                          <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                      </form>

                  </div>
              </div> <!-- /.col-xs-12 -->
          </div> <!-- /.row -->
      </div> <!-- /.container -->
  </section>


          <hr>



<?php include "includes/footer.php";?>
