/******************************************
* Make the formal AJAX request to a PHP
* Query application.
*******************************************/
function get_contents(page)
{
   xmlhttp = new XMLHttpRequest();

   if (xmlhttp != null)
   {
      xmlhttp.onreadystatechange = stateChange;
      xmlhttp.open("GET", "content.php" + "?type=" + page, true);
      xmlhttp.send(null);
   }
   else
   {
      alert("Your browser is too out of date to proccess request.");
   }
}

/******************************************
* Insert query result into Webpage
*******************************************/
function stateChange()
{
   var dom = document.getElementById("qdata");
   switch (xmlhttp.readyState)
   {
      case 0:
      case 1:
      case 2: // insert and update a progress bar to tell the user
      case 3: //    how the request is going.
         dom.innerHTML = "<br/><div class = 'progress_bar'>"+
            "<p>Loading Content</p>"+
            "<progress value='"+ xmlhttp.readyState +
            "' max='5'></progress></div>";
         break;

      // once the request is complete, embed the new HTML and then
      // execute the scripts we are expecting.
      case 4:
         if (xmlhttp.status == 200)
         {
            dom.innerHTML = xmlhttp.responseText;
         }
         else
         {
            dom.innerHTML = "Problem retrieving data -- Server Error 666";
         }
         break;
   }
}
