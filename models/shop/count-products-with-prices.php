<?php 
    if(isset($_GET["action"]) && $_GET["action"] == "countBooks"){
        require_once "../../config/connection.php";
        require_once "../forbidden/functions.php";
        $checkBoxes = $_GET["nizCheckbox"];
        $output = array();
        foreach($checkBoxes as $checkBox){
            if (strpos($checkBox, '+') == false) {
                list($min, $max) = explode("-", $checkBox);
                $query = "SELECT COUNT(*) AS books_number
                          FROM books b
                          WHERE (SELECT p.value
                                 FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                 WHERE bp.book_id = b.book_id
                                 ORDER BY date_become_effective DESC
                                 LIMIT 1) > ? AND (SELECT p.value
                                                   FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                                   WHERE bp.book_id = b.book_id
                                                   ORDER BY date_become_effective DESC
                                                   LIMIT 1) <= ?";
                $numbersPrepare = $db -> prepare($query);

                $numbersPrepare -> execute([$min, $max]);

                $numbers = $numbersPrepare -> fetch();

                array_push($output, $numbers -> books_number);
                
            }
            else{
                list($min, $max) = explode("+", $checkBox);
                $query = "SELECT COUNT(*) AS books_number
                          FROM books b
                          WHERE (SELECT p.value
                                 FROM books_prices bp INNER JOIN prices p ON bp.price_id = p.price_id
                                 WHERE bp.book_id = b.book_id
                                 ORDER BY date_become_effective DESC
                                 LIMIT 1) >= ?";
                $numbersPrepare = $db -> prepare($query);

                $numbersPrepare -> execute([$min]);

                $numbers = $numbersPrepare -> fetch();

                array_push($output, $numbers -> books_number);
            }

        }
        vratiJSON($output, 200);
    }
    else{
        header("Location: ../../index.php");
    }
?>