<?php
  //read
  if(isset($_GET['p_id'])) {
    $p_id = $_GET['p_id'];
  }

  $query = "SELECT * FROM posts WHERE post_id = $p_id ";
  $selectAll = mysqli_query($connection,$query);
  while($row = mysqli_fetch_assoc($selectAll)) {
    $id = $row['post_id'];
    $author = $row['post_author'];
    $title = $row['post_title'];
    $post_cat_id = $row['post_category_id'];
    $status = $row['post_status'];
    $image = $row['post_image'];
    $tags = $row['post_tags'];
    $date = $row['post_date'];
    $content = $row['post_content'];
  }

  //update
  if(isset($_POST['update_post'])) {
    if (isset($_SESSION['user_role'])) {
      if ($_SESSION['user_role'] == 'admin') {
        $post_title        = $_POST['title'];
        $post_category_id  = $_POST['post_category'];
        $post_author       = $_POST['author'];
        $post_status       = $_POST['post_status'];
        $post_tags         = $_POST['post_tags'];
        $post_content      = $_POST['post_content'];
        if(isset($_FILES['image'])) {
          $post_image        = $_FILES['image']['name'] . strtotime('now');
          $post_image_temp   = $_FILES['image']['tmp_name'];
          move_uploaded_file($post_image_temp, "../images/$post_image");
        }

        $query = "UPDATE posts SET ";
        $query .= "post_title = '{$post_title}', ";
        $query .= "post_category_id = '{$post_category_id}', ";
        $query .= "post_author = '{$post_author}', ";
        $query .= "post_status = '{$post_status}', ";
        if(isset($_FILES['image'])) {
          $query .= "post_image = '{$post_image}', ";
        }
        $query .= "post_tags = '{$post_tags}', ";
        $query .= "post_content = '{$post_content}' ";
        $query .= "WHERE post_id = {$p_id} ";
        $update_query = mysqli_query($connection, $query);
        if(!$update_query) {
          die(mysqli_error($connection));
        } else {
          echo "<p class='text-success'>post updated.
                <a href='../post.php?p_id={$p_id}'>view updated post</a>
                 or <a href='posts.php'>view all posts</a></p>";
        }
        // header("Location: posts.php");
      }
    }
  }
 ?>
<form action="" method="post" enctype="multipart/form-data">
     <div class="form-group">
        <label for="title">Post Title</label>
         <input value="<?php echo $title ?>" type="text" class="form-control" name="title">
     </div>

    <div class="form-group">
      <!-- <label for="category">Category</label> -->
      <select name="post_category" class="form-control">
        <?php
          $query = "SELECT * FROM categories";
          $selectAll = mysqli_query($connection, $query);
          if(!$selectAll) {
            die(mysqli_error($connection));
          }
          while($row = mysqli_fetch_assoc($selectAll)) {
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];

            if ($cat_id == $post_cat_id) {
              echo "<option value='{$cat_id}' selected>{$cat_title}</option>";
            } else {
              echo "<option value='{$cat_id}'>{$cat_title}</option>";
            }

          }
         ?>
      </select>
     </div>

     <!-- <div class="form-group">
        <label for="author">Post Author</label>
         <input value="<?php echo $author ?>" type="text" class="form-control" name="author">
     </div> -->

     <div class="form-group">
        <?php
          $query = "SELECT * FROM users";
          $selectAll = mysqli_query($connection, $query);
          if(!$selectAll) {
            die(mysqli_error($connection));
          }
         ?>
       <select name="author" class="form-control">

         <?php
           while($row = mysqli_fetch_assoc($selectAll)) {
             $user_id = $row['user_id'];
             $username = $row['username'];
             if ($author == $user_id) {
              echo "<option value='{$user_id}' selected> {$username}</option>";
            } else {
              echo "<option value='{$user_id}'>{$username}</option>";
            }
           }
          ?>
       </select>
      </div>

      <div class="form-group">
        <select class="form-control" name="post_status" id="">
            <!-- <option value="draft" selected disabled>Post Status</option> -->

            <?php
              echo "<option value='{$status}'>{$status}</option>";

              if($status == 'published') {
                echo "<option value='draft'>Draft</option>";
              } else {
                echo "<option value='published'>Published</option>";
              }
             ?>

        </select>
     </div>

   <div class="form-group">
        <label for="post_image">Post Image</label>
          <div class="thumbnail" style="width: 105px">
            <img src="../images/<?php echo $image ?>" width="100" class="image-responsive">
          </div>
          <input class="form-control" type="file"  name="image">
     </div>

     <div class="form-group">
        <label for="post_tags">Post Tags</label>
         <input value="<?php echo $tags ?>" type="text" class="form-control" name="post_tags">
     </div>

     <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control "name="post_content" id="" cols="30" rows="10"><?php echo $content ?></textarea>
     </div>

      <div class="form-group">
       <input class="btn btn-primary" type="submit" name="update_post" value="update Post">
      </div>
</form>
