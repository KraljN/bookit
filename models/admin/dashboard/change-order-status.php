<?php 
if(isset($_POST["actionString"]) && $_POST["actionString"] == "changeStatus"){
    require_once("../../../config/connection.php");
    require_once("../../forbidden/functions.php");

    $changeStatusQuery = "UPDATE orders
                          SET order_status_id = ?
                          WHERE order_id = ?";

    $prepareQuery = $db -> prepare($changeStatusQuery);

    try{
        $prepareQuery -> execute([$_POST["statusId"], $_POST["orderId"]]);
        vratiJSON(["message" => "ok"], 204);
    }
    catch(PDOException $ex){
        logError($e->getMessage(), "order-status-update");
        $message = "error";
        vratiJSON(["message"=>$message], 500);
    }
}
else{
    header("Location: ../../../index.php");
}