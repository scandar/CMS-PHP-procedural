<div>
  <table class="table table-bordered table-hover">
    <thead>
      <th>ID</th>
      <th>Author</th>
      <th>Comment</th>
      <th>Email</th>
      <th>Status</th>
      <th>In Response to</th>
      <th>Date</th>
      <th>Approve</th>
      <th>Unapprove</th>
      <th>Delete</th>
    </thead>

    <tbody>
      <?php
        if (isset($_GET['p_id'])) {
          $query = "SELECT * FROM comments WHERE comment_post_id =" . mysqli_real_escape_string($connection,$_GET['p_id']);
        } else {
          $query = "SELECT * FROM comments";
        }
        $selectAll = mysqli_query($connection,$query);
        $count = mysqli_num_rows($selectAll);
        if ($count == 0) {
          echo "<h1>No comments for this post :(</h1>";
        }
        while($row = mysqli_fetch_assoc($selectAll)) {
          $id       = $row['comment_id'];
          $post_id  = $row['comment_post_id'];
          $author   = $row['comment_author'];
          $content  = $row['comment_content'];
          $email    = $row['comment_email'];
          $status   = $row['comment_status'];
          $date     = $row['comment_date'];


          echo "<tr>
                  <td>{$id}</td>
                  <td>{$author}</td>
                  <td>{$content}</td>
                  <td>{$email}</td>
                  <td>{$status}</td>";

                  // displaying post title dynamically
                  $query = "SELECT * FROM posts WHERE post_id = $post_id ";
                  $select_post = mysqli_query($connection, $query);

                  while($post = mysqli_fetch_assoc($select_post)) {
                    $post_title = $post['post_title'];
                    echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
                  }


          echo   "<td>{$date}</td>";
          if (isset($_GET['p_id'])) {
            echo "  <td><a href='comments.php?approval=approved&c_id={$id}&p_id={$post_id}'>Approve</a></td>
                    <td><a href='comments.php?approval=unapproved&c_id={$id}&p_id={$post_id}'>Unapprove</a></td>
                    <td><a href='comments.php?delete={$id}&p_id={$post_id}'>Delete</a></td>
                  </tr>";
          } else {
            echo "  <td><a href='comments.php?approval=approved&c_id={$id}'>Approve</a></td>
                    <td><a href='comments.php?approval=unapproved&c_id={$id}'>Unapprove</a></td>
                    <td><a href='comments.php?delete={$id}'>Delete</a></td>
                  </tr>";
          }
        }

        //Delete
        if(isset($_GET['delete'])) {
          $delete_id = $_GET['delete'];
          $query     = "DELETE FROM comments WHERE comment_id = $delete_id ";
          $delete    = mysqli_query($connection, $query);
          if(!$delete) {
            die(mysqli_error($connection));
          }

          header("Location: comments.php");


          // comment count
          // $query = "SELECT * FROM posts WHERE post_id = $post_id ";
          // $select_post = mysqli_query($connection, $query);
          // while($post = mysqli_fetch_assoc($select_post)) {
          //   if($post['post_comment_count']) {
          //     $query = "UPDATE posts SET post_comment_count = post_comment_count - 1 ";
          //     $query .= "WHERE post_id = $post_id";
          //     $update_count = mysqli_query($connection, $query);
          //     if(!$update_count) {
          //       die(mysqli_error($connection));
          //     }
          //   }
          // }
        }

        //approval
        if(isset($_GET['approval'])) {
          $approval = $_GET['approval'];
          $c_id = $_GET['c_id'];
          $query     = "UPDATE comments SET comment_status = '$approval' WHERE comment_id = $c_id ";
          $update    = mysqli_query($connection, $query);
          if(!$update) {
            die(mysqli_error($connection));
          }
          if (isset($_GET['p_id'])) {
            header("Location: comments.php?p_id=" . $_GET['p_id']);
          } else {
            header("Location: comments.php");
          }

        }

       ?>

    </tbody>

  </table>
</div>
