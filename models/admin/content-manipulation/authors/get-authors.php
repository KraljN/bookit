<?php if(isset($_GET["action"]) && $_GET["action"] == "getAuthors"){
        require_once("../../../../config/connection.php");
        require_once("../../../forbidden/functions.php");
        $query = "SELECT p.first_name AS name, p.last_name AS surname, p.person_id AS id
                  FROM persons p INNER JOIN authors a ON p.person_id = a.person_id";
        $output = doSelect($query);
        vratiJSON($output, 200);
}
else{
    header("Location: ../../../../index.php");
}