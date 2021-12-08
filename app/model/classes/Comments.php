<?php
// Contains the attributes for Comments objects and functions these objects use.

// Comments class
class Comments {
  public $id;
  public $storyID;
  public $author;
  public $author_id;
  public $date;
  public $comment;
  const DB_TABLE = 'comments';

  // Loads all the comments from the sql and returns them as an array
  public static function loadAllComments() {

    $comments = array();

    $query = "SELECT id FROM ".self::DB_TABLE." ORDER BY date DESC";
    $result = $GLOBALS['conn']->query($query);
    if($result->num_rows) {
      while($row = $result->fetch_assoc()) {
        $com = self::loadByID($row['id']);
        $comments[$row['id']] = $com;
      }
    }
    return $comments;
  }

  // Loads a comment from its ID
  public static function loadByID($commentID) {
    $query = sprintf("SELECT * FROM %s WHERE id = %d",
       self::DB_TABLE,
       $GLOBALS['conn']->real_escape_string($commentID)
       );
    $result = $GLOBALS['conn']->query($query);
    if($result->num_rows) {
      $row = $result->fetch_assoc();
      $com = new Comments();
      $com->id = $row['id'];
      $com->storyID = $row['storyID'];
      $com->author = $row['author'];
      $com->author_id = $row['author_id'];
      $com->date = $row['date'];
      $com->comment = $row['comment'];
      return $com;
    } else {
      return null;
    }
  }

  // Inserts a comment into the sql
  public static function insertComment($comment) {
    $query = sprintf("INSERT INTO %s (storyID, author_id, comment) VALUES ('%d', '%d', '%s') ",
      self::DB_TABLE,
      $comment->storyID,
      $comment->author_id,
      $GLOBALS['conn']->real_escape_string($comment->comment)
      );
    $result = $GLOBALS['conn']->query($query);
    if($result) {
      $commentID = $GLOBALS['conn']->insert_id;
      $com = self::loadByID($commentID);
      return $com;
    } else {
      return null;
    }
  }

}
