<?php
// Contains the attributes for NewsStory objects and functions these objects use.

// News story class
class LikedPosts {
  public $id;
  public $user_id;
  public $news_id;
  const DB_TABLE = 'liked_posts';

  // Loads all the stories that were liked by the given user
  public static function loadLikedStoriesIDs($user_id) {
    $likedStories = array();

    $query = "SELECT news_id FROM ".self::DB_TABLE." WHERE user_id = ".$user_id;
    //echo $query;
    $result = $GLOBALS['conn']->query($query);
    if($result->num_rows) {
      $i = 1;
      while($row = $result->fetch_assoc()) {
        $likedStories[$i] = $row['news_id'];
        //echo $likedStories[$i];
        $i = $i + 1;
      }
    }
    return $likedStories;
  }

  // Loads a story given its id
  public static function loadByID($storyID) {
    $query = sprintf("SELECT * FROM %s WHERE id = %d",
        self::DB_TABLE,
        $GLOBALS['conn']->real_escape_string($storyID)
        );
    $result = $GLOBALS['conn']->query($query);
    if($result->num_rows) {
      $row = $result->fetch_assoc();
      $st = new LikedPosts();
      $st->id = $row['id'];
      $st->user_id = $row['user_id'];
      $st->news_id = $row['news_id'];
      return $st;
    } else {
      return null;
    }
  }

  // Inserts a given story into a database using an SQL command.
  public static function insertLikedStory($story_id, $user_id) {
    $query = sprintf("INSERT INTO %s (user_id, news_id) VALUES ('%d', '%d') ",
      self::DB_TABLE,
      $user_id,
      $story_id
      );
    $result = $GLOBALS['conn']->query($query);
    if($result) {
      $likedStoryID = $GLOBALS['conn']->insert_id;
      $ls = self::loadByID($likedStoryID);
      return $ls;
    } else {
      return null;
    }
  }

  // Deletes a liked story from the sql given its id
  public static function deleteLikedStory($id) {

    // Delete the story
    $query = sprintf("DELETE FROM %s WHERE news_id = %d; ",
      self::DB_TABLE,
      $id
      );
    //echo $query;

    $result = $GLOBALS['conn']->query($query);
    if($result) {
      return $id;
    } else {
      return null;
    }
  }


}
