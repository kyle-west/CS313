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
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src = "js/request_handler.js"></script>
      <script src = "js/load_content.js"></script>
      <script src = "js/update_server.js"></script>
      <script src = "js/buttons.js"></script>
      <?=$__global_head;?>
   </head>
   <body>
      <div id = "modal" onclick="">
         <span id = "exit" onclick="modalOff();">x</span>
         <div id="modal_content" onclick="">
            <p>TEST</p>
         </div>
      </div>

      <table id = "main" class = "content">
         <?php require 'nav.php'; ?>
      </table>

      <script>
         get_contents("<?=$current_page;?>");
         load_side_contents();
      </script>
   </body>
</html>
