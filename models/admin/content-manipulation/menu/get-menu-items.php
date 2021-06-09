<?php 
if(isset($_GET["action"]) && $_GET["action"] == "getMenuItems"){
    require_once("../../../../config/connection.php");
    require_once("../../../forbidden/functions.php");
    $query = "SELECT navigation_id AS id, text, href, priority  FROM navigation";
    vratiJSON(doSelect($query), 200);
}
else{
    header("Location: ../../../../index.php");
}