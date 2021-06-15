<?php 
if(isset($_GET["actionString"]) && $_GET["actionString"] == "getOrders"){
    require_once("../../../config/connection.php");
    require_once("../../forbidden/functions.php");
    $orderQuery = "SELECT p.first_name AS name, p.last_name AS surname, o.address, os.name AS status, os.order_status_id AS statusId, o.order_id AS id
                   FROM persons p INNER JOIN users u ON p.person_id = u.person_id
                   INNER JOIN orders o ON u.user_id = o.user_id
                   INNER JOIN order_statuses os ON o.order_status_id = os.order_status_id";
    $orderLineQuery = "SELECT order_item_quantity AS quantity, order_item_price AS price, product_name AS pName
                       FROM order_items 
                       WHERE order_id = ?";
    $orderLinePrepare = $db -> prepare($orderLineQuery);

    $orderStatusesQuery = "SELECT name, order_status_id AS id FROM order_statuses";

    $orderStatuses = doSelect($orderStatusesQuery);

    $orders = doSelect($orderQuery);

    foreach($orders as $order){
        $orderLinePrepare -> execute([$order -> id]);
        $order -> orderItems = $orderLinePrepare -> fetchAll();
    }

    $output["orders"] = $orders;
    $output["statuses"] = $orderStatuses;
    vratiJSON($output, 200);
    
}
else{
    header("Location: ../../../index.php");
}