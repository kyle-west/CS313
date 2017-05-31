<?php
   // initialize session
   session_start();

   if (isset($_POST["username"])) {
      $_SESSION["username"] = $_POST["username"];
      require 'db.php';
      $statement = $db->prepare(
         'SELECT * FROM users WHERE username =:username'
      );
      $statement->bindValue(':username', $_SESSION["username"], PDO::PARAM_STR);
      $statement->execute();
      $row = $statement->fetch(PDO::FETCH_ASSOC);
      $_SESSION['user_id'] = $row["id"];
      header("Location: index.php");
   } else {
      echo "[NOT SIGNED IN]";
   }

 ?>
<br/>
<br/>
<br/>
<form class="" action="login.php" method="post">
   <button type="submit" name="username" value="test1">Login as Test User 1</button>
   <br/>
   <br/>
   <button type="submit" name="username" value="test7">Login as Test User 7</button>
   <br/>
   <br/>
   <button type="submit" name="username" value="test9">Login as Test User 9</button>
</form>
<br/>
<br/>
<br/>
<br/>
<button onclick = "window.location.href = 'logout.php';" >Log out</button>
