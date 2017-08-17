<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
          <div class="input-group">
              <input type="text" name="search" class="form-control">
              <span class="input-group-btn">
                  <input class="btn btn-default" type="submit" name="submit" value="Search">
              </span>
          </div>
        </form>
        <!-- /.input-group -->
    </div>

    <!-- login -->
    <div class="well">
      <?php if (!isset($_SESSION['username'])) { ?>
        <h4>Login</h4>
        <form action="includes/login.php" method="post">
          <div class="form-group">
              <input type="text" name="username" class="form-control" placeholder="username">
          </div>
          <div class="input-group">
              <input type="password" name="password" class="form-control" placeholder="password">
              <span class="input-group-btn">
                <button class="btn btn-primary" type="submit" name="login">Login</button>
              </span>
          </div>
        </form>
        <!-- /.input-group -->
        <?php } else {
          $user = $_SESSION['username'];
          $id = $_SESSION['user_id'];
          echo "<h4>Logged in as <a href='profile.php?u_id={$id}'>{$user}</a></h4>
                <a class='btn btn-info' href='includes/logout.php'>Logout</a>";
        } ?>
    </div>

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                  <?php
                    $query = "SELECT * FROM categories";
                    $selectAll = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_assoc($selectAll)) {
                      $title = $row['cat_title'];
                      $id = $row['cat_id'];
                      echo "<li><a href='category.php?category={$id}'>{$title}</a></li>";
                    }
                   ?>
                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>



    <!-- Side Widget Well -->
    <?php include "widget.php" ?>

</div>
