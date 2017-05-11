<?php
   // initialize session
   session_start();

?>
<tr>
   <td id = "nav">
      <div class="user_row">
         Welcome, <?=$_SESSION['username'];?>
      </div>
      <p>Not <?=$_SESSION['username'];?>? <a href = "logout.php">Sign out</a></p>
      <br/>
      <br/>
      <br/>

      <a href="index.php?pg=docs" class="nav_header_link">
         <div class="nav_header">
            Documents
         </div>
      </a>
      <br/>
      <br/>

      <a href="index.php?pg=revs" class="nav_header_link">
         <div class="nav_header">
            Reviews
         </div>
      </a>
   </td>

   <td id = "main_container">
      <div id = "qdata">SERVER GENERATED CONTENT</div>
   </td>
</tr>
