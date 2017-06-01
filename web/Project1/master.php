<?php
/**************************************************************
* MASTER GLOBALS
* by Kyle West
*
* Contains useful application wide information and functions
* that can be user in multiple places in the application
**************************************************************/

// our company title
$__company = "Peerfessional";

// common head tags
$__global_head = "
   <link rel='stylesheet' href='css/base.css'/>
   <link rel='stylesheet' href='css/colors.css'/>
   <link rel='stylesheet' href='css/popup.css'/>
   <link rel='stylesheet' href='css/buttons.css'/>
   <link rel='stylesheet' href='css/modal.css'/>
";

/*****************************************************
* determines if a subpage is of a valid type.
*****************************************************/
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
