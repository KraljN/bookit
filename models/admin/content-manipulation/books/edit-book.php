<?php if(isset($_POST["actionString"]) && $_POST["actionString"] == "editBook"){
    session_start();
    require_once("../../../../config/connection.php");
    require_once("../../../forbidden/functions.php");
    $mb = MB;
    $greske = array();
    $files = null;
    if(isset($_FILES["picture"])){
        $files = $_FILES;
    }
    $_POST["genres"] = explode(",", $_POST["genres"]);
    validateBook($_POST, $files);
    if(count($greske) == 0){
        $bookQuery = "UPDATE books 
                      SET author_id = ?, publisher_id = ?, title = ?, publication_year = ?, description = ?, number_of_pages = ?
                      WHERE book_id = ?";
        $pictureQuery = "UPDATE book_images SET alt = ?, path = ?
                         WHERE book_id = ?";
        $deleteGenreQuery = "DELETE FROM  genres_books 
                             WHERE book_id = ?";
        $lastPriceQuery = "SELECT p.value AS price 
                            FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                            WHERE bp.book_id = ?
                            ORDER BY bp.date_become_effective DESC
                            LIMIT 1";
        $pictureQuery = "UPDATE book_images 
                         SET alt = ?, path = ?
                         WHERE book_id = ?";
        $lastPricePrepare = $db -> prepare($lastPriceQuery);
        $bookUpdatePrepare = $db -> prepare($bookQuery);
        $genreDeletePrepare = $db -> prepare($deleteGenreQuery);
        $pictureUpdatePrepare = $db -> prepare($pictureQuery);
        $pictureName = time() . "_" . $_FILES["picture"]["name"];
        $pictureAlt = explode(".", $_FILES["picture"]["name"])[0];
        $db -> beginTransaction();
        try{
            $bookUpdatePrepare -> execute([$_POST["author"], $_POST["publisher"], $_POST["title"], $_POST["year"], $_POST["description"], $_POST["pages"], $_POST["id"]]);
            $genreDeletePrepare -> execute([$_POST["id"]]);
            insertGenres($_POST["genres"], $_POST["id"]);
            $lastPricePrepare -> execute([$_POST["id"]]);
            $lastPrice = floatval($lastPricePrepare -> fetch() -> price);
            if($lastPrice != floatval($_POST["price"])){
                insertPrice($_POST["price"], $_POST["id"]);
            }
            if($files != null){
                $previousPicturePath = getPicturePath($_POST["id"]);
                unlink(IMG_PATH . "thumb-" . $previousPicturePath);
                unlink(IMG_PATH .  $previousPicturePath);
                saveResizedImage($_FILES["picture"]);
                $isMoved = move_uploaded_file($_FILES["picture"]["tmp_name"], IMG_PATH . $pictureName);
                if($isMoved){
                    try{
                        $pictureUpdatePrepare -> execute([$pictureAlt, $pictureName, $_POST["id"]]);
                    }
                    catch(PDOException $ex){
                        logError($ex->getMessage(), "image-update");
                        $message = "Error updating image for book";
                        $db->rollBack();
                        vratiJSON(["message"=>$message], 500);
                    }
            }
            }
             $db -> commit();
             vratiJSON(["message"=> "success"], 204);
        }
        catch(PDOException $ex){
            logError($ex->getMessage(), "book-update");
            $message = "Error updating book";
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
