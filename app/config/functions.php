<?php 
/* 
  ./app/config/functions.php
*/

namespace App\Config\Functions;

/**
 * shAction: load syntaxHighlighter stylesheets & scripts
 *
 * @return void
 */
function shAction() {
  GLOBAL $stylesheet, $script;
  ob_start();
    include '../app/views/templates/partials/_shStylesheets.php';
  $stylesheet = ob_get_clean();
  ob_start();
    include '../app/views/templates/partials/_shScripts.php';
  $script = ob_get_clean();
};