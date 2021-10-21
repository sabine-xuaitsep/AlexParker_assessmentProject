<?php
/*
  ./app/routers/postsRouter.php

  intval() prevent error: 
    (number > 9223372036854775807) === string
*/

use App\Controllers\PostsController;
include_once '../app/controllers/postsController.php';


switch ($_GET['posts']):

  case 'edit':

    if(isset($_GET['id'])):
      // EDIT A POST ROUTE
      // PATTERN: /posts/id/slug-of-post/edit/form.html => ?posts=edit&id=x
      // CTRL: PostsController
      // ACTION: edit
      // TITLE: Alex Parker - Edit a post
      PostsController\editAction($conn, intval($_GET['id']));

    else:
      // ADD A POST ROUTE
      // PATTERN: /posts/add/form.html => ?posts=edit
      // CTRL: PostsController
      // ACTION: edit
      // TITLE: Alex Parker - Add a post
      PostsController\editAction($conn);

    endif;

    break;


  case 'store':
    // STORE A POST ROUTE
    // PATTERN: /posts/add/insert.html => ?posts=store
    // CTRL: PostsController
    // ACTION: store
    // REDIRECTION to homepage
    Core\Functions\storeFile($_FILES, $_POST);
    // TODO: error message & block process if file is not stored
    
    PostsController\storeAction($conn, $_POST, $_FILES['image']['name']);
    break;


  case 'update':
    // UPDATE A POST ROUTE
    // PATTERN: /posts/id/slug-of-post/edit/update.html => ?posts=update&id=x
    // CTRL: PostsController
    // ACTION: update
    // REDIRECTION to detail of post

    // check if picture wasn't changed
    if(isset($_POST['image']) && $_FILES['image']['name'] === ''):
      PostsController\updateAction($conn, intval($_GET['id']), $_POST, $_POST['image']);

    else:
      Core\Functions\storeFile($_FILES, $_POST);
      // TODO: error message & block process if file is not stored

      PostsController\updateAction($conn, intval($_GET['id']), $_POST, $_FILES['image']['name']);
    endif;

    break;


  case 'delete':
    // DELETE A POST ROUTE
    // PATTERN: /posts/id/slug-of-post/delete.html => ?posts=delete&id=x
    // CTRL: PostsController
    // ACTION: delete
    // REDIRECTION to homepage
    PostsController\deleteAction($conn, intval($_GET['id']));
    break;
  

  case 'more':
    // POST PAGINATION ROUTE
    // PATTERN: /page/x.html => ?posts=more&page=x
    // CTRL: PostsController
    // ACTION: index
    // TITLE: Alex Parker - Blog
    PostsController\indexAction($conn, intval($_GET['page']));
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
