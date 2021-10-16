<?php
/*
  ./app/router.php
*/

use App\Controllers\PostsController;


if(isset($_GET['postId'])):
  // DETAIL OF A POST ROUTE
  // PATTERN: /posts/id/slug-of-post.html => ?postId=x
  // CTRL: PostsController
  // ACTION: show
  // TITLE: Alex Parker - Title of post
  include_once '../app/controllers/postsController.php';
  PostsController\showAction($conn, $_GET['postId']);

elseif(isset($_GET['posts']) && $_GET['posts'] === 'create'):
  // ADDING A POST ROUTE
  // PATTERN: /posts/add/form.html => ?posts=create
  // CTRL: PostsController
  // ACTION: create
  // TITLE: Alex Parker - Add a post
  include_once '../app/controllers/postsController.php';
  PostsController\createAction($conn);

else:
  // DEFAULT ROUTE
  // PATTERN: /
  // CTRL: PostsController
  // ACTION: index
  // TITLE: Alex Parker - Blog
  include_once '../app/controllers/postsController.php';
  PostsController\indexAction($conn);
  
    
endif;
