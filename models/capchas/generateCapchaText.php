<?php
    include "models/forbidden/functions.php";
    $opseg = "QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm0123456789";
    $_SESSION["capchaText"] = generisiCapchaText($opseg, 6);