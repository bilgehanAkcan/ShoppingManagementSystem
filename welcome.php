<?php
session_start();
include("config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	buyProduct($conn);
}

function buyProduct($conn) {
	if (isset($_COOKIE["product_id"])) {
		$lala = $_COOKIE["product_id"];
	}
	else {
		echo "Cookie Not Set";
	}
	if (isset($_COOKIE["amount"])) {
		$zaza = $_COOKIE["amount"]; 
	}
	else 
		echo "Cookie Not Set";
	$amount = $lala;
	$id = $zaza;
	$query = "update product P1 set P1.stock = P1.stock - $amount where P1.stock >= $amount and P1.pid = '$id' and (select C.wallet from customer C where C.cname = '" . $_SESSION['login_user'] . "') > ($amount * P1.price)";
	$query2 = "update customer set wallet = wallet - ($amount * (select price from product where pid = '$id')) where cname = '" . $_SESSION['login_user'] . "'";
	$query3 = "insert into buy values((select cid from customer where cname = '" . $_SESSION['login_user'] . "'), '$id', $amount)";
	$conn->query($query);
	if (mysqli_affected_rows($conn) > 0) {
		$conn->query($query2);	
		$conn->query($query3);
		echo '<script>alert("Buy operation is successful")</script>';
	}
	else {
		echo '<script>alert("Buy operation is not successful, try again.")</script>';
	}
																
}

?>
<html>
	<head>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<style type="text/css">
			#linksize {
				font-size: 25px;
			}
			#writingsize {
				font-size: 20px;
			}
			#writingsize2 {
				font-size: 17px;
			}
		</style>
	</head>
	<body>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<ul class="nav justify-content-center">
  			<li class="nav-item">
  				<a id="linksize" class="nav-link active" href="profile.php">Profile</a>
  			</li>
  			<li class="nav-item">
    			<a id="linksize" class="nav-link" href="logout.php">Log Out</a>
  			</li>
		</ul>
		<hr>
		<center>
		<table>
			<tr>
				<td><strong id="writingsize">Product ID&emsp;</strong></td>
				<td><strong id="writingsize">Product Name&emsp;</strong></td>
				<td><strong id="writingsize">Price&emsp;</strong></td>
			</tr>
			<?php
				$query = "select * from product where stock > 0";
				$result = $conn->query($query);
				while ($row = mysqli_fetch_array($result)) {
			?>
			<tr>
				<td id="writingsize2"><?php echo $row['pid']; $cookie_value = $row['pid'];?></td>
				<td id="writingsize2"><?php echo $row['pname'] ?></td>
				<td id="writingsize2"><?php echo $row['price']?></td>
			</tr>
			<?php
				}	
			?>
		</table>
		<br>
		</center>
		<script type="text/javascript">
        	function setProductId(x) {
           		document.cookie = "product_id = " + x;    		
        	}
        	function setAmount(y) {
        		document.cookie = "amount = " + y;
        	}
    	</script>
    	<center>
		<form method="POST" id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<p>Enter the product id and the quantity that you want to buy:</p>
			<strong id="writingsize">Product Id</strong>&emsp;&ensp;<strong id="writingsize">Quantity</strong><br><br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
			<input type="text" name="abcd" value="" size="6" onchange="setAmount(this.value)"/>&emsp;&emsp;
			<input type="text" name="xyz" value="" size="6" onchange="setProductId(this.value)">&emsp;&emsp;
			<button type="submit" class="btn btn-success">Buy</button>
		</form>
		</center>
	</body>
</html>
