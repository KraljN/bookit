<?php

session_start();

// header( "Content-Description: File Transfer");
// header("Transfer-Encoding: binary");

 $word = new COM("word.application") or die("Unable to instantiate Word");
 $word->Visible=1;
 $word->Documents->Add();

 $text = [];

 array_push($text, "Nikola Kralj");
 array_push($text, "Email: nikolakralj9@gmail.com");
 array_push($text, "Index number: 76/18");
 array_push($text, "Year of study: Second");
 array_push($text, "Site made for purpose of Workshop for PHP");

$result = "";
foreach($text as $i => $singleRow){
    if($i == 0){
        $result .= $singleRow . "\n\n";
    }
    else{
        $result .= $singleRow . "\n";
    }
}

 $word->Selection->TypeText($result);
 $filename = tempnam(sys_get_temp_dir(), "word");
 $word->Documents[1]->SaveAs($filename);

header("Content-Disposition: attachment; filename=NikolaKralj.docx");
header("Content-Type: application/vnd.ms-word");

 $word->Quit();
 $word = null;
 readfile($filename);
 unlink($filename);
?>