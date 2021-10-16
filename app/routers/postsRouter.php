<?php
/*
  ./app/routers/postsRouter.php
*/

use App\Controllers\PostsController;
include_once '../app/controllers/postsController.php';

switch ($_GET['posts']):

  case 'create':
    // ADDING A POST ROUTE
    // PATTERN: /posts/add/form.html => ?posts=create
    // CTRL: PostsController
    // ACTION: create
    // TITLE: Alex Parker - Add a post
    PostsController\createAction($conn);
    break;
  
  default:
    // DETAIL OF A POST ROUTE
    // PATTERN: /posts/id/slug-of-post.html => ?postId=x
    // CTRL: PostsController
    // ACTION: show
    // TITLE: Alex Parker - Title of post
    PostsController\showAction($conn, $_GET['posts']);
    break;

endswitch;
