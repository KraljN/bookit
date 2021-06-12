<?php if(isset($_POST["actionString"]) && $_POST["actionString"] == "editPublishers"){
    session_start();
    require_once("../../../../config/connection.php");
    require_once("../../../forbidden/functions.php");
    $greske = array();
    $regExpName = "/^[A-ZĐŠĆŽČ][a-zšđćžč][a-zšđćžč\.']{1,14}(\s[A-ZĐŠĆŽČa-zšđćžč'\.]{1,14})*$/";
    if(!isset($_POST["name"])) array_push($greske, "Publisher Name is required field");
    if(!isset($_POST["id"])) array_push($greske, "Publisher Id is required field");
    if(!preg_match($regExpName, $_POST["name"])){
        array_push($greske, "Publisher Name Must be in valid format (St. Martin's Press)");
    }

    if(count($greske) == 0){
        $query = "UPDATE publishers 
                  SET publisher_name = ?
                  WHERE publisher_id = ?";
        $prepareInsert = $db -> prepare($query);
        
        try{
            $prepareInsert -> execute([$_POST["name"], $_POST["id"]]);
            vratiJSON(["success" => true], 201);
        }
        catch(PDOException $e){
            logError($e->getMessage(), "edit-publisher");
            vratiJSON(["error" => true] , 409);
    }   
    }
    else{
        $_SESSION["greskeGenre"] = $greske;
        vratiJSON(["reload" => true] , 422);
    }
}
else{
    header("Location: ../../../../index.php");
}