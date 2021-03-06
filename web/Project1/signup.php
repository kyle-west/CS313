<?php
/**************************************************************
* SIGNUP PAGE
* by Kyle West
*
* Provides interface for the user to create an account. Calls
* itself to proccess its own form. If valid info, create new
* user on the DB, and send user to the home page.
**************************************************************/
// initialize session
session_start();

// Error messages
$err = "";
$errU = "";

// Proccess the data for creating a new user
if (isset($_POST["submit"])) {
   // collect and sanitize the contents
   $user = htmlspecialchars($_POST['usrn']);
   $pass = htmlspecialchars($_POST['pass']);
   $pass2 = htmlspecialchars($_POST['passc']);
   $len = strlen($pass);

   if ($len < 8) { // check valid length
      $err = "Passwords must be a minimum of 8 letters.";
   } else if ($pass != $pass2) { // check if the passwords are the same
      $err = "Passwords do not match.";
   } else {
      // check if user exists
      require 'db.php';
      $statement = $db->prepare(
         'SELECT username FROM users WHERE username =:username'
      );
      $statement->bindValue(':username', $user, PDO::PARAM_STR);
      $statement->execute();

      // if user exists already, print error message
      // otherwise insert the new user into the DB
      if ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
         $errU = "'$user' is taken.";
      } else if (!empty($user) && !empty($pass)){
         $newuser = $db->prepare(
            'INSERT INTO users (username, password) VALUES (:user, :pass)'
         );
         $newuser->bindValue(':user', $user, PDO::PARAM_STR);
         $newuser->bindValue(':pass', password_hash($pass, PASSWORD_DEFAULT));
         $newuser->execute();
         header("Location: login.php");
         die();
      }
   }
}
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <link rel="stylesheet" href="css/login.css">
      <title>Sign Up!</title>
      <script type="text/javascript" src = "js/signup.js"></script>
      <script type="text/javascript" src = "js/request_handler.js"></script>
   </head>
   <body onload="document.getElementById('usrn').focus();">
      <h1>Sign Up for a Peerfessional Account!</h1>
      <div class = "content">
         <form class="" action="signup.php" method="post" onsubmit="return validate();">
            <table class = "fillbox">
               <tr>
                  <td>Please Enter a new Username: </td>
                  <td class="right">
                     <input id = "usrn" type="text" name="usrn" value="" placeholder="you123"
                            onchange="checkUser(this);">
                  </td>
               </tr>
               <tr>
                  <td></td>
                  <td class="right err_gen"><span id = "errU"></span></td>
               </tr>
               <tr>
                  <td><label for="pass">Type a password:</label></td>
                  <td class="right">
                     <input id = "pass" type="password" name="pass" value=""
                            onblur = "checkPass(this);"/>
                  </td>
               </tr>
               <tr>
                  <td><label for="pass">Confirm Password:</label></td>
                  <td class="right">
                     <input id = "pass_confirmed" type="password" value="" name="passc"
                            onblur = "checkPass(this);"/>
                  </td>
               </tr>
               <tr>
                  <td></td>
                  <td class="right err_gen"><span id = "errP"></span></td>
               </tr>
            </table>
            <p class = "err1"><?=$err?><p>
            <input type="submit" name="submit" value="Sign Up for Peerfessional!"/>
         </form>
      </div>
      <div id = "sidenote">
         Already have an account?
         <input type="button" value = "Login!"
                onclick="window.location.href = 'login.php'"/>
      </div>
   </body>
</html>
