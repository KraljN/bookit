<?php 
session_start();
if(isset($_POST["register"])){
    require_once "../../config/connection.php";
    include "../functions.php";
    $name = $_POST["name"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $creditCard = $_POST["creditCard"];
    $obradjenCredit = str_replace('-',"", $creditCard);
    $country = $_POST["country"];
    $city = $_POST["city"];
    $address = $_POST["address"];
    $number = $_POST["number"];
    $cvv = $_POST["cvv"];
    $roleId=KORISNIK;
    $loged = NIJE_ULOGOVAN;
 
    $greske = [];
    $regExpName = "/^[A-ZĐŠĆŽČ][a-zšđćžč]{1,14}$/";
    $regExpLastName ="/^([A-ZĐŠĆŽČ][a-zšđćžč]{1,14})+(\s[A-ZĐŠĆŽČ][a-zšđćžč]{1,14})*$/";
    $regExpEmail = "/^([a-z0-9]{2,15}@[a-z]{2,10}\.[a-z]{2,5})(\.[a-z]{2,5})*$/";
    $regExpUsername = "/[\d\w\.-_]{4,15}/";
    $regExpCreditCard = "/^\d{4}(\-\d{4}){3}$/";
    $regExpCountry = '/^[A-Z]\w{2,10}$/';
    $regExpAddress = "/^[A-Z][\w]{5,10}(\s[\w]{5,10}){0,5}(\s[0-9]{1,4})$/";
    $regExpPhoneNumber = "/^\+?[0-9]{9,15}$/";
    $regExpCVV = "/^[0-9]{3}$/";

    if(!preg_match($regExpName, $name)){
        $greske[] = "Wrong name format (Exp. John)";
        }
    if(!preg_match($regExpLastName, $lastName)){
        $greske[] = "Wrong last name format (Exp. Miles)";
    }
    if(!preg_match($regExpPhoneNumber, $number)){
        $greske[] = "Wrong mobile number format (Ex. +381621235234)";
    }
    if(!preg_match($regExpEmail, $email)){
        $greske[] = "Wrong mail format (john@gmail.com)";
    }
    if(!preg_match($regExpUsername, $username)){
        $greske[] = "Minimum 5 maximum 15 ([A-z][0-9].-_)";
    }
    if(!preg_match($regExpUsername, $password)){
        $greske[] = "Minimum 5 maximum 15 ([A-z][0-9].-_)";
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
    if(count($greske)==0){
        $card = str_replace('-', '', $creditCard);
        $countryId = getCountryId($db, $country);
        $cityId = getCityId($db, $city);
        $date = date("Y-m-d H:i:s");
        $password = md5($password);
        if((!$countryId && !$cityId) || (!$countryId && $cityId)){
            insertCountry($db, $country);
            $insertedCountryId = getCountryId($db, $country);
            insertCity($db, $city, $insertedCountryId);
            $insertedCityId = getCityId($db, $city);
            insertPerson($db, $name, $lastName);
            $lastPersonId = getLastInsertedId($db);
            if(insertUser($db, $username, $password, $lastPersonId, $address, $insertedCityId, $roleId, $number, $date, $email, $loged)){
                $lastUserId = getLastInsertedId($db);
                insertPayment($db, $card, $cvv, $lastUserId);
            }
            else{
                deleteFromDb($db, $lastPersonId, "persons", "person");
            }

        }
        if($countryId && !$cityId){
            $insertedCountryId = getCountryId($db, $country);
            insertCity($db, $city, $insertedCountryId);
            $insertedCityId = getCityId($db, $city);
            insertPerson($db, $name, $lastName);
            $lastPersonId = getLastInsertedId($db);
            if(insertUser($db, $username, $password, $lastPersonId, $address, $insertedCityId, $roleId, $number, $date, $email, $loged)){
                $lastUserId = getLastInsertedId($db);
                insertPayment($db, $card, $cvv, $lastUserId);
            }
            else{
                deleteFromDb($db, $lastPersonId, "persons", "person");
            }
        }
        if($countryId && $cityId){
            $insertedCityId = getCityId($db, $city);
            insertPerson($db, $name, $lastName);
            $lastPersonId = getLastInsertedId($db);
            if(insertUser($db, $username, $password, $lastPersonId, $address, $insertedCityId, $roleId, $number, $date, $email, $loged)){
                $lastUserId = getLastInsertedId($db);
                insertPayment($db, $card, $cvv, $lastUserId);
            }
            else{
                deleteFromDb($db, $lastPersonId, "persons", "person");
            }
        }
    }
    else{
        $_SESSION['greske'] = $greske;
        $output= ["redirect" => true];
        header("Content-Type: application/json");
        echo json_encode($output);
    }

}
else{
    header("Location: ../../index.php?page=login");
    //uneti u log fajl da je pokusan prekrsaj
}