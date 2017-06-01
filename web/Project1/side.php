<?php
/**************************************************************
* GET SIDE BAR CONTENTS
* by Kyle West
*
* Connects to the DB and retrieves information reguarding the
* top documents and reviews owned/assigned to this user. This
* is expected to return information to the side bar of the
* main application and formats data accordingly.
**************************************************************/
// initialize everything
require 'db.php';
session_start();

// ensure we are logged in
if (!isset($_SESSION['username'])) {
   header("Location: login.php");
   die();
}

// Check the part of the sidebar we are looking for
$part = $_GET['part'];
switch ($part) {
   /*************************************************
   * Pull the top three documents from the DB
   *************************************************/
   case "docs":
      $statement = $db->prepare(
         'SELECT DISTINCT ON (d.filename)
          d.filename AS "file"
          FROM documents d FULL JOIN reviews r
          ON d.id = r.doc_id
          INNER JOIN users u
          ON u.id = d.user_id
          WHERE u.username = :username
          GROUP BY d.id, r.status
          ORDER BY d.filename
          LIMIT 3;'
      );
      $statement->bindValue(':username', $_SESSION["username"], PDO::PARAM_STR);
      $statement->execute();
      while ($row = $statement->fetch(PDO::FETCH_ASSOC))
      { ?>
         <p><?=$row["file"];?></p>
      <?php }
      break;

   /*************************************************
   * Pull the top three reviews from the DB
   *************************************************/
   case "revs":
      $statement = $db->prepare(
         'SELECT d.filename AS "file",
                 u.username AS "owned",
                 d.page_count AS "pcount",
                 r.status   AS "status"
         FROM documents d INNER JOIN reviews r
         ON d.id = r.doc_id
         INNER JOIN users u
         ON u.id = d.user_id
         WHERE r.reviewer = :user_id
         ORDER BY r.status, d.filename
         LIMIT 3;'
      );
      $statement->bindValue(':user_id', $_SESSION["user_id"], PDO::PARAM_STR);
      $statement->execute();
      while ($row = $statement->fetch(PDO::FETCH_ASSOC))
      { ?>
         <p><?=$row["file"];?></p>
      <?php }
      break;

   // ensure nothing happens if not valid page type.
   default: die();
}
?>
