/**************************************************************************
* SEND DELETE
**************************************************************************/
function remove_selected_from_db() {
   var data = "type=delete";

   var elements = document.getElementsByClassName('mark_delete');
   for (var i = 0; i < elements.length; i++) {
       data += "&del_docs[]" + "="+ elements[i].value;
   }

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

   console.log("DELETE statement sent");
   document.getElementById('form_del').innerHTML = "";
   unselectAllRows();
   modalOff();
}

/**************************************************************************
* CANCEL DELETE
**************************************************************************/
function cancel_delete() {
   document.getElementById('form_del').innerHTML = "";
   console.log("DELETE canceled");
   modalOff();
}

/**************************************************************************
* SEND NEW DOCUMENT
**************************************************************************/
function add_document_to_db() {
   var data = "type=add_doc";

   data += "&name=" + document.getElementById('new_doc_name').value;
   data += "&pcount=" + document.getElementById('new_doc_pc').value;

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

   console.log("ADD statement sent");
   modalOff();
}

/**************************************************************************
* CHANGE DOCUMENT NAME
**************************************************************************/
function change_document_name_in_db(id, newname) {
   var data = "type=name_change&id="+id+"&newname="+newname;

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

/**************************************************************************
* SEND DOC TO PEER
**************************************************************************/
function send_doc_to_reviewer() {
   var data = "type=new_review";

   var elements = document.getElementsByClassName('mark_send');
   for (var i = 0; i < elements.length; i++) {
       data += "&send_docs[]" + "="+ elements[i].value;
   }

   elements = document.getElementsByClassName('rev_opt selected');
   for (var i = 0; i < elements.length; i++) {
       data += "&peer[]" + "="+ elements[i].getAttribute('data-reviewer');
   }

   new Request("update.php", { post: data }).execute();

   unselectAllRows();
   modalOff();
   console.log("REVIEW ADD statement sent");
   get_contents("docs");
}

/**************************************************************************
* UPDATE REVIEW STATUS
**************************************************************************/
function update_status(elem, newstatus) {
   var id = elem.parentElement.getAttribute('data-doc-id');
   var data = "type=update_status&doc="+id+"&status="+newstatus;

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
