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
          JOIN posts p ON c.id = p.category_id
          GROUP BY c.id
          ORDER BY name ASC;';
  $rs = $conn->query($sql);
  return $rs->fetchAll(\PDO::FETCH_ASSOC);
}


/**
 * findOne by id
 *
 * @param \PDO $conn
 * @param string $id
 * @return array
 */
function findOne(\PDO $conn, int $id) :array {
  $sql = 'SELECT *
          FROM categories
          WHERE id = :id;';
  $rs = $conn->prepare($sql);
  $rs->bindValue(':id', $id, \PDO::PARAM_INT);
  $rs->execute();
  return $rs->fetch(\PDO::FETCH_ASSOC);
}