<?php
  include "includes/delete_modal.php";
  //bulk delete - clone - change status
  if (isset($_POST['submit'])) {
    if (isset($_SESSION['user_role'])) {
      if ($_SESSION['user_role'] == 'admin') {
        $ids = $_POST['checkArray'];
        $action = $_POST['bulk_select'];

        foreach ($ids as $post_id) {
          if ($action == 'delete') {
            $query = "DELETE FROM posts WHERE post_id = {$post_id} ";
            $delete = mysqli_query($connection, $query);
            if (!$delete) {
              die(mysqli_error($connection));
            }
          } elseif ($action == 'clone') {
            $query = "SELECT * FROM posts WHERE post_id = {$post_id} ";
            $select_posts = mysqli_query($connection, $query);
            if (!$select_posts) {
              die(mysqli_error($connection));
            }
            while ($row = mysqli_fetch_assoc($select_posts)) {
              $title = $row['post_title'];
              $cat_id = $row['post_category_id'];
              $date = $row['post_date'];
              $author = $row['post_author'];
              $status = $row['post_status'];
              $image = $row['post_image'];
              $tags = $row['post_tags'];
              $content = $row['post_content'];

              $query = "INSERT INTO posts(post_title,post_category_id,post_date,post_author,post_status,post_image,post_tags,post_content) ";
              $query .= "VALUES('{$title}',{$cat_id},'{$date}','{$author}','{$status}','{$image}','{$tags}','{$content}')";
              $clone = mysqli_query($connection, $query);
              if (!$clone) {
                die(mysqli_error($connection));
              }
            }
          } elseif ($action == 'draft' || 'published') {
            $query = "UPDATE posts SET post_status = '{$action}' WHERE post_id = {$post_id} ";
            $update = mysqli_query($connection, $query);
            if (!$update) {
              die(mysqli_error($connection));
            }
          }
        }
      }
    }
  }
 ?>
<div>
  <form action="" method="post">
    <table class="table table-bordered table-hover">
      <div class="bulk-container col-xs-4">
        <select class="form-control" name="bulk_select">
          <option disabled selected>Select option</option>
          <option value="published">Publish</option>
          <option value="draft">Draft</option>
          <option value="clone">Clone</option>
          <option value="delete">Delete</option>
        </select>
      </div>
      <div class="bulk-container col-xs-4">
        <input type="submit" name="submit" value="Apply" class="btn btn-success">
        <a href="posts.php?source=add_post" class="btn btn-primary">Add new post</a>
      </div>
      <thead>
        <th><input type="checkbox" id="select-all-checkbox"></th>
        <th>ID</th>
        <th>Author</th>
        <th>Title</th>
        <th>Views</th>
        <th>Category</th>
        <th>Status</th>
        <th>Image</th>
        <th>Tags</th>
        <th>Comments</th>
        <th>Date</th>
        <th>Edit</th>
        <th>Delete</th>
      </thead>

      <tbody>
        <?php
          $query = "SELECT posts.post_id, posts.post_author, posts.post_title, posts.post_category_id, posts.post_status, ";
          $query .= "posts.post_image, posts.post_tags, posts.post_date, posts.post_view_count, categories.cat_title, categories.cat_id, users.username, users.user_id ";
          $query .= "FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id ";
          $query .= "LEFT JOIN users ON posts.post_author = users.user_id ";
          $query .= "ORDER BY posts.post_id ASC ";
          $selectAll = mysqli_query($connection,$query);

          //generating table loop
          while($row = mysqli_fetch_assoc($selectAll)) {
            $id          = $row['post_id'];
            $author      = $row['post_author'];
            $title       = $row['post_title'];
            $cat_id      = $row['post_category_id'];
            $status      = $row['post_status'];
            $image       = $row['post_image'];
            $tags        = $row['post_tags'];
            $date        = $row['post_date'];
            $views       = $row['post_view_count'];
            $cat_title   = $row['cat_title'];
            $post_author = $row['username'];

            $query = "SELECT * FROM comments WHERE comment_post_id = {$id}";
            $comments = mysqli_query($connection,$query);
            if (!$comments) {
              die(mysqli_error($connection));
            }
            $comments_count = mysqli_num_rows($comments);


            echo "<tr>
                   <td><input type='checkbox' class='checkbox' name='checkArray[]' value='{$id}'></td>
                   <td>{$id}</td>
                   <td><a href='../profile.php?u_id={$author}'>{$post_author}</a></td>
                   <td><a href='../post.php?p_id={$id}'>{$title}</a></td>
                   <td>{$views}</td>
                   <td>{$cat_title}</td>
                   <td>{$status}</td>
                   <td><img width='100' src='../images/{$image}' /></td>
                   <td>{$tags}</td>
                   <td><a href='comments.php?p_id=$id'>{$comments_count}</a></td>
                   <td>{$date}</td>
                   <td><a href='posts.php?source=edit_post&p_id={$id}'>Edit</a></td>
                   <td><a href='javascript: void(0)' class='delete-link' data-id='{$id}'>Delete</a></td>
                  </tr>";
          }
          //delete post
          if (isset($_GET['delete'])) {
            deletePost($_GET['delete']);
          }
         ?>

      </tbody>

    </table>
  </form>
</div>

<!-- deletion modal -->
<script>
  $(document).ready(function() {
    $(".delete-link").on('click', function() {
      var id = $(this).attr('data-id');
      var deleteUrl = "posts.php?delete=" + id;
      $('.modal-delete').attr('href', deleteUrl);
      $('#myModal').modal('show');
    });
  });
</script>
