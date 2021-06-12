<?php if(isset($_POST["actionString"]) && $_POST["actionString"] == "insertAuthor"){
    session_start();
    require_once("../../../../config/connection.php");
    require_once("../../../forbidden/functions.php");
    $greske = validateAuthor($_POST);
    if(count($greske) == 0){

        $db -> beginTransaction();

        $queryPersons = "INSERT INTO persons VALUES(NULL,?,?)";
        $queryAuthor = "INSERT INTO authors VALUES(NULL, ?)";
        $prepareInsertPerson = $db -> prepare($queryPersons);
        $prepareInsertAuthor = $db -> prepare($queryAuthor);
        
        try{
            $prepareInsertPerson -> execute([$_POST["name"], $_POST["surname"]]);
            $personId = getLastInsertedId();
        }
        catch(PDOException $e){
            logError($e->getMessage(), "insert-person");
            $db -> rollBack();
            vratiJSON(["error" => true] , 500);
        }
        try{
            $prepareInsertAuthor -> execute([$personId]);
            $db -> commit();
            vratiJSON(["success" => true], 201);
        }
        catch(PDOException $e){
            logError($e->getMessage(), "insert-author");
            $db -> rollBack();
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