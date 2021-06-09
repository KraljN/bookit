<?php 
    session_start();
    require_once "config/config.php";
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
                break;
            case "products":
                include "views/products.php";
                break;
            case "admin-dashboard":
                if(!(isset($_SESSION["korisnik"]) && $_SESSION["korisnik"] -> role_id == ADMIN)) header("Location: index.php");
                include "views/admin/dashboard.php";
                break;
            case "admin-reports":
                if(!(isset($_SESSION["korisnik"]) && $_SESSION["korisnik"] -> role_id == ADMIN)) header("Location: index.php");
                include "views/admin/reports.php";
                break;
            case "content-manipulation":
                if(!(isset($_SESSION["korisnik"]) && $_SESSION["korisnik"] -> role_id == ADMIN)) header("Location: index.php");
                    include "views/admin/content-manipulation.php";
                    break;
            case "menu-item-form":
                if(!(isset($_SESSION["korisnik"]) && $_SESSION["korisnik"] -> role_id == ADMIN)) header("Location: index.php");
                include "views/admin/menu-item-form.php";
                break;
        }
    }
    include "views/fixed/footer.php";