<?php
   
   // the classic message
   $hello = "Hello World!";
   
   // Print out each letter of the message with each letter increasing in size.
   for ($i = 0; $i < strlen($hello); $i++) {
      print "<span style = 'font-size:".(($i+5)*10)."pt;'>".$hello[$i]."<span>";
   }

?>