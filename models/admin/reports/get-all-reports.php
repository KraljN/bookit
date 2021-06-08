<?php 
if(isset($_GET["action"]) && $_GET["action"] == "getReport"){
    require_once("../../../config/connection.php");
    require_once("../../forbidden/functions.php");
    $accessRows = file(ACCESS_LOG);
    $accessRows = array_reverse($accessRows);
    $errorsRows = file(ERRORS_LOG);
    $errorsRows = array_reverse($errorsRows);
    $output = [];
    $output["accessNumber"] = count($accessRows);
    $output["errorsNumber"] = count($errorsRows);

    $accessPageNumber = isset($_GET["accessPageNumber"]) ? $_GET["accessPageNumber"] : 1;
    $errorsPageNumber = isset($_GET["errorsPageNumber"]) ? $_GET["errorsPageNumber"] : 1;
    define('PER_PAGE', 10);
    $start = ($accessPageNumber - 1) * PER_PAGE;

    $n = $start + PER_PAGE > count($accessRows) ? count($accessRows) : $start + PER_PAGE;
    $i = 0;
    for($j = $start;$j < $n; $j++){
        list($action, $ip, $datetime) =  explode(SEPARATOR, $accessRows[$j]);
        if($action != "logged-in"){
            $page = $action;
            $output['access'][$i]["page"] = $page;
            $output['access'][$i]["ip"] = $ip;
            $output['access'][$i]["time"] = formatDate($datetime);
            $i++;
        }
    }

    $start = ($errorsPageNumber - 1) * PER_PAGE;
    $n = $start + PER_PAGE > count($errorsRows) ? count($errorsRows) : $start + PER_PAGE;
    $i = 0;
    for($j = $start;$j < $n; $j++){
            list($action, $message,  $ip, $datetime) =  explode(SEPARATOR, $errorsRows[$j]);
            $output['errors'][$i]["action"] = $action;
            $output['errors'][$i]["message"] = $message;
            $output['errors'][$i]["ip"] = $ip;
            $output['errors'][$i]["time"] = formatDate($datetime);
            $i++;
    }

    vratiJSON($output, 200);
}
else{
    header("Location: ../../../index.php");
}