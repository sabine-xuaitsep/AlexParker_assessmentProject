<?php
/*
  ./app/router.php
*/


  // DEFAULT ROUTE : list of posts
  // PATTERN: /
  // CTRL: postsController
  // ACTION: indexAxtion
  // TITLE: Alex Parker - Blog
  include_once '../app/controllers/postsController.php';
  App\Controllers\postsController\indexAction($conn);
