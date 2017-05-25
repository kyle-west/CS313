<table id = "server_table">
<?php
   // initialize everything
   require 'db.php';
   require 'db_translate.php';
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
                   r.status   AS "status",
                   d.id AS "id"
            FROM documents d FULL JOIN reviews r
            ON d.id = r.doc_id
            INNER JOIN users u
            ON u.id = d.user_id
            WHERE u.username =:username
            ORDER BY d.filename,r.status;'
         );
         $statement->bindValue(':username', $_SESSION["username"], PDO::PARAM_STR);
         $statement->execute();
         $last_id = -1;
         while ($row = $statement->fetch(PDO::FETCH_ASSOC))
         {
            if ($last_id != $row["id"]) { ?>
               <tr class = "blank">
                  <td></td><td></td><td></td><td></td>
               </tr>
               <tr onclick = "selectRow(this);" id = '<?=$row["id"];?>' data-name = '<?=$row["file"];?>' class = "data_row">
                  <td>
                     <span ondblclick="editText(this);" data-row-id = "<?=$row["id"];?>">
                     <?=$row["file"];?></span>
                  </td>
                  <td><?=$row["pcount"];?></td>
                  <td><?=$row["reviewed"];?></td>
                  <td><?=evaluteReviewStatus($row["status"]);?></td>
               </tr>
               <?php
               $last_id = $row['id'];
            } else { ?>
               <tr data-tied-to = '<?=$row["id"];?>'  class = "data_row_assoc" onclick="selectAssocRow(this)">
                  <td></td>
                  <td></td>
                  <td>
                     <?php
                        if (!empty($row["reviewed"])) {
                           echo $row["reviewed"];
                        } else {
                           echo "<input type = 'button' onclick = 'buttons.docs.send();' value = 'Select a Reviewer!'/>";
                        }
                     ?>
                  </td>
                  <td><?=evaluteReviewStatus($row["status"]);?></td>
               </tr>
            <?php }
         }
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
                        case -9:echo "[Rejected]"; break;
                        case 1:
                           echo "<input type = 'button' onclick = '' value = 'Accept'/>";
                           echo "<input type = 'button' onclick = '' value = 'Reject'/>";
                           break;
                        case 2:
                           echo "<input type = 'button' onclick = '' value = 'Review'/>";
                           echo "<input type = 'button' onclick = '' value = 'Send Back'/>";
                           break;
                        case 3:echo "[Completed]"; break;
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

<div class = "button_row">
   <?php if ($type == "docs") { ?>
      <div class="button plus left" onclick = "buttons.docs.plus();"
           id = "plus" title = 'Upload New Document'>
         <div class="content">
            +
         </div>
      </div>

      <div class="button question left" onclick = "buttons.docs.help();"
           id = "help" title = 'Help Menu'>
         <div class="content">
            ?
         </div>
      </div>

      <div class="button minus right show_on_selected"
           onclick = "buttons.docs.minus();" id = "minus" title = 'Remove Selected'>
         <div class="content">
            <img src="imgs/trash.png"/>
         </div>
      </div>

      <div class="button send right show_on_selected"
      onclick = "buttons.docs.send();" id = "send" title = 'Send to Peer'>
      <div class="content">
         <img src="imgs/send2.png" id = 'send_icon'/>
      </div>
   </div>
   <?php } ?>
</div>

<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
