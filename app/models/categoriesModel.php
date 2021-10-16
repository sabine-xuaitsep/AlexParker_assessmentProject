<?php
/* 
  ./app/models/categoriesModel.php
*/

namespace App\Models\CategoriesModel;


/**
 * findAll categories
 *
 * @param \PDO $conn
 * @return array
 */
function findAll(\PDO $conn) :array {
  $sql = 'SELECT *
          FROM categories
          ORDER BY name ASC;';
  $rs = $conn->query($sql);
  return $rs->fetchAll(\PDO::FETCH_ASSOC);
}
