<?php 
include('config.php');
error_reporting(E_ALL);
if(isset($_GET['signup']))
{
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$phone = $_POST['phone'];
	
		$sql="INSERT INTO ajax_users (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$password')";
		$result = $conn->query($sql);
		if($result){
			echo "Registration successfull";
		}
}

if(isset($_GET['login'])){
	$user = json_decode($_POST['jsonUser']);
	$email = $user->email;
	//var_dump($_POST['jsonUser']);
	//echo $email;
	//exit();
	$password = $user->password;

	$sql = "SELECT * FROM ajax_users where email = '$email'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

		$usersArray = array();

		if(($row['password'] == $password) && ($row['isAdmin'] == 'A')){
			$adminSelectQuery = "SELECT * FROM ajax_users";
			$adminResultObject = $conn->query($adminSelectQuery);
			while($userRow = $adminResultObject->fetch_assoc()){
				$userObj = (object)[
					'id' => $userRow['id'],
					'name' => $userRow['name'],
					'email' => $userRow['email'],
					'phone'=> $userRow['phone']
				];

				array_push($usersArray, $userObj);

			}	
			echo json_encode($usersArray);
		}

		elseif(($row['password'] == $password) && ($row['isAdmin'] == 'C')){
			$userObj = (object)[
				'id' => $row['id'],
				'name' => $row['name'],
				'email' => $row['email'],
				'phone'=> $row['phone']
			];	
			//var_dump($userObj);
			array_push($usersArray, $userObj);
			echo json_encode($usersArray);
		}
		else{
			echo 0;
		}
	}





?>

