<?php
/* 
  ./app/controllers/postsController.php
*/

namespace App\Controllers\PostsController;
use App\Models\PostsModel;
include_once '../app/models/postsModel.php';

/**
 * indexAction: posts list
 *
 * @param \PDO $conn
 * @return void
 */
function indexAction(\PDO $conn) {
  // asking all posts to postsModel
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
  $post = PostsModel\findOne($conn, $id);

  //  if $id doesn't exist in DB
  if($post === []):
    // redirection to homepage
    header('Location:' . BASE_HREF);

  else:
    GLOBAL $content, $title;
    // load $title
    $title = "Alex Parker - " . $post['title'];
    // load posts/show in $content
    ob_start();
      include '../app/views/posts/show.php';
    $content = ob_get_clean();
  
    // load popupAction
    popupAction($conn);
  
    // load shAction (syntaxHiglighter stylesheets & scripts)
    \App\Config\Functions\shAction();

  endif;
}


/**
 * popupAction: suggest one post randomly
 *
 * @param \PDO $conn
 * @return void
 */
function popupAction(\PDO $conn) {
  // asking one post randomly to postsModel
  $post = PostsModel\suggestOne($conn);

  // load posts/_popup in $popup
  GLOBAL $popup;
  ob_start();
    include '../app/views/posts/_popup.php';
  $popup = ob_get_clean();
}


/**
 * editAction
 *
 * @param \PDO $conn
 * @param integer $id
 * @return void
 */
function editAction(\PDO $conn, int $id = 0) {
  // asking one post to postsModel 
  //  $_GET['id'] exist ? return [data] : return [] 
  $post = PostsModel\findOne($conn, $id);

  GLOBAL $content, $title;
  // load $title
  $title = ($post === []) ? "Alex Parker - Add a post" : "Alex Parker - Edit a post";
  
  // load create form
  ob_start();
    include '../app/views/posts/postForm.php';
  $content = ob_get_clean();

  // load popupAction
  popupAction($conn);

  // load shAction (syntaxHiglighter stylesheets & scripts)
  \App\Config\Functions\shAction();
}


/**
 * storeAction
 *
 * @param \PDO $conn
 * @param array $data
 * @return void
 */
function storeAction(\PDO $conn, array $data) {
  // adding $data to postsTable
  $result = PostsModel\insertOne($conn, $data);

  // check error
  if ($result === false):
    editAction($conn);
  else:
    // redirection to homepage
    header('Location:' . BASE_HREF);
  endif;
}