<?php include "includes/header.php" ?>
    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php
                  $status = "";
                  if(isset($_GET['p_id'])) {
                    $post_id = $_GET['p_id'];
                    $query = "SELECT * FROM posts WHERE post_id = $post_id ";
                    // $query .= "AND post_status = 'published' ";
                    $selectAll = mysqli_query($connection, $query);
                    if (!$selectAll) {
                      die(mysqli_error($connection));
                    }
                    if (!mysqli_num_rows($selectAll)) {
                      echo "<div class='text-center'><h1>ERROR 404</h1><h2>Post not found :/</h2></div>";
                    }
                    while ($row = mysqli_fetch_assoc($selectAll)) {
                      $title = $row['post_title'];
                      $id = $row['post_id'];
                      $author = $row['post_author'];
                      $status = $row['post_status'];
                      $date = $row['post_date'];
                      $content = $row['post_content'];
                      $image = $row['post_image'];
                      if (empty($title)) {
                        echo "empty";
                      }
                      if ($status == 'published') {



                ?>

                <?php adminActions($post_id); ?>
                <!-- Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $id ?>"><?php echo $title ?></a>
                </h2>
                <p class="lead">

                  <?php
                    $query = "SELECT * FROM users WHERE user_id = '{$author}' ";
                    $select_user = mysqli_query($connection, $query);
                    if (!$select_user) {
                      die(mysqli_error($connection));
                    }
                    $arr = mysqli_fetch_assoc($select_user);
                    $u_id = $arr['user_id'];
                    $username = $arr['username'];
                   ?>

                    by <a href="profile.php?u_id=<?php echo $u_id ?>"><?php echo $username ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $date ?></p>
                <hr>
                <img class="img-responsive" src="<?php echo "images/$image" ?>" alt="">
                <hr>
                <p><?php echo $content ?></p>


                <hr>
              <?php
                  } else {
                    echo "<div class='text-center'><h1>ERROR 404</h1><h2>Post not found :/</h2></div>";
                  }
                }
                  if ($status == 'published') {
                    $query = "UPDATE posts SET post_view_count = post_view_count + 1 WHERE post_id = {$post_id}";
                    $addView = mysqli_query($connection,$query);
                    if (!$addView) {
                      die(mysqli_error($connection));
                    }
                  }

                 } else {
                    header("Location: ./");
                   }
              ?>

              <!-- comments form -->
              <?php
              if ($status == 'published') {

                if(isset($_POST['create_comment'])) {
                  $author  = $_POST['comment_author'];
                  $email   = $_POST['comment_email'];
                  $content = $_POST['comment_content'];
                  $post_id = $_GET['p_id'];

                  if(!empty($author) && !empty($email) && !empty($content)) {

                    $query = "INSERT INTO comments(comment_post_id,comment_author, comment_email, comment_content, comment_date, comment_status) ";
                    $query .= "VALUES({$post_id},'{$author}','{$email}','{$content}',now(),'unapproved') ";
                    $selectAll = mysqli_query($connection, $query);
                    if(!$selectAll) {
                      die(mysqli_error($connection));
                    }


                    // $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
                    // $query .= "WHERE post_id = $post_id";
                    // $update_count = mysqli_query($connection, $query);
                    // if(!$update_count) {
                    //   die(mysqli_error($connection));
                    // }
                  } else {
                    echo "<script>alert('please fill all fields')</script>";
                  }
                }


               ?>
              <div class="well">
                <h4>Leave a comment:</h4>
                <form action="" method="post" role="form">
                  <div class="form-group">
                    <input type="text" name="comment_author" placeholder="Your name" class="form-control">
                  </div>
                  <div class="form-group">
                    <input type="email" name="comment_email" placeholder="Your email" class="form-control">
                  </div>
                  <div class="form-group">
                    <textarea name="comment_content" rows="3" class="form-control" placeholder="Your comment.."></textarea>
                  </div>
                  <input type="submit" name="create_comment" value="Submit" class="btn btn-primary">
                </form>
              </div>
              <!-- Comment -->

              <?php
                $query = "SELECT * FROM comments WHERE comment_post_id = {$post_id} ";
                $query .= "AND comment_status = 'approved' ";
                $query .= "ORDER BY comment_id DESC ";
                $select_comments = mysqli_query($connection, $query);
                if(!$select_comments) {
                  die(mysqli_error($connection));
                }
                while($row = mysqli_fetch_assoc($select_comments)) {
                  $comment_date = $row['comment_date'];
                  $comment_content = $row['comment_content'];
                  $comment_author = $row['comment_author'];
                  ?>


              <div class="media">
                  <a class="pull-left" href="#">
                      <img class="media-object" src="http://placehold.it/64x64" alt="">
                  </a>
                  <div class="media-body">
                      <h4 class="media-heading"><?php echo $comment_author; ?>
                          <small><?php echo $comment_date; ?></small>
                      </h4>
                      <?php echo $comment_content; ?>
                  </div>
              </div>
              <?php } }?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>
        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <?php include "includes/footer.php" ?>
