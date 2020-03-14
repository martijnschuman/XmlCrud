<?php

if(isset($_POST["accountPwdRestSubmit"])){

    session_start();

    $selector               = $_POST["selector"];
    $validator              = $_POST["validator"];
    $password               = $_POST["pwd"];
    $passwordRepeat         = $_POST["pwdRepeat"];

	if(empty($password)){
        $_SESSION['error'] = "Geen wachtwoord ingevuld!";
        header("Location: ". $_SERVER['HTTP_REFERER']);
        die;
    }
    else if(empty($passwordRepeat)){
        $_SESSION['error'] = "Geen herhaald wachtwoord ingevuld!";
        header("Location: ". $_SERVER['HTTP_REFERER']);
        die;
    }else if ($password != $passwordRepeat) {
        $_SESSION['error'] = "Wachtwoorden zijn niet gelijk!";
        header("Location: ". $_SERVER['HTTP_REFERER']);
        die;
    }

    $currentDate = date("U");

    require "../functions/dbcon_function.php";
	$conn = dbConn();

    $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector=? AND pwdResetExpires >=?";
    $stmt =  mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "Er was een probleem met de code in de database";
        exit();
    }else{
        mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if (!$row = mysqli_fetch_assoc($result)){
            echo "Er was een probleem met de verificatie, probeer het opnieuw";
            exit();
        } else {

            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);

            if ($tokenCheck === false){
                echo "Er was een probleem met de verificatie, probeer het opnieuw-2";
                exit();
            } else if($tokenCheck === true){

                $tokenEmail = $row['pwdResetEmail'];

                $sql = "SELECT * FROM users WHERE email=?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    echo "Er was een probleem met de code in de database-2";
                    exit();
                }else{
                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if (!$row = mysqli_fetch_assoc($result)){
                        $_SESSION['success'] = "Email address is niet bekend";
                        header("Location: ". $_SERVER['HTTP_REFERER']);
                        die;
                    } else {
                        $sql = "UPDATE users SET pwd=? WHERE email=?";
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt, $sql)){
                            echo "Er was een probleem met de code in de database-3";
                            exit();
                        }else{
                            $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
                            mysqli_stmt_execute($stmt);
                            if(!$stmt){
                                Echo "error";
                            }else{
                                $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt, $sql)){
                                    echo "Er was een probleem met de code in de database-4";
                                    exit();
                                }else{
                                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                    mysqli_stmt_execute($stmt);
                                    if(!$stmt){
                                        Echo "error2";
                                    }else{
                                        $_SESSION['success'] = "Wachtwoord bijgewerkt!";
                                        header("Location: ../pages/login/index");
                                        die;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

}else {
    header("Location: ../index?verboden_voor_gebruikers3");
    exit(); 
}