<?php
    //========PATHS========
    define("PATH", $_SERVER["DOCUMENT_ROOT"] . "/bookIt");
    define("ENV_PATH", PATH . "/config/.env");

    //========LOGS========

    define("SEPARATOR", "\t");
    define("ACCESS_LOG", PATH . "/data/access.txt");
    define("ERRORS_LOG", PATH . "/data/errors.txt");

    //========DATABASE========
    define("DBNAME", getParameter("DBNAME"));
    define("SERVER", getParameter("SERVER"));
    define("USERNAME", getParameter("USERNAME"));
    define("PASSWORD", getParameter("PASSWORD"));

    function getParameter($name){
        $file =  fopen(ENV_PATH, "r");
        $output = "";
        $info =  file(ENV_PATH);
        foreach($info as $row){
            $value = explode("=", $row);
            if($value[0]==$name){
                $output .=  trim($value[1]);
                break;
            }
        }
        fclose($file);
        return $output;
    }