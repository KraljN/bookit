<?php
    require_once "config.php";
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
    function logError($message = null, $customMessage = null){
        $open = fopen(ERRORS_LOG, "a");
        if($open){
            fwrite($open,$customMessage . SEPARATOR .  $message. SEPARATOR ."{$_SERVER['REMOTE_ADDR']}". SEPARATOR . date("Y-m-d H:i:s", time()) ."\n");
            fclose($open);
        }
    }
    function logFailedLogin($userId){
        $open = fopen(FAILED_LOGIN_LOG, "a");
        if($open){
            fwrite($open, $userId . SEPARATOR  ."{$_SERVER['REMOTE_ADDR']}". SEPARATOR . date("Y-m-d H:i:s", time()) ."\n");
            fclose($open);
        }
    }   