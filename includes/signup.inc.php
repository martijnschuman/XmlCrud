<?php

if(isset($_POST['signupSubmit'])){

	session_start();
	require "../functions/dbcon_function.php";
	$conn = dbConn();

	$username	 						= $_POST['username'];
	$emailAddress	 					= $_POST['emailAddress'];
	$pwd 								= $_POST['password'];
	$pwdRepeat 							= $_POST['passwordRepeat'];


	if(empty($username)){
        $_SESSION['error'] = "Geen gebruikersnaam ingevuld!";
        header("Location: ". $_SERVER['HTTP_REFERER']);
        die;
	}
    else if(empty($emailAddress)){
        $_SESSION['error'] = "Geen email adres ingevuld!";
        header("Location: ". $_SERVER['HTTP_REFERER']);
        die;
	}
	else if(empty($pwd)){
        $_SESSION['error'] = "Geen wachtwoord ingevuld!";
        header("Location: ". $_SERVER['HTTP_REFERER']);
        die;
	}
	else if(empty($pwdRepeat)){
        $_SESSION['error'] = "Geen herhaald wachtwoord ingevuld!";
        header("Location: ". $_SERVER['HTTP_REFERER']);
        die;
	}
	else if($pwd != $pwdRepeat){
		$_SESSION['error'] = "Wachtwoorden zijn niet gelijk!";
        header("Location: ". $_SERVER['HTTP_REFERER']);
        die;
	}
	else{
		$sql = "SELECT username FROM users WHERE username=?";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql)){
			header("Location: ../paginas/systeem/signup.php?error=sqlerrorsignup");
			exit();
		}
		else{
			mysqli_stmt_bind_param($stmt, "s", $username);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			$resultCheck = mysqli_stmt_num_rows($stmt);
			if($resultCheck > 0){
				$_SESSION['error'] = "Gebruikersnaam is al in gebruik";
				header("Location: ". $_SERVER['HTTP_REFERER']);
				die;
			}
			else {
				$sql = "INSERT INTO users (username, email, pwd) VALUES (?,?,?)";
				$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt, $sql)){
					header("Location: ../paginas/systeem/signup.php?error=sqlerrorsignup2");
					exit();
				}
				else{
					$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
					mysqli_stmt_bind_param($stmt, "sss", $username, $emailAddress, $hashedPwd);
					mysqli_stmt_execute($stmt);
				}
			}
		}
	}

	$query = "SELECT * FROM users WHERE id = (select max(id) from users)";
	$result = mysqli_query($conn, $query);

    if ($result) {
		$row = mysqli_fetch_assoc($result);

		$_SESSION['id'] = $row['id'];
		$_SESSION['username'] = $row['username'];
		$_SESSION['email'] = $row['email'];
		$_SESSION['tl'] = $row['tl'];
    } else {
        var_dump($result);
	}

	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}else{
	header("Location: ../index.php?verboden_voor_gebruikers");
	exit();
}