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
  $sql = 'SELECT c.*, COUNT(p.id) AS postsCount
          FROM categories c
          LEFT JOIN posts p ON c.id = p.category_id
          GROUP BY c.id
          ORDER BY name ASC;';
  $rs = $conn->query($sql);
  return $rs->fetchAll(\PDO::FETCH_ASSOC);
}
