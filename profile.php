<?php include "includes/header.php" ?>
    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">



            <!-- Blog Entries Column -->
            <div class="col-md-8">

              <?php
                if (isset($_GET['u_id'])) {
                  $u_id = $_GET['u_id'];
                  $query = "SELECT * FROM users WHERE user_id = {$u_id} ";
                  $select_user = mysqli_query($connection, $query);
                  if (!$select_user) {
                    die(mysqli_error($connection));
                  }
                  while ($row = mysqli_fetch_assoc($select_user)) {
                    $username = $row['username'];
                    $first_name = $row['user_firstname'];
                    $last_name = $row['user_lastname'];
                    $user_image = $row['user_image'];

                  }
                }
               ?>
               <div class="row">

                 <div class="col-md-6">
                   <img class="img-responsive img-rounded" src="images/<?php echo $user_image ?>" alt="<?php echo $username ?>'s avatar">
                 </div>

                  <h1 class="page-header col-md-6">
                      <?php echo $first_name . " " . $last_name; ?>
                      <small><?php echo "@" . $username; ?></small>
                  </h1>
                </div>
                <h1 class="text-center"><?php echo $username; ?>'s posts</h1>
                <?php
                  if(isset($_GET['u_id'])) {
                    $query = "SELECT * FROM posts WHERE post_author = {$u_id} ";
                    $query .= "AND post_status = 'published' ";
                    $selectAll = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_assoc($selectAll)) {
                      $title = $row['post_title'];
                      $id = $row['post_id'];
                      $author = $row['post_author'];
                      $date = $row['post_date'];
                      $content = substr($row['post_content'],0,97) . "...";
                      $image = $row['post_image'];

                ?>

                <?php echo profile_adminActions($_GET['u_id']); ?>
                <!-- Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $id ?>"><?php echo $title ?></a>
                </h2>
                <!-- <p class="lead">
                    by <a href="index.php"><?php echo $author ?></a>
                </p> -->
                <p><span class="glyphicon glyphicon-time"></span><?php echo $date ?></p>
                <hr>
                <img class="img-responsive" src="<?php echo "images/$image" ?>" alt="">
                <hr>
                <p><?php echo $content ?></p>


                <hr>
              <?php }} ?>


            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>
        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <?php include "includes/footer.php" ?>
