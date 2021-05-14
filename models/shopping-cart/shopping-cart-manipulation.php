<?php 
session_start();
// unset($_SESSION["shoppingCart"]);
// unset($_SESSION["shopingCart"]);

if(isset($_POST["action"])){
    if($_POST["action"] == "add"){
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
    }
    if($_POST["action"]=="remove"){
        
        $id = $_POST["id"];
        foreach($_SESSION["shoppingCart"] as $i => $product){
            if($i == $id){
                unset($_SESSION["shoppingCart"][$i]);
            }
        }
    }
    if($_POST["action"] == "changeQuantity"){
        $quantity = $_POST["quantity"];
        foreach($_SESSION["shoppingCart"] as $i => $product){
            if($i == $_POST["id"]){
                $_SESSION["shoppingCart"][$i]["productQuantity"] = $quantity;
            }
        }
    }
}
else{
    header("Location: ../index.php");
}