<?php

  //DB params get via env variables
  define('DB_HOST' , getenv('MYSQL_HOST'));
  define('DB_USER' , getenv('MYSQL_USER'));
  define('DB_PASS' , getenv('MYSQL_ROOT_PASSWORD'));
  define('DB_NAME' , 'shareposts');

  // App Root
  define('APPROOT' , dirname(dirname(__FILE__)));
  
  // URL Root
  define('URLROOT' , 'http://localhost/shareposts');

  //Site name
  define('SITENAME' , 'SharePosts');

?>