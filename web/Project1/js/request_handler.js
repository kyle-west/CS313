/***************************************************************
* The REQUEST class                        Last Update: May 2017
* By Kyle West
*
* Handles AJAX requests to retrieve serverside info.
***************************************************************/

/***************************************************************
* Constructor:
* @param location, the page to request data from
* @param data, (opt.) JSON {get,post} data to append request
* @param resultElem, (opt.) the HTML elem to inject responseText
***************************************************************/
function Request(location, data, resultElem) {
   this.complete = false;
   this.location = location;
   this.post     = data.post  || null;
   this.get      = data.get   || "";
   this.result   = resultElem || null;
   this.async    = true;
   this.req = new XMLHttpRequest();
}

/***************************************************************
* Request Class Definition
***************************************************************/
Request.prototype = {
   /************************************************************
   * Constructor (Defined Above)
   ************************************************************/
   constructor: Request,

   /************************************************************
   * Sends the AJAX request with the appropriate POST/GET data.
   ************************************************************/
   execute: function () {
      if (this.req != null)
      {
         var that = this; // resolve scope issues
         this.req.onreadystatechange = function () {
            switch (that.req.readyState) {
               case 4:
                  that.response = that.req.responseText;
                  if (that.req.status == 200) {
                     if (that.result) that.result.innerHTML = that.req.responseText;
                     console.log("SUCCESS retrieving data from: " + that.location);
                     that.ifSuccess();
                  } else {
                     console.error("Problem retrieving data from: " + that.location);
                     that.ifFailed();
                  }
                  that.complete = true; // flag we have completed request
                  that.whenDone();
                  break;
            }
         };
         if (this.post) {
            this.req.open("POST", this.location + "?" + this.get, this.async);
            this.req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            this.req.send(this.post);
         } else {
            this.req.open("GET", this.location + "?" + this.get, this.async);
            this.req.send(null);
         }
      }
      else
      {
         console.error("Browser is too out of date to proccess AJAX requests.");
      }
   },

   /************************************************************
   * DEFAULT Callback functions for after the request completes
   ************************************************************/
   ifSuccess : function () {},
   ifFailed  : function () {},
   whenDone  : function () {}
};
