<?php 
session_start();
if(isset($_POST["action"]) && $_POST["action"] == "contact"){
    include "../../config/connection.php";
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $other = $_POST["other"];
    $message = $_POST["message"];

    $nameRegexp = "/^([A-ZĐŠĆŽČ][a-zšđćžč]{1,14})+(\s[A-ZĐŠĆŽČ][a-zšđćžč]{1,14})*$/";
    $emailRegexp = "/^([a-z0-9]{2,15}@[a-z]{2,10}\.[a-z]{2,5})(\.[a-z]{2,5})*$/";
    $greske = [];

    if(!preg_match($nameRegexp, $name)){
        $greske[] = "Wrong name format (Exp. Miles (Johnes))";
    }
    if(!preg_match($emailRegexp, $email)){
        $greske[] = "Wrong mail format (john@gmail.com)";
    }
    if($subject == "other"){
        if(!preg_match($nameRegexp, $other)){
            $greske[] = "Wrong subject format (Exp. Other Problematic Subject)";
        }
    }
    else if($subject == "0"){
        $greske[] = "You must choose subject";
    }
    if(empty($message)){
        $greske[] = "Message can't be empty!";
    }
    if(count($greske) == 0){
        if($subject == "other"){
            $pripremaUnos = $db -> prepare("INSERT INTO contact_forms VALUES (NULL, :message, :subjectId, :name)");
        }
    }
    else{
        $_SESSION['greske'] = $greske;
        $output = ["redirect" => true];
        header("Content-Type: application/json");
        echo json_encode($output);
    }
}
else{
    header("Location: ../../index.php?page=home");
    //uneti u log fajl da je pokusan prekrsaj
}