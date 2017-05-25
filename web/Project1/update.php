<?php

print_r($_POST);

require "db.php";

session_start();

if (!isset($_SESSION['username'])) {
   header("Location: login.php");
   die();
}

$type = htmlspecialchars($_POST['type']);

switch ($type) {
   case 'add_doc':
      $query = 'INSERT INTO documents (user_id, filename, page_count) VALUES
                ((SELECT id FROM users WHERE username = :username), :filename, :page_count)';

      $statement = $db->prepare($query);
      $statement->bindValue(':username', $_SESSION["username"], PDO::PARAM_STR);
      $statement->bindValue(':filename', htmlspecialchars($_POST['name']), PDO::PARAM_STR);
      $statement->bindValue(':page_count', htmlspecialchars($_POST['pcount']), PDO::PARAM_INT);

      $statement->execute();
      break;

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


   case "delete":
      for ($d = 0; $d < count($_POST['del_docs']); $d++) {
            $doc  = htmlspecialchars($_POST['del_docs'][$d]);

            // remove dependancies
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
}

?>
