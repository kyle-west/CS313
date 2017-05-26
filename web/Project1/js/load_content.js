/***************************************************************
* CONTENT LOADING FROM SERVER
* By Kyle West
*
* File contains functions related to retrieving information from
* the server for the main page contents.
***************************************************************/

/******************************************
* Collect page contents from serverside
*******************************************/
function get_contents(page)
{
   var req = new Request(
      "content.php",
      { get: "type=" + page },
      document.getElementById("qdata")
   );

   // attach additional onclicks to small cancel buttons
   switch (page) {
      case "docs":
         req.ifSuccess = function () {
            $(".firepeer").click(function(event) {
               event.stopPropagation();
            });
         }
         break;
   }

   req.execute();
}


/******************************************
* Collect sidebar contents from serverside
*******************************************/
function load_side_contents()
{
   // documents sidebar
   new Request(
      "side.php",
      { get: "part=docs" },
      document.getElementById("side_docs")
   ).execute();

   // reviews sidebar
   new Request(
      "side.php",
      { get: "part=revs" },
      document.getElementById("side_revs")
   ).execute();
}
