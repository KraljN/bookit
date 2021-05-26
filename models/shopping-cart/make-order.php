<?php 
    session_start();
    if(isset($_POST["action"]) && $_POST["action"] == "purchase" && isset($_SESSION["korisnik"])){
        require_once "../../config/connection.php";
        require_once "../forbidden/functions.php";
        $query = "INSERT INTO orders VALUES (NULL, :user_id, :date)";
        $pripremaOrder = $db -> prepare ($query);
        $userId = $_SESSION["korisnik"]->user_id;
        $pripremaOrder -> bindParam(":user_id", $userId);
        $date = date("Y-m-d H:i:s");
        $pripremaOrder->bindParam(":date", $date);
        $db -> beginTransaction();
        try{
            $pripremaOrder -> execute();
            $orderId = getLastInsertedId();
        }
        catch(PDOException $e){
            logError($e->getMessage(), "order-insert");
            $message = "error";
            vratiJSON(["message"=>$message], 500);
            $db -> rollBack();
        }



        $query = "INSERT INTO order_items VALUES (NULL, :book_id, :order_id, :quantity, :price)";
        $pripremaOrder = $db -> prepare($query);

        $priceQuery = "SELECT p.value AS price
        FROM  books b INNER JOIN books_prices bp ON b.book_id = bp.book_id
        INNER JOIN prices p ON bp.price_id = p.price_id
        WHERE b.book_id = :book_id
        ORDER BY bp.date_become_effective DESC
        LIMIT 1";

        $pripremaPrice = $db -> prepare ($priceQuery);
        $success = true;
        foreach ($_SESSION["shoppingCart"] as $productId => $quantity){
            $pripremaOrder -> bindParam(":book_id", $productId);
            $pripremaOrder -> bindParam(":order_id", $orderId);
            $pripremaOrder -> bindParam(":quantity", $quantity["productQuantity"]);
            $pripremaOrder -> bindParam(":price", $price);

            $pripremaPrice -> bindParam(":book_id", $productId);
            $pripremaPrice -> execute();

            $price = $pripremaPrice -> fetch();
            $price = $price -> price * $quantity["productQuantity"];

            try{
                   $pripremaOrder -> execute(); 

            }
            catch(PDOException $e){
                logError($e->getMessage(), "user-insert");
                $success = false;
            }

        }
        if($success) {
            $message = "success";
            unset($_SESSION["shoppingCart"]);
            vratiJSON(["message"=>$message], 201);
            $db -> commit();
        }
        else{
            $db -> rollBack();
            $message = "error";
            vratiJSON(["message"=>$message], 500);
        }
    }
    else{
        header("Location: ../index.php?page=login");
    }