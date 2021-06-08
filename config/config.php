<?php
    //========PATHS========
    define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/bookIt");
    define("ENV_PATH", ROOT_PATH . "/config/.env");
    define("IMG_PATH", "assets/img/");// =========== Kada se dize na hosting dodati ROOT_PATH ispred "/assets/img/" ===============
    define("DISPLAY_ROOT_PATH", "www.bookit.com/index?page=");

    //========LOGS========

    define("SEPARATOR", "\t");
    @define("ACCESS_LOG", ROOT_PATH . "/data/access.txt");
    @define("ERRORS_LOG", ROOT_PATH . "/data/errors.txt");

    //========DATABASE========
    define("DBNAME", getParameter("DBNAME"));
    define("SERVER", getParameter("SERVER"));
    define("USERNAME", getParameter("USERNAME"));
    define("PASSWORD", getParameter("PASSWORD"));


    //=======USER INSERT=====
    define("NIJE_ULOGOVAN", 0);
    define("ADMIN", 1);
    define("KORISNIK", 2);



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