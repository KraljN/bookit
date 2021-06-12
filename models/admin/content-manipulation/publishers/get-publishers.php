<?php if(isset($_GET["actionString"]) && $_GET["actionString"] == "displayPublishers"){
        require_once("../../../../config/connection.php");
        require_once("../../../forbidden/functions.php");
        $query = "SELECT publisher_id AS id, publisher_name AS name
                  FROM publishers";
        $output = doSelect($query);
        vratiJSON($output, 200);
}
else{
    header("Location: ../../../../index.php");
}