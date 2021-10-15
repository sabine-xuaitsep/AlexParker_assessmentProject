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
