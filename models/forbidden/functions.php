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
function getCountryId($countryName){
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
function getCityId($cityName){
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
// function getPaymentId($userId){
//     global $db;
//     $prepare = $db->prepare("SELECT payment_id FROM user_payments WHERE user_id = :id");
//     $prepare->bindParam(":id", $userId);
//     $prepare->execute();
//     $result = $prepare->fetch();
//     if($result){
//         return $result->payment_id;
//     }
//     else{
//         return false;
//     }
// }
function insertCountry($countryName){
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
function insertCity($cityName, $countryId){
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
function updatePayment($cardNumber, $ccv, $id){
    global $db;
    $prepare  = $db->prepare("UPDATE payments p INNER JOIN users_payments u ON p.payment_id = u.payment_id
    SET p.card_number = :cardNumber, p.card_verification_value = :cvv
    WHERE u.user_id = :id");
    $prepare->bindParam(":cardNumber", $cardNumber);
    $prepare->bindParam(":cvv", $ccv);
    $prepare->bindParam(":id", $id);
    try{
        $prepare->execute();
        return true;
    }
    catch(PDOException $ex){
        logError($ex->getMessage(), "payment-update");
        $message = "Error entering city";
        vratiJSON(["message"=>$message], 500);

    }

}
function insertPerson($name, $lastName){
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
function updatePerson($name, $lastName, $id){
    global $db;
    $prepare  = $db->prepare("UPDATE persons p INNER JOIN users u ON p.person_id = u.person_id
                              SET p.first_name = :firstName, p.last_name = :lastName
                              WHERE u.user_id = :user_id ");
    $prepare->bindParam(":firstName", $name);
    $prepare->bindParam(":lastName", $lastName);
    $prepare->bindParam(":user_id", $id);
    try{
        $prepare->execute();
        return true;
    }
    catch(PDOException $ex){
        logError($ex->getMessage(), "person-update");
        $message = "Error updating person";
        vratiJSON(["message"=>$message], 500);
        return false;
    }
}
function getLastInsertedId(){
    global $db;
   $output = $db->lastInsertId();
   return $output;
}
function insertUser( $username, $password, $lastPersonId, $address, $insertedCityId, $roleId, $number, $date, $email, $loged, $active){
    global $db;
    $prepare = $db->prepare("INSERT INTO users VALUES (NULL, :userame, :password, :personId, :address, :cityId, :roleId, :phoneNumber, :date, :email, :active)");
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
    $prepare->bindParam(":active", $active);


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
function updateUser( $username, $address, $insertedCityId, $roleId, $number, $email, $userId){
    global $db;
    $prepare = $db->prepare("UPDATE users 
                             SET username = :userame, addres = :address, city_id = :cityId, role_id = :roleId, phone_number = :phoneNumber, date_updated = :date, email = :email
                             WHERE user_id = :id");
    $prepare->bindParam(":email", $email);
    $prepare->bindParam(":address", $address);
    $prepare->bindParam(":phoneNumber", $number);
    $date = date("Y-m-d H:i:s");
    $prepare->bindParam(":date", $date);
    $prepare->bindParam(":cityId", $insertedCityId);
    $prepare->bindParam(":roleId", $roleId);
    $prepare->bindParam(":userame", $username);
    $prepare->bindParam(":id", $userId);



    try{
        $prepare->execute();
        return true;
    }
    catch(PDOException $ex){
        logError($ex->getMessage(), "user-update");
        $message = "User already exist";
        vratiJSON(["message"=>$message], 409);
        return false;
    }
}
function insertPayment($card, $cvv, $lastUserId){
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
function deleteFromDb($id, $tableName, $idPrefix){ 
    global $db;
    $prepare = $db->prepare("DELETE FROM " . $tableName . " WHERE " . $idPrefix . "_id = :id");
    $prepare->bindParam(":id", $id);
    try{
        $prepare->execute();
        return true;
    }
    catch(PDOException $ex){
        logError($ex->getMessage(), "delete from db");
        return false;
    }
}
function formatDate($datetime){
    list($date, $time) = explode(" ", $datetime);
    list($year, $month, $day) = explode('-', $date);
    list($hours, $minutes,$seconds) = explode(':', $time);
    @$output = date("d-m-Y H:i:s", mktime($hours, $minutes, $seconds, $month, $day, $year));
    return $output;
}
function validateMenuItem($data){
    $greske = array();
    $regExpName = "/^[A-ZĐŠĆŽČ][a-zšđćžč]{1,14}(\s[A-ZĐŠĆŽČ][a-zšđćžč]{1,14})*$/";
    $regExpPriority = "/^[0-9]{1,10}$/";
    $regExpUrl = "/(http(s)?:\/\/)?(www\.)?[a-zA-Z0-9@:_\+~#=]{2,20}\.[a-z0-9]{2,6}[a-zA-Z0-9@:%_\+.~#?&\/=\.]*/";
    if(!isset($_POST["name"])) array_push($greske, "Name for Menu Tab is required");
    if(!isset($_POST["priority"])) array_push($greske, "Priority for Menu Tab is required");
    if(!isset($_POST["url"])) array_push($greske, "Url for Menu Tab is required");
    if( @!preg_match($regExpName , $data["name"])) array_push($greske, "Name must be well formated (Home Page)");
    if( @!preg_match($regExpPriority , $data["priority"])) array_push($greske, "Priority must be number above zero");
    if( @!preg_match($regExpUrl , $data["url"])) array_push($greske, "Provide valid url address ([www.]pera.com)");

    return $greske;
}
function validateAuthor($data){
    $greske = array();
    $regExpName = "/^[A-ZĐŠĆŽČ][a-zšđćžč]{1,14}(\s[A-ZĐŠĆŽČ][a-zšđćžč]{1,14})*$/";
    if(!isset($_POST["name"])) array_push($greske, "First for Menu Tab is required");
    if(!isset($_POST["surname"])) array_push($greske, "Last Name for Author Tab is required");
    if( @!preg_match($regExpName , $data["name"])) array_push($greske, "Name must be well formated (Nikola)");
    if( @!preg_match($regExpName , $data["surname"])) array_push($greske, "Last name must be well formated (Kralj)");

    return $greske;

}
function  validateUser($data, $withPassword = true){
    $greske = array();
    $regExpName ="/^([A-ZĐŠĆŽČ][a-zšđćžč]{1,14})(\s[A-ZĐŠĆŽČ][a-zšđćžč]{1,14})*$/";
    $regExpEmail = "/^([a-z0-9]{2,15}@[a-z]{2,10}\.[a-z]{2,5})(\.[a-z]{2,5})*$/";
    $regExpUsername = "/[\d\w\.-_]{4,15}/";
    $regExpCreditCard = "/^\d{4}(\-\d{4}){3}$/";
    $regExpCountry = '/^[A-Z]\w{2,10}$/';
    $regExpAddress = "/^[A-Z][\w]{5,20}(\s[\w]{5,20}){0,5}(\s[0-9]{1,4})$/";
    $regExpPhoneNumber = "/^\+?[0-9]{9,15}$/";
    $regExpCVV = "/^[0-9]{3}$/";

    $name = $data["name"];
    $lastName = $data["lastName"];
    $email = $data["email"];
    $username = $data["username"];
    $creditCard = $data["creditCard"];
    $country = $data["country"];
    $city = $data["city"];
    $address = $data["address"];
    $number = $data["number"];
    $cvv = $data["cvv"];

    if(!preg_match($regExpName, $name)){
        $greske[] = "Wrong name format (Exp. John)";
        }
    if(!preg_match($regExpName, $lastName)){
        $greske[] = "Wrong last name format (Exp. Miles)";
    }
    if(!preg_match($regExpPhoneNumber, $number)){
        $greske[] = "Wrong mobile number format (Ex. +381621235234)";
    }
    if(!preg_match($regExpEmail, $email)){
        $greske[] = "Wrong mail format (john@gmail.com)";
    }
    if(!preg_match($regExpUsername, $username)){
        $greske[] = "Wrong Username Minimum 5 maximum 15 ([A-z][0-9].-_)";
    }
    if($withPassword){
        $password = $data["password"];
        if(!preg_match($regExpUsername, $password)){
            $greske[] = "Wrong Password Format Minimum 5 maximum 15 ([A-z][0-9].-_)";
        }
    }
    if(!preg_match($regExpCreditCard, $creditCard)){
        $greske[] = "Wrong credit card format(Exact 16 digits)";
    }
    if(!preg_match($regExpCountry, $country)){
        $greske[] = "Wrong country format (Exp. Serbia)";
    }
    if(!preg_match($regExpCountry, $city)){
        $greske[] = "Wrong city format (Exp. Serbia)";
    }
    if(!preg_match($regExpAddress, $address)){
        $greske[] = "Wrong address format (Exp. Takovska 17)";
    }
    if(!preg_match($regExpCVV, $cvv)){
        $greske[] = "Wrong CVV format(Last 3 numbers on back of your card)";
    }
    return $greske;
}