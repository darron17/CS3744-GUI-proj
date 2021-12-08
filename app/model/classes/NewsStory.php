<?php
// Contains the attributes for NewsStory objects and functions these objects use.

// News story class
class NewsStory {
  public $id;
  public $title;
  public $author;
  public $author_id;
  public $body;
  public $description;
  public $likes;
  public $url;
  public $url_header;
  public $date;
  public $img;
  const DB_TABLE = 'news_story';

  // Loads the stories and organizes them based on likes in descending order.
  // Returns the updated story data array
  public static function loadAllStoriesLikes() {

    $stories = array();

    $query = "SELECT id FROM ".self::DB_TABLE." ORDER BY likes DESC";
    $result = $GLOBALS['conn']->query($query);
    if($result->num_rows) {
      $i = 1;
      while($row = $result->fetch_assoc()) {
        $st = self::loadByID($row['id']);
        $stories[$i] = $st;
        $i = $i + 1;
      }
    }
    return $stories;
  }

  // Loads the stories and organizes them based on the date from present to past.
  // Return the updated story data array
  public static function loadAllStoriesDate() {

    $stories = array();

    $query = "SELECT id FROM ".self::DB_TABLE." ORDER BY date DESC";
    $result = $GLOBALS['conn']->query($query);
    if($result->num_rows) {
      $i = 1;
      while($row = $result->fetch_assoc()) {
        $st = self::loadByID($row['id']);
        $stories[$i] = $st;
        $i = $i + 1;
      }
    }
    return $stories;
  }

  // Loads the stories and organizes them based on the date from present to past.
  // Return the updated story data array
  public static function loadAllStoriesUser($user) {

    $stories = array();

    $query = "SELECT id FROM ".self::DB_TABLE." WHERE author_id = ".$user;
    $result = $GLOBALS['conn']->query($query);
    if($result->num_rows) {
      $i = 1;
      while($row = $result->fetch_assoc()) {
        $st = self::loadByID($row['id']);
        $stories[$i] = $st;
        $i = $i + 1;
      }
    }
    return $stories;
  }


  // Given a story id, loads the corresponding story. Stores the data from the loaded
  // story into a new NewsStory object and returns that new object
  public static function loadByID($storyID) {
    $query = sprintf("SELECT * FROM %s WHERE id = %d",
        self::DB_TABLE,
        $GLOBALS['conn']->real_escape_string($storyID)
        );
    $result = $GLOBALS['conn']->query($query);
    if($result->num_rows) {
      $row = $result->fetch_assoc();
      $st = new NewsStory();
      $st->id = $row['id'];
      $st->title = $row['title'];
      $st->body = $row['body'];
      $st->description = $row['description'];
      $st->likes = $row['likes'];
      $st->url = $row['url'];
      $st->url_header = $row['url_header'];
      $st->author = $row['author'];
      $st->author_id = $row['author_id'];
      $st->date = $row['date'];
      $st->img = $row['img'];
      return $st;
    } else {
      return null;
    }
  }

  // Inserts a given story into a database using an SQL command.
  public static function insertStory($story) {
    $query = sprintf("INSERT INTO %s (title, description, url, img, author, author_id) VALUES ('%s', '%s', '%s', '%s', '%s', '%d') ",
      self::DB_TABLE,
      $GLOBALS['conn']->real_escape_string($story->title),
      $GLOBALS['conn']->real_escape_string($story->description),
      $GLOBALS['conn']->real_escape_string($story->url),
      $GLOBALS['conn']->real_escape_string($story->img),
      $story->author,
      $story->author_id
      );
    $result = $GLOBALS['conn']->query($query);
    if($result) {
      $storyID = $GLOBALS['conn']->insert_id;
      $ns = self::loadByID($storyID);
      return $ns;
    } else {
      return null;
    }
  }

  // Deletes a story given a coressponding ID using an SQL command
  public static function deleteStory($id) {

    // Delete the event that is linked with the story first
    $query = sprintf("DELETE FROM %s WHERE %s .post_1_id = %d; ",
      'event',
      'event',
      $id
      );
    $result = $GLOBALS['conn']->query($query);
    //echo $query;
    // Delete the story
    $query = sprintf("DELETE FROM %s WHERE %s .id = %d; ",
      self::DB_TABLE,
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

  // Updates a story's attributes given the story and the new inputs for that story
  public static function updateStory($story, $storyID, $title, $description, $url, $img) {

    $query = sprintf("UPDATE %s SET title = '%s', description = '%s', url = '%s', img = '%s', author = '%s' WHERE id = '%d'",
    self::DB_TABLE,
    $GLOBALS['conn']->real_escape_string($title),
    $GLOBALS['conn']->real_escape_string($description),
    $GLOBALS['conn']->real_escape_string($url),
    $GLOBALS['conn']->real_escape_string($img),
    $story->author,
    $GLOBALS['conn']->real_escape_string($storyID)
    );
    $result = $GLOBALS['conn']->query($query);
    if($result) {
      return $story;
    } else {
      return null;
    }
  }

  // Used to update the likes
  public function update() {
    $query = sprintf("UPDATE %s SET title = '%s', description = '%s', likes = %d, url = '%s', img = '%s', author_id = %d WHERE id = %d ",
      self::DB_TABLE,
      $GLOBALS['conn']->real_escape_string($this->title),
      $GLOBALS['conn']->real_escape_string($this->description),
      $GLOBALS['conn']->real_escape_string($this->likes),
      $GLOBALS['conn']->real_escape_string($this->url),
      $GLOBALS['conn']->real_escape_string($this->img),
      $GLOBALS['conn']->real_escape_string($this->author_id),
      $GLOBALS['conn']->real_escape_string($this->id)
      );
    //echo $query;
    $result = $GLOBALS['conn']->query($query);
    if($result) {
      return $this;
    } else {
      return null;
    }
  }

  // Loads all stories given a keyword
  public static function loadAllStoriesKeyword($keyword) {
    $query = sprintf("SELECT id FROM ".self::DB_TABLE." WHERE title LIKE '%%%s%%'",
    $keyword
  );
    //echo $query;
    $result = $GLOBALS['conn']->query($query);
    if($result->num_rows) {
      $i = 1;
      while($row = $result->fetch_assoc()) {
        $st = self::loadByID($row['id']);
        $stories[$i] = $st;
        $i = $i + 1;
      }
    }
    return $stories;
  }
}
