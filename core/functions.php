<?php 
/* 
  ./core/functions.php
*/

namespace Core\Functions;


/**
 * Truncate the string with default length
 *
 * @param string $chain
 * @param integer $length
 * @return string
 */
function truncate(string $chain, int $length = TRUNCATE_LENGTH) :string {
  if (strlen($chain) > $length):
    $chain = substr($chain, 0, strpos($chain, ' ', $length)) . ' [...]';    
  endif;
  return $chain;
}


/**
 * Formatting date with default format
 *
 * @param string $date
 * @param string $format
 * @return string
 */
function datify(string $date, string $format = DATE_FORMAT) :string {
  $date = new \DateTime($date);
  return $date->format($format);
}


/**
 * Converts accentuated characters (àéïöû etc.) 
 * to their ASCII equivalent (aeiou etc.)
 *
 * @param  string $str
 * @param  string $charset
 * @return string
 */
function accent2ascii(string $str, string $charset = 'utf-8'): string
{
    $str = htmlentities($str, ENT_NOQUOTES, $charset);

    $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères

    return $str;
}


/**
 * Transform a string to slug
 *
 * @param string $chain
 * @param string $separator
 * @return string
 */
function slugify(string $chain, string $separator = '-') :string {
  $chain = accent2ascii($chain);
  $chain = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', $separator, $chain)));
  return trim($chain, '-');
}


/**
 * storeFile
 *
 * @param array $files
 * @param array $post
 * @return void
 */
function storeFile(array $files, array $post) {

  // TODO: improve all error messages
  
  $img_dir = "D:/web_dev/Dropbox/htdocs/scripts_serveurs/AlexParker_assessmentProject/public/images/blog/";
  $target_file = $img_dir . basename($files["image"]["name"]);    
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
  // Check if image file is a actual image or fake image
  if(isset($post["submit"])) {
    $check = getimagesize($files["image"]["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
  }
  
  // Check if file already exists
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }
  
  // Check file size
  if ($files["image"]["size"] > 3000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }
  
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($files["image"]["tmp_name"], $target_file)) {
      echo "The file ". htmlspecialchars(basename($files["image"]["name"])). " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}
