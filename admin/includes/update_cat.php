<form action="" method="post">
  <div class="form-group">
    <label for="cat-title">Edit category</label>

    <?php
      if(isset($_GET['edit'])) {
        $cat_id = $_GET['edit'];
        $query = "SELECT * FROM categories WHERE cat_id = $cat_id ";
        $selectAll = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($selectAll)) {
          $cat_id = $row['cat_id'];
          $cat_title = $row['cat_title'];
          ?>
    <input value="<?php if(isset($cat_title)) {echo $cat_title;} ?>" type="text" name="cat_title" class="form-control" id="cat-title">
    <?php }} ?>

  </div>
  <div class="form-group">
    <input type="submit" name="update" class="btn btn-primary" value="update category">
  </div>
</form>

<?php //update
  if(isset($_POST['update'])) {
    $title = $_POST['cat_title'];
    $query = "UPDATE categories SET cat_title = '{$title}' WHERE cat_id = $cat_id ";
    $update_query = mysqli_query($connection, $query);
    header("Location: categories.php");
  }
 ?>
