<?php

require "db.php";

$check = htmlspecialchars($_POST["check"]);

switch ($check) {
   case "user":
      $query = 'SELECT username FROM users WHERE username = :username';

      $statement = $db->prepare($query);
      $statement->bindValue(
         ':username',
         htmlspecialchars($_POST["user"]),
         PDO::PARAM_STR
      );
      $statement->execute();
      if ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
         print "duplicate";
      } else {
         print "free";
      }
      break;
}

?>
