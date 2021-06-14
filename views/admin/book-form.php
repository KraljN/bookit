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
                <div class="col-md-6 d-flex align-items-center justify-content-center form-group">
                    <label for="picture">Book Picture</label>
                </div>
                <div class="col-md-6 form-group">
                    <input type="file" id="picture"/>
                    <span class="text-danger ml-2 "></span>
                    <span class="required-star">*</span>
                </div>
                </div>
                <div class="col-md-12 form-group ">
                    <input type="text" value="<?php if(isset($_GET["id"])) echo($user -> email) ?>" class="form-control input-height mb-2" id="title" name="title" placeholder="Title"/>
                    <span class="required-star">*</span>
                    <span class="text-danger ml-2 wrong d-none">Wrong title format (The Handmaid's Tale)</span>
                </div>
                <div class="row m-0">
                    <div class="container">
                        <textarea class="form-control mb-1" id="description" placeholder="Description" cols="50" rows="3"></textarea>
                        <span class="text-danger"></span>
                    </div>
                </div>
            <div class="row m-0">
                <div class="col-md-6 form-group">
                    <select class="custom-select mb-1" id="year">
                        <option  value="0">Publification Year</option>
                    <?php for($i = $currentYear; $i>$borderYear; $i--): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                    <span class="text-danger ml-2"></span>
                    <span class="required-star">*</span>
                </div>
                <div class="col-md-3 col-sm-6 form-group">
                    <input type="number" min="1" class="form-control input-height mb-2" value="<?php if(isset($_GET["id"])) echo($user -> payments[0] -> card_verification_value) ?>" id="pages" name="pages" placeholder="Number Of Pages"/>
                    <span class="text-danger d-none">Number of pages must be above 0</span>
                    <span class="required-star">*</span>
                </div>
                <div class="col-md-3 col-sm-6 form-group">
                    <input type="number" min="1" class="form-control input-height mb-2" value="<?php if(isset($_GET["id"])) echo($user -> payments[0] -> card_verification_value) ?>" id="price" name="price" placeholder="Price"/>
                    <span class="text-danger  d-none">Price must be above 0</span>
                    <span class="required-star">*</span>
                </div>
            </div>
            <div class="row m-0">
                <div class="col-md-6 form-group">
                    <select class="custom-select mb-1" id="author">
                        <option  value="0">Author</option>
                    <?php foreach($authors as $author): ?>
                        <option value="<?= $author -> id ?>"><?= $author -> name . " " . $author -> surname ?></option>
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
                        <option value="<?= $publisher -> id ?>"><?= $publisher -> name?></option>
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
                            <input class="form-check-input" name="genres" type="checkbox" value="<?= $genre -> id ?>"/>
                            <label class="form-check-label" for="defaultCheck1">
                                <?= $genre -> name ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                    <span class="text-danger ml-2 wrong d-none">You must choose at least 1 genre</span>
                </div>
            </div>
            <div class="row m-0">
            <span class="text-success text-center font-weight-bold successInfo mx-auto"><?php if(!isset($_GET["id"])) echo("Successful added book"); else echo("Book successfully updated") ?></span>
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