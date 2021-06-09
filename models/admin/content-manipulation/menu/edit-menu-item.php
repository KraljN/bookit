<?php if(isset($_POST["actionString"]) && $_POST["actionString"] == "editMenu"){
    session_start();
    require_once("../../../../config/connection.php");
    require_once("../../../forbidden/functions.php");
    $greske = array();
    $greske = validateMenuItem($_POST);
    if(count($greske) == 0){
        $query = "UPDATE navigation 
                  SET text=?, href=?, priority=?
                  WHERE navigation_id = ?";
        $prepareUpdate = $db -> prepare($query);

        try{
            $prepareUpdate -> execute([$_POST["name"], $_POST["url"], $_POST["priority"], $_POST["id"]]);
            vratiJSON(["success" => true], 204);
        }
        catch(PDOException $e){
            logError($e->getMessage(), "edit-menu-item");
            vratiJSON(["error" => true] , 409);
    }   
    }
    else{
        // var_dump($greske);
        $_SESSION["greske"] = $greske;
        vratiJSON(["reload" => true] , 422);
    }
}
else{
    header("Location: ../../../../index.php");
}