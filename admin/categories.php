<?php include "includes/header.php" ?>
<div id="wrapper">
    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Categories
                        <small>Subheading</small>
                    </h1>

                    <div class="col-md-6">
                      <!-- make new category -->
                      <?php insertCategory(); ?>
                      <form action="" method="post">
                        <div class="form-group">
                          <label for="cat-title">add category</label>
                          <input type="text" name="cat_title" class="form-control" id="cat-title">
                        </div>
                        <div class="form-group">
                          <input type="submit" name="submit" class="btn btn-primary" value="add category">
                        </div>
                      </form>
                      <?php
                        if(isset($_GET['edit'])) {
                          include "includes/update_cat.php";
                        }
                       ?>
                    </div>
                    <div class="col-md-6">
                      <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <td>ID</td>
                            <td>name</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            //displaying categories from the database
                            readCategories();
                            //deleting category
                            deleteCategory();
                           ?>
                        </tbody>
                      </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
<?php include "includes/footer.php" ?>
