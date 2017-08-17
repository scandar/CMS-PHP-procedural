<div>
  <table class="table table-bordered table-hover">
    <thead>
      <th>ID</th>
      <th>Username</th>
      <th>First name</th>
      <th>Last name</th>
      <th>Email</th>
      <th>Role</th>
    </thead>

    <tbody>
      <?php
        $query = "SELECT * FROM users";
        $selectAll = mysqli_query($connection,$query);
        while($row = mysqli_fetch_assoc($selectAll)) {
          $id        = $row['user_id'];
          $username  = $row['username'];
          $firstname = $row['user_firstname'];
          $lastname  = $row['user_lastname'];
          $email     = $row['user_email'];
          $image     = $row['user_image'];
          $role      = $row['user_role'];
          $password  = $row['user_password'];


          echo "<tr>
                  <td>{$id}</td>
                  <td>{$username}</td>
                  <td>{$firstname}</td>
                  <td>{$lastname}</td>
                  <td>{$email}</td>
                  <td>{$role}</td>
                  <td><a href='users.php?role=admin&u_id={$id}'>make admin</a></td>
                  <td><a href='users.php?role=subscriber&u_id={$id}'>make subscriber</a></td>
                  <td><a href='users.php?source=edit_user&u_id={$id}'>Edit</a></td>
                  <td><a href='users.php?delete={$id}'>Delete</a></td>
                </tr>";
        }

        //Delete
        if(isset($_GET['delete'])) {
          if (isset($_SESSION['user_role'])) {
            if ($_SESSION['user_role'] == 'admin') {
              $delete_id = $_GET['delete'];
              $query     = "DELETE FROM users WHERE user_id = $delete_id ";
              $delete    = mysqli_query($connection, $query);
              if(!$delete) {
                die(mysqli_error($connection));
              }
              header("Location: users.php");
            }
          }
        }

        //approval
        if(isset($_GET['role'])) {
          if (isset($_SESSION['user_role'])) {
            if ($_SESSION['user_role'] == 'admin') {
              $role = $_GET['role'];
              $u_id = $_GET['u_id'];
              $query     = "UPDATE users SET user_role = '$role' WHERE user_id = $u_id ";
              $update    = mysqli_query($connection, $query);
              if(!$update) {
                die(mysqli_error($connection));
              }
              header("Location: users.php");
            }
          }
        }

       ?>

    </tbody>

  </table>
</div>
