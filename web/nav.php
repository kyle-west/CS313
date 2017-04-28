<?php
   // from Brother Burton's TA2 solution on github
   // collcects the file name of the file that called us.
   $file = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
?>
<div>
   <h1 class = " block logo_text">
      Lexifex &lt;<span>Code&nbsp;Builders</span>&gt;
   </h1>
   <div class="block nav">
      <ul>
         <li class = "<?php if ($file == "index") print "active"?>">
            <a href="index.php">About Us</a>
         </li>
         <li class = "<?php if ($file == "assignments") print "active"?>">
            <a href="assignments.php">CS 313 Assignments</a>
         </li>
         <!-- The following is an external link and will never be "active" on our severs -->
         <li class = "right">
            <a href="https://github.com/kyle-west/CS313">Check us out on GitHub!</a>
         </li>
      </ul>
   </div>
</div>
