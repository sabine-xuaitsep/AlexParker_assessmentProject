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
 * @param integer $pageNb
 * @return void
 */
function indexAction(\PDO $conn, int $pageNb = 1) {
  // count all posts
  $postsCount = PostsModel\countAll($conn);
  $nbOfPages = ceil($postsCount/10);

  //  if pageNb doesn't exist
  //    lower numbers are already excluded by .htaccess
  if($pageNb > $nbOfPages):
    // redirection to homepage
    header('Location:' . BASE_HREF);

  else:
    // calc $offset
    $offset = ($pageNb-1)*10;

    // asking all posts to postsModel
    $posts = PostsModel\findAll($conn, $offset);

    // load $title & posts/index in $content
    GLOBAL $content, $title;
    $title = "Alex Parker - Blog";
    ob_start();
      include '../app/views/posts/index.php';
    $content = ob_get_clean();

  endif;
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
  //  ($id exist) ? return [data] : return [] 
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
  //  ($id exist) ? return [data] : return [] 
  $post = PostsModel\findOne($conn, $id);
  
  // check if $id doesn't exist && URL matches with Add a post route
  if($post === [] && ($_SERVER['REQUEST_URI'] != BASE_HREF . 'posts/add/form.html')):
    // redirection to Add a post route
    header('Location:' . BASE_HREF . 'posts/add/form.html'); 
  endif;

  GLOBAL $content, $title;
  // load $title
  $title = ($post === []) ? "Alex Parker - Add a post" : "Alex Parker - Edit a post";
  // load postForm
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
function storeAction(\PDO $conn, array $data, string $fileName) {
  // adding $data to postsTable
  $result = PostsModel\insertOne($conn, $data, $fileName);

  // check error
  if ($result === false):
    // redirection to previous page
    GLOBAL $script;
      $script .= '<script>alert("Error : post not saved! You will be redirected to the previous page.");window.history.back();</script>';
  else:
    // redirection to homepage
    header('Location:' . BASE_HREF);
  endif;
}


/**
 * updateAction
 *
 * @param \PDO $conn
 * @param integer $id
 * @param array $data
 * @param string $fileName
 * @return void
 */
function updateAction(\PDO $conn, int $id, array $data, string $fileName) {
  // updating $data by $id in postsTable
  $result = PostsModel\updateOne($conn, $id, $data, $fileName);

  // check error
  if ($result === false):
    // redirection to previous page
    GLOBAL $script;
      $script .= '<script>alert("Error during update! You will be redirected to the previous page.");window.history.back();</script>';
  else:
    // redirection to detail of post
    header('Location:' . BASE_HREF . 'posts/' . $id . '/' . \Core\Functions\slugify($data['title']) . '.html');
  endif;
}


/**
 * deleteAction
 *
 * @param \PDO $conn
 * @param integer $id
 * @return void
 */
function deleteAction(\PDO $conn, int $id) {
  // updating $data by $id in postsTable
  $result = PostsModel\deleteOne($conn, $id);

  // check error
  if ($result === false):
    // redirection to previous page
    GLOBAL $script;
    $script .= '<script>alert("Deletion not executed! You will be redirected to the previous page.");window.history.back();</script>';
  else:
    // redirection to homepage
    header('Location:' . BASE_HREF);
  endif;
}
