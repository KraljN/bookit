<?php 
session_start();
$capchaText = $_SESSION["capchaText"];

header("Content-type: image/png");

$slika = imagecreatefrompng("../../assets/img/captchabg.png");
$font = $_SERVER["DOCUMENT_ROOT"] . "/bookIt/assets/fonts/grandstander.ttf";

$textBoja = imagecolorallocate($slika, 155, 163, 158);

$uspeh = imagettftext($slika, 30, 0, 20, 45, $textBoja, $font, $capchaText);
// var_dump($uspeh);
ImagePng($slika);
imagedestroy($slika);
