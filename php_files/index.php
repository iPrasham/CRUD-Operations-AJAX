<?php echo("Welcome....You're successfully logged in");



include("config.php");




session_start();
error_reporting(E_ALL);

if(!isset($_SESSION['loginUser'])){
	header("Location: login.php");
}

$email = $_SESSION['email'];
$isAdmin = $_SESSION['isAdmin'];
print($isAdmin);
//exit;

if(isset($_POST['logout'])){
	session_destroy();
	header("Location: login.php");
}

$delete_id = $_GET['deleteid'];
if(isset($delete_id)){
$delete_query = "DELETE FROM php_users WHERE id='$delete_id'";
if($conn->query($delete_query)){
	echo "Deleted successfully";
}
}
$update_id = $_GET['updateid'];
if(isset($update_id)){
if(isset($_POST['submit'])){
	$name = $_POST['name'];
	$password = $_POST['password'];  
}

$update_query = "UPDATE php_users SET name = '$name', passwords = '$password' where id = '$update_id'";  
if($conn->query($update_query)){
	echo "Updated successfully";
	//header("Location: index.php");



}
}
if($isAdmin == 'A') {
	$sql = "SELECT * FROM php_users";
	print($sql);
	}
else {
	$sql = "SELECT * FROM php_users where email = '$email'";
	print($sql);
	}


$result = $conn->query($sql);
//echo($result);
print("Hello");
print($result->num_rows);

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Home</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	</head>
	<body>
		<div class="container">
			<h1>Hi <?php echo $_SESSION['loginUser']; ?></h1>
			<form action="index.php" method="post">
				<button type="submit" name="logout" class="btn btn-success float-right">Logout</button>
			</form>
			<h3>User details: </h3>
			<br/>
			<table class="table table-striped text-center">
  				<thead class="thead-dark">
   					 <tr>
     						 <th scope="col">ID</th>
     						 <th scope="col">NAME</th>
						 <th scope="col">EMAIL</th>
						 <th scope="col">PROFILE PICTURE</th>
						 <th scope="col">UPDATE</th>
						 <th scope="col">DELETE</th>
   					 </tr>
  				</thead>
				<tbody>
				<?php while($row = $result->fetch_assoc()){ ?>
   					 <tr>
						<?php $id = $row['id'] ?>
						<td><?php echo $row['id']; ?></td>
					 	<td><?php echo $row['name']; ?></td>
						<td><?php echo $row['email']; ?></td>
						<td><img src="./uploads/images/<?php echo $row['image_name']; ?>" width="30%" height="30%"/></td>
						<td><a href="update.php?updateid=<?php echo $id; ?>"><button class="btn btn-primary" type="button">Edit details</button></a></td>
						<td><a href="index.php?deleteid=<?php echo $id; ?>"><button type="button" name="delete" class="btn btn-danger">Delete User</button></a></td> 
					</tr>
				<?php } ?>
  				</tbody>
			</table>
		</div>
	</body>
</html>

