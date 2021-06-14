<?php
    require_once("config/connection.php");
    require_once("models/forbidden/functions.php");
    $currentYear = intval(date("Y"));
    $borderYear = $currentYear - 50;

    $authorQuery = "SELECT p.first_name AS name, p.last_name AS surname, a.author_id AS id
                    FROM persons p INNER JOIN authors a ON p.person_id = a.person_id";
    $authors = doSelect($authorQuery);

    $publisherQuery = "SELECT publisher_id AS id, publisher_name AS name
                       FROM publishers";
    $publishers = doSelect($publisherQuery);

    $genresQuery = "SELECT genre_id AS id, genre_name AS name
                    FROM genres";
    $genres = doSelect($genresQuery);

    if(isset($_GET["id"])){
        $queryBook = "SELECT b.book_id AS id, bi.path, bi.alt, (SELECT p.value
                                                            FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                                            WHERE bp.book_id = b.book_id
                                                            ORDER BY date_become_effective DESC
                                                            LIMIT 1) AS price, b.title, p.first_name AS name, p.last_name AS  surname,
                                                            b.description, b.number_of_pages AS number, b.publication_year AS year, b.author_id AS author,
                                                            b.publisher_id AS publisher
                  FROM book_images bi  
                  INNER JOIN books b ON bi.book_id = b.book_id 
                  INNER JOIN authors a ON b.author_id = a.author_id
                  INNER JOIN persons p ON p.person_id = a.person_id
                  WHERE b.book_id = ?";
        $bookPrepare = $db -> prepare($queryBook);
        $bookPrepare -> execute([$_GET["id"]]);
        $book = $bookPrepare -> fetch();
        $queryGenre = "SELECT g.genre_id
                       FROM genres g INNER JOIN genres_books gb ON g.genre_id = gb.genre_id
                       WHERE gb.book_id = ?";
        $genrePrepare = $db -> prepare($queryGenre);
        $genrePrepare -> execute([$_GET["id"]]);
        $genresResult = $genrePrepare -> fetchAll();
        $genreIds = array();
        foreach($genresResult as $genre){
            array_push($genreIds, $genre->genre_id);
        }

    }
?>


<div id="admin">
  <input type="hidden" id="id" value="<?php if(isset($_GET["id"])) echo($_GET["id"]) ?>" />
  <div class="wraper">
    <?php include "views/fixed/admin-sidebar.php" ?>
    <div class="main-panel ps-container ps-theme-default ps-active-y" data-ps-id="f7afacc4-17e4-875c-6b50-56b077e542ea">
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
          <div class="container-fluid">
            <div class="navbar-wrapper">
              <a class="navbar-brand"></a>
            </div>
            <button class="navbar-toggler mr-4" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
              <span class="sr-only">Toggle navigation</span>
              <span class="navbar-toggler-icon icon-bar"></span>
              <span class="navbar-toggler-icon icon-bar"></span>
              <span class="navbar-toggler-icon icon-bar"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end">
            </div>
          </div>
        </nav>
        <div class="content px-0">
            <div class="col-12 col-xl-10 col-xxl-8 mx-auto">
              <div class="card" id="menu-item-add-form">
                <div class="card-header card-header-primary">
                  <h4 class="card-title"><?php if(!isset($_GET["id"])) echo("Add"); else echo("Edit") ?> Book</h4>
                  <p class="card-category"><?php if(!isset($_GET["id"])) echo("Add book to your site"); else echo("Edit book on your site") ?></p>
                </div>
                <div class="card-body">
            <form class="row" action="obrada.php" enctype="multipart/form-data" method="post">
            <div class="row m-0">
                <div class="col-md-6 d-flex align-items-center justify-content-center form-group d-flex flex-column">
                <?php if(isset($_GET['id'])):?>
                    <img src="<?= DISPLAY_IMG_PATH  . "thumb-" .  $book -> path ?>" class="img-fluid mb-2" alt="<?= $book -> path ?>"/>
                <?php endif; ?>
                    <label for="picture">Book Picture</label>
                </div>
                <div class="col-md-6 form-group d-flex flex-column justify-content-center">
                    <input type="file" id="picture"/>
                    <span class="text-danger ml-2 "></span>
                    <span class="required-star">*</span>
                </div>
                </div>
                <div class="col-md-12 form-group ">
                    <input type="text" value="<?php if(isset($_GET["id"])) echo($book -> title) ?>" class="form-control input-height mb-2" id="title" name="title" placeholder="Title"/>
                    <span class="required-star">*</span>
                    <span class="text-danger ml-2 wrong d-none">Wrong title format (The Handmaid's Tale)</span>
                </div>
                <div class="row m-0">
                    <div class="container">
                        <textarea class="form-control mb-1" id="description" placeholder="Description" cols="50" rows="3"><?php if(isset($_GET["id"])) echo($book -> description) ?></textarea>
                        <span class="text-danger"></span>
                    </div>
                </div>
            <div class="row m-0">
                <div class="col-md-6 form-group">
                    <select class="custom-select mb-1" value="" id="year">
                        <option  value="0">Publification Year</option>
                    <?php for($i = $currentYear; $i>$borderYear; $i--): ?>
                        <option <?php if(isset($_GET["id"]) && $book -> year == $i) echo('selected="selected"') ?> value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                    <span class="text-danger ml-2"></span>
                    <span class="required-star">*</span>
                </div>
                <div class="col-md-3 col-sm-6 form-group">
                    <input type="number" min="1" class="form-control input-height mb-2" value="<?php if(isset($_GET["id"])) echo($book -> number) ?>" id="pages" name="pages" placeholder="Number Of Pages"/>
                    <span class="text-danger d-none">Number of pages must be above 0</span>
                    <span class="required-star">*</span>
                </div>
                <div class="col-md-3 col-sm-6 form-group">
                    <input type="number" min="1" step="any" class="form-control input-height mb-2" value="<?php if(isset($_GET["id"])) echo($book -> price) ?>" id="price" name="price" placeholder="Price"/>
                    <span class="text-danger  d-none">Price must be above 0</span>
                    <span class="required-star">*</span>
                </div>
            </div>
            <div class="row m-0">
                <div class="col-md-6 form-group">
                    <select class="custom-select mb-1" id="author">
                        <option  value="0">Author</option>
                    <?php foreach($authors as $author): ?>
                        <option <?php if(isset($_GET["id"]) && $book -> author == $author -> id) echo('selected="selected"') ?>  value="<?= $author -> id ?>"><?= $author -> name . " " . $author -> surname ?></option>
                    <?php endforeach; ?>
                    </select>
                    <span class="text-danger"></span>
                    <span class="required-star">*</span>
                    <span class="text-danger ml-2 d-none">You must choose author</span>
                </div>
                <div class="col-md-6 form-group">
                    <select class="custom-select mb-1" id="publisher">
                        <option  value="0">Publisher</option>
                    <?php foreach($publishers as $publisher): ?>
                        <option <?php if(isset($_GET["id"]) && $book -> publisher == $publisher -> id) echo('selected="selected"') ?> value="<?= $publisher -> id ?>"><?= $publisher -> name?></option>
                    <?php endforeach; ?>
                    </select>
                    <span class="text-danger"></span>
                    <span class="required-star">*</span>
                    <span class="text-danger ml-2 d-none">You must choose publisher</span>
                </div>
            </div>
            <div class="row m-0 flex-column">
                <div class="container">
                    <?php foreach($genres as $genre): ?>
                        <div class="form-check">
                            <input class="form-check-input" <?php if(isset($_GET["id"]) && in_array($genre -> id, $genreIds)) echo('checked="checked"') ?> name="genres" type="checkbox" value="<?= $genre -> id ?>"/>
                            <label class="form-check-label">
                                <?= $genre -> name ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                    <span class="text-danger ml-2 wrong d-none">You must choose at least 1 genre</span>
                </div>
            </div>
            <div class="row m-0">
            <span class="text-success text-center font-weight-bold successInfo mx-auto"><?php if(!isset($_GET["id"])) echo("Successful added book"); else echo("Book successfully updated. Reload page to see changes") ?></span>
            <span class="text-danger text-center font-weight-bold mb-3 errorInfo mx-auto">Error encountered. Please try again later</span>
            </div>
            <div class="row m-0">
            <input type="submit" value="<?php if(isset($_GET["id"])) echo("Edit"); else echo("Add") ?>" class="btn btn-primary ml-auto mt-3" name="register" id="<?php if(isset($_GET["id"])) echo("edit-user-submit"); else echo ("add-book-submit") ?>"/>
                <div class="clearfix"></div>
            </div>
            <div class="row m-0 d-flex justify-content-center">
            <?php if(isset($_SESSION["greske"])): ?>
                    <ul class="text-center">
                        <?php foreach($_SESSION["greske"] as $greska): ?>
                            <li class="text-danger"><?= $greska ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php
                 endif;
                 unset($_SESSION["greske"]);
            ?>
            </div>
        </form>
                </div>
                </div>
                </div>
              </div>
            </div>
        </div>
    </div>
  </div>
</div>