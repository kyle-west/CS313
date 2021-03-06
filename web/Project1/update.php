<?php
/**************************************************************
* UPDATE DATABASE
* by Kyle West
*
* Connects to the DB and inserts/updates new relevent information.
**************************************************************/
// initialize everything
require "db.php";
session_start();

// ensure logged in
if (!isset($_SESSION['username'])) {
   header("Location: login.php");
   die();
}

// what kind of info updates are we making?
$type = htmlspecialchars($_POST['type']);

switch ($type) {
   /*************************************************
   * Insert a new document in the DB owned by user
   *************************************************/
   case 'add_doc':
      $query = 'INSERT INTO documents (user_id, filename, page_count) VALUES
                ((SELECT id FROM users WHERE username = :username), :filename, :page_count)';

      $statement = $db->prepare($query);
      $statement->bindValue(':username', $_SESSION["username"], PDO::PARAM_STR);
      $statement->bindValue(':filename', htmlspecialchars($_POST['name']), PDO::PARAM_STR);
      $statement->bindValue(':page_count', htmlspecialchars($_POST['pcount']), PDO::PARAM_INT);

      $statement->execute();
      break;

   /*************************************************
   * Change the name of an already exsting document
   * owned by the current user.
   *************************************************/
   case 'name_change':
      $query = 'UPDATE documents
                SET filename = :newname
                WHERE id = :id
                AND user_id = (SELECT id FROM users WHERE username = :username)';

      $statement = $db->prepare($query);
      $statement->bindValue(':username', $_SESSION["username"], PDO::PARAM_STR);
      $statement->bindValue(':id', htmlspecialchars($_POST['id']), PDO::PARAM_INT);
      $statement->bindValue(':newname', htmlspecialchars($_POST['newname']), PDO::PARAM_STR);

      $statement->execute();
      break;

   /*************************************************
   * Remove a document owned by the current user.
   *************************************************/
   case "delete":
      for ($d = 0; $d < count($_POST['del_docs']); $d++) {
            $doc  = htmlspecialchars($_POST['del_docs'][$d]);

            // remove dependancies first
            $dropdeps = "DELETE FROM reviews WHERE doc_id = :doc;";
            $drop_stmnt = $db->prepare($dropdeps);
            $drop_stmnt->bindValue(':doc', $doc, PDO::PARAM_INT);
            $drop_stmnt->execute();

            // remove document
            $query = "DELETE FROM documents
                      WHERE id = :doc
                      AND user_id = (SELECT id FROM users WHERE username = :username)";

            $statement = $db->prepare($query);
            $statement->bindValue(':username', $_SESSION["username"], PDO::PARAM_STR);
            $statement->bindValue(':doc', $doc, PDO::PARAM_INT);

            $statement->execute();
      }
      break;

   /*************************************************
   * Add a new peer review instance to the DB
   *************************************************/
   case "new_review":
      for ($d = 0; $d < count($_POST['send_docs']); $d++) {
         for ($p = 0; $p < count($_POST['peer']); $p++) {
            $doc  = htmlspecialchars($_POST['send_docs'][$d]);
            $peer = htmlspecialchars($_POST['peer'][$p]);

            $query = 'INSERT INTO reviews (doc_id, reviewer, status) VALUES
                      (:doc, (SELECT id FROM users WHERE username = :peer), 1)
                      ON CONFLICT (doc_id, reviewer) DO NOTHING;';

            $statement = $db->prepare($query);
            $statement->bindValue(':peer', $peer, PDO::PARAM_STR);
            $statement->bindValue(':doc', $doc, PDO::PARAM_INT);

            $statement->execute();
         }
      }
      break;

   /*************************************************
   * Update the status code of a document review
   *************************************************/
   case "update_status":
      $status  = htmlspecialchars($_POST['status']);
      $doc     = htmlspecialchars($_POST['doc']);

      $query = 'UPDATE reviews SET status = :status WHERE doc_id = :doc
                AND reviewer = (SELECT id FROM users WHERE username = :username);';

      $statement = $db->prepare($query);
      $statement->bindValue(':status', $status, PDO::PARAM_INT);
      $statement->bindValue(':doc', $doc, PDO::PARAM_INT);
      $statement->bindValue(':username', $_SESSION["username"], PDO::PARAM_STR);

      $statement->execute();
      break;

   /*************************************************
   * Remove a previously established review assignment
   * only if the review has finished or not started.
   *************************************************/
   case "cancel_rev":
      $reviewer = (string)htmlspecialchars($_POST['reviewer']);
      $doc      = (int)htmlspecialchars($_POST['doc']);

      $query = 'DELETE FROM reviews USING documents
                WHERE reviews.doc_id     = documents.id
                AND   documents.user_id  = (SELECT id FROM users WHERE username = :username)
                AND   reviews.reviewer   = (SELECT id FROM users WHERE username = :reviewer)
                AND   reviews.doc_id     = :doc
                AND   reviews.status NOT IN (2)'; // 2 : "Reivew in Progress"

      $statement = $db->prepare($query);
      $statement->bindValue(':reviewer', $reviewer, PDO::PARAM_STR);
      $statement->bindValue(':doc', $doc, PDO::PARAM_INT);
      $statement->bindValue(':username', $_SESSION["username"], PDO::PARAM_STR);

      $statement->execute();
      break;
}

?>
