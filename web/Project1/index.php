<?php

   // initialize session
   session_start();
   require 'master.php';

   if (!isset($_SESSION['username'])) {
      header("Location: login.php");
      die();
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
      <script src = "js/load_content.js"></script>
      <script src = "js/side_content.js"></script>
      <?=$__global_head;?>
   </head>
   <body>
      <table class = "content">
         <?php require 'nav.php'; ?>
      </table>

      <script>
         get_contents("<?=$current_page;?>");
         load_side_contents_docs();
         load_side_contents_revs();
      </script>
   </body>
</html>
