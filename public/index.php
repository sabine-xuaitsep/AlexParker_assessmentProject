<?php
/*
  ./public/index.php
*/

require_once '../core/init.php';
require_once '../app/router.php';

// AJAX check
if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
  // load template if no AJAX request
  require_once "../app/views/templates/index.php";
}

require_once '../core/close.php';
