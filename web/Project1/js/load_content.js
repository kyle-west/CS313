/******************************************
* Make the formal AJAX request to a PHP
* Query application.
*******************************************/
function get_contents(page)
{
   new Request(
      "content.php",
      { get: "type=" + page },
      document.getElementById("qdata")
   ).execute();
}


/******************************************
* Make the formal AJAX request to a PHP
* Query application.
*******************************************/
function load_side_contents()
{
   new Request(
      "side.php",
      { get: "part=docs" },
      document.getElementById("side_docs")
   ).execute();
   new Request(
      "side.php",
      { get: "part=revs" },
      document.getElementById("side_revs")
   ).execute();
}
