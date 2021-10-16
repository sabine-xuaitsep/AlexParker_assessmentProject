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

  GLOBAL $content, $title;
  // load $title
  $title = "Alex Parker - " . $post['title'];
  // load posts/show in $content
  ob_start();
    include '../app/views/posts/show.php';
  $content = ob_get_clean();

  // load popupAction
  popupAction($conn);
}


/**
 * popupAction: suggest one post randomly
 *
 * @param \PDO $conn
 * @return void
 */
function popupAction(\PDO $conn) {
  // asking one post randomly to postsModel
  include_once '../app/models/postsModel.php';
  $post = PostsModel\suggestOne($conn);

  // load posts/_popup in $popup
  GLOBAL $popup;
  ob_start();
    include '../app/views/posts/_popup.php';
  $popup = ob_get_clean();
}