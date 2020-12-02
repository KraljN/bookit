<?php
    if(isset($_POST["action"]) && $_POST["action"] == "updateActivity"){
        session_start();
        include "../../config/connection.php";
        var_dump($_SESSION["korisnik"] -> user_id);
        $updateActivities = $db -> prepare("UPDATE user_activities
                                            SET last_activity = :activity
                                            WHERE user_id = :userId");
        $updateActivities -> bindParam(":userId", $_SESSION["korisnik"] -> user_id);
        $currentTime = date("Y-m-d H-i-s", time());
        $updateActivities -> bindParam(":activity", $currentTime);
        $updateActivities -> execute(); 
    }
    else{
        header("Location: ../../index.php?page=home");
        //uneti u log fajl da je pokusan prekrsaj
    }