<?php
/* 
  ./app/controllers/postsController.php
*/

namespace App\Controllers\PostsController;
use App\Models\PostsModel;


/**
 * indexAction
 *
 * @param \PDO $conn
 * @return void
 */
function indexAction(\PDO $conn) {
  // asking all posts to postsModel
  include_once '../app/models/postsModel.php';
  $posts = PostsModel\findAll($conn);

  // load $title & posts/index in $content
  GLOBAL $content, $title;
  $title = "Alex Parker - Blog";
  ob_start();
    include '../app/views/posts/index.php';
  $content = ob_get_clean();
}
