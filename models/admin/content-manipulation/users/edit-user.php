<?php 
session_start();
if(isset($_POST["actionString"]) && $_POST["actionString"] == "editUser"){
    require_once("../../../../config/connection.php");
    require_once("../../../forbidden/functions.php");
    $name = $_POST["name"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $id = $_POST["id"];
    $username = $_POST["username"];
    $creditCard = $_POST["creditCard"];
    $obradjenCredit = str_replace('-',"", $creditCard);
    $country = $_POST["country"];
    $city = $_POST["city"];
    $address = $_POST["address"];
    $number = $_POST["number"];
    $cvv = $_POST["cvv"];
    $roleId=$_POST["role"];
 
    $greske = validateUser($_POST, false);
    if(count($greske) == 0){
        $card = str_replace('-', '', $creditCard);
        $countryId = getCountryId($country);
        $cityId = getCityId($city);
        $date = date("Y-m-d H:i:s");
        if((!$countryId && !$cityId) || (!$countryId && $cityId)){
            insertCountry($country);
            $insertedCountryId = getCountryId($country);
            insertCity( $city, $insertedCountryId);
            $insertedCityId = getCityId($city);
            $paymentId = getPaymentId($id);
            // insertPerson($name, $lastName);
            // $lastPersonId = getLastInsertedId();
            // if(insertUser($username, $password, $lastPersonId, $address, $insertedCityId, $roleId, $number, $date, $email, $loged, $active)){
            //     $lastUserId = getLastInsertedId();
            //     insertPayment($card, $cvv, $lastUserId);
            // }
            // else{
            //     deleteFromDb($lastPersonId, "persons", "person");
            // }

        }
        if($countryId && !$cityId){
            $insertedCountryId = getCountryId($country); 
            insertCity($city, $insertedCountryId);
            $insertedCityId = getCityId($city);
            // insertPerson($name, $lastName);
            // $lastPersonId = getLastInsertedId();
            // if(insertUser($username, $password, $lastPersonId, $address, $insertedCityId, $roleId, $number, $date, $email, $loged, $active)){
            //     $lastUserId = getLastInsertedId();
            //     insertPayment($card, $cvv, $lastUserId);
            // }
            // else{
            //     deleteFromDb( $lastPersonId, "persons", "person");
            // }
        }
        if($countryId && $cityId){
            $insertedCityId = getCityId($city);
            // insertPerson($name, $lastName);
            // $lastPersonId = getLastInsertedId();
            // if(insertUser($username, $password, $lastPersonId, $address, $insertedCityId, $roleId, $number, $date, $email, $loged, $active)){
            //     $lastUserId = getLastInsertedId();
            //     insertPayment($card, $cvv, $lastUserId);
            // }
            // else{
            //     deleteFromDb($lastPersonId, "persons", "person");
            // }
        }
        if(
            updatePerson($name, $lastName, $id) &&
            updateUser($username, $address, $insertedCityId, $roleId, $number, $email, $id ) &&
            updatePayment($obradjenCredit, $cvv, $id)
        ){
            vratiJSON(["message" => "success"], 204);
        }
    }
    else{
        $_SESSION['greske'] = $greske;
        $output= ["redirect" => true];
        vratiJSON($output, 422);
    }

}
else{
    header("Location: ../../index.php?page=login");
}