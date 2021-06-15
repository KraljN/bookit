<?php
require_once "../../config/connection.php";

$query = "SELECT b.book_id AS id, b.title, b.number_of_pages AS number, b.publication_year AS year, pb.publisher_name AS publisher, p.first_name AS name, p.last_name AS  surname, (SELECT p.value
                                                                          FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                                                          WHERE bp.book_id = b.book_id
                                                                          ORDER BY date_become_effective DESC
                                                                          LIMIT 1) AS price
        FROM  books b LEFT JOIN publishers pb ON b.publisher_id = pb.publisher_id
        INNER JOIN authors a ON b.author_id = a.author_id
        INNER JOIN persons p ON p.person_id = a.person_id";

$books = doSelect($query);
$date = date("d-m-Y");

$queryGenre = "SELECT g.genre_name 
FROM genres g INNER JOIN genres_books gb ON g.genre_id = gb.genre_id 
WHERE gb.book_id = ?";

$genrePrepare = $db -> prepare($queryGenre);

foreach($books AS $book){
    $genrePrepare -> execute([$book -> id]);
    $book-> genres = $genrePrepare -> fetchAll();
}
$file="books_info_" . $date . ".xls";
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$file");
?>
<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Publisher</th>
            <th>Genres</th>
            <th>Publification Year</th>
            <th>Number Of Pages</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($books as $book): ?>
        <tr>
            <td><?= $book -> title ?></td>
            <td><?= $book -> name . " " . $book -> surname ?></td>
            <td><?= $book -> publisher ?></td>
            <td>
                <?php foreach($book -> genres as  $index => $genre){
                    if($index != 0){
                        echo(",");
                    }
                    echo(" " . $genre -> genre_name);

                } ?>
            </td>
            <td><?= $book -> year ?></td>
            <td><?= $book -> number ?></td>
            <td><?= $book -> price . "&euro;" ?></td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
