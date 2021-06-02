<?php 
    if(isset($_GET["action"]) && $_GET["action"] == "show"){
        require_once "../../config/connection.php";
        require_once "../forbidden/functions.php";

        // var_dump($_GET);
        // sogolisica 27
    
        @ $page = $_GET["pageNumber"];

        $perPage = 4;
        $offset = $perPage * ($page - 1);
    
        $query = "SELECT b.book_id AS id, bi.path, b.date_inserted , bi.alt, b.title, (SELECT p.value
                                                                                        FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                                                                        WHERE bp.book_id = b.book_id
                                                                                        ORDER BY date_become_effective DESC
                                                                                        LIMIT 1) AS price
                   FROM book_images bi INNER JOIN books b ON bi.book_id = b.book_id
                   LIMIT 4
                   OFFSET $offset";
    
        $books = $db -> query($query) -> fetchAll();

        $totalQuery = "SELECT *
                       FROM books";

        $totalPriprema = $db -> prepare ($totalQuery);

         $totalPriprema -> execute();
         $total = $totalPriprema -> rowCount();

        $output = [
            "total" => $total,
            "data" => $books
        ];
    
        vratiJSON($output, 200);
    }
    else{
        header("Location: ../../index.php");
    }
