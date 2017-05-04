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
            <a class = "underline_hover" href="helloworld.php">
               <h1>Hello World</h1>
            </a>
            <p>
               This classic message has been shared in countless languages.
               <i>Hello World</i> not only celebrates the triumph of man over
               machine, but represents the subtle victory that new programmers
               experience when it all finally works.
            </p>
         </div>
         <div class="block_content">
            <a class = "underline_hover"
               href="http://mckenzieclarke.com/illustrations.php">
               <h1>PHP Shopping Cart</h1>
            </a>
            <p>
               I got permission from Brother Burton to use a site that I have
               done in real life. This is the website I made for my wife, so
               all the art on it is real and actually avaliable for purchase.
               It does not use any databases and everything is stored in
               session and local variables.
            </p>
         </div>
         <div class="block_content">
            <p>
               [other projects coming soon]
            </p>
         </div>
      </div>

      <br/>
      <br/>
      <br/>
      <br/>
      <br/>
      <br/>

      <script src="js/background_render.js"></script>
   </body>
</html>
