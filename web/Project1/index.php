<?php

   // initialize session
   session_start();
   require 'master.php';

   if (!isset($_SESSION['username'])) {
      // TODO: Kick out user to login instead of this...
      $_SESSION['username'] = "DevMaster";
   }

   // set up "page" we are on
   $current_page = $_GET['pg'];
   if (!validPage($current_page)) {
      $current_page = "docs";
   }

?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title><?=$__company;?></title>
      <link rel="stylesheet" href="css/master.css"/>
      <script src = "js/load_content.js"></script>
      <?=$__global_head;?>
   </head>
   <body>
      <table class = "content">
         <?php require 'nav.php'; ?>
      </table>

      <script>
         get_contents("<?=$current_page;?>");
      </script>
   </body>
</html>
