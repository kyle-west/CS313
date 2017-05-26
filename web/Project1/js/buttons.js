var buttons = {
   docs: {
      minus : function () {
         var modal_content = document.getElementById("modal_content");
         modal_content.innerHTML =
            "<h2>Are you sure you want to delete the following?</h2>" +
            "<form id = 'form_del'> <ul>";

         var selected = document.getElementsByClassName('selected');
         for (var i = 0; i < selected.length; i++) {
            var item_name = selected[i].getAttribute('data-name');
            var item_id = selected[i].id;
            modal_content.innerHTML += "<li>"+item_name;
            modal_content.innerHTML += "<input type = 'hidden' class = 'mark_delete' value = '"+item_id+"'/>";
            modal_content.innerHTML += "</li>";
            console.log("PROMPT FOR DELETE: item #" + item_id + ", '" + item_name + "'");
         }

         modal_content.innerHTML += "</ul>" +
               "<br/><span><i>This action <b>cannot</b> be undone.</i></span>" +
               "<input type = 'button' name = 'remove' value = 'Remove' class = 'right' onclick = 'remove_selected_from_db();'/>" +
               "<input type = 'button' name = 'remove' value = 'Cancel' class = 'right' onclick = 'cancel_delete()'/>" +
            "</form><br/>";
         modalOn();
      },

      plus  : function () {
         var modal_content = document.getElementById("modal_content");
         modal_content.innerHTML =
            "<h2>Upload a file to Peerfessional!</h2>" +
            "<form id = 'form_add'>" +
               "Filename: <input type = 'text' id = 'new_doc_name'/> "+
               "Number of Pages: <input type = 'number' id = 'new_doc_pc' min='1'/>"+
               "<br/><br/>"+
               "<input type = 'button' name = 'add' value = 'Upload' class = 'right' onclick = 'add_document_to_db();'/>" +
               "<input type = 'button' name = 'add' value = 'Cancel' class = 'right' onclick = 'modalOff();'/>" +
            "</form><br/>";
         modalOn();
      },

      help  : function () {
         document.getElementById("modal_content").innerHTML =
            "<h2>Help Menu:</h2> <p>[instructions go here]</p>"+
            "<input type = 'button' name = 'ok' value = 'OK' class = 'right' onclick = 'modalOff();'/><br/>";
         modalOn();
      },

      send  : function () {
         var item_names = "";
         var item_inputs = "";
         var modal_content = document.getElementById("modal_content");
         modal_content.innerHTML =
            "<h2>Send to a Peer! </h2>";

         var selected = document.getElementsByClassName('selected');
         for (var i = 0; i < selected.length; i++) {
            var item_name = selected[i].getAttribute('data-name');
            var item_id = selected[i].id;
            item_names += " \"" + item_name + "\"";
            switch (i) {
               case selected.length - 1: break;
               case selected.length - 2: item_names += ", and "; break;
               default: item_names += ", ";
            }

            item_inputs += "<input type = 'hidden' class = 'mark_send' value = '"+item_id+"'/>";
            console.log("PROMPT FOR SEND: item #" + item_id + ", '" + item_name + "'");
         }
         modal_content.innerHTML += "<p> Select a Peer to review " + item_names+ "</p>";

         modal_content.innerHTML +=
            "<form id = 'form_rev'>" +
               "<div id = 'reviewer_opts_head'></div>" +
               "<div id = 'reviewer_opts'><i>Loading Peers...</i></div>" +
               "<br/><br/>"+ item_inputs +
               "<input type = 'button' name = 'send' value = 'Send to Peer' class = 'right' onclick = 'send_doc_to_reviewer();'/>" +
               "<input type = 'button' name = 'send' value = 'Cancel' class = 'right' onclick = 'modalOff();'/>" +
            "</form><br/>";

            var req = new Request(
               "getrevs.php",
               { get: "view=modal_select_peer" },
               document.getElementById("reviewer_opts")
            );
            req.ifSuccess = function () { // stylize the header
               document.getElementById("reviewer_opts_head").innerHTML =
                  document.getElementById("rev_opt_head").innerHTML;
               document.getElementById("rev_opt_head").innerHTML = "";
            };
            req.execute();

         modalOn();
      },

      firepeer : function (elem) {
         var doc  = elem.getAttribute('data-doc-id');
         var stat = elem.getAttribute('data-status');
         var rev  = elem.getAttribute('data-reviewer');
         var modal_content = document.getElementById("modal_content");

         switch (stat) {
            case "-9":
            case  "3":
               modal_content.innerHTML =
               "<h2>Remove Review</h2>"+
               "<p>Are you sure you want to remove "+rev+"'s review from the list'? </p>"+
               "<div id = 'cancel_rev' data-id = '"+doc+"' data-rev = '"+rev+"'></div>"+
               "<input type = 'button' name = 'remove' value = 'Yes' class = 'right' onclick = 'cancel_review_in_db();'/>"+
               "<input type = 'button' name = 'remove' value = 'No' class = 'right' onclick = 'modalOff();'/>"+
               "<br/>";
               break;

            case "1":
               modal_content.innerHTML =
               "<h2>Cancel Peer Review</h2>"+
               "<p>Are you sure you want to cancel your review from "+rev+"? </p>"+
               "<div id = 'cancel_rev' data-id = '"+doc+"' data-rev = '"+rev+"'></div>"+
               "<input type = 'button' name = 'fire' value = 'Yes' class = 'right' onclick = 'cancel_review_in_db();'/>"+
               "<input type = 'button' name = 'fire' value = 'No' class = 'right' onclick = 'modalOff();'/>"+
               "<br/>";
               break;
         }

         modalOn();
      }
   },

   revs: {
      review: function(elem) {
         var doc = elem.parentElement.getAttribute('data-doc-name');
         var modal_content = document.getElementById("modal_content");
         modal_content.innerHTML =
            "<h2>Review \""+doc+"\"</h2>"+
            "<p>[This is out of the CS 313 Project1 scope]</p>" +
            "<input type = 'button' name = 'done' value = 'OK' class = 'right' onclick = 'modalOff();'/><br/>";
         modalOn();
      }
   },
};

