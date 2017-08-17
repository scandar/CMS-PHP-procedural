<?php include "includes/header.php"; ?>
<?php if (!isAdmin($_SESSION['username'])){header("Location: ../");} ?>
<div id="wrapper">
    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome
                        <small><?php echo $_SESSION['username']; ?></small>
                    </h1>
                </div>
            </div>
            <!-- /.row -->


                     <!-- /.row -->

     <div class="row">
         <div class="col-md-3">
             <div class="panel panel-primary">
                 <div class="panel-heading">
                     <div class="row">
                         <div class="col-xs-3">
                             <i class="fa fa-file-text fa-5x"></i>
                         </div>
                         <div class="col-xs-9 text-right">


                             <div class='huge'><?php echo $posts_count = countTable('posts'); ?></div>

                             <div>Posts</div>
                         </div>
                     </div>
                 </div>
                 <a href="posts.php">
                     <div class="panel-footer">
                         <span class="pull-left">View Details</span>
                         <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                         <div class="clearfix"></div>
                     </div>
                 </a>
             </div>
         </div>
         <div class="col-md-3">
             <div class="panel panel-green">
                 <div class="panel-heading">
                     <div class="row">
                         <div class="col-xs-3">
                             <i class="fa fa-comments fa-5x"></i>
                         </div>
                         <div class="col-xs-9 text-right">
                           <div class='huge'><?php echo $comments_count = countTable('comments'); ?></div>
                           <div>Comments</div>
                         </div>
                     </div>
                 </div>
                 <a href="comments.php">
                     <div class="panel-footer">
                         <span class="pull-left">View Details</span>
                         <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                         <div class="clearfix"></div>
                     </div>
                 </a>
             </div>
         </div>
         <div class="col-md-3">
             <div class="panel panel-yellow">
                 <div class="panel-heading">
                     <div class="row">
                         <div class="col-xs-3">
                             <i class="fa fa-user fa-5x"></i>
                         </div>
                         <div class="col-xs-9 text-right">
                           <div class='huge'><?php echo $users_count = countTable('users'); ?></div>
                             <div>Users</div>
                         </div>
                     </div>
                 </div>
                 <a href="users.php">
                     <div class="panel-footer">
                         <span class="pull-left">View Details</span>
                         <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                         <div class="clearfix"></div>
                     </div>
                 </a>
             </div>
         </div>
         <div class="col-md-3">
             <div class="panel panel-red">
                 <div class="panel-heading">
                     <div class="row">
                         <div class="col-xs-3">
                             <i class="fa fa-list fa-5x"></i>
                         </div>
                         <div class="col-xs-9 text-right">
                              <div class='huge'><?php echo $categories_count = countTable('categories'); ?></div>
                              <div>Categories</div>
                         </div>
                     </div>
                 </div>
                 <a href="categories.php">
                     <div class="panel-footer">
                         <span class="pull-left">View Details</span>
                         <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                         <div class="clearfix"></div>
                     </div>
                 </a>
             </div>
         </div>
     </div><!-- /.row -->
     <?php
       $published_post_count     = conditionCount('posts','post_status','published');
       $draft_post_count         = conditionCount('posts','post_status','draft');
       $unapproved_comment_count = conditionCount('comments','comment_status','unapproved');
       $subscriber_count         = conditionCount('users','user_role','subscriber');
      ?>

     <div class="row">
       <script type="text/javascript">
         google.charts.load('current', {'packages':['bar']});
         google.charts.setOnLoadCallback(drawChart);

         function drawChart() {
           var data = google.visualization.arrayToDataTable([
             ['Data', 'Count'],
             <?php
              $element_text = ['All posts', 'Active posts', 'Draft posts', 'comments', 'Unapprvd comments', 'users', 'subscribers', 'categories'];
              $element_count = [$posts_count, $published_post_count, $draft_post_count, $comments_count, $unapproved_comment_count, $users_count, $subscriber_count, $categories_count];

              for($i=0; $i<Count($element_count); $i++) {
                echo "['{$element_text[$i]}', {$element_count[$i]}],";
              }
              ?>
            //  ['posts', 1000]
           ]);

           var options = {
             chart: {
               title: '',
               subtitle: '',
             }
           };

           var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

           chart.draw(data, google.charts.Bar.convertOptions(options));
         }
       </script>
       <div id="columnchart_material" style="width: auto; height: 500px;"></div>
     </div>

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
<?php include "includes/footer.php"; ?>
