<?php
/**************************************************************
* NAVIGATION BAR
* by Kyle West
*
* The basic frame of the application: the side bar and the
* main content frame.
**************************************************************/

// initialize session
session_start();

// ensure we are logged in
if (!isset($_SESSION['username'])) {
   header("Location: login.php");
   die();
}

?>
<tr>
   <td id = "nav">
      <div class="user_row">
         Welcome, <?=$_SESSION['username'];?>
      </div>
      <p class = "outside">Not <?=$_SESSION['username'];?>? <a href = "logout.php">Sign out</a></p>
      <br/>
      <br/>
      <br/>

      <a href="index.php?pg=docs" class="nav_header_link">
         <div class="nav_header">
            Documents
         </div>
      </a>
         <div id = "side_docs" class = "nav_list"></div>
      <br/>
      <br/>

      <a href="index.php?pg=revs" class="nav_header_link">
         <div class="nav_header">
            Reviews
         </div>
      </a>
         <div id = "side_revs" class = "nav_list"></div>
   </td>

   <td id = "main_container">
      <div id = "qdata"></div>
   </td>
</tr>
