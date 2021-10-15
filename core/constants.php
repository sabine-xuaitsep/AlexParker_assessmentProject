<?php
/*
  ./core/constants.php
*/


// base href path
$base_href = preg_split("/public/", $_SERVER['REQUEST_URI']);

define('BASE_HREF', $base_href[0] . 'public/');