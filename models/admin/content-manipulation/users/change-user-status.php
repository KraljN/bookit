<?php
if(isset($_POST["actionString"]) && $_POST["actionString"] == "changeStatus"){
    require_once("../../../../config/connection.php");
    require_once("../../../forbidden/functions.php");
    $statusReverse = $_POST["status"] == 1 ? 0 : 1;
    $query = "UPDATE users SET active = ?, date_updated = ?
              WHERE user_id = ?";
    try{
        $updatePrepare = $db -> prepare($query);
        $updatePrepare -> execute([$statusReverse, date("Y-m-d H:i:s"), $_POST["id"]]);
        vratiJSON(["message"=> "success"], 204);
    }
    catch(PDOException $ex){
        logError($ex->getMessage(), "status-update");
        vratiJSON(["message"=>$message], 500);
    }
}
else{
    header("Location: ../../../../index.php");
}