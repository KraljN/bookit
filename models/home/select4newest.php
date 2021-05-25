<?php 
   if(isset($_GET["action"]) && ($_GET["action"]=="getNewlyAdded")){
    require_once("../../config/connection.php");
    $data = doSelect("SELECT b.book_id AS id, bi.path, b.date_inserted , bi.alt, b.title, (SELECT p.value
                                                                                  FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                                                                  WHERE bp.book_id = b.book_id
                                                                                  ORDER BY date_become_effective DESC
                                                                                  LIMIT 1) AS price
    FROM book_images bi INNER JOIN books b ON bi.book_id = b.book_id 
    ORDER BY b.date_inserted DESC
    LIMIT 4");
    
    // (SELECT price_id 
    // FROM books_prices bp
    // WHERE bp.book_id = b.book_id
    // ORDER BY date_become_effective DESC
    // LIMIT 1)  = p.price_id
    $code =  count($data)==0?204:200;
    header("Content-Type: application/json");
    echo json_encode($data);
    http_response_code($code);

}
else{
    header("Location: ../../index.php?page=home");
}