<?php if(isset($_GET["actionString"]) && $_GET["actionString"] == "displayBooks"){
        require_once("../../../../config/connection.php");
        require_once("../../../forbidden/functions.php");
        $query = "SELECT b.book_id AS id, bi.path, bi.alt, (SELECT p.value
                                                            FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                                            WHERE bp.book_id = b.book_id
                                                            ORDER BY date_become_effective DESC
                                                            LIMIT 1) AS price, b.title, p.first_name AS name, p.last_name AS  surname
                  FROM book_images bi  
                  INNER JOIN books b ON bi.book_id = b.book_id 
                  INNER JOIN authors a ON b.author_id = a.author_id
                  INNER JOIN persons p ON p.person_id = a.person_id";

        $books = doSelect($query);

        $queryGenre = "SELECT g.genre_name 
                       FROM genres g INNER JOIN genres_books gb ON g.genre_id = gb.genre_id 
                       WHERE gb.book_id = ?";

        $genrePrepare = $db -> prepare($queryGenre);

        foreach($books AS $book){
            $genrePrepare -> execute([$book -> id]);
            $book-> genres = $genrePrepare -> fetchAll();
        }

        vratiJSON($books, 200);
}
else{
    header("Location: ../../../../index.php");
}