<!DOCTYPE html>
<html>
  <head>
    <title>მონაცემთა ბაზის ატვირთვა</title>
  </head>
  <body>

    <h3>იტვირთება...</h3>

<?php
  require_once 'functions.php';

  createTable('members',
              'user VARCHAR(20),
              pass VARCHAR(255),
              first_name VARCHAR(16),
              last_name VARCHAR(16),
              city VARCHAR(30),
              INDEX(user(6))');

  createTable('messages', 
              'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              auth VARCHAR(16),
              recip VARCHAR(16),
              pm CHAR(1),
              time INT UNSIGNED,
              message VARCHAR(4096),
              INDEX(auth(6)),
              INDEX(recip(6))');

  createTable('friends',
              'user VARCHAR(16),
              friend VARCHAR(16),
              INDEX(user(6)),
              INDEX(friend(6))');

  createTable('profiles',
              'user VARCHAR(16),
              text VARCHAR(4096),
              INDEX(user(6))');
?>

    <br>...დასრულდა.
  </body>
</html>