function modalOn() {
   $('html, body').animate({ scrollTop: 0 }, 'fast');
   document.getElementById('modal').style.display = "block";
}

function modalOff() {
   document.getElementById('modal').style.display = "none";
}

window.onkeyup = function(e) {
   var key = e.keyCode ? e.keyCode : e.which;

   switch (key) {

      case 27: // escape
         modalOff();
      case 13: // enter
         var curent_edit = document.getElementsByClassName('edit_text')[0];
         if (curent_edit != null) {
            curent_edit.blur();
         }
         break;
   }
}

function editText(elem) {
   var text = elem.innerText;
   elem.innerHTML = "<input type = 'text' class = 'edit_text' " +
      "value = '"+ text +"' " + "data-original-text = '"+ text +"' " +
      "onblur = 'change_doc_name(this, this.parentElement);'" +
      "onfocus = 'this.select();'/>";
   elem.childNodes[0].focus();
   if (elem.parentElement.classList.contains('selected')) {
      elem.parentElement.classList.remove('selected');
      toggleAssocRows(elem.parentElement);
   }
   console.log("Editing text:   '" + text + "'");
}

function change_doc_name(elem, parent) {
   var original_text = elem.getAttribute("data-original-text");
   if (elem.value.length > 0 && elem.value != original_text) {
      var val = parent.innerHTML = elem.value;
      parent.parentElement.parentElement.setAttribute('data-name', val);
      change_document_name_in_db(parent.parentElement.parentElement.id, val);
   } else {
      var val = parent.innerHTML = original_text;
      console.log("NO CHANGES MADE: '" + val + "'");
   }
}

function unselectAllRows() {
   var rows = document.getElementsByClassName('data_row');
   for (var i = 0; i < rows.length; i++) {
      if (rows[i].classList.contains('selected')) {
         rows[i].classList.remove('selected');
         toggleAssocRows(rows[i]);
      }
   }
}

function toggleAssocRows(tieElem) {
   var rows = document.getElementsByClassName('data_row_assoc');
   for (var i = 0; i < rows.length; i++) {
      if (rows[i].getAttribute("data-tied-to") == tieElem.id) {
         if (!tieElem.classList.contains('selected')) {
            rows[i].classList.remove('selected_assoc');
         } else {
            rows[i].classList.add('selected_assoc');
         }
      }
   }
}

function selectRow(row) {
   if (row.classList.contains('selected')) {
      row.classList.remove('selected');
      toggleAssocRows(row);
   } else {
      row.classList.add('selected');
      toggleAssocRows(row);
   }
   updateButtons();
}

function toggleMainRows(tieElem) {
   var rows = document.getElementsByClassName('data_row');
   for (var i = 0; i < rows.length; i++) {
      if (rows[i].id == tieElem.getAttribute("data-tied-to")) {
         if (!tieElem.classList.contains('selected_assoc')) {
            rows[i].classList.remove('selected');
         } else {
            rows[i].classList.add('selected');
         }
         return rows[i];
      }
   }
}

function selectAssocRow(row) {
   if (row.classList.contains('selected_assoc')) {
      row.classList.remove('selected_assoc');
   } else {
      row.classList.add('selected_assoc');
   }
   toggleAssocRows(toggleMainRows(row));
   updateButtons();
}

function updateButtons() {
   if ($('.selected').length > 0) {
      $('.show_on_selected').slideDown();
   } else $('.show_on_selected').slideUp();
}

function selectRev(row) {
   if (row.classList.contains('selected')) {
      row.classList.remove('selected');
      toggleAssocRows(row);
   } else {
      row.classList.add('selected');
      toggleAssocRows(row);
   }
}
