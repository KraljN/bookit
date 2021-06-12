<?php if(isset($_POST["actionString"]) && $_POST["actionString"] == "editAuthor"){
    session_start();
    require_once("../../../../config/connection.php");
    require_once("../../../forbidden/functions.php");
    $greske = array();
    $greske = validateAuthor($_POST);
    if(count($greske) == 0){
        $query = "UPDATE persons 
                  SET first_name=?, last_name=?
                  WHERE person_id = ?";
        $prepareUpdate = $db -> prepare($query);

        try{
            $prepareUpdate -> execute([$_POST["name"], $_POST["surname"], $_POST["id"]]);
            vratiJSON(["success" => true], 204);
        }
        catch(PDOException $e){
            logError($e->getMessage(), "edit-menu-item");
            vratiJSON(["error" => true] , 500);
    }   
    }
    else{
        $_SESSION["greske"] = $greske;
        vratiJSON(["reload" => true] , 422);
    }
}
else{
    header("Location: ../../../../index.php");
}