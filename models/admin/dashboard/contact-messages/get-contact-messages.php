<?php 
    require_once ("config/connection.php");
    require_once ("models/forbidden/functions.php");
    
    $messageQuery = "SELECT contact_form_id AS id, message, name, date, email
                     FROM contact_forms";
    $otherSubjectQuery = "SELECT text 
                          FROM `subject_descriptions`
                          WHERE contact_form_id = ?";

    $otherSubjectQueryPrepare = $db -> prepare($otherSubjectQuery);

    $subjectQuery = "SELECT fs.subject_name AS name
                     FROM contact_forms_form_subjects cff INNER JOIN form_subjects fs ON cff.subject_id = fs.subject_id
                     WHERE cff.contact_form_id = ?";

    $subjectQueryPrepare = $db -> prepare($subjectQuery);


    $contacts = doSelect($messageQuery);

    foreach($contacts as $contact){
        $contact -> date = formatDate($contact -> date);
        $otherSubjectQueryPrepare -> execute([$contact -> id]);
        $subjectQueryPrepare -> execute([$contact -> id]);
        
        if($otherSubjectQueryPrepare -> rowCount() == 1) $contact -> subject = $otherSubjectQueryPrepare -> fetch() -> text;
        if($subjectQueryPrepare -> rowCount() == 1 ) $contact -> subject = $subjectQueryPrepare -> fetch() -> name;
    }