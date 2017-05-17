<?php
// initialize session
session_start();
try
{
   if ($_SERVER['HTTP_HOST'] == "https://pure-hamlet-55952.herokuapp.com") {
         $password = '';
         $user = 'postgres';
         $db = new PDO('pgsql:host=https://pure-hamlet-55952.herokuapp.com;port=5432;dbname=pure-hamlet-55952::DATABASE', $user, $password);
      } else {
         $password = '7510';
         $user = 'postgres';
         $db = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=cs313', $user, $password);
      }
   }
   catch (PDOException $ex)
   {
      echo 'Error!: ' . $ex->getMessage();
      die();
   }
?>
