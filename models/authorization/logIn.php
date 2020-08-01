<?php  
if(isset($_POST["action"]) && $_POST["action"]=="uloguj"){
    session_start();
    require_once "../../config/connection.php";
    include "../functions.php";
    $user = $_POST["username"];
    $pass = $_POST["password"];
    $regExpUser = "/[\d\w\.-_]{4,15}/";
    $greske = array();

    if(!preg_match($regExpUser, $user)){
        $greske[] = "Minimum 5 maximum 15 ([A-z][0-9].-_)";
    }
    if(!preg_match($regExpUser, $pass)){
        $greske[] = "Minimum 5 maximum 15 ([A-z][0-9].-_)";
    }
    if(count($greske) == 0){
        
    }
    else{
        $_SESSION['greske'] = $greske;
        $output= ["redirect" => true];
        header("Content-Type: application/json");
        echo json_encode($output);
    }
}
else{
    header("Location: ../../index.php?page=login");
    //uneti u log fajl da je pokusan prekrsaj
}