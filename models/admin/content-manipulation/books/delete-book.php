<?php if(isset($_POST["actionString"]) && $_POST["actionString"] == "deleteBook"){
        require_once("../../../../config/connection.php");
        require_once("../../../forbidden/functions.php");
        $previousPicturePath = getPicturePath($_POST["id"]);
        unlink(IMG_PATH . "thumb-" . $previousPicturePath);
        unlink(IMG_PATH .  $previousPicturePath);
        if(deleteFromDb($_POST["id"], "books", "book")){
            vratiJSON(["message"=>"success"], 204);
        }
        else{
            vratiJSON(["error"=>"true"], 500);
        }
}
else{
    header("Location: ../../../../index.php");
}