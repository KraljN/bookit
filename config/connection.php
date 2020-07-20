<?php
    require_once "config.php";
    logAccess();
    try{
        $db = new PDO("mysql:host=".SERVER.";dbname=".DBNAME.";charset=utf8", USERNAME, PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }
    catch(PDOException $e){
        echo $e->getMessage();
        logError($e->getMessage());
    }
    function doSelect ($query){
        global $db;
        return $db->query($query)->fetchAll();
    }
    function logAccess (){
        $open = fopen(ACCESS_LOG, "a");
        if($open){
            fwrite($open, "{$_SERVER['PHP_SELF']}". SEPARATOR ."{$_SERVER['REMOTE_ADDR']}". SEPARATOR . gmdate("Y-m-d H:i:s") ."\n");
            fclose($open);
        }
    }
    function logError($message = null, $customMessage = null){
        $open = fopen(ERRORS_LOG, "a");
        if($open){
            fwrite($open,$customMessage . SEPARATOR .  $message. SEPARATOR ."{$_SERVER['REMOTE_ADDR']}". SEPARATOR . gmdate("Y-m-d H:i:s") ."\n");
            fclose($open);
        }
    }