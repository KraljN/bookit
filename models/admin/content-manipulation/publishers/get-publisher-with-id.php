<?php if(isset($_GET["actionString"]) && $_GET["actionString"] == "deletePublisher"){
        require_once("../../../../config/connection.php");
        require_once("../../../forbidden/functions.php");
        $query = "SELECT COUNT(*) AS number
                  FROM books 
                  WHERE publisher_id = ?";
        $queryPrepare = $db -> prepare($query);
        $queryPrepare -> execute([$_GET["id"]]);
        $output = $queryPrepare -> fetch();
        vratiJSON($output, 200);
}
else{
    header("Location: ../../../../index.php");
}