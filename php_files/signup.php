<?php
include('config.php');
error_reporting(E_ALL);

$encryptionMethod = "AES-256-CBC";  // AES is used by the U.S. gov't to encrypt top secret documents.
$secretHash = "25c6c7ff35b9979b151f2136cd13b0ff";

if(isset($_POST['submit'])){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirmPassword = $_POST['confirmPassword'];
	
	$image = $_FILES['dp']['name']; 
	$ext_image = explode('.',$image);
 	$image_ext_type = end($ext_image);
	
	date_default_timezone_set('Asia/Calcutta');
 	$date = date('m/d/Yh:i:sa', time());
 	$random = rand(10000,99999);
 	$enc_name = $date.$rand;
 	$image_name = md5($enc_name).'.'.$image_ext_type;
 	$image_path="./uploads/images/".$image_name;
	if(move_uploaded_file($_FILES['dp']['tmp_name'],$image_path)){
		print("Uploaded successfully");
	}else{
		print("Upload failed");
	} 	
	
	$flag = 0;
	if(!isset($name) && ($name == '')){
		echo("<span>Please provide your name</span>");
		$flag = 1;
	}

	if(!isset($email) && ($email == '')){
		echo("<span>Please provide your email address</span>");
		$flag = 1;
	}

	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		echo("<span>Invalid email address</span>");
		$flag = 1; 
	}

	if(!isset($password) && ($password == '')){
		echo("<span>Please provide password</span>");
		$flag = 1;
	}

	if(!(strlen($password)>= 8)){
		echo("<span>Password should be greater than 8 character</span>");
		$flag = 1;
	}

	if(!isset($confirmPassword) && ($confirmPassword == '')){
		echo("<span>Please confirm your password</span>");
		$flag = 1;
	}

	if(strlen($password) != strlen($confrimPassword) && ($password != $confirmPassword)){
		echo("<span>Password mismatch</span>");
		$flag = 1;
	}

	$password = openssl_encrypt($password, $encryptionMethod, $secretHash);
	$hashedPassword = hash('sha256', $password);

	if($flag == 0){
		$sql = "INSERT INTO php_users (name, email, image_name,  passwords) VALUES ('$name', '$email', '$image_name','$hashedPassword')";
		print($sql);
		if($conn->query($sql) === TRUE){
			echo("<span>New record inserted</span>");
			header("Location: login.php");
		}
		else{
			echo("Error in inserting new data ".$sql. "<br>".$conn->error);
			//header("Location: signup.php");
		} 
	}
	else{
		//header("Location: signup.php");
	}

}
?>

<!DOCTYPE html>
<html>
 <head>
  <title>Sign-Up</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
 </head>
 <body>
  <div class="container">
   <h1>Register here</h1> 
   <form method="post" action="signup.php" enctype="multipart/form-data">
    <div class="form-group">
     <label for="name">Name</label>
     <input id="name" name="name" class="form-control" placeholder="Enter your full name">
    </div>
    <div class="form-group">
     <label for="email">Email address</label>
     <input type="email" class="form-control" id="email1" name="email" placeholder="Enter your email address" aria-describedby="emailHelp">
     <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
     <label for="image">Profile Picture</label>
     <br/>     
     <input type="file" id="image" name="dp">
    </div>
    <div class="form-group">
     <label for="password">Password</label>
     <input type="password" name="password" class="form-control" id="password" placeholder="Your password">
    </div>
    <div class="form-group">
     <label for="confirmPassword">Re-enter Password</label>
     <input type="password" id="confirmPassword" name="confirmPassword" placeholder="please enter your password again" class="form-control">
    </div> 
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
   </form>  
  </div> 


</body>
</html> 
