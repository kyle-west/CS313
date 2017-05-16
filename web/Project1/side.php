
<?php
   // initialize everything
   require 'db.php';
   session_start();

   $part = $_GET['part'];

   // echo $_SESSION["user_id"]." | ".$_SESSION["username"]." | ".$type."<br/><br/><br/>";

   switch ($part) {
      /*************************************************
      *
      *************************************************/
      case "docs":
         $statement = $db->prepare(
            'SELECT d.filename AS "file",
                   d.page_count AS "pcount",
                   (SELECT username FROM users WHERE id = r.reviewer) AS "reviewed",
                   r.status   AS "status"
            FROM documents d FULL JOIN reviews r
            ON d.id = r.doc_id
            INNER JOIN users u
            ON u.id = d.user_id
            WHERE u.username =:username
            ORDER BY r.status, d.filename
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
      *
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
