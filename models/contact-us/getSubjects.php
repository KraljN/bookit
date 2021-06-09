<?php 
    if(isset($_GET["action"]) && $_GET["action"] == "subjects"){
        include "../../config/connection.php";
        include "../forbidden/functions.php";
        $query = "SELECT subject_id as id, subject_name as name
                  FROM form_subjects";
        vratiJSON(doSelect($query), 200);
    }
    else{
        header("Location: ../../index.php?page=home");
        //uneti u log fajl da je pokusan prekrsaj
    }