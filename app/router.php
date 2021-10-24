<?php
/*
  ./app/router.php

  intval() prevent error: 
  (number > 9223372036854775807) === string
*/


if(isset($_GET['posts'])):
  include_once '../app/routers/postsRouter.php';

elseif(isset($_GET['catID'])):

  if(isset($_GET['page'])):
    // CATEGORIES PAGINATION ROUTE
    // PATTERN: /categories/id/page/x.html => ?catID=x&page=x
    // CTRL: PostsController
    // ACTION: category
    // TITLE: Alex Parker - CategoryName
    include_once '../app/controllers/postsController.php';
    App\Controllers\PostsController\categoryAction($conn, intval($_GET['catID']), intval($_GET['page']));
  
  else:
    // CATEGORIES ROUTE
    // PATTERN: /categories/id/slug-of-category.html => ?catID=x
    // CTRL: CategoriesController
    // ACTION: category
    // TITLE: Alex Parker - CategoryName
    include_once '../app/controllers/postsController.php';
    App\Controllers\PostsController\categoryAction($conn, intval($_GET['catID']));
  endif;

else:
  // DEFAULT ROUTE
  // PATTERN: /
  // CTRL: PostsController
  // ACTION: index
  // TITLE: Alex Parker - Blog
  include_once '../app/controllers/postsController.php';
  App\Controllers\PostsController\indexAction($conn);
  
endif;
