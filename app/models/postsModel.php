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


/**
 * findOne post by ID
 *  if $id doesn't exist, return [];
 *
 * @param \PDO $conn
 * @param integer $id
 * @return array
 */
function findOne(\PDO $conn, int $id) :array {
  $sql = 'SELECT p.*, c.name as catName
          FROM posts p
          JOIN categories c ON p.category_id = c.id
          WHERE p.id = :id;';
  $rs = $conn->prepare($sql);
  $rs->bindValue(':id', $id, \PDO::PARAM_INT);
  $rs->execute();
  $result = $rs->fetch(\PDO::FETCH_ASSOC);
  $result = ($result === false) ? [] : $result;
  return $result;
}


/**
 * suggestOne post randomly
 *
 * @param \PDO $conn
 * @return array
 */
function suggestOne(\PDO $conn) :array {
  $sql = 'SELECT *
          FROM posts 
          ORDER BY RAND () 
          LIMIT 1;';
  $rs = $conn->query($sql);
  return $rs->fetch(\PDO::FETCH_ASSOC);
}