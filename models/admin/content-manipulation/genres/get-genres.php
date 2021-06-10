<?php if(isset($_GET["actionString"]) && $_GET["actionString"] == "displayGenres"){
        require_once("../../../../config/connection.php");
        require_once("../../../forbidden/functions.php");
        $query = "SELECT genre_id AS id, genre_name AS name
                  FROM genres";
        $output = doSelect($query);
        vratiJSON($output, 200);
}
else{
    header("Location: ../../../../index.php");
}