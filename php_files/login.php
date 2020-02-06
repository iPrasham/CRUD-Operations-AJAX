<?php 
include('config.php');
error_reporting(E_ALL);

$encryptionMethod = "AES-256-CBC";  // AES is used by the U.S. gov't to encrypt top secret documents.
$secretHash = "25c6c7ff35b9979b151f2136cd13b0ff";

if(isset($_POST['submit'])){
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	$password = openssl_encrypt($password, $encryptionMethod, $secretHash);
        $hashedPassword = hash('sha256', $password);

	$sql = "SELECT name, passwords, isAdmin FROM php_users WHERE email = '$email'";
	print($sql);
        $result = $conn->query($sql);

	if($result->num_rows == 1){
		$row = $result->fetch_assoc();
		$passwordFromDB = $row['passwords'];
		if($hashedPassword == $passwordFromDB){
			echo("Login suucessfull");
			session_start();
			$_SESSION['loginUser'] = $row['name'];
			$_SESSION['isAdmin'] = $row['isAdmin'];
			$_SESSION['email'] = $email;
			header("Location: index.php");
		}
		else{
			echo("Wrong Password");
		}
	}
}
?>

<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<div class="container">
<h1>Login here:</h1>
<form method="post" action="login.php">
  <div class="form-group">
    <label for="email">Email address</label>
    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" name="password" class="form-control" id="password">
  </div>
  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
</form>
</div>
</body>
</html>
