<?php

if(isset($_POST['loginSubmit'])){
    
    session_start();
    require "../functions/dbcon_function.php";
    $conn = dbConn();

    $username             	= $_POST['username'];
    $password	            = $_POST['password'];

    if(empty($username)){
        $_SESSION['error'] = "Geen gebruikersnaam ingevuld!";
        header("Location: ". $_SERVER['HTTP_REFERER']);
        die;
    }
    else if(empty($password)){
        $_SESSION['error'] = "Geen wachtwoord ingevuld!";
        header("Location: ". $_SERVER['HTTP_REFERER']);
        die;
    }
    else{
        $sql = "SELECT * FROM users WHERE username=? OR email=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ". $_SERVER['HTTP_REFERER']."?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "ss", $username, $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)){
                $pwdCheck = password_verify($password, $row['pwd']);
                if($pwdCheck == false) {
                    $_SESSION['error'] = "Verkeerd wachtwoord";
                    header("Location: ". $_SERVER['HTTP_REFERER']);
                    die;
                }
                else if ($pwdCheck == true) {
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['tl'] = $row['tl'];
                    $_SESSION['last_action'] = time();

                    //Gebruiker ip adres
                    function getUserIpAddr(){
                        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
                            //ip from share internet
                            $ip = $_SERVER['HTTP_CLIENT_IP'];
                        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                            //ip pass from proxy
                            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                        }else{
                            $ip = $_SERVER['REMOTE_ADDR'];
                        }
                        return $ip;
                    }
                    $ip = getUserIpAddr();
                    
                    //Gebruiker lokatie
                    function get_client_ip(){
                        $ipaddress = '';
                        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
                            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
                        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
                        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
                            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
                        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
                            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
                        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
                            $ipaddress = $_SERVER['HTTP_FORWARDED'];
                        } else if (isset($_SERVER['REMOTE_ADDR'])) {
                            $ipaddress = $_SERVER['REMOTE_ADDR'];
                        } else {
                            $ipaddress = 'UNKNOWN';
                        }

                        return $ipaddress;
                    }
                    $PublicIP = get_client_ip();
                    $json     = file_get_contents("http://ipinfo.io/$PublicIP/geo");
                    $json     = json_decode($json, true);
                    $country  = $json['country'];
                    $region   = $json['region'];
                    $city     = $json['city'];

                    date_default_timezone_set('Europe/Amsterdam');
                    $date=date("l, d F, Y, H:i:s");
                    $updatefile = "../Documenten/userlog.txt";
                    $fh = fopen($updatefile, 'a') or die("can't open file");
                    $stringData = "******************************************* \n";
                    fwrite($fh, $stringData);
                    $stringData = "Gebruiker: ".$_SESSION['username']." \n";
                    fwrite($fh, $stringData);
                    $stringData = "Tijd: $date \n";
                    fwrite($fh, $stringData);
                    $stringData = "Ip-adres: $ip \n";
                    fwrite($fh, $stringData);
                    $stringData = "Locatie: $country, $region, $city \n";
                    fwrite($fh, $stringData);
                    $stringData = "******************************************* \n\n";
                    fwrite($fh, $stringData);
                    fclose($fh);

                    header("Location: ". $_SERVER['HTTP_REFERER']);
                    exit(); 
                }
            }
            else{
                $_SESSION['error'] = "Gebruikersnaam is niet bekend";
                header("Location: ". $_SERVER['HTTP_REFERER']);
                die;
            }
        }
    }
}else {
    header("Location: ../index.php?verboden_voor_gebruikers");
	exit();
}
