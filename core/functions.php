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