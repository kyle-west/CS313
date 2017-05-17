<?php
// initialize session
session_start();
try
{
      $user = 'postgres';
      if ($_SERVER['HTTP_HOST'] == "https://pure-hamlet-55952.herokuapp.com") {
         $password = '';
      } else $password = '7510';
      $db = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=cs313', $user, $password);
   }
   catch (PDOException $ex)
   {
      echo 'Error!: ' . $ex->getMessage();
      die();
   }
?>
