<?php
function generisiCapchaText($opseg, $duzina){
    $duzinaOpsega = strlen($opseg);
    $text = "";
    for($i = 0; $i < $duzina; $i++){
        $randomKarakter = $opseg[rand(0, $duzinaOpsega - 1)];
        $text .= $randomKarakter;
    }
    return $text;
}
function vratiJSON($array, $statusCode){
    http_response_code($statusCode);
    header("Content-Type: application/json");
    echo json_encode($array);
}
function getCountryId($countryName){// $db, 
    global $db;
    $prepare = $db->prepare("SELECT country_id FROM countries WHERE country_name = :drzava");
    $prepare->bindParam(":drzava", $countryName);
    $prepare->execute();
    $result = $prepare->fetch();
    if($result){
        return $result->country_id;
    }
    else{
        return false;
    }
}
function getCityId($cityName){// $db, 
    global $db;
    $prepare = $db->prepare("SELECT city_id FROM cities WHERE city_name = :city");
    $prepare->bindParam(":city", $cityName);
    $prepare->execute();
    $result = $prepare->fetch();
    if($result){
        return $result->city_id;
    }
    else{
        return false;
    }
}
function insertCountry($countryName){// $db, 
    global $db;
    $prepare = $db->prepare("INSERT INTO countries VALUES (NULL, :drzava)");
    $prepare->bindParam(":drzava", $countryName);
    try{
        $prepare->execute();
    }
    catch(PDOException $ex){
        logError($ex->getMessage(), "country-insert");
        $message = "Error entering country";
        vratiJSON(["message"=>$message], 500);
    }
}
function insertCity($cityName, $countryId){// $db, 
    global $db;
    $prepare = $db->prepare("INSERT INTO cities VALUES (NULL, :city, :countryId)");
    $prepare->bindParam(":city", $cityName);
    $prepare->bindParam(":countryId", $countryId);
    try{
        $prepare->execute();
    }
    catch(PDOException $ex){
        logError($ex->getMessage(), "city-insert");
        $message = "Error entering city";
        vratiJSON(["message"=>$message], 500);

    }
}
function insertPerson($name, $lastName){// $db, 
    global $db;
    $prepare  = $db->prepare("INSERT INTO persons VALUES (NULL, :firstName, :lastName)");
    $prepare->bindParam(":firstName", $name);
    $prepare->bindParam(":lastName", $lastName);
    try{
        $prepare->execute();
        return true;
    }
    catch(PDOException $ex){
        logError($ex->getMessage(), "person-insert");
        $message = "Error inserting person";
        vratiJSON(["message"=>$message], 500);
        return false;
    }
}
function getLastInsertedId(){
    global $db;
   $output = $db->lastInsertId();
   return $output;
}
function insertUser( $username, $password, $lastPersonId, $address, $insertedCityId, $roleId, $number, $date, $email, $loged){// $db,
    global $db;
    $prepare = $db->prepare("INSERT INTO users VALUES (NULL, :userame, :password, :personId, :address, :cityId, :roleId, :phoneNumber, :date, :email)");
    $prepare->bindParam(":email", $email);
    $prepare->bindParam(":password", $password);
    $prepare->bindParam(":personId", $lastPersonId);
    $prepare->bindParam(":address", $address);
    $prepare->bindParam(":phoneNumber", $number);
    $date = date("Y-m-d H:i:s");
    $prepare->bindParam(":date", $date);
    $prepare->bindParam(":cityId", $insertedCityId);
    $prepare->bindParam(":roleId", $roleId);
    $prepare->bindParam(":userame", $username);

    try{
        $prepare->execute();
        return true;
    }
    catch(PDOException $ex){
        logError($ex->getMessage(), "user-insert");
        $message = "User already exist";
        vratiJSON(["message"=>$message], 409);
        return false;
    }
}
function insertPayment($card, $cvv, $lastUserId){// $db, 
    global $db;
    $prepare = $db->prepare("INSERT INTO payments VALUES (NULL, :card, :cvv)");
    $prepare->bindParam(":card", $card);
    $prepare->bindParam(":cvv", $cvv);
    try{
        $prepare->execute();
        $lastInsertedPaymentId = getLastInsertedId($db);
    }
    catch(PDOException $ex){
        logError($ex->getMessage(), "payment-insert");
        $message = "Error while entering card";
        vratiJSON(["message"=>$message], 500);

    } 
    $userPayment = $db->prepare("INSERT INTO users_payments VALUES (NULL, :userId, :paymentId)");
    $userPayment->bindParam(":userId", $lastUserId);
    $userPayment->bindParam(":paymentId", $lastInsertedPaymentId);
    try{
        $userPayment->execute();
        $message = "You successfuly made account";
        vratiJSON(["message"=>$message], 201);

        return true;
    }
    catch(PDOException $ex){
        logError($ex->getMessage(), "payment_user-insert");
        $message = "Error while entering card";
        vratiJSON(["message"=>$message], 500);

        return false;
    } 
}
function deleteFromDb($id, $tableName, $idPrefix){// $db, 
    global $db;
    $prepare = $db->prepare("DELETE FROM " . $tableName . " WHERE " . $idPrefix . "_id = :id");
    $prepare->bindParam(":id", $id);
    try{
        $prepare->execute();
    }
    catch(PDOException $ex){
        logError($ex->getMessage(), "delete from db");
    }
}
function formatDate($datetime){
    list($date, $time) = explode(" ", $datetime);
    list($year, $month, $day) = explode('-', $date);
    list($hours, $minutes,$seconds) = explode(':', $time);
    @$output = date("d-m-Y H:i:s", mktime($hours, $minutes, $seconds, $month, $day, $year));
    return $output;
}