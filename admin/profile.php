<?php include "includes/header.php" ?>
<?php
  if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select)) {
      $u_id = $row['user_id'];
      $user_username = $row['username'];
      $user_password = $row['user_password'];
      $user_firstname = $row['user_firstname'];
      $user_lastname = $row['user_lastname'];
      $user_email = $row['user_email'];
      $user_role = $row['user_role'];
      $user_image = $row['user_image'];
    }
  }

  

  //update
  if(isset($_POST['update_user'])) {
    $username  = $_POST['username'];
    $password  = $_POST['password'];
    if (!empty($password)) {
      $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10 ));
    }
    $firstname = $_POST['firstname'];
    $lastname  = $_POST['lastname'];
    $email     = $_POST['email'];
    $role      = $_POST['role'];

    $image        = $_FILES['image']['name'];
    $image_temp   = $_FILES['image']['tmp_name'];
    move_uploaded_file($image_temp, "../images/$image");

    if(empty($image)) {
      $query = "SELECT * FROM users WHERE user_id = $u_id ";
      $select_img = mysqli_query($connection, $query);
      while($row = mysqli_fetch_assoc($select_img)) {
        $image = $row['user_image'];
      }
    }


    $query = "UPDATE users SET ";
    $query .= "username = '{$username}', ";
    if (!empty($password)) {
      $query .= "user_password = '{$password}', ";
    }
    $query .= "user_firstname = '{$firstname}', ";
    $query .= "user_lastname = '{$lastname}', ";
    $query .= "user_email = '{$email}', ";
    $query .= "user_role = '{$role}', ";
    $query .= "user_image = '{$image}' ";
    $query .= "WHERE user_id = {$u_id}";
    $update_query = mysqli_query($connection, $query);
    if(!$update_query) {
      die(mysqli_error($connection));
    }
    header("Location: profile.php");
  }
 ?>
<div id="wrapper">
    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Posts
                        <small>Subheading</small>
                    </h1>


                   <form action="" method="post" enctype="multipart/form-data">
                     <div class="form-group">
                        <label for="username">username</label>
                         <input value="<?php echo $user_username ?>" type="text" class="form-control" name="username">
                     </div>

                     <div class="form-group">
                        <label for="password">password</label>
                         <input type="password" class="form-control" name="password">
                     </div>

                     <div class="form-group">
                        <label for="firstname">First name</label>
                         <input value="<?php echo $user_firstname ?>" type="text" class="form-control" name="firstname">
                     </div>
                     <div class="form-group">
                        <label for="lastname">Last name</label>
                         <input value="<?php echo $user_lastname ?>" type="text" class="form-control" name="lastname">
                     </div>
                     <div class="form-group">
                        <label for="email">Email</label>
                         <input value="<?php echo $user_email ?>" type="email" class="form-control" name="email">
                     </div>
                     <div class="form-group">
                        <label for="image">image</label>
                        <img width="100" src="../images/<?php echo $user_image ?>">
                         <input type="file" class="form-control" name="image">
                     </div>

                      <div class="form-group">
                        <select class="form-control" name="role">
                            <option value="<?php echo $user_role ?>"><?php echo $user_role ?></option>
                            <?php
                               if($user_role == 'admin') {
                                 echo "<option value='subscriber'>subscriber</option>";
                               } else {
                                 echo "<option value='admin'>admin</option>";
                               }
                             ?>
                        </select>
                     </div>

                      <div class="form-group">
                       <input class="btn btn-primary" type="submit" name="update_user" value="Update">
                      </div>
                   </form>


                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
<?php include "includes/footer.php" ?>
