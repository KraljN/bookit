<?php
if(isset($_GET["action"]) && $_GET["action"] == "getStatistic"){
    require_once("../../../config/connection.php");
    require_once("../../forbidden/functions.php");
    $accessRows = file(ACCESS_LOG);
    $views = $percentages = $allPages = $output =  [];
    $totalViews = 0;
    $currentUnix = time();
    $unixYesterday = strtotime('-1 day', time());
    foreach($accessRows as $row){
        list($action, $ip, $datetime) =  explode(SEPARATOR, $row);
        if($action != "logged-in"){
            array_push($allPages, $action);
            $totalViews ++;
            $page = $action;
            list($date, $time) = explode(" ", $datetime);
            list($year, $month, $day) = explode('-', $date);
            list($hours, $minutes,$seconds) = explode(':', $time);
            @$unixLog = mktime($hours, $minutes, $seconds, $month, $day, $year);
            if($unixLog > $unixYesterday) {
                $todayViews[$page] = isset($todayViews[$page]) ? $todayViews[$page] + 1 : 1;
            }
            $views[$page] = isset($views[$page]) ? $views[$page] + 1 : 1;
        }
    }
    $allPages = array_unique($allPages);
    $output['totalNumber']  = count($allPages);


    $pageNumber = isset($_GET["pageNumber"]) ? $_GET["pageNumber"] : 1;
    define("PER_PAGE", 5);
    $start = ($pageNumber - 1) * PER_PAGE;

    foreach($allPages as $singlePage){
        if(!isset($views[$singlePage])) $views[$singlePage] = 0;
        if(!isset($todayViews[$singlePage])) $todayViews[$singlePage] = 0;
        $percentages[$singlePage] = round($views[$singlePage] / $totalViews * 100, 1);
        $data['information'][$singlePage]["views"] = $todayViews[$singlePage];
        $data['information'][$singlePage]["percentage"] = $percentages[$singlePage];
    }
    $output['information'] = array_slice($data['information'], $start, PER_PAGE);
    vratiJSON($output, 200);
}
else{
    header("Location: ../../../index.php");
}
