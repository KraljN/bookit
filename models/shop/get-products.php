<?php 
    if(isset($_GET["action"]) && $_GET["action"] == "show"){
        require_once "../../config/connection.php";
        require_once "../forbidden/functions.php";
        @ $page = $_GET["pageNumber"];

        //===========ORDER DEO============
        $order = $_GET["order"];
        list($what, $how) = explode("-", $order);
        if($what == "word") $what = "b.title";
        $how = strtoupper($how);
        //===================================


        //===========OFFSET DEO===========
        $perPage = 4;
        $offset = $perPage * ($page - 1);
        //================================


        $whereQuery = " WHERE ";

        $hasFilter = false;

        //============AUTHORS============
        if(isset($_GET["authors"])){
            $hasFilter = true;
            $authors = $_GET["authors"];
            $authorQuery = "";
            $lastAuthorId = end($authors);
            foreach($authors as $index => $author){
                if($author != $lastAuthorId){
                    $authorQuery .= "b.author_id = $author OR "; 
                }
                else{
                    $authorQuery .= "b.author_id = $author ";
                }
            }
            $whereQuery .= $authorQuery;
        }
        //=====================================

        if(isset($_GET["genres"])){
            $hasFilter = true;
            $genres = $_GET["authors"];
            $genresQuery = "";
            $lastIndex = end($genres);
            foreach($genres as $index => $genre){
                if($index != $lastIndex){
                    $genresQuery .= "b.author_id = $genre OR"; 
                }
                else{
                    $genresQuery .= "b.author_id = $genre ";
                }
            }
            $whereQuery .= $genresQuery;
        }

    
        $query = "SELECT b.book_id AS id, bi.path, b.date_inserted , bi.alt, b.title, (SELECT p.value
                                                                                        FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                                                                        WHERE bp.book_id = b.book_id
                                                                                        ORDER BY date_become_effective DESC
                                                                                        LIMIT 1) AS price
                   FROM book_images bi INNER JOIN books b ON bi.book_id = b.book_id
                   ";
                    if($hasFilter) $query .= $whereQuery;
                   $query .= "ORDER BY $what $how
                   LIMIT 4
                   OFFSET $offset";
                //    var_dump($query);
    
        $books = $db -> query($query) -> fetchAll();

        $totalQuery = "SELECT *
                       FROM books b";

        if($hasFilter) $totalQuery .= $whereQuery;

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
