<?php if(isset($_POST["actionString"]) && $_POST["actionString"] == "insertMenu"){
    session_start();
    require_once("../../../../config/connection.php");
    require_once("../../../forbidden/functions.php");
    $greske = validateMenuItem($_POST);
    if(count($greske) == 0){
        $query = "INSERT INTO navigation VALUES(NULL,?,?,?)";
        $prepareInsert = $db -> prepare($query);
        
        try{
            $prepareInsert -> execute([$_POST["name"], $_POST["url"], $_POST["priority"]]);
            vratiJSON(["success" => true], 201);
        }
        catch(PDOException $e){
            logError($e->getMessage(), "insert-menu-item");
            vratiJSON(["error" => true] , 409);
    }   
    }
    else{
        var_dump($greske);
        $_SESSION["greske"] = $greske;
        vratiJSON(["reload" => true] , 422);
    }
}
else{
    header("Location: ../../../../index.php");
}