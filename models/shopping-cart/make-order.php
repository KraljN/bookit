<?php 
    session_start();
    if(isset($_POST["action"]) && $_POST["action"] == "purchase"){

    }
    else{
        header("Location: ../index.php");
    }