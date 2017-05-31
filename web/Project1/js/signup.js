/***************************************************************
* SIGN UP JS FILE
* By Kyle West
*
* File contains functions related to retrieving information from
* the server and preproccessing the Signup form.
***************************************************************/

/***************************************************************
* Check that the passwords match and are at least 8 characters
***************************************************************/
function checkPass(elem) {
   // collect needed elements
   var pass1 = document.getElementById('pass');
   var pass2 = document.getElementById('pass_confirmed');
   var errmsg = document.getElementById('errP');

   // return flag
   var okPass = true;

   // check the user defined Passwords
   if (pass1.value != pass2.value && pass2.value.length != 0) {
      if (elem && elem === pass2)
         errmsg.innerHTML = "Passwords Do Not Match";
      okPass = false;
   } else if (pass1.value.length < 8 && pass1.value.length != 0) {
      if (elem && elem === pass1)
         errmsg.innerHTML = "Passwords must be at least 8 characters";
      okPass = false;
   } else {
      errmsg.innerHTML = "";
   }

   return okPass;
}

/***************************************************************
* Ask the server if the username already exists.
***************************************************************/
var okusername = false; // global check flag
function checkUser(elem) {
   // remove whitespace
   elem.value = elem.value.replace(/^\s+|\s+$/gm,'');

   okusername = false;
   var data = "check=user&user="+elem.value;

   // send request`
   var req = new Request("check.php", { post: data });

   // when complete, update error messages
   req.whenDone = function () {
      var errmsg = document.getElementById('errU');
      if (this.response == "duplicate") {
         errmsg.innerHTML = "Username is taken.";
      } else {
         errmsg.innerHTML = "";
         okusername = true;
      }
   }
   req.execute();
}


/***************************************************************
* Runs a full validation to check the scope of the form
***************************************************************/
function validate() {
   return okusername && checkPass();
}
