<?php

function users_online() {
  global $connection;
  $session = session_id();
  $time = time();
  $time_out_length = 120;
  $time_out = $time - $time_out_length;

  $query = "SELECT * FROM users_online where session = '{$session}' ";
  $send_query = mysqli_query($connection, $query);
  $count = mysqli_num_rows($send_query);

  if ($count == NULL) {
    mysqli_query($connection, "INSERT INTO users_online(session,time) VALUES('$session','$time')");
  } else {
    mysqli_query($connection, "UPDATE users_online SET time = $time WHERE session = '{$session}'");
  }

  $user_count = mysqli_query($connection,"SELECT * FROM users_online WHERE time > $time_out");
  return mysqli_num_rows($user_count);
}

function insertCategory() {
  global $connection;
  if(isset($_POST['submit'])) {
    if (isset($_SESSION['user_role'])) {
      if ($_SESSION['user_role'] == 'admin') {
        $cat_title = $_POST['cat_title'];

        if($cat_title == "" || empty($cat_title)) {
          echo "category field can't be empty";
        } else {
          $query = "INSERT INTO categories(cat_title) ";
          $query .= "VALUE('{$cat_title}') ";
          $create_category = mysqli_query($connection,$query);

          if(!$create_category) {
            die("QUERY FAILED" . mysqli_error($connection));
          }
        }
      }
    }
  }
}
function readCategories() {
  global $connection;
  $query = "SELECT * FROM categories";
  $selectAll = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_assoc($selectAll)) {
    $id = $row['cat_id'];
    $title = $row['cat_title'];
    echo "<tr>
            <td>{$id}</td>
            <td>{$title}</td>
            <td><a href='categories.php?delete={$id}'>Delete</a></td>
            <td><a href='categories.php?edit={$id}'>Edit</a></td>
          </tr>";
  }
}

function deleteCategory() {
  global $connection;
  if(isset($_GET['delete'])) {
    if (isset($_SESSION['user_role'])) {
      if ($_SESSION['user_role'] == 'admin') {
        $id_delete = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id = {$id_delete} ";
        $delete_query = mysqli_query($connection, $query);
        header("Location: categories.php");
      }
    }
  }
}

function countTable($table_name) {
  global $connection;
  $query = "SELECT * FROM " . $table_name;
  $selectAll = mysqli_query($connection, $query);
  $count = mysqli_num_rows($selectAll);
  if (!$count) {
    die(mysqli_error($connection));
  }
  return $count;
}
function conditionCount($table_name, $col, $condition) {
  global $connection;
  $query = "SELECT * FROM $table_name WHERE $col = '$condition' ";
  $selectAll = mysqli_query($connection, $query);
  return mysqli_num_rows($selectAll);
}

function deletePost($id) {
  global $connection;
  if(isset($_GET['delete'])) {
    if (isset($_SESSION['user_role'])) {
      if ($_SESSION['user_role'] == 'admin') {
        $delete_id = $id;
        $query = "DELETE FROM posts WHERE post_id = $delete_id ";
        $delete = mysqli_query($connection, $query);
        if(!$delete) {
          die(mysqli_error($connection));
        }
        header("Location: posts.php");
      }
    }
  }
}

function isAdmin($username) {
  global $connection;
  $query = "SELECT user_role FROM users where username = '$username' ";
  $send_query = mysqli_query($connection,$query);
  if (!$send_query) {
    die(mysqli_error($connection));
  }
  $user = mysqli_fetch_assoc($send_query);
  if ($user['user_role'] == 'admin') {
    return true;
  } else {
    return false;
  }
}
 ?>
