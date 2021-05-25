<?php 
    session_start();
    if(isset($_POST["action"]) && $_POST["action"] == "purchase" && isset($_SESSION["korisnik"])){
        require_once "../../config/connection.php";
        require_once "../forbidden/functions.php";
        $query = "INSERT INTO orders VALUES (NULL, :user_id)";
        $pripremaOrder = $db -> prepare ($query);
        $userId = $_SESSION["korisnik"]->user_id;
        $pripremaOrder -> bindParam(":user_id", $userId);
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

        $priceQuery = "SELECT p.value AS price
        FROM  books b INNER JOIN books_prices bp ON b.book_id = bp.book_id
        INNER JOIN prices p ON bp.price_id = p.price_id
        WHERE b.book_id = :book_id
        ORDER BY bp.date_become_effective DESC
        LIMIT 1";

        $pripremaPrice = $db -> prepare ($priceQuery);
        

        foreach ($_SESSION["shoppingCart"] as $productId => $quantity){
            $pripremaOrder -> bindParam(":book_id", $productId);
            $pripremaOrder -> bindParam(":order_id", $orderId);
            $pripremaOrder -> bindParam(":quantity", $quantity["productQuantity"]);
            $pripremaOrder -> bindParam(":price", $price);

            $pripremaPrice -> bindParam(":book_id", $productId);
            $pripremaPrice -> execute();

            $price = $pripremaPrice -> fetch();
            $price = $price -> price * $quantity["productQuantity"];

            //try i catch
            //COMMIT IDE NA KRAJ OVOG TRY BLOKA
            // $pripremaOrder -> execute();

            //Obavestavanje korisnika o uspesnosti
        }

        $db -> commit();
    }
    else{
        header("Location: ../index.php?page=login");
    }