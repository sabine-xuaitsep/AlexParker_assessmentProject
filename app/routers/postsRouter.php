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

    // 4 === UPLOAD_ERR_NO_FILE
    $fileName = ($_FILES['image']['error'] === 4) ? '' : $_FILES['image']['name'];

    $check = Core\Functions\storeFile($_FILES);
    // $check = ARRAY(status, msg)
    
    if($check['status'] === 0):
      GLOBAL $script;
      $script .= '<script>alert("' . $check['msg'] . '");window.history.back();</script>';;
      
    else:
      PostsController\storeAction($conn, $_POST, $fileName);
    endif;

    break;


  case 'update':
    // UPDATE A POST ROUTE
    // PATTERN: /posts/id/slug-of-post/edit/update.html => ?posts=update&id=x
    // CTRL: PostsController
    // ACTION: update
    // REDIRECTION to detail of post
 
    // if no file selected
    if($_FILES['image']['error'] === 4): // UPLOAD_ERR_NO_FILE
      $fileName = isset($_POST['image']) ? $_POST['image'] : '';
      PostsController\updateAction($conn, intval($_GET['id']), $_POST, $fileName);

    else:
      $check = Core\Functions\storeFile($_FILES);
      // $check = ARRAY(status, msg)
      
      if($check['status'] === 0):
        GLOBAL $script;
        $script .= '<script>alert("' . $check['msg'] . '");window.history.back();</script>';
      else:
        PostsController\updateAction($conn, intval($_GET['id']), $_POST, $_FILES['image']['name']);
      endif;

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
