/***************************************************************
* This class handles AJAX Requests
***************************************************************/
function Request(location, data, resultElem) {
   this.complete = false;
   this.location = location;
   this.post     = data.post || null;
   this.get      = data.get  || true; // make default
   this.result   = resultElem || null;
   this.req = new XMLHttpRequest();
}

Request.prototype = {
   constructor: Request,
   execute: function () {
      if (this.req != null)
      {
         var that = this; // resolve scope issues
         this.req.onreadystatechange = function () {
            switch (that.req.readyState) {
               case 4:
                  if (that.req.status == 200) {
                     if (that.result) that.result.innerHTML = that.req.responseText;
                     console.log("SUCCESS retrieving data from: " + that.location);
                     that.ifSuccess();
                  } else {
                     console.error("Problem retrieving data from: " + that.location);
                     that.ifFailed();
                  }
                  that.complete = true;
                  that.whenDone();
                  break;
            }
         };
         if (this.post) {
            this.req.open("POST", this.location, true);
            this.req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            this.req.send(this.post);
            console.info("SENDING '"+this.post+"' VIA POST TO '"+this.location+"'")
         } else if (this.get) {
            this.req.open("GET", this.location + "?" + this.get, true);
            this.req.send(null);
         }
      }
      else
      {
         console.error("Browser is too out of date to proccess AJAX requests.");
      }
   },

   ifSuccess : function () {}, // don't do anything
   ifFailed  : function () {}, // don't do anything
   whenDone  : function () {}  // don't do anything
};
