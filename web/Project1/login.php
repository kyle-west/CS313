<?php
/**************************************************************
* LOGIN PAGE
* by Kyle West
*
* Provides interface for the user to login. Calls itself to
* proccess its own form. If valid user, set session data with
* valid information, and send user to the home page.
**************************************************************/

// initialize session
session_start();

// Proccess Login submission.
$err = "";
if (isset($_POST["submit"])) {
   // strip user data from script injection
   $user = htmlspecialchars($_POST['usrn']);
   $pass = htmlspecialchars($_POST['pass']);

   // poll database
   require 'db.php';
   $getpass = $db->prepare(
      'SELECT id,password FROM users WHERE username =:username'
   );
   $getpass->bindValue(':username', $user, PDO::PARAM_STR);
   $getpass->execute();

   // if the user exists and passwords match, log user in
   // otherwise ouput standard error message
   if ($passrow = $getpass->fetch(PDO::FETCH_ASSOC)) {
      $hash = $passrow["password"];
      if (password_verify($pass, $hash)) {
         $_SESSION['user_id'] = $passrow["id"];
         $_SESSION['username'] = $user;
         header("Location: index.php");
         die();
      } else {
         $err = "Username or password incorrect.";
      }
   } else {
      $err = "Username or password incorrect.";
   }

}
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <link rel="stylesheet" href="css/login.css">
      <title>Peerfessional - Sign In</title>
   </head>
   <body onload="document.getElementById('usrn').focus();">
      <h1>Peerfessional Login</h1>
      <div class = "content">
         <form class="" action="login.php" method="post">
            <table>
               <tr>
                  <td><label for="usrn">Username:</label></td>
                  <td class="right"><input id = "usrn" type="text" name="usrn" value="" placeholder="you123"></td>
               </tr>
               <tr>
                  <td><label for="pass">Password:</label></td>
                  <td class="right"><input id = "pass" type="password" name="pass" value=""></td>
               </tr>
            </table>
            <p class = "err1"><?=$err?><p>
            <input type="submit" name="submit" value="Login">
         </form>
      </div>
      <div id = "sidenote">
         Don't have an account?
         <input type="button" value = "Sign Up!"
                onclick="window.location.href = 'signup.php'"/>
      </div>
   </body>
</html>
