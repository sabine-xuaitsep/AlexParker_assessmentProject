<?php
/* 
  ./app/controllers/postsController.php
*/

namespace App\Controllers\PostsController;
use App\Models\PostsModel;


/**
 * indexAction: posts list
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


/**
 * showAction: detail of a post
 *
 * @param \PDO $conn
 * @param integer $id
 * @return void
 */
function showAction(\PDO $conn, int $id) {
  // asking one post to postsModel
  include_once '../app/models/postsModel.php';
  $post = PostsModel\findOne($conn, $id);

  // load $title & posts/show in $content
  GLOBAL $content, $title;
  $title = "Alex Parker - " . $post['title'];
  ob_start();
    include '../app/views/posts/show.php';
  $content = ob_get_clean();
}