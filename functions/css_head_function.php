<?php

function css(){
    $path = glob($_SERVER['DOCUMENT_ROOT']."/School/Semester2/c/playMusic/CSS/*.css");
    $absolute = "D:/OneDrive/Documenten/Website-host/School/Semester2/c/playMusic/";
    $relative = "http://localhost/School/Semester2/c/playMusic/";

    $css = str_replace($absolute, $relative, $path);
    $css_out = "";

    foreach($css as $css_path){
        $css_out .= '<link rel="stylesheet" href="'.$css_path.'">'; 
    }
    return $css_out;
}
