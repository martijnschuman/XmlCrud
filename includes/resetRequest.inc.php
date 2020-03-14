<?php

if(isset($_POST['accountPwdRestSubmit'])){   

    session_start();
    require "../functions/dbcon_function.php";
	$conn = dbConn();

    $selector           = bin2hex(random_bytes(8));
    $token              = random_bytes(32);
    $url                = "http://localhost/School/Semester2/c/playMusic/pages/pwdReset/newpwd?selector=" . $selector . "&validator=" . bin2hex($token);
    $expires            = date("U") + 1800;
    $userEmail          = $_POST["emailAddress"];

    if(empty($userEmail)){
        $_SESSION['error'] = "Geen email adres ingevuld!";
        header("Location: ". $_SERVER['HTTP_REFERER']);
        die;
    }else{
        $sql = "DELETE FROM pwdreset WHERE pwdResetEmail=?";
        $stmt =  mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            echo "Er was een probleem met de code";
            exit();
        } 
        else{
            mysqli_stmt_bind_param($stmt, "s", $userEmail);
            mysqli_stmt_execute($stmt);
        }

        $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?,?,?,?);";
        $stmt =  mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            echo "Er was een probleem met de codeV2";
            exit();
        } 
        else{
            $hashedToke = password_hash($token, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToke, $expires);
            mysqli_stmt_execute($stmt);
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        $to = $userEmail;
        $subject = 'Wachtwoord reset voor PlayMusic';
        $message = '<p>We hebben een wachtwoord reset verzoek ontvangen. De link hiervoor is hieronder te zien. Mocht u dit niet hebben gedaan kan u deze email negeren.</p>';
        $message .= '<p>Hier is uw wachtwoord reset link </br>';
        $message .= '<a href="' . $url . '">' . $url . '</a></p>';

        $headers = "From: NebulosityGaming <team.nebg@gmail.com>\r\n";
        $headers .= "Reply-To: team.nebg@gmail.com\r\n";
        $headers .= "Content-type: text/html\r\n";

        mail($to, $subject, $message, $headers);

        $_SESSION['success'] = "Reset email verzonden";
        header("Location: ". $_SERVER['HTTP_REFERER']);
        die;
    }
}else {
    header("Location: ../index.php?verboden_voor_gebruikers");
    exit(); 
}