<?php

require "db.php";

session_start();

if (!isset($_SESSION['username'])) {
   header("Location: login.php");
   die();
}

$view = htmlspecialchars($_GET["view"]);

switch ($view) {
   case "modal_select_peer":
      $statement = $db->prepare(
         'SELECT username, ranking
          FROM users
          WHERE username NOT IN (\'admin\',:username)
          ORDER BY ranking DESC;'
      );
      $statement->bindValue(':username', $_SESSION["username"], PDO::PARAM_STR);
      $statement->execute();

      print "<div id = 'rev_opt_head'><table class = 'rev_opt_head'>";
      print "<tr> <th>Peer to Review</th> <th>Their Ranking</th> </tr>";
      print "</table></div>";
      print "<table id = 'modal_select_peer'>";
      while ($row = $statement->fetch(PDO::FETCH_ASSOC))
      {
         print "<tr class = 'blank'><td></td><td></td><td></td><td></td></tr>";
         print "<tr class = 'rev_opt' onclick = 'selectRev(this)' ";
         print "data-reviewer = '".$row['username']."'";
         print "><td>".$row['username']."</td>";
         print "<td>";
         for ($i = 0; $i < $row['ranking']; $i++) {
            print " &#9733;";
         }
         print "</td></tr>";
      }
      print "</table>";
      break;
}

?>
