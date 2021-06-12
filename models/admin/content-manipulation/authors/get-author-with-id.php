<?php if(isset($_GET["actionString"]) && $_GET["actionString"] == "deleteAuthor"){
        require_once("../../../../config/connection.php");
        require_once("../../../forbidden/functions.php");
        $query = "SELECT COUNT(*) AS number
                  FROM books b INNER JOIN authors a ON b.author_id = a.author_id
                  WHERE a.person_id = ?";
        $queryPrepare = $db -> prepare($query);
        $queryPrepare -> execute([$_GET["id"]]);
        $output = $queryPrepare -> fetch();
        vratiJSON($output, 200);
}
else{
    header("Location: ../../../../index.php");
}