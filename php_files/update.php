<?php 
include("config.php");
$id = $_GET['updateid'];
$select_query = "SELECT * FROM php_users WHERE id = '$id'";
$result = $conn->query($select_query);
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Update</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	</head>
	<body>
	<div class="container">
	<form method="post" action="index.php?updateid=<?php echo $row['id']; ?>">
			<div class="form-group">
				<label for="name">Name</label>
				<input id="name" class="form-control" name="name" type="text" value="<?php echo $row['name']; ?>" placeholder="Enter your name">
			</div>
			<div class="form-group">
    				<label for="email">Email address</label>
				<input type="email" placeholder="Your email here"  class="form-control" name="email" id="email" aria-describedby="emailHelp" value="<?php echo $row['email']; ?> "disabled>
    				<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  			</div>
  			<div class="form-group">
    				<label for="password">Password</label>
				<input type="password" name="password" placeholder="Enter password" class="form-control" value="<?php echo $row['passwords']; ?>" id="password">
  			</div>
  			<button type="submit" name="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>
	</body>
</html>
