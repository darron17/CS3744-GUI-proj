<?php
// Contains the attributes for User objects and functions these objects use.

// User class
class User {
  public $id;
  public $username;
  public $password;
  public $role;
  public $email;
  public $first;
  public $last;
  public $experience;
  const DB_TABLE = 'user';
  const ROLE = array(
    'admin' => 0,
    'passive' => 1,
    'active' => 2
  );

  // Loads the users and organizes them based on id in ascending order.
  public static function loadAllUsers() {

    $users = array();

    $query = "SELECT id FROM ".self::DB_TABLE." ORDER BY id ASC";
    $result = $GLOBALS['conn']->query($query);
    if($result->num_rows) {
      while($row = $result->fetch_assoc()) {
        $u = self::loadByID($row['id']);
        $users[$row['id']] = $u;
      }
    }
    return $users;
  }

  // Loads the user from the name
  public static function loadByUsername($username) {
    $query = sprintf("SELECT id FROM %s WHERE username = '%s'",
        self::DB_TABLE,
        $GLOBALS['conn']->real_escape_string($username)
        );

    $result = $GLOBALS['conn']->query($query);
    if($result->num_rows) {
      $row = $result->fetch_assoc();
      return self::loadByID($row['id']);
    } else {
      return null;
    }
  }


  // Given a story id, loads the corresponding story. Stores the data from the loaded
  // story into a new NewsStory object and returns that new object
  public static function loadByID($userID) {
    $query = sprintf("SELECT * FROM %s WHERE id = %d",
        self::DB_TABLE,
        $GLOBALS['conn']->real_escape_string($userID)
        );

    $result = $GLOBALS['conn']->query($query);
    if($result->num_rows) {
      $row = $result->fetch_assoc();
      $u = new User();
      $u->id = $row['id'];
      $u->username = $row['username'];
      $u->password = $row['password'];
      $u->role = $row['role'];
      $u->email = $row['email'];
      $u->first = $row['first'];
      $u->last = $row['last'];
      $u->experience = $row['experience'];
      return $u;
    } else {
      return null;
    }
  }

  // Updates the user info on the sql
  public static function updateUser($password, $first, $last, $email, $experience, $userID) {

    $query = sprintf("UPDATE %s SET password = '%s', first = '%s', last = '%s', email = '%s', experience = '%s' WHERE id = %d",
    self::DB_TABLE,
    $GLOBALS['conn']->real_escape_string($password),
    $GLOBALS['conn']->real_escape_string($first),
    $GLOBALS['conn']->real_escape_string($last),
    $GLOBALS['conn']->real_escape_string($email),
    $GLOBALS['conn']->real_escape_string($experience),
    $GLOBALS['conn']->real_escape_string($userID)
    );
    $result = $GLOBALS['conn']->query($query);
    if($result) {
      return $story;
    } else {
      return null;
    }
  }

  // Updates the role of the given user
  public static function updateRole($user, $role, $id) {

    $query = sprintf("UPDATE %s SET role = %d WHERE id = %d",
    self::DB_TABLE,
    $GLOBALS['conn']->real_escape_string($role),
    $GLOBALS['conn']->real_escape_string($id)
    );
    $result = $GLOBALS['conn']->query($query);
    if($result) {
      return $user;
    } else {
      return null;
    }
  }

  // Adds a user given the user's information
  public static function newUser($user) {

    $query = sprintf("INSERT INTO %s (username, password, role, email, first, last, experience) VALUES ('%s', '%s', '%d', '%s', '%s', '%s', '%s') ",
    self::DB_TABLE,
    $GLOBALS['conn']->real_escape_string($user->username),
    $GLOBALS['conn']->real_escape_string($user->password),
    $GLOBALS['conn']->real_escape_string($user->role),
    $GLOBALS['conn']->real_escape_string($user->email),
    $GLOBALS['conn']->real_escape_string($user->first),
    $GLOBALS['conn']->real_escape_string($user->last),
    $GLOBALS['conn']->real_escape_string($user->experience)
    );
    //echo $query;
    $result = $GLOBALS['conn']->query($query);
    if($result) {
      $id = $GLOBALS['conn']->insert_id;
      $user->id = $id;
      return $user;
    } else {
      return null;
    }
  }

}
