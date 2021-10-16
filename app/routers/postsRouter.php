<?php
/*
  ./app/routers/postsRouter.php
*/

use App\Controllers\PostsController;
include_once '../app/controllers/postsController.php';

switch ($_GET['posts']):

  case 'edit':
    // ADDING A POST ROUTE
    // PATTERN: /posts/add/form.html => ?posts=edit
    // CTRL: PostsController
    // ACTION: edit
    // TITLE: Alex Parker - Add a post
    PostsController\editAction($conn);
    break;

  case 'store':
    // INSERT A POST ROUTE
    // PATTERN: /posts/add/insert.html => ?posts=store
    // CTRL: PostsController
    // ACTION: store
    // REDIRECTION VERS LA PAGE D'ACCUEIL
    PostsController\storeAction($conn, $_POST);
    break;

  default:
    // DETAIL OF A POST ROUTE
    // PATTERN: /posts/id/slug-of-post.html => ?posts=x
    // CTRL: PostsController
    // ACTION: show
    // TITLE: Alex Parker - Title of post
    PostsController\showAction($conn, intval($_GET['posts']));
    break;

endswitch;
