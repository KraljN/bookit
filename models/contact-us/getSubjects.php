<?php 
    if(isset($_GET["action"]) && $_GET["action"] == "subjects"){
        include "../../config/connection.php";
        include "../forbidden/functions.php";
        $subjects = $db -> query("SELECT subject_id as id, subject_name as name
                                  FROM form_subjects") -> fetchAll();
        vratiJSON($subjects, 200);
    }
    else{
        header("Location: ../../index.php?page=home");
        //uneti u log fajl da je pokusan prekrsaj
    }