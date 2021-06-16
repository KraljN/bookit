<?php 
session_start();
if(isset($_POST["actionString"]) && $_POST["actionString"] == "insertUser"){
    require_once "../../config/connection.php";
    include "../forbidden/functions.php";
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
    $active = AKTIVAN_KORISNIK;
 
    $greske = validateUser($_POST);

    if(count($greske) == 0){
        $card = str_replace('-', '', $creditCard);
        $countryId = getCountryId($country);
        $cityId = getCityId($city, $countryId);
        $date = date("Y-m-d H:i:s");
        $password = md5($password);
        if((!$countryId && !$cityId) || (!$countryId && $cityId)){
            insertCountry($country);
            $insertedCountryId = getCountryId($country);
            insertCity( $city, $insertedCountryId);
            $insertedCityId = getCityId($city, $insertedCountryId);
            insertPerson($name, $lastName);
            $lastPersonId = getLastInsertedId();
            if(insertUser($username, $password, $lastPersonId, $address, $insertedCityId, $roleId, $number, $date, $email, $loged, $active)){
                $lastUserId = getLastInsertedId();
                insertPayment($card, $cvv, $lastUserId);
            }
            else{
                deleteFromDb($lastPersonId, "persons", "person");
            }

        }
        if($countryId && !$cityId){
            $insertedCountryId = getCountryId($country); 
            insertCity($city, $insertedCountryId);
            $insertedCityId = getCityId($city, $countryId);
            insertPerson($name, $lastName);
            $lastPersonId = getLastInsertedId();
            if(insertUser($username, $password, $lastPersonId, $address, $insertedCityId, $roleId, $number, $date, $email, $loged, $active)){
                $lastUserId = getLastInsertedId();
                insertPayment($card, $cvv, $lastUserId);
            }
            else{
                deleteFromDb( $lastPersonId, "persons", "person");
            }
        }
        if($countryId && $cityId){
            $insertedCityId = $cityId;
            insertPerson($name, $lastName);
            $lastPersonId = getLastInsertedId();
            if(insertUser($username, $password, $lastPersonId, $address, $insertedCityId, $roleId, $number, $date, $email, $loged, $active)){
                $lastUserId = getLastInsertedId();
                insertPayment($card, $cvv, $lastUserId);
            }
            else{
                deleteFromDb($lastPersonId, "persons", "person");
            }
        }
    }
    else{
        $_SESSION['greskeRegister'] = $greske;
        $output= ["redirect" => true];
        vratiJSON($output, 422);
    }

}
else{
    header("Location: ../../index.php");
}