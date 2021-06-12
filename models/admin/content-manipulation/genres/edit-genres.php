<?php if(isset($_POST["actionString"]) && $_POST["actionString"] == "editGenres"){
    session_start();
    require_once("../../../../config/connection.php");
    require_once("../../../forbidden/functions.php");
    $greske = array();
    $regExpName = "/^[A-ZĐŠĆŽČ][a-zšđćžč]{1,14}(\s[A-ZĐŠĆŽČ][a-zšđćžč]{1,14})*$/";
    if(!isset($_POST["name"])) array_push($greske, "Genre Name is required field");
    if(!isset($_POST["id"])) array_push($greske, "Genre Id is required field");
    if(!preg_match($regExpName, $_POST["name"])){
        array_push($greske, "Genre name must be in valid format (Sci FI)");
    }

    if(count($greske) == 0){
        $query = "UPDATE genres 
                  SET genre_name = ?
                  WHERE genre_id = ?";
        $prepareInsert = $db -> prepare($query);
        
        try{
            $prepareInsert -> execute([$_POST["name"], $_POST["id"]]);
            vratiJSON(["success" => true], 201);
        }
        catch(PDOException $e){
            logError($e->getMessage(), "insert-genre");
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