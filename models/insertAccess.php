<?php if(isset($_POST["action"]) && $_POST["action"]=="pristup"){
    require_once "../config/config.php";
        $open = fopen(ACCESS_LOG, "a");
        if($open){
            fwrite($open, "{$_POST["stranica"]}". SEPARATOR ."{$_SERVER['REMOTE_ADDR']}". SEPARATOR . gmdate("Y-m-d H:i:s") ."\n");
            fclose($open);
        }
}
else{
    header("Location: ../index.php");
}