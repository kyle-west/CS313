<table id = "server_table">
<?php
   // initialize everything
   require 'db.php';
   session_start();

   $type = $_GET['type'];

   // echo $_SESSION["user_id"]." | ".$_SESSION["username"]." | ".$type."<br/><br/><br/>";

   switch ($type) {
      /*************************************************
      *
      *************************************************/
      case "docs":
         print "<h1 class = 'content_header'> Your Documents, Master ".$_SESSION["username"]."</h1>";
         print "<tr> <th>File</th> <th>Page Count</th> <th>Reviewed By</th> <th>Status</th> </tr>";
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
            ORDER BY r.status, d.filename;'
         );
         $statement->bindValue(':username', $_SESSION["username"], PDO::PARAM_STR);
         $statement->execute();
         while ($row = $statement->fetch(PDO::FETCH_ASSOC))
         { ?>
            <tr class = "blank">
               <td></td><td></td><td></td><td></td>
            </tr>
            <tr>
               <td><?=$row["file"];?></td>
               <td><?=$row["pcount"];?></td>
               <td>
                  <?php
                     if (!empty($row["reviewed"])) {
                        echo $row["reviewed"];
                     } else {
                        echo "<input type = 'button' onclick = '' value = 'Select a Reviewer!'/>";
                     }
                  ?>
               </td>
               <td><?=$row["status"];?></td>
            </tr>
         <?php }
         break;

      /*************************************************
      *
      *************************************************/
      case "revs":
         print "<h1 class = 'content_header'> The Following Documents Need Your Feedback, Sir ".$_SESSION["username"]."</h1>";
         print "<tr> <th>From</th> <th>File</th> <th>Page Count</th><th>Action</th></tr>";
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
            ORDER BY r.status, d.filename;'
         );
         $statement->bindValue(':user_id', $_SESSION["user_id"], PDO::PARAM_STR);
         $statement->execute();
         while ($row = $statement->fetch(PDO::FETCH_ASSOC))
         { ?>
            <tr class = "blank">
               <td></td><td></td><td></td><td></td>
            </tr>
            <tr>
               <td><?=$row["owned"];?></td>
               <td><?=$row["file"];?></td>
               <td><?=$row["pcount"];?></td>
               <td>
                  <?php
                     switch ($row["status"]) {
                        case 0:
                           echo "<input type = 'button' onclick = '' value = 'Start Reviewing'/>";
                           break;
                        default:
                           echo "<input type = 'button' onclick = '' value = 'Continue Review'/>";
                           echo "<input type = 'button' onclick = '' value = 'Mark Done'/>";
                           break;
                     }
                  ?>
               </td>
            </tr>
         <?php }
         break;

      // ensure nothing happens if not valid page type.
      default: die();
   }
?>
</table>
