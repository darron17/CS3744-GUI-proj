<?php

set_include_path(dirname(__FILE__));

include_once 'config.php';

// Starts the session
session_start();

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME)
  or die ('Error: '.$conn->connect_error);

// class autoloader
spl_autoload_register(function($class_name) {
  include SYSTEM_PATH.'/model/classes/'.$class_name.'.php';
});
