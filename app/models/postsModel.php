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


/**
 * insertOne post
 *
 * @param \PDO $conn
 * @param array $data
 * @return integer
 */
function insertOne(\PDO $conn, array $data) :bool {
  $sql = 'INSERT INTO posts
          SET title       = :title,
              text        = :text,
              quote       = :quote,
              category_id = :catID,
              created_at  = NOW();';
  $rs = $conn->prepare($sql);
  $rs->bindValue(':title', $data['title'], \PDO::PARAM_STR);
  $rs->bindValue(':text', $data['text'], \PDO::PARAM_STR);
  $rs->bindValue(':quote', $data['quote'], \PDO::PARAM_STR);
  $rs->bindValue(':catID', $data['category_id'], \PDO::PARAM_INT);
  return $rs->execute();
}


/**
 * updateOne post
 *
 * @param \PDO $conn
 * @param integer $id
 * @param array $data
 * @return boolean
 */
function updateOne(\PDO $conn, int $id, array $data) :bool {
  $sql = 'UPDATE posts
          SET title       = :title,
              text        = :text,
              quote       = :quote,
              category_id = :catID
          WHERE id        = :id;';
  $rs = $conn->prepare($sql);
  $rs->bindValue(':id', $id, \PDO::PARAM_INT);
  $rs->bindValue(':title', $data['title'], \PDO::PARAM_STR);
  $rs->bindValue(':text', $data['text'], \PDO::PARAM_STR);
  $rs->bindValue(':quote', $data['quote'], \PDO::PARAM_STR);
  $rs->bindValue(':catID', $data['category_id'], \PDO::PARAM_INT);
  return $rs->execute();
}


/**
 * deleteOne post
 *
 * @param \PDO $conn
 * @param integer $id
 * @return boolean
 */
function deleteOne(\PDO $conn, int $id) :bool {
  $sql = 'DELETE FROM posts
          WHERE id = :id;';
  $rs = $conn->prepare($sql);
  $rs->bindValue(':id', $id, \PDO::PARAM_INT);
  return $rs->execute();
}
