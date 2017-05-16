/******************************************
* Make the formal AJAX request to a PHP
* Query application.
*******************************************/
function load_side_contents_docs()
{
   docs_query = new XMLHttpRequest();

   if (docs_query != null)
   {
      docs_query.onreadystatechange = fill_side_docs;
      docs_query.open("GET", "side.php" + "?part=docs", true);
      docs_query.send(null);
      console.log("LOADING docs");
   }
}

/******************************************
* Make the formal AJAX request to a PHP
* Query application.
*******************************************/
function load_side_contents_revs()
{
   revs_query = new XMLHttpRequest();

   if (revs_query != null)
   {
      revs_query.onreadystatechange = fill_side_revs;
      revs_query.open("GET", "side.php" + "?part=revs", true);
      revs_query.send(null);
      console.log("LOADING revs");
   }
}

/******************************************
* Insert query result into Webpage
*******************************************/
function fill_side_docs()
{
   var dom = document.getElementById("side_docs");
   switch (docs_query.readyState)
   {
      case 4:
         if (docs_query.status == 200)
         {
            dom.innerHTML = docs_query.responseText;
         }
         else
         {
            dom.innerHTML = "--- ---";
         }
         break;
   }
}
/******************************************
* Insert query result into Webpage
*******************************************/
function fill_side_revs()
{
   var dom = document.getElementById("side_revs");
   switch (revs_query.readyState)
   {
      case 4:
         if (revs_query.status == 200)
         {
            dom.innerHTML = revs_query.responseText;
         }
         else
         {
            dom.innerHTML = "--- ---";
         }
         break;
   }
}
