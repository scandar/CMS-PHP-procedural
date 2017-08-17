<?php include "includes/header.php" ?>
    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>
                <?php
                  if(isset($_POST['submit'])){
                    $search = $_POST['search'];
                    $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' ";
                    $query .= "AND post_status = 'published' ";
                    $selectAll = mysqli_query($connection, $query);

                    if(!$selectAll) {
                      die("query failed " . mysqli_error($connection));
                    }

                    $count = mysqli_num_rows($selectAll);
                    if($count == 0) {
                      echo "<h1>no results</h1>";
                    }

                    while ($row = mysqli_fetch_assoc($selectAll)) {
                      $id = $row['post_id'];
                      $title = $row['post_title'];
                      $author = $row['post_author'];
                      $date = $row['post_date'];
                      $content = substr($row['post_content'],0,100);
                      $image = $row['post_image'];
                ?>
                <!-- Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $id; ?>"><?php echo $title ?></a>
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
                    by <a href="profile.php?u_id=<?php echo $u_id; ?>"><?php echo $username ?></a>
                </p>
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
