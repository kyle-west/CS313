<?php

print_r($_POST);

// TODO: actually do stuff to the database

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
      for ($i = 0; $i < count($_POST['del_docs']); $i++) {
         $docs .= htmlspecialchars($_POST['del_docs'][$i]);
         if ($i + 1 != count($_POST['del_docs']))
            $docs .= ",";
      }

      // remove dependancies
      $dropdeps = "DELETE FROM reviews WHERE doc_id IN (:idset)";
      $drop_stmnt = $db->prepare($dropdeps);
      $drop_stmnt->bindValue(':idset', $docs, PDO::PARAM_STR);
      $drop_stmnt->execute();

      // remove document
      $query = "DELETE FROM documents
                WHERE id IN (:idset)
                AND user_id = (SELECT id FROM users WHERE username = :username)";

      $statement = $db->prepare($query);
      $statement->bindValue(':username', $_SESSION["username"], PDO::PARAM_STR);
      $statement->bindValue(':idset', $docs, PDO::PARAM_STR);

      $statement->execute();
      break;
}

?>
