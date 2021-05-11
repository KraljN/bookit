<?php 
    session_start();
    include "views/fixed/head.php";
    include "views/fixed/header.php";
    if(!isset($_GET["page"])){
        include "views/home.php";
    }
    else{
        switch ($_GET["page"]){
            case 'home':
                include "views/home.php";
                break;
            case 'single-product':
                include "views/single-product.php";
                break;
            case 'login':
                include "views/login.php";
                break;
            case 'contact':
                include "views/contact.php";
                break;
            case 'shopping-cart':
                include "views/shopping-cart.php";
        }
    }
    include "views/fixed/footer.php";