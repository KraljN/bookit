<?php
if(isset($_GET["action"]) && ($_GET["action"]=="menu")){
    require_once("../../config/connection.php");
    $menu = doSelect("SELECT text, href FROM `navigation` ORDER BY priority");
    $code =  count($menu)==0?204:200;
    header("Content-Type: application/json");
    echo json_encode($menu);
    http_response_code($code);

}
else{
    header("Content-Type: text/html; charset=UTF-8");
    header("Location: ../../index.php?page=home");
    //uneti u log fajl da je pokusan prekrsaj
}