<?php  
if(isset($_POST["action"]) && $_POST["action"]=="uloguj"){
    session_start();
    require_once "../../config/connection.php";
    include "../forbidden/functions.php";
    $user = $_POST["username"];
    $pass = md5($_POST["password"]);
    $capcha = $_POST["capcha"];

    $regExpUser = "/[\d\w\.-_]{4,15}/";
    $regExpCapcha= "/[\d\w]{5,6}/";
    $greske = array();

    if(!preg_match($regExpUser, $user)){
        $greske[] = "Minimum 5 maximum 15 ([A-z][0-9].-_)";
    }
    if(!preg_match($regExpUser, $pass)){
        $greske[] = "Minimum 5 maximum 15 ([A-z][0-9].-_)";
    }
    if(!preg_match($regExpCapcha, $capcha)){
        $greske[] = "Minimum 5 maximum 6 numbers or letters";
    }
    if(count($greske) == 0){
        $pripremaLog = $db->prepare('SELECT u.user_id, u.username, u.role_id
                                     FROM users u INNER JOIN roles r ON U.role_id = r.role_id 
                                     WHERE u.username = :user AND u.password = :pass');
        $pripremaLog->bindParam(":user", $user);
        $pripremaLog->bindParam(":pass", $pass);
        $pripremaLog->execute();
        if($pripremaLog -> rowCount() == 1 && $_SESSION["capchaText"] == $capcha){
            $_SESSION["korisnik"] = $pripremaLog->fetch();
            $open = fopen(ACCESS_LOG, "a");
            if($open){
                fwrite($open, "logged-in". SEPARATOR ."{$_SERVER['REMOTE_ADDR']}". SEPARATOR . gmdate("Y-m-d H:i:s") ."\n");
                fclose($open);
            }
            $admin = $_SESSION["korisnik"]->role_id == ADMIN ? true : false;
            $output = ["logged" => true, "admin"=>$admin];
            vratiJSON($output, 200);
        }
        else{


            $proveraUser = $db -> prepare("SELECT email
                                           FROM users
                                           WHERE username = :username");
            $proveraUser -> bindParam(":username", $user);
            $proveraUser -> execute();
            if($proveraUser -> rowCount() == 1){
                $mail = $proveraUser -> fetch() -> email;

                $to = $mail;
                $subject = 'Failed attempt of loging onto our website';
                $message = 'Hi, \r\n Somebody tried to login onto our site with your username. \r\n Contact support if it isn\'t you \r\n';
                $headers = 'From: book-it.com' . "\r\n";

                $uspesno = mail($to, $subject, $message, $headers);
                // var_dump($uspesno);    Treba se namestiti mail server za ovo!!!
                
            }
            $output = ["logged" => false];
            vratiJSON($output, 401);
        }
    }
    else{
        $_SESSION['greske'] = $greske;
        $output= ["redirect" => true];
        vratiJSON($output, 200);
    }
}
else{
    header("Location: ../../index.php?page=login");
    //uneti u log fajl da je pokusan prekrsaj
}