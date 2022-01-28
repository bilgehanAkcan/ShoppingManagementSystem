<?php
session_start();
include("config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	login($conn);
}
function login($conn) {
	$username = $_POST['name'];
	$password = $_POST['password'];
	$query = "select * from customer where cname = '$username' and cid = '$password'";
	if ($result = $conn->query($query)) {
		if ($result->num_rows == 1) {
			$_SESSION['login_user'] = $username;
			header("location: welcome.php");
		}
		else {
			echo '<script>alert("Login Unsuccessful")</script>';		
		}
	}
	else {
		echo '<script>alert("Login Unsuccessful")</script>';	
	}
}
?>

<html>
	<head>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<style type="text/css">
			#inputshape {
				border: 2px solid gray;
  				border-radius: 25px;
			}
		</style>
		<script>
		function validateForm() {
  			var x = document.forms["myForm"]["name"].value;
  			var y = document.forms["myForm"]["password"].value;
  			if (x == "" || x == null || y == "" || y == null) {
    			alert("Name and password must be filled out");
    			return false;
  			}
		}
		</script>
	</head>
	<body>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<center>
		<form class="mt-5" name="myForm" onsubmit="return validateForm()" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
			<h2>LOGIN</h2><br>
  			Name:&emsp;&nbsp;<input id="inputshape" type="text" name="name"=><br><br>
  			Password: <input id="inputshape" type="password" name="password"><br><br>
  			<button class="btn btn-success" type="submit">Submit</button>
		</form>
		</center>
	</body>
</html>

