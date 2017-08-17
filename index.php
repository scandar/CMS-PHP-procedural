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
                  $per_page = 5;
                  if(isset($_GET['page'])) {
                    $page = $_GET['page'];
                  } else {
                    $page = "";
                  }
                  if ($page == "" || $page == 1) {
                    $start = 0;
                  } else {
                    $start = ($page * $per_page) - $per_page;
                  }


                  $count_query = "SELECT * FROM posts WHERE post_status = 'published' ";
                  $select_count = mysqli_query($connection, $count_query);
                  $count = mysqli_num_rows($select_count);
                  $count = ceil($count / $per_page);

                  $query = "SELECT * FROM posts WHERE post_status = 'published' LIMIT $start,$per_page ";
                  $selectAll = mysqli_query($connection, $query);
                  while ($row = mysqli_fetch_assoc($selectAll)) {
                    $title = $row['post_title'];
                    $id = $row['post_id'];
                    $author = $row['post_author'];
                    $date = $row['post_date'];
                    $content = substr($row['post_content'],0,100);
                    $image = $row['post_image'];
                ?>
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
                    by <a href="profile.php?u_id=<?php echo $u_id; ?>"><?php echo $username ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $date ?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $id ?>">
                  <img class="img-responsive" src="<?php echo "images/$image" ?>" alt="">
                </a>
                <hr>
                <p><?php echo $content ?></p>

                <hr>
              <?php  } ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>
        <ul class="pager">
          <?php
            echo "<li><a href='./'>first</a></li>";
            for ($i=1; $i <= $count; $i++) {
              if ($i == $page) {
                echo "<li><a class='activeLink' href='index.php?page={$i}'>{$i}</a></li>";
              } else {
                echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
              }
            }
            echo "<li><a href='index.php?page={$count}'>last</a></li>";

           ?>
        </ul>
        <!-- Footer -->
        <?php include "includes/footer.php" ?>
