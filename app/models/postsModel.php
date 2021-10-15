<?php
/* 
  ./app/models/postsModel.php
*/

namespace App\Models\PostsModel;


/**
 * findAll posts
 *
 * @param \PDO $conn
 * @return array
 */
function findAll(\PDO $conn) :array {
  $sql = 'SELECT p.*, c.name as catName
          FROM posts p
          JOIN categories c ON p.category_id = c.id
          ORDER BY p.created_at DESC
          LIMIT 10;';
  $rs = $conn->query($sql);
  return $rs->fetchAll(\PDO::FETCH_ASSOC);
}
