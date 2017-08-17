<?php
  if(isset($_POST['create_user'])) {
    if (isset($_SESSION['user_role'])) {
      if ($_SESSION['user_role'] == 'admin') {
        $username  = $_POST['username'];
        $password  = $_POST['password'];
        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10 ));


        $firstname = $_POST['firstname'];
        $lastname  = $_POST['lastname'];
        $email     = $_POST['email'];
        $role      = $_POST['role'];

        $user_image        = $_FILES['image']['name'];
        $user_image_temp   = $_FILES['image']['tmp_name'];

        move_uploaded_file($user_image_temp, "../images/$user_image");

        $query = "INSERT INTO users(username, user_password, user_firstname, user_lastname, user_email, user_image, user_role) ";
        $query .= "VALUES('{$username}','{$password}','{$firstname}','{$lastname}','{$email}','{$user_image}','{$role}') ";
        $create_user = mysqli_query($connection, $query);
        if(!$create_user) {
          die(mysqli_error($connection));
        } else {
          echo "user created: <a href='users.php'>View users</a>";
        }
      }
    }
  }
 ?>

<form action="" method="post" enctype="multipart/form-data">
     <div class="form-group">
        <label for="username">username</label>
         <input type="text" class="form-control" name="username">
     </div>

     <div class="form-group">
        <label for="password">password</label>
         <input type="password" class="form-control" name="password">
     </div>

     <div class="form-group">
        <label for="firstname">First name</label>
         <input type="text" class="form-control" name="firstname">
     </div>
     <div class="form-group">
        <label for="lastname">Last name</label>
         <input type="text" class="form-control" name="lastname">
     </div>
     <div class="form-group">
        <label for="email">Email</label>
         <input type="email" class="form-control" name="email">
     </div>
     <div class="form-group">
        <label for="image">image</label>
         <input type="file" class="form-control" name="image">
     </div>

      <div class="form-group">
        <select name="role">
            <option value="admin">admin</option>
            <option value="subscriber">subscriber</option>
        </select>
     </div>



      <div class="form-group">
       <input class="btn btn-primary" type="submit" name="create_user" value="Create">
      </div>
</form>
