<?php 
if(isset($_GET["action"]) && $_GET["action"] == "getInfo"){
    require_once("../../../config/connection.php");
    require_once("../../forbidden/functions.php");
    $accessRows = file(ACCESS_LOG);
    $views  =  $countedPages = [];
    $loggedUsersNumber = 0;
    $unixYesterday = strtotime('-1 day', time());
    foreach($accessRows as $row){
        list($action, $ip, $datetime) =  explode(SEPARATOR, $row);
        if($action == "logged-in"){
            list($date, $time) = explode(" ", $datetime);
            list($year, $month, $day) = explode('-', $date);
            list($hours, $minutes,$seconds) = explode(':', $time);
            @$unixLog = mktime($hours, $minutes, $seconds, $month, $day, $year);
            if($unixLog > $unixYesterday) $loggedUsersNumber ++;
        }
        else{
            $page = $action;
            if(in_array($page, $countedPages)) continue;
            $viewsForPage = 0;
            foreach($accessRows as $rowForCount){
                $pageForCount =  explode(SEPARATOR, $rowForCount)[0];
                if($pageForCount == $page) $viewsForPage ++;
            }
            $views[$page] = $viewsForPage;
            array_push($countedPages, $page);
        }
    }
    asort($views);
    $pageViews = end($views);
    $pageName = key($views);
    $pageUrl = "index?page=" . $pageName; 
    $pageName = "www.bookit.com/index.php?page=" . $pageName;

    $queryTotalUsers = "SELECT COUNT(*) AS 'number'
                        FROM users";
    $totalAccounts = $db -> query ($queryTotalUsers) -> fetch() -> number;

    $queryOrders = "SELECT COUNT(*) AS 'number'
                    FROM orders";
    $totalOrders = $db -> query ($queryOrders) -> fetch() -> number;

    $output = [
        "logins" => $loggedUsersNumber,
        "accounts" => $totalAccounts,
        "most-popular-page-name" => $pageName,
        "most-popular-page-url" => $pageUrl,
        "most-popular-page-views-count" => $pageViews,
        "orders" => $totalOrders
    ];
    vratiJSON($output, 200);
}
else{
    header("Location: ../../../index.php");
}