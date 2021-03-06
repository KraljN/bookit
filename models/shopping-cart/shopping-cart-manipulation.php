<?php 
session_start();
// unset($_SESSION["shoppingCart"]);

if(isset($_POST["action"])){

    switch($_POST["action"]){
        case("add"):
            if(!isset($_SESSION["shoppingCart"])){
                $_SESSION["shoppingCart"] = [];
                $cartProductsIds=[];
            }
            else{
                $cartProductsIds = array_keys($_SESSION["shoppingCart"]);
            }
            $productId = $_POST["id"];
            if(in_array($productId, $cartProductsIds)){
                $_SESSION["shoppingCart"][$productId]["productQuantity"]++;
            }
            else{
                $_SESSION["shoppingCart"][$productId]["productQuantity"] = 1;
            }
            break;

        case("remove"):
            $id = $_POST["id"];
            foreach($_SESSION["shoppingCart"] as $i => $product){
                if($i == $id){
                    unset($_SESSION["shoppingCart"][$i]);
                }
            }
            break;
        case("removeOne"):
            foreach($_SESSION["shoppingCart"] as $i => $product){
                if($i == $_POST["id"]){
                    if( $_SESSION["shoppingCart"][$i]["productQuantity"] == 1) continue;
                    $_SESSION["shoppingCart"][$i]["productQuantity"] -- ;
                }
            }
            break;
        case("changeQuantity"):
            foreach($_SESSION["shoppingCart"] as $i => $product){
                if($i == $_POST["id"]){
                    $_SESSION["shoppingCart"][$i]["productQuantity"] = $_POST['quantity'];
                }
            }
            break;
    }
}
else{
    header("Location: ../index.php");
}