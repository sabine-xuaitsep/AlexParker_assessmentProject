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
function accent2ascii(string $str, string $charset = 'utf-8'): string {
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
 * @param array $file
 * @return array
 */
function storeFile(array $file) :array {

  // init $status for later check
  $status = 1;
  // init $msg for storing errors
  $msg = 'Check: ';


  // check if file exceed MAX_FILE_SIZE defined in form
  if($file['image']['error'] === 2): // UPLOAD_ERR_FORM_SIZE
    $status = 0;
    $msg .= "Your file is too large! Please choose a smaller one";


  elseif($file['image']['error'] === 0): // UPLOAD_ERR_OK
    // store mime type
    $checkMime = preg_split("/\//", mime_content_type($file['image']['tmp_name']));
    // store if format is allowed
    $allowedExt = ["jpeg", "png", "gif"];
    $allowed = array_search($checkMime[1], $allowedExt);
    // store path
    $img_dir = "D:/web_dev/Dropbox/htdocs/scripts_serveurs/AlexParker_assessmentProject/public/images/blog/";
    $target_file = $img_dir . basename($file['image']['name']); 

    // check if file name already exists
    if(file_exists($target_file)):
      $status = 2;
      // redirection to ajaxAction
      $msg .= "File name already exist. ";
    endif;
    
    // check if file is fake image
    if($checkMime[0] !== "image"):
      $status = 0;
      $msg .= "File is not really a picture. ";
    endif;

    // check if file format is allowed
    if($allowed === false):
      $status = 0;
      $msg .= "Your file is " . mime_content_type($file['image']['tmp_name']) . " format. Only .jpg, .jpeg, .png or .gif files are allowed. ";
    endif;

    // if everything OK
    if($status === 1):
      // try to upload file
      if(move_uploaded_file($file['image']['tmp_name'], $target_file)): 
        $status = 1;
        $msg = "The file ". htmlspecialchars(basename($file["image"]["name"])). " has been uploaded. ";
      else:
        $status = 0;
        $msg = "Sorry, there was an error uploading your file. Please choose another one or try again later. ";
      endif;
    
    else:
      $msg .= "Please choose another one.";

    endif;


  else:
    $status = 0;
    $msg = "Sorry, an error occurred. You will be redirected to the previous page. If error persist, try again later.";

  endif;

  
  // render $check
  $check = [
    'status'  => $status, 
    'msg'     => $msg
  ];

  return $check;
}
