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

  if ($pageNb === 1):
    // check if URL = BASE_HREF
    if($_SERVER['REQUEST_URI'] != BASE_HREF):
      // redirection to homepage
      header('Location:' . BASE_HREF);
    endif;
  endif;
    
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

  // check if URL = BASE_HREF
  if($_SERVER['REQUEST_URI'] === BASE_HREF . '?posts=' . $id):
    // redirection to homepage
    header('Location:' . BASE_HREF . 'posts/' . $id . '/' . \Core\Functions\slugify($post['title']) . '.html');
  endif;

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
 * @param array $file
 * @return void
 */
function storeAction(\PDO $conn, array $data, array $file) {

  // if no file selected
  if($file['image']['error'] === 4): // UPLOAD_ERR_NO_FILE
    $fileName = '';

  else:
    $check = \Core\Functions\storeFile($file);
    // $check = ARRAY(status, msg)
    
    if($check['status'] === 0):
      GLOBAL $script;
      $script .= '<script>alert("' . $check['msg'] . '");window.history.back();</script>';

    elseif($check['status'] === 2): 

      GLOBAL $content, $script;
      // load _ghostForm to store $_POST & $_FILES
      ob_start();
        include '../app/views/posts/_ghostForm.php';
      $content = ob_get_clean();

      // add script for AJAX request
      $script .= '
        <script src="js/posts/store.js"></script>
      ';

    else:
      $fileName = $file['image']['name'];
    endif;

  endif;

  // if $fileName exist === no errors in previous steps
  if(isset($fileName)):
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
  endif;
}


/**
 * ajaxStoreAction
 *
 * @param \PDO $conn
 * @param array $data
 * @param string $fileName
 * @return void
 */
function ajaxStoreAction(\PDO $conn, array $data, string $fileName) {
  $data = [
    'title' => str_replace('_', ' ', $data['title']),
    'text'  => str_replace('_', ' ', $data['text']),
    'quote' => str_replace('_', ' ', $data['quote'])
  ];
  $result = PostsModel\insertOne($conn, $data, $fileName);
}


/**
 * updateAction
 *
 * @param \PDO $conn
 * @param integer $id
 * @param array $data
 * @param array $file
 * @return void
 */
function updateAction(\PDO $conn, int $id, array $data, array $file) {

  // if no file selected
  if($file['image']['error'] === 4): // UPLOAD_ERR_NO_FILE
    $fileName = isset($data['image']) ? $data['image'] : '';

  else:
    $check = \Core\Functions\storeFile($file);
    // $check = ARRAY(status, msg)
    
    if($check['status'] === 0):
      GLOBAL $script;
      $script .= '<script>alert("' . $check['msg'] . '");window.history.back();</script>';

    elseif($check['status'] === 2): 

      GLOBAL $content, $script;
      // load _ghostForm to store $_POST & $_FILES
      ob_start();
        include '../app/views/posts/_ghostForm.php';
      $content = ob_get_clean();

      // add script for AJAX request
      $script .= '
        <script src="js/posts/update.js"></script>
      ';

    else:
      $fileName = $file['image']['name'];
    endif;

  endif;

  // if $fileName exist === no errors in previous steps
  if(isset($fileName)):
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
  endif;
}


/**
 * ajaxUpdateAction
 *
 * @param \PDO $conn
 * @param integer $id
 * @param array $data
 * @param string $fileName
 * @return void
 */
function ajaxUpdateAction(\PDO $conn, int $id, array $data, string $fileName) {
  $data = [
    'title' => str_replace('_', ' ', $data['title']),
    'text'  => str_replace('_', ' ', $data['text']),
    'quote' => str_replace('_', ' ', $data['quote'])
  ];
  $result = PostsModel\updateOne($conn, $id, $data, $fileName);
}


/**
 * deleteAction
 *
 * @param \PDO $conn
 * @param integer $id
 * @return void
 */
function deleteAction(\PDO $conn, int $id) {

  GLOBAL $content, $script;
  // load _ghostForm to store $id
  ob_start();
    include '../app/views/posts/_ghostForm.php';
  $content = ob_get_clean();

  // add script for AJAX request
  $script .= '
    <script src="js/posts/delete.js"></script>
  ';
}


/**
 * ajaxDeleteAction
 *
 * @param \PDO $conn
 * @param integer $id
 * @return void
 */
function ajaxDeleteAction(\PDO $conn, int $id) {
  // deleting post by $id in postsTable
  $result = PostsModel\deleteOne($conn, $id);
}
