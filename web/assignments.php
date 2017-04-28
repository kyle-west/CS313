<!DOCTYPE html>
<html>
   <head>
      <?php require("head.php"); ?>
   </head>
   <body>
      <canvas id = "canvas">
         Your browser is not good enough to hand this code.
      </canvas>

      <div id = "main_container">
         <?php require("nav.php"); ?>

         <div class="block_content">
            <a class = "underline_hover" href="helloworld.php"><h1>Assignment 0</h1></a>
            <p>
               This classic message has been shared in countless languages.
               <i>Hello World</i> not only celebrates the triumph of man over
               machine, but represents the subtle victory that new programmers
               experience when it all finally works.
            </p>
         </div>
         <div class="block_content">
            <p>
               [other projects coming soon]
            </p>
         </div>
      </div>

      <script src="js/background_render.js"></script>
   </body>
</html>
