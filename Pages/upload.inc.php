<?php
session_start();
$target_dir = "Songs/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
    } else {
        $_SESSION['error'] = "Bestand geen foto";
        header("Location: ../CreateSong.cshtml");                        // error 1      echo "File is not an image.";
        exit();  
    }
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $_SESSION['error'] = "Bestand te groot";
    header("Location: ../CreateSong.cshtml");                             // error 2         echo "Sorry, your file is too large.";
    exit();
}
// Allow certain file formats
if($imageFileType != "jpg") {
    $_SESSION['error'] = "Alleen jpg";
    header("Location: ../CreateSong.cshtml");                         // error 3          echo "Sorry, only JPG, JPEG & PNG files are allowed.";  
    exit();
}
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $_SESSION['error'] = "Success";
    header("Location: ../CreateSong.cshtml");
} else {
    $_SESSION['error'] = "Kan niet verplaatsen naar juiste map";
    header("Location: ../CreateSong.cshtml");
    exit();
}
?>