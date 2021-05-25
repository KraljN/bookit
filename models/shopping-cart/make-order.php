<?php 
    session_start();
    if(isset($_POST["action"]) && $_POST["action"] == "purchase" && isset($_SESSION["korisnik"])){
        require_once "../../config/connection.php";
        $query = "INSERT INTO orders VALUES (NULL, :user_id)";
        $pripremaOrder = $db -> prepare ($query);
        $pripremaOrder -> bindParam(":user_id", $_SESSION["korisnik"]["user_id"]);
        $db -> beginTransaction();
        try{
            $pripremaOrder -> execute();
        }
        catch(PDOException $e){
            logError($ex->getMessage(), "user-insert");
            $message = "error";
            vratiJSON(["message"=>$message], 500);
            $db -> rollBack();
        }

        $orderId = getLastInsertedId();

        $query = "INSERT INTO order_items VALUES (NULL, :book_id, :order_id, :quantity, :price)";
        $pripremaOrder = $db -> prepare($query);

        foreach ($_SESSION["shoppingCart"] as $productId => $quantity){
            $pripremaOrder -> bindParam(":book_id", $productId);
            $pripremaOrder -> bindParam(":order_id", $orderId);
            $pripremaOrder -> bindParam(":quantity", $quantity["productQuantity"]);
            $pripremaOrder -> bindParam(":price", $quantity["productQuantity"]);
        }

        $db -> commit();
    }
    else{
        header("Location: ../index.php?page=login");
    }