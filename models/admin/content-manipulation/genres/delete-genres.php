<?php if(isset($_POST["actionString"]) && $_POST["actionString"] == "deleteGenre"){
        require_once("../../../../config/connection.php");
        require_once("../../../forbidden/functions.php");
        if(deleteFromDb($_POST["id"], "genres", "genre")){
            vratiJSON(["message"=>"success"], 204);
        }
        else{
            vratiJSON(["error"=>"true"], 500);
        }
}
else{
    header("Location: ../../../../index.php");
}