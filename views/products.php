<!-- NOTIFICATION -->
<div class="row">
        <div class="col-10 col-sm-6 col-md-5 col-lg-4  justify-content-center align-items-center mx-auto fixed-bottom rounded" id="popUp">
            <p class=" text-white my-2 text-center"></p>
        </div>
</div>
<!-- END OF NOTIFICATION -->
<?php    
    require_once "config/connection.php";
    $authorsQuery = "SELECT a.author_id AS id, p.first_name AS name, p.last_name AS surname, COUNT(b.book_id) AS book_number
                     FROM persons p INNER JOIN authors a ON p.person_id = a.person_id
                     INNER JOIN books b ON a.author_id = b.author_id
                     GROUP BY a.author_id";
    $authors = $db -> query($authorsQuery) -> fetchAll();

    $categoriesQuery = "SELECT g.genre_id AS id, g.genre_name AS name, COUNT(b.book_id) AS book_number
                        FROM genres g INNER JOIN genres_books gb ON g.genre_id = gb.genre_id
                        INNER JOIN books b ON gb.book_id = b.book_id
                        GROUP BY g.genre_id";
    $genres = $db -> query($categoriesQuery) -> fetchAll();

    $prices

?>
<input type="hidden" id="pageNumber" value="<?= isset($_GET["pageNumber"]) ? $_GET["pageNumber"] : 1 ?>"/>
<section class="static about-sec mb-0">
        <div class="container">
            <h1 class="mb-5">Book it shop offer</h1>
            <div class="recent-book-sec mb-0">
                <div class="row justify-content-around m-0">
                    <div class="col-md-6 col-lg-4 px-5">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="font-weight-bold text-left">Order By</label>
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option>Price Descending</option>
                                <option>Price Ascending</option>
                                <option>A-Z</option>
                                <option>Z-A</option>
                            </select>
                        </div>
                        <div class="form-group text-center">
                            <label class="font-weight-bold text-center">Authors</label>
                            <div class="d-flex flex-column align-items-start">
                            <?php foreach($authors as $author): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="authors[]" value="<?= $author -> id ?>"/>
                                    <label class="form-check-label">
                                        <?= $author -> name . " " . $author -> surname . " (" . $author -> book_number . ")" ?>
                                    </label>
                                </div>
                            <?php endforeach ?>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <label class="font-weight-bold text-center">Genres</label>
                            <div class="d-flex flex-column align-items-start">
                            <?php foreach($genres as $genre): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="genres[]" value="<?= $genre -> id ?>"/>
                                    <label class="form-check-label">
                                        <?= $genre -> name . " (" . $genre -> book_number . ")" ?>
                                    </label>
                                </div>
                            <?php endforeach ?>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <label class="font-weight-bold text-center">Prices</label>
                            <div class="d-flex flex-column align-items-start">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="prices" value="0-5"/>
                                    <label class="form-check-label priceCheckboxLabel">
                                        0-5 &euro;
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="prices" value="5-7.5"/>
                                    <label class="form-check-label priceCheckboxLabel">
                                        5-7.5 &euro;
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="prices" value="7.5-10"/>
                                    <label class="form-check-label priceCheckboxLabel">
                                        7.5-10 &euro;
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="prices" value="10+"/>
                                    <label class="form-check-label priceCheckboxLabel">
                                        10+ &euro;
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <label class="font-weight-bold text-center">Publishers</label>
                            <div class="d-flex flex-column align-items-start">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="exampleRadios" id="exampleRadios1" value="option1"/>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Cambridge University Press
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="exampleRadios" id="exampleRadios1" value="option1"/>
                                    <label class="form-check-label" for="exampleRadios1">
                                        McClelland and Stewart
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="exampleRadios" id="exampleRadios1" value="option1"/>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Olympia Press
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                    <div class="row mb-2 mx-0"> 
                    <div class="input-group  mr-sm-2 d-flex justify-content-center align-items-center w-100">
                        <form action="#" class="form-inline d-flex justify-content-center align-items-center">
                            <div class="input-group mr-1 mb-1">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></div>
                                </div>
                                <input type="text" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Search By Title">
                            </div>
                            <button type="submit" class="btn default-padding mb-1">Search</button>
                        </form>
                    </div>
                    </div>
                        <div class="row m-0" id="books"> </div>  
                    </div>
                </div>
            </div>
        </div>
    </section>