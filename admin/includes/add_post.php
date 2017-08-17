<?php
  if(isset($_POST['create_post'])) {
    if (isset($_SESSION['user_role'])) {
      if ($_SESSION['user_role'] == 'admin') {
        $post_title        = $_POST['title'];
        $post_category_id  = $_POST['post_category'];
        $post_author       = $_POST['author'];
        $post_status       = $_POST['post_status'];

        $post_image        = $_FILES['image']['name'] . strtotime('now');
        $post_image_temp   = $_FILES['image']['tmp_name'];

        $post_tags         = $_POST['post_tags'];
        $post_content      = $_POST['post_content'];
        $post_date         = date('d-m-y');
        // $post_comment_count = 0;

        move_uploaded_file($post_image_temp, "../images/$post_image");

        $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date,post_image,post_content,post_tags,post_status) ";
        $query .= "VALUES({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}', '{$post_status}') ";
        $create_post = mysqli_query($connection, $query);
        if(!$create_post) {
          die(mysqli_error($connection));
        } else {
          $query = "SELECT * FROM posts WHERE post_content = '{$post_content}' ";
          $post = mysqli_query($connection, $query);
          if(!$post) {
            die(mysqli_error($connection));
          }
          while($row = mysqli_fetch_assoc($post)) {
            $p_id = $row['post_id'];
            echo "<p class='text-success'>post added.
                     <a href='../post.php?p_id={$p_id}'>view post</a>
                  or <a href='posts.php'>view all posts</a>
                  </p>";
          }
        }
      }
    }
  }
 ?>

<form action="" method="post" enctype="multipart/form-data">
     <div class="form-group">
        <label for="title">Post Title</label>
         <input type="text" class="form-control" name="title">
     </div>



     <div class="form-group">
       <!-- <label for="category">Category</label> -->
       <select name="post_category" class="form-control">
         <option selected disabled>Category</option>
         <?php
           $query = "SELECT * FROM categories";
           $selectAll = mysqli_query($connection, $query);
           if(!$selectAll) {
             die(mysqli_error($connection));
           }
           while($row = mysqli_fetch_assoc($selectAll)) {
             $cat_id = $row['cat_id'];
             $cat_title = $row['cat_title'];
             echo "<option value='{$cat_id}'>{$cat_title}</option>";
           }
          ?>
       </select>
      </div>


     <!-- <div class="form-group">
        <label for="title">Post Author</label>
         <input type="text" class="form-control" name="author">
     </div> -->

     <div class="form-group">
       <!-- <label for="category">Category</label> -->
       <select name="author" class="form-control">
         <option selected disabled>Author</option>
         <?php
           $query = "SELECT * FROM users";
           $selectAll = mysqli_query($connection, $query);
           if(!$selectAll) {
             die(mysqli_error($connection));
           }
           while($row = mysqli_fetch_assoc($selectAll)) {
             $user_id = $row['user_id'];
             $username = $row['username'];
             echo "<option value='{$user_id}'>{$username}</option>";
           }
          ?>
       </select>
      </div>

      <div class="form-group">
        <select class="form-control" name="post_status" id="">
            <option value="draft">Post Status</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
     </div>

   <div class="form-group">
        <label for="post_image">Post Image</label>
         <input type="file"  name="image">
     </div>

     <div class="form-group">
        <label for="post_tags">Post Tags</label>
         <input type="text" class="form-control" name="post_tags">
     </div>

     <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control "name="post_content" id="" cols="30" rows="10"></textarea>
     </div>

      <div class="form-group">
       <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
      </div>
</form>
