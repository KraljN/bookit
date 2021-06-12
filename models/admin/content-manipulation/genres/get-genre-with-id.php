<?php if(isset($_GET["actionString"]) && $_GET["actionString"] == "deleteGenre"){
        require_once("../../../../config/connection.php");
        require_once("../../../forbidden/functions.php");
        $query = "SELECT COUNT(*) AS number
                  FROM books b INNER JOIN genres_books  gb ON b.book_id = gb.book_id
                  WHERE gb.genre_id = ?";
        $queryPrepare = $db -> prepare($query);
        $queryPrepare -> execute([$_GET["id"]]);
        $output = $queryPrepare -> fetch();
        vratiJSON($output, 200);
}
else{
    header("Location: ../../../../index.php");
}