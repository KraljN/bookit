<?php
function getCountryId($db, $countryName){
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
function getCityId($db, $cityName){
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
function insertCountry($db, $countryName){
    $prepare = $db->prepare("INSERT INTO countries VALUES (NULL, :drzava)");
    $prepare->bindParam(":drzava", $countryName);
    try{
        $prepare->execute();
    }
    catch(PDOException $ex){
        logError($ex->getMessage(), "country-insert");
        $message = "Error entering country";
        $status = 500;
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode(["message"=>$message]);
    }
}
function insertCity($db, $cityName, $countryId){
    $prepare = $db->prepare("INSERT INTO cities VALUES (NULL, :city, :countryId)");
    $prepare->bindParam(":city", $cityName);
    $prepare->bindParam(":countryId", $countryId);
    try{
        $prepare->execute();
    }
    catch(PDOException $ex){
        logError($ex->getMessage(), "city-insert");
        $message = "Error entering city";
        $status = 500;
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode(["message"=>$message]);
    }
}
function insertPerson($db, $name, $lastName){
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
        $status = 500;
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode(["message"=>$message]);
        return false;
    }
}
function getLastInsertedId($db){
   $output = $db->lastInsertId();
   return $output;
}
function insertUser($db, $username, $password, $lastPersonId, $address, $insertedCityId, $roleId, $number, $date, $email, $loged){
    $prepare = $db->prepare("INSERT INTO users VALUES (NULL, :userame, :password, :personId, :address, :cityId, :roleId, :phoneNumber, :date, :email, :loged)");
    $prepare->bindParam(":email", $email);
    $password = md5($password);
    $prepare->bindParam(":password", $password);
    $prepare->bindParam(":personId", $lastPersonId);
    $prepare->bindParam(":address", $address);
    $prepare->bindParam(":phoneNumber", $number);
    $date = date("Y-m-d H:i:s");
    $prepare->bindParam(":date", $date);
    $prepare->bindParam(":cityId", $insertedCityId);
    $prepare->bindParam(":roleId", $roleId);
    $prepare->bindParam(":userame", $username);
    $prepare->bindParam(":loged", $loged);

    try{
        $prepare->execute();
        return true;
    }
    catch(PDOException $ex){
        logError($ex->getMessage(), "user-insert");
        $message = "User already exist";
        $status = 500;
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode(["message"=>$message]);
        return false;
    }
}
function insertPayment($db, $card, $cvv, $lastUserId){
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
        $status = 500;
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode(["message"=>$message]);
    } 
    $userPayment = $db->prepare("INSERT INTO users_payments VALUES (NULL, :userId, :paymentId)");
    $userPayment->bindParam(":userId", $lastUserId);
    $userPayment->bindParam(":paymentId", $lastInsertedPaymentId);
    try{
        $userPayment->execute();
        $message = "You successfuly made account";
        $status = 201;
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode(["message"=>$message]);
        return true;
    }
    catch(PDOException $ex){
        logError($ex->getMessage(), "payment_user-insert");
        $message = "Error while entering card";
        $status = 500;
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode(["message"=>$message]);
        return false;
    } 
}
function deleteFromDb($db, $id, $tableName, $idPrefix){
    $prepare = $db->prepare("DELETE FROM " . $tableName . " WHERE " . $idPrefix . "_id = :id");
    $prepare->bindParam(":id", $id);
    try{
        $prepare->execute();
    }
    catch(PDOException $ex){
        logError($ex->getMessage(), "delete from db");
    }
}