<?php if(isset($_POST["action"]) && $_POST["action"]=="pristup"){
    require_once "../config/config.php";
        $open = fopen(ACCESS_LOG, "a");
        if($open){
            fwrite($open, "{$_POST["stranica"]}". SEPARATOR ."{$_SERVER['REMOTE_ADDR']}". SEPARATOR . date("Y-m-d H:i:s", time()) ."\n");
            fclose($open);
        }
}
else{
    header("Location: ../index.php");
}