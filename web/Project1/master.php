<?php

   $__company = "Peerfessional";

   $__global_head = "
      <link rel='stylesheet' href='css/base.css'/>
      <link rel='stylesheet' href='css/colors.css'/>
      <link rel='stylesheet' href='css/popup.css'/>
      <link rel='stylesheet' href='css/buttons.css'/>
      <link rel='stylesheet' href='css/modal.css'/>
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
