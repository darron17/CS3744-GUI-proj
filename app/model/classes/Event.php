<?php
// Contains the attributes for Event objects and functions these objects use.

// Event class
class Event {
  public $id;
  public $event_type;
  public $user_1_id;
  public $user_2_id;
  public $post_1_id;
  public $post_2_id;
  public $data_1;
  public $data_2;
  public $date;
  const DB_TABLE = 'event';
  const EVENT_TYPE = array(
    'add_story' => 210,
    'view_profile' => 220,
    'edit_story' => 230,
    'edit_profile' => 240,
    'changed_role' => 250
  );

  // Loads the users and organizes them based on id in ascending order.
  public static function loadAllEvents() {

    $events = array();

    $query = "SELECT id FROM ".self::DB_TABLE." ORDER BY date DESC";
    $result = $GLOBALS['conn']->query($query);
    if($result->num_rows) {
      while($row = $result->fetch_assoc()) {
        $e = self::loadByID($row['id']);
        $events[$row['id']] = $e;
      }
    }
    return $events;
  }



  // Given a story id, loads the corresponding story. Stores the data from the loaded
  // story into a new NewsStory object and returns that new object
  public static function loadByID($eventID) {
    $query = sprintf("SELECT * FROM %s WHERE id = %d",
        self::DB_TABLE,
        $GLOBALS['conn']->real_escape_string($eventID)
        );

    $result = $GLOBALS['conn']->query($query);
    if($result->num_rows) {
      $row = $result->fetch_assoc();
      $e = new Event();
      $e->id = $row['id'];
      $e->event_type = $row['event_type'];
      $e->user_1_id = $row['user_1_id'];
      $e->user_2_id = $row['user_2_id'];
      $e->post_1_id = $row['post_1_id'];
      $e->post_2_id = $row['post_2_id'];
      $e->data_1 = $row['data_1'];
      $e->data_2 = $row['data_2'];
      $e->date = $row['date'];
      return $e;
    } else {
      return null;
    }
  }

  // Checks if a given variable is null
  private static function checkIfNull($val) {
    if($val == null) {
      return 'NULL';
    }
    elseif(is_numeric($val)) {
      return $val;
    }
    else {
      return "'".$val."'";
    }
  }

  // Inserts a given story into a database using an SQL command.
  public static function insertEvent($event) {
    $query = sprintf("INSERT INTO %s (event_type, user_1_id, user_2_id, post_1_id, post_2_id, data_1, data_2) VALUES (%d, %d, %s, %s, %s, %s, %s); ",
      self::DB_TABLE,
      $GLOBALS['conn']->real_escape_string($event->event_type),
      $GLOBALS['conn']->real_escape_string($event->user_1_id),
      self::checkIfNull($GLOBALS['conn']->real_escape_string($event->user_2_id)),
      self::checkIfNull($GLOBALS['conn']->real_escape_string($event->post_1_id)),
      self::checkIfNull($GLOBALS['conn']->real_escape_string($event->post_2_id)),
      self::checkIfNull($GLOBALS['conn']->real_escape_string($event->data_1)),
      self::checkIfNull($GLOBALS['conn']->real_escape_string($event->data_2))
      );

    $result = $GLOBALS['conn']->query($query);
    if($result) {
      $eventID = $GLOBALS['conn']->insert_id;
      $e = self::loadByID($eventID);
      return $e;
    } else {
      return null;
    }
  }
}
