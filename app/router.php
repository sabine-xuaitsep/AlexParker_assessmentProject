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

  // check if URL = BASE_HREF
  if($_SERVER['REQUEST_URI'] != BASE_HREF):
    // redirection to homepage
    header('Location:' . BASE_HREF);
  endif;

  include_once '../app/controllers/postsController.php';
  App\Controllers\PostsController\indexAction($conn, 1);
  
endif;
