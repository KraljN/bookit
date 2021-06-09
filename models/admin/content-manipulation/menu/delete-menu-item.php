<?php if(isset($_POST["actionString"]) && $_POST["actionString"] == "deleteMenuItem"){
    require_once("../../../../config/connection.php");
    require_once("../../../forbidden/functions.php");
    if(deleteFromDb($_POST["id"], "navigation", "navigation")){
        vratiJSON(["message"=>"success"], 204);
    }
    else{
        vratiJSON(["error"=>"true"], 500);
    }
}
else{
    header("Location: ../../../../index.php");
}