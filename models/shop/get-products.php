<?php 
    require_once "../../config/connection.php";
    require_once "../forbidden/functions.php";

    $query = "SELECT b.book_id AS id, bi.path, b.date_inserted , bi.alt, b.title, (SELECT p.value
                                                                                    FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                                                                    WHERE bp.book_id = b.book_id
                                                                                    ORDER BY date_become_effective DESC
                                                                                    LIMIT 1) AS price
               FROM book_images bi INNER JOIN books b ON bi.book_id = b.book_id ";

    $books = $db -> query($query) -> fetchAll();

    vratiJSON($books, 201);