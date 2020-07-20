<?php 
   if(isset($_GET["action"]) && ($_GET["action"]=="getNewlyAdded")){
    require_once("../../config/connection.php");
    $data = doSelect("SELECT DISTINCT bi.path, bi.alt, b.title, p.value 
    FROM book_images bi INNER JOIN books b ON bi.book_id = b.book_id 
    INNER JOIN books_prices bp ON b.book_id = bp.book_id
    INNER JOIN prices p ON (SELECT price_id 
                            FROM books_prices bp
                            WHERE bp.book_id = b.book_id
                            ORDER BY date_become_effective DESC
                            LIMIT 1)  = p.price_id ");
    $code =  count($data)==0?204:200;
    header("Content-Type: application/json");
    echo json_encode($data);
    http_response_code($code);

}
else{
    header("Location: ../../index.php?page=home");
    //uneti u log fajl da je pokusan prekrsaj
}