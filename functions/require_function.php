<?php

function require_nodig(){
    $require = glob($_SERVER['DOCUMENT_ROOT']."/School/Semester2/c/playMusic/functions/*.php");
    
    foreach($require as $require_path){
        require_once "$require_path";
    }
}