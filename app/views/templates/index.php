<?php
/*
  ./app/views/templates/index.php
*/
?>

<!DOCTYPE html>
<html lang="en">
  <head>

    <?php include_once '../app/views/templates/partials/_head.php'; ?>

  </head>

  <body>
    <!-- Preloader Start -->
    <div class="preloader">
      <div class="rounder"></div>
    </div>
    <!-- Preloader End -->

    <div id="main">
      <div class="container">
        <div class="row">

          <?php include '../app/views/templates/partials/_sidebar.php'; ?>

          <!-- Blog Post (Right Sidebar) Start -->
          <div class="col-md-9">
            <div class="col-md-12 page-body">

              <?php 
              // Dynamic content zone
              echo $content; 
              ?>

            </div>

            <?php include '../app/views/templates/partials/_footer.php'; ?>

          </div>
          <!-- Blog Post (Right Sidebar) End -->
        </div>
      </div>
    </div>

    
    <!-- popup ON FORM & SINGLE PAGES ONLY -->
    <?php echo $popup; ?>

    
    <!-- Back to Top Start -->
    <a href="#" class="scroll-to-top"><i class="fa fa-long-arrow-up"></i></a>
    <!-- Back to Top End -->

    <?php include '../app/views/templates/partials/_scripts.php'; ?>

  </body>
</html>
