<?php
/*
  ./app/router.php
*/


if(isset($_GET['posts'])):
  include_once '../app/routers/postsRouter.php';

else:
  // DEFAULT ROUTE
  // PATTERN: /
  // CTRL: PostsController
  // ACTION: index
  // TITLE: Alex Parker - Blog
  include_once '../app/controllers/postsController.php';
  App\Controllers\PostsController\indexAction($conn);
  
endif;
