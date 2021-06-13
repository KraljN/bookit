<?php if(isset($_GET["action"]) && $_GET["action"] == "getUsers"){
        require_once("../../../../config/connection.php");
        require_once("../../../forbidden/functions.php");
        $query = "SELECT p.first_name AS name, p.last_name AS surname, u.phone_number, u.username, u.addres, c.city_name, co.country_name, u.active, u.user_id AS id, u.email, r.role_name AS role 
                  FROM persons p INNER JOIN users u ON p.person_id = u.person_id
                  LEFT JOIN roles r ON u.role_id = r.role_id 
                  INNER JOIN cities c ON u.city_id = c.city_id 
                  INNER JOIN countries co ON c.country_id = co.country_id";
        $paymentQuery = "SELECT p.card_number, p.card_verification_value 
                         FROM payments p INNER JOIN users_payments up ON p.payment_id = up.payment_id
                         WHERE up.user_id = ?";
        $output = doSelect($query);
        foreach($output as $user){
            $paymentPrepare = $db -> prepare($paymentQuery);
            $paymentPrepare -> execute([$user -> id]);
            $payments = $paymentPrepare -> fetchAll();
            $user -> payments = $payments;
        }
        vratiJSON($output, 200);
}
else{
    header("Location: ../../../../index.php");
}