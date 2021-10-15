<?php
/*
  ./app/router.php
*/


if(isset($_GET['postId'])):
  // DETAIL OF A POST ROUTE
  // PATTERN: /posts/id/slug-of-post.html => ?postId=x
  // CTRL: PostsController
  // ACTION: show
  // TITLE: Alex Parker - Title of post
  include_once '../app/controllers/postsController.php';
  App\Controllers\PostsController\showAction($conn, $_GET['postId']);
  
  
else:
  // DEFAULT ROUTE
  // PATTERN: /
  // CTRL: PostsController
  // ACTION: index
  // TITLE: Alex Parker - Blog
  include_once '../app/controllers/postsController.php';
  App\Controllers\PostsController\indexAction($conn);
  
    
endif;
