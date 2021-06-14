<?php if(isset($_POST["actionString"]) && $_POST["actionString"] == "addBook"){
    session_start();
    require_once("../../../../config/connection.php");
    require_once("../../../forbidden/functions.php");
    $mb = MB;
    $greske = array();
    if(!isset($_FILES["picture"])){
        array_push($greske, "You must provide picture");
    }
    $_POST["genres"] = explode(",", $_POST["genres"]);
    validateBook($_POST, $_FILES);
    if(count($greske) == 0){
        $pictureName = time() . "_" . $_FILES["picture"]["name"];
        $pictureAlt = explode(".", $_FILES["picture"]["name"])[0];
        $bookQuery = "INSERT INTO books VALUES(NULL, ?, ?, ?, ?, ?, ?, ?)";
        $genreQuery = "INSERT INTO genres_books VALUES(NULL, ?, ?)";
        $priceBookQuery = "INSERT INTO books_prices VALUES(NULL, ?, ?, ?)";
        $priceQuery = "INSERT INTO prices VALUES(NULL, ?)";
        $pictureQuery = "INSERT INTO book_images VALUES(NULL, ?, ?, ?)";
        $genreInsertPrepare = $db -> prepare($genreQuery);
        $bookInsertPrepare = $db -> prepare($bookQuery);
        $date = date("Y-m-d H:i:s");
        $db -> beginTransaction();
        try{
             $isInsertedBook = $bookInsertPrepare -> execute([$_POST["author"], $_POST["publisher"], $_POST["title"], $_POST["year"], $_POST["description"], $_POST["pages"], $date]);
            if($isInsertedBook){
                $bookId = getLastInsertedId();
                    foreach(@$_POST["genres"] as $genre){
                        try{
                        $genreInsertPrepare -> execute([$genre, $bookId]);
                        }
                        catch(PDOException $ex){
                            logError($ex->getMessage(), "genre-book-insert");
                            $message = "Error linking genre with book";
                            $db->rollBack();
                            vratiJSON(["message"=>$message], 500);
                        }
                    }
                    $priceId = getPriceId($_POST["price"]);
                    if(!$priceId){
                        $pricePrepare = $db -> prepare($priceQuery);
                        try{
                            $pricePrepare -> execute([$_POST["price"]]);
                            $priceId = getLastInsertedId();
                        }
                        catch(PDOException $ex){
                            logError($ex->getMessage(), "price-insert");
                            $message = "Error inserting price";
                            $db->rollBack();
                        }
                    }
                    $priceBookPrepare = $db -> prepare($priceBookQuery);
                    try{
                        $priceBookPrepare -> execute([$bookId, $priceId, $date]);
                    }
                    catch(PDOException $ex){
                        logError($ex->getMessage(), "book-price-insert");
                        $message = "Error linking price with book";
                        $db->rollBack();
                        vratiJSON(["message"=>$message], 500);
                    }
                        saveResizedImage($_FILES["picture"]);
                       $isMoved = move_uploaded_file($_FILES["picture"]["tmp_name"], IMG_PATH . $pictureName);
                       if($isMoved){
                            $imagePrepare = $db -> prepare($pictureQuery);
                            try{
                                $imagePrepare -> execute([$pictureAlt, $pictureName, $bookId]);
                            }
                            catch(PDOException $ex){
                                logError($ex->getMessage(), "image-insert");
                                $message = "Error inserting image for book";
                                $db->rollBack();
                                vratiJSON(["message"=>$message], 500);
                            }
                       }
                       vratiJSON(["message"=>"ok"], 201);
                       $db -> commit();
            }
        }
        catch(PDOException $ex){
            logError($ex->getMessage(), "book-insert");
            $message = "Error entering book";
            $db->rollBack();
            vratiJSON(["message"=>$message], 500);
        }
    }
    else{
        $_SESSION["greske"] = $greske;
        vratiJSON(["reload" => true] , 422);
    }
}
else{
    header("Location: ../../../../index.php");
}