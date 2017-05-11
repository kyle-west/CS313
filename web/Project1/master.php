<?php

   $__company = "Peerfessional";

   $__global_head = "
      <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
   ";

   function validPage($page) {
      switch ($page) {
         case 'docs':
         case 'revs':
            return true;
         default:
            return false;
      }
   }

?>
