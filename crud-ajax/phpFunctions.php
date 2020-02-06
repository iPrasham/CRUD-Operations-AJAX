<?php 
include('config.php');
error_reporting(E_ALL);
if(isset($_GET['signup']))
{

	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$phone = $_POST['phone'];
	$flag = 0;
	
	if(!preg_match("/^[A-Z]{1}[a-zA-Z\s]{1,50}$/", $name)){
		$flag = 1;
		echo "Enter valid name";
	}

	if(!preg_match("/^[6-9]\d{9}$/", $phone)){
		$flag = 1;
		echo "Enter valid phone number";

	}
	
	if(!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $email)){
		$flag = 1;
		echo "Enter valid email";

	}

	if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#\$%\^&\*]).{8,22}$/", $password)){
		$flag = 1;
		echo "Enter valid password";
	}
	
	$hashedPassword = hash('sha256', $password);
	if($flag == 1){
		echo "Please provide valid data";
	}else{

		$sql="INSERT INTO ajax_users (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$hashedPassword')";
		
		try{
			$result = $conn->query($sql);
		}catch(Exception $exception){
			echo "Query failed.";
		}
		
		if($result){
			echo "Registration successfull";
		}
	}
}

if(isset($_GET['login'])){
	
	$user = json_decode($_POST['jsonUser']);
	$email = $user->email;
	//var_dump($_POST['jsonUser']);
	//echo $email;
	//exit();
	$password = $user->password;
	$flag = 0;

	if(!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $email)){
		$flag = 1;
		echo "Enter valid email";

	}

	if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#\$%\^&\*]).{8,22}$/", $password)){
		$flag = 1;
		echo "Enter valid password";
	}


	if($flag == 1){
		return;
	}
	else{
	$hashedPassword = hash('sha256', $password);
	$sql = "SELECT * FROM ajax_users where email = '$email' and password = '$hashedPassword'";
	try{
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
	}
	catch(Exception $exception){
		   echo "Query failed.";
	   }
		$usersArray = array();

		if(($row['isAdmin'] == 'A')){
			$adminSelectQuery = "SELECT * FROM ajax_users";
			$adminResultObject = $conn->query($adminSelectQuery);
			while($userRow = $adminResultObject->fetch_assoc()){
				$userObj = (object)[
					'id' => $userRow['id'],
					'name' => $userRow['name'],
					'email' => $userRow['email'],
					'phone'=> $userRow['phone']
				];

				//array_push($usersArray, $userObj);
				$usersArray[] = $userObj;	
			}	
			echo json_encode($usersArray);
		}

		elseif(($row['isAdmin'] == 'C')){
			$userObj = (object)[
				'id' => $row['id'],
				'name' => $row['name'],
				'email' => $row['email'],
				'phone'=> $row['phone']
			];	

			$usersArray[] = $userObj;

			//var_dump($userObj);
			//array_push($usersArray, $userObj);
			echo json_encode($usersArray);
		}
		else{
			echo 0;
		}

	}
}




?>

