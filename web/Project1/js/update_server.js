/***************************************************************
* SERVERSIDE UPDATE REQUESTS
* By Kyle West
*
* File contains all functions related to onclick events and key
* strokes accross the application.
***************************************************************/

/***************************************************************
* Sends user initiated update to remove specified documents from
* the list. Sends request and updates page following completion.
***************************************************************/
function remove_selected_from_db() {
   // initialze data string
   var data = "type=delete";

   // append data string with relevant info
   var elements = document.getElementsByClassName('mark_delete');
   for (var i = 0; i < elements.length; i++) {
       data += "&del_docs[]" + "="+ elements[i].value;
   }

   // send the request to the server
   var req = new Request("update.php", { post: data });
   req.whenDone = function () {
      get_contents("docs");
      new Request(
         "side.php",
         { get: "part=docs" },
         document.getElementById("side_docs")
      ).execute();
   };
   req.execute();

   // close down action
   console.log("DELETE statement sent");
   document.getElementById('form_del').innerHTML = "";
   unselectAllRows();
   modalOff();
}

/***************************************************************
* Sends user initiated update to add a new document to their list.
* Sends request and updates page following completion.
***************************************************************/
function add_document_to_db() {
   // initialze data string
   var data = "type=add_doc";

   // append data string with relevant info
   data += "&name=" + document.getElementById('new_doc_name').value;
   data += "&pcount=" + document.getElementById('new_doc_pc').value;

   // send the request to the server
   var req = new Request("update.php", { post: data });
   req.whenDone = function () {
      get_contents("docs");
      new Request(
         "side.php",
         { get: "part=docs" },
         document.getElementById("side_docs")
      ).execute();
   };
   req.execute();

   // close down action
   console.log("ADD statement sent");
   modalOff();
}

/***************************************************************
* Sends user initiated update to a document's name. Sends update
* to server and refreshes page contents following completion.
***************************************************************/
function change_document_name_in_db(id, newname) {
   // initialze data string and append with relevant info
   var data = "type=name_change&id="+id+"&newname="+newname;

   // send the request to the server
   var req = new Request("update.php", { post: data });
   req.whenDone = function () {
      new Request(
         "side.php",
         { get: "part=docs" },
         document.getElementById("side_docs")
      ).execute();
   };
   req.execute();

   console.log("CHANGE statement sent: #" + id + " to '"+newname+"'");
}

/***************************************************************
* Sends user initiated reuqest to send documents to other users
* for peer reviewing. Sends request and updates page following
* completion.
***************************************************************/
function send_doc_to_reviewer() {
   // initialze data string
   var data = "type=new_review";

   // append data string with relevant document info
   var elements = document.getElementsByClassName('mark_send');
   for (var i = 0; i < elements.length; i++) {
       data += "&send_docs[]" + "="+ elements[i].value;
   }

   // append data string with relevant peer info
   elements = document.getElementsByClassName('rev_opt selected');
   for (var i = 0; i < elements.length; i++) {
       data += "&peer[]" + "="+ elements[i].getAttribute('data-reviewer');
   }

   // send the request to the server
   new Request("update.php", { post: data }).execute();

   // close down action
   unselectAllRows();
   modalOff();
   console.log("REVIEW ADD statement sent");
   get_contents("docs");
}

/***************************************************************
* Sends user initiated update to cancel previously requested
* peer reviews. Sends update to server and refreshes page
* contents following completion.
***************************************************************/
function cancel_review_in_db() {
   // collect info we need to send
   var review = document.getElementById('cancel_rev');
   var id     = review.getAttribute('data-id');
   var rev    = review.getAttribute('data-rev');

   // initialze data string with collected info
   var data = "type=cancel_rev&doc="+id+"&reviewer="+rev;

   // send the request to the server
   var req = new Request("update.php", { post: data });
   req.whenDone = function () {
      get_contents("docs");
   };
   req.execute();

   // close down action
   unselectAllRows();
   modalOff();
   console.log("CANCEL REVIEW statment sent");
}

/***************************************************************
* Sends user initiated update to the status of a review assigned
* to them for review. Sends update to server and refreshes page
* contents following completion.
***************************************************************/
function update_status(elem, newstatus) {
   // collect info we need to send
   var id = elem.parentElement.getAttribute('data-doc-id');

   // initialze data string with collected info
   var data = "type=update_status&doc="+id+"&status="+newstatus;

   // send the request to the server
   var req = new Request("update.php", { post: data });
   req.whenDone = function () {
      get_contents("revs");
      new Request(
         "side.php",
         { get: "part=revs" },
         document.getElementById("side_revs")
      ).execute();
   };
   req.execute();

   console.log("UPDATE STATUS statement sent");
}
