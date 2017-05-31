<?php
/**************************************************************
* CHECK DATABASE
* by Kyle West
*
* This file is called to retrieve basic boolean info from the
* database (Created for the signup page to validate the username)
**************************************************************/

require "db.php";

// figure out what item we are checking.
$check = htmlspecialchars($_POST["check"]);

// Although switch statements are used typically for multiple
// cases, and this switch only has one, I left it as a switch
// statement to make additional types of queries later.
switch ($check) {
   /********************************************************
   * Check if a given username is a duplicate or not.
   ********************************************************/
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
