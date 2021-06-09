<?php if(isset($_POST["action"]) && $_POST["action"] == "insertMenu"){
    session_start();
    require_once("../../../../config/connection.php");
    require_once("../../../forbidden/functions.php");
    $greske = array();
    $regExpName = "/^[A-ZĐŠĆŽČ][a-zšđćžč]{1,14}+(\s[A-ZĐŠĆŽČ][a-zšđćžč]{1,14})*$/";
    $regExpPriority = "/^[0-9]{1,10}$/";
    $regExpUrl = "/(http(s)?:\/\/)?(www\.)?[a-zA-Z0-9@:_\+~#=]{2,20}\.[a-z0-9]{2,6}[a-zA-Z0-9@:%_\+.~#?&\/=\.]*/";
    if(!isset($_POST["name"])) array_push($greske, "Name for Menu Tab is required");
    if(!isset($_POST["priority"])) array_push($greske, "Priority for Menu Tab is required");
    if(!isset($_POST["url"])) array_push($greske, "Url for Menu Tab is required");
    if( @!preg_match($regExpName , $_POST["name"])) array_push($greske, "Name must be well formated (Home Page)");
    if( @!preg_match($regExpPriority , $_POST["priority"])) array_push($greske, "Priority must be number above zero");
    if( @!preg_match($regExpUrl , $_POST["url"])) array_push($greske, "Provide valid url address ([www.]pera.com)");
    if(count($greske) == 0){
        $query = "INSERT INTO navigation VALUES(NULL,?,?,?)";
        $prepareInsert = $db -> prepare($query);

        try{
            $prepareInsert -> execute([$_POST["name"], $_POST["url"], $_POST["priority"]]);
            vratiJSON(["success" => true], 201);
        }
        catch(PDOException $e){
            logError($e->getMessage(), "insert-menu-item");
            vratiJSON(["error" => true] , 409);
    }   
    }
    else{
        var_dump($greske);
        $_SESSION["greske"] = $greske;
        vratiJSON(["reload" => true] , 422);
    }
}
else{
    header("Location: ../../../../index.php");
}