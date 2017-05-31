<?php
/**************************************************************
* CHECK DATABASE 
* by Kyle West
*
* This file is called to retrieve basic boolean info from the
* database (Created for the signup page to validate the username)
**************************************************************/

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
