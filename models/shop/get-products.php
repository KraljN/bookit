<?php 
    if(isset($_GET["action"]) && $_GET["action"] == "show"){
        require_once "../../config/connection.php";
        require_once "../forbidden/functions.php";
        @ $page = $_GET["pageNumber"];


        $hasFilter = false;
        $hasOrder = false;
        //===========ORDER DEO============
        if(isset($_GET["order"])){
            $hasOrder = true;
            $order = $_GET["order"];
            list($what, $how) = explode("-", $order);
            if($what == "word") $what = "b.title";
            $how = strtoupper($how);
        }
        // $order = $_GET["order"];
        // list($what, $how) = explode("-", $order);
        // if($what == "word") $what = "b.title";
        // $how = strtoupper($how);
        //===================================


        //===========OFFSET DEO===========
        $perPage = 4;
        $offset = $perPage * ($page - 1);
        //================================


        $whereQuery = " WHERE ";

        //============AUTHORS============
        if(isset($_GET["authors"])){
            $hasFilter = true;
            $authors = $_GET["authors"];
            $authorQuery = "";
            $lastAuthorId = end($authors);
            foreach($authors as $index => $author){
                if($index == 0 && $author == $lastAuthorId){
                    $authorQuery .= "b.author_id = $author "; 
                }
                else if($index == 0){
                    $authorQuery .= "(b.author_id = $author OR ";
                }
                else if($author == $lastAuthorId){
                    $authorQuery .= "b.author_id = $author) "; 
                }

                else{
                    $authorQuery .= "b.author_id = $author OR ";
                }
            }
            $whereQuery .= $authorQuery;
        }
        //=====================================


        //===============PUBLISHER DEO=========
        if(isset($_GET["publishers"])){
            $hasFilter = true;
            $publishers = $_GET["publishers"];
            $publisherQuery = "";
            $lastPublisherId = end($publishers);
            foreach($publishers as $index => $publisher){
                if($index == 0 && $publisher == $lastPublisherId){
                    $publisherQuery .= "b.publisher_id = $publisher "; 
                }
                else if($index == 0){
                    $publisherQuery .= "(b.publisher_id = $publisher OR ";
                }
                else if($publisher == $lastPublisherId){
                    $publisherQuery .= "b.publisher_id = $publisher) "; 
                }

                else{
                    $publisherQuery .= "b.publisher_id = $publisher OR ";
                }
            }
            if(strpos($whereQuery, "=") != null){
                $whereQuery.= "AND $publisherQuery ";
            }
            else{
                $whereQuery .= $publisherQuery;
            }
        }
        //============================================


        //================PRICES DEO===================
        if(isset($_GET["prices"])){
            $hasFilter = true;
            $priceRanges = $_GET["prices"];
            $priceQuery = "";
            $lastPriceRange = end($priceRanges);
            foreach($priceRanges as  $index => $priceRange){
                if($index == 0 && $priceRange == $lastPriceRange){
                    if(strpos($priceRange, "-") != null){
                        list($min, $max) = explode("-", $priceRange);
                        $priceQuery .= "(SELECT p.value
                                        FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                        WHERE bp.book_id = b.book_id
                                        ORDER BY date_become_effective DESC
                                        LIMIT 1) > $min AND (SELECT p.value
                                                            FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                                            WHERE bp.book_id = b.book_id
                                                            ORDER BY date_become_effective DESC
                                                            LIMIT 1) <= $max ";
                    }
                    else{
                        list($min, $max) = explode("+", $priceRange);
                        $priceQuery .= "(SELECT p.value
                                        FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                        WHERE bp.book_id = b.book_id
                                        ORDER BY date_become_effective DESC
                                        LIMIT 1) > $min ";
                    }
                }
                else if($index == 0){
                    if(strpos($priceRange, "-") != null){
                        list($min, $max) = explode("-", $priceRange);
                        $priceQuery .= "((SELECT p.value
                                        FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                        WHERE bp.book_id = b.book_id
                                        ORDER BY date_become_effective DESC
                                        LIMIT 1) > $min AND (SELECT p.value
                                                            FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                                            WHERE bp.book_id = b.book_id
                                                            ORDER BY date_become_effective DESC
                                                            LIMIT 1) <= $max OR ";
                    }
                    else{
                        list($min, $max) = explode("+", $priceRange);
                        $priceQuery .= "((SELECT p.value
                                        FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                        WHERE bp.book_id = b.book_id
                                        ORDER BY date_become_effective DESC
                                        LIMIT 1) > $min OR ";
                    }
                }   
                else if($priceRange == $lastPriceRange){
                    if(strpos($priceRange, "-") != null){
                        list($min, $max) = explode("-", $priceRange);
                        $priceQuery .= "(SELECT p.value
                                        FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                        WHERE bp.book_id = b.book_id
                                        ORDER BY date_become_effective DESC
                                        LIMIT 1) > $min AND (SELECT p.value
                                                            FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                                            WHERE bp.book_id = b.book_id
                                                            ORDER BY date_become_effective DESC
                                                            LIMIT 1) <= $max) ";
                    }
                    else{
                        list($min, $max) = explode("+", $priceRange);
                        $priceQuery .= "(SELECT p.value
                                        FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                        WHERE bp.book_id = b.book_id
                                        ORDER BY date_become_effective DESC
                                        LIMIT 1) > $min) ";
                    }
                }
                else{
                    if(strpos($priceRange, "-") != null){
                        list($min, $max) = explode("-", $priceRange);
                        $priceQuery .= "(SELECT p.value
                                        FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                        WHERE bp.book_id = b.book_id
                                        ORDER BY date_become_effective DESC
                                        LIMIT 1) > $min AND (SELECT p.value
                                                            FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                                            WHERE bp.book_id = b.book_id
                                                            ORDER BY date_become_effective DESC
                                                            LIMIT 1) <= $max OR ";
                    }
                    else{
                        list($min, $max) = explode("+", $priceRange);
                        $priceQuery .= "(SELECT p.value
                                        FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                        WHERE bp.book_id = b.book_id
                                        ORDER BY date_become_effective DESC
                                        LIMIT 1) > $min OR ";
                    }
                }

            }
            if(strpos($whereQuery, "=") != null){
                $whereQuery.= "AND $priceQuery ";
            }
            else{
                $whereQuery .= $priceQuery;
            }
        }
        //=============================================

        //===================GENRES DEO================
        if(isset($_GET["genres"])){
            $hasFilter = true;
            $genres = $_GET["genres"];
            $genreQuery = "";
            $lastGenreId = end($genres);
            foreach($genres as $index => $genre){
                if($index == 0 && $genre == $lastGenreId){
                    $genreQuery .= "gb.genre_id = $genre ";
                }
                else if($index == 0){
                    $genreQuery .= "(gb.genre_id = $genre OR ";
                }
                else if($genre == $lastGenreId){
                    $genreQuery .= "gb.genre_id = $genre) "; 
                }
                else{
                    $genreQuery .= "gb.genre_id = $genre OR ";
                }
            }
            if(strpos($whereQuery, "=") != null){
                $whereQuery.= "AND $genreQuery ";
            }
            else{
                $whereQuery .= $genreQuery;
            }
        }
        //=====================================================

        //=======================SEARCH DEO=====================
        if(!empty($_GET["search"])){
            $hasFilter = true;
            $lowerSearch = strtolower($_GET["search"]);
            $search = "%$lowerSearch%";
            $searchQuery = "LOWER(b.title) LIKE '$search' ";
            if(strpos($whereQuery, "=") != null){
                $whereQuery.= "AND  $searchQuery";
            }
            else{
                $whereQuery .= $searchQuery;
            }
        }
        //========================================================


    
        $query = "SELECT DISTINCT b.book_id AS id, bi.path, b.date_inserted , bi.alt, b.title, (SELECT p.value
                                                                                        FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                                                                        WHERE bp.book_id = b.book_id
                                                                                        ORDER BY date_become_effective DESC
                                                                                        LIMIT 1) AS price
                   FROM book_images bi INNER JOIN books b ON bi.book_id = b.book_id
                   INNER JOIN genres_books gb ON b.book_id = gb.book_id
                   ";
                   if($hasFilter) $query .= $whereQuery;
                   if($hasOrder) $query .= "ORDER BY $what $how ";
                   $query .= "LIMIT 4
                   OFFSET $offset";
                //    var_dump($query);
    
        $books = $db -> query($query) -> fetchAll();

        $totalQuery = "SELECT DISTINCT b.book_id
                       FROM books b INNER JOIN genres_books gb ON b.book_id = gb.book_id";

        if($hasFilter) $totalQuery .= $whereQuery;


                //    var_dump($totalQuery);



        $total = $db -> query($totalQuery) -> rowCount();

        $output = [
            "total" => $total,
            "data" => $books
        ];
    
        vratiJSON($output, 200);
    }
    else{
        header("Location: ../../index.php");
    }
