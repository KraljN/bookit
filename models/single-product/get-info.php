<?php 
    if(isset($_GET["id"])){
        require_once "config/connection.php";
        $prepare = $db->prepare("SELECT DISTINCT b.book_id AS id, bi.path, bi.alt, b.title, p.value AS price, b.description, b.publication_year, per.first_name, per.last_name, pub.publisher_name, b.number_of_pages AS pages 
        FROM book_images bi INNER JOIN books b ON bi.book_id = b.book_id
        LEFT JOIN publishers pub ON pub.publisher_id = b.publisher_id
        LEFT JOIN authors a ON a.author_id = b.author_id INNER JOIN persons per ON a.person_id = per.person_id
        INNER JOIN books_prices bp ON b.book_id = bp.book_id
        INNER JOIN prices p ON (SELECT price_id 
                                FROM books_prices bp
                                WHERE bp.book_id = b.book_id
                                ORDER BY date_become_effective DESC
                                LIMIT 1)  = p.price_id
        WHERE b.book_id = :id");
        $prepare->bindParam(":id", $_GET["id"]);
        $prepare->execute();
        $result = $prepare->fetch();
        $prepareGenres = $db->prepare("SELECT g.genre_name AS genre
        FROM genres g INNER JOIN genres_books gb ON g.genre_id = gb.genre_id
        INNER JOIN books b ON gb.book_id = b.book_id
        WHERE b.book_id = :id");
        $prepareGenres->bindParam(":id", $_GET["id"]);
        $prepareGenres->execute();
        $resultGenres = $prepareGenres->fetchAll();
    }
    else{
        header("Location: ../../index.php?page=home");
    }