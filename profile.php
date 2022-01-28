<?php
session_start();
include "config.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['form_type']) && $_POST['form_type'] == 'form1') {
		returnProduct($conn);
	}
    else if (isset($_POST['form_type']) && $_POST['form_type'] == 'form2') {
    	loadMoney($conn);
    }
}

function returnProduct($conn) {
	if (isset($_COOKIE["aaa"])) {
		$product_id = $_COOKIE["aaa"];
	}
	else {
		echo "Cookie Not Set";
	}
	if (isset($_COOKIE["bbb"])) {
		$return_quantity = $_COOKIE["bbb"];
	}
	else {	
		echo "Cookie Not Set";
	}
	$query2 = "update product set stock = stock + $return_quantity where pid = '$product_id' and $return_quantity <= (select quantity from buy natural join customer where pid = '$product_id' and cname = '" . $_SESSION['login_user'] . "')";
	$query3 = "update customer set wallet = wallet + ($return_quantity * (select price from product where pid = '$product_id')) where cname = '" . $_SESSION['login_user'] . "'";
	$query4 = "update buy B set B.quantity = B.quantity - $return_quantity where B.pid = '$product_id' and B.cid = (select C.cid from customer C where C.cname = '" . $_SESSION['login_user'] . "')";
	$conn->query($query2);
	if (mysqli_affected_rows($conn) > 0) {
		$conn->query($query3);
		$conn->query($query4);
		echo '<script>alert("Return operation completed successfully")</script>';
	}
	else {
		echo '<script>alert("Return operation is not successful, try again.")</script>';
	}
	
}

function loadMoney($conn) {
	if (isset($_COOKIE["money"])) {
		$loaded_money = $_COOKIE["money"];
	}
	else {
		echo "Cookie Not Set";
	}
	$query1 = "update customer set wallet = wallet + $loaded_money where cname = '" . $_SESSION['login_user'] . "'";
	$conn->query($query1);
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
  				<a id="linksize" class="nav-link active" href="welcome.php">Home Page</a>
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
				<td><strong id="writingsize">Quantity&emsp;</strong></td>
			</tr>
			<?php
				$query = "select pid, pname, quantity from product natural join buy natural join customer where cname = '" . $_SESSION['login_user'] . "' and quantity > 0";
				$result = $conn->query($query);
				while ($row = mysqli_fetch_array($result)) {
			?>
			<tr>
				<td id="writingsize2"><?php echo $row['pid']; $cookie_value = $row['pid'];?></td>
				<td id="writingsize2"><?php echo $row['pname'] ?></td>
				<td id="writingsize2"><?php echo $row['quantity']?></td>
			</tr>
			<?php
				}
			?>
		</table>
		</center>
		<br>
		<center>
		<form method="POST" id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<input type="hidden" name="form_type" value="form1">
			<strong id="writingsize2">Return Product:</strong>
			<input type="text" name="productid" value="" placeholder="Enter Product ID" onchange="setId(this.value)" size="13"/>
			<input type="text" name="quantity" value="" placeholder="Enter Quantity" onchange="setQuantity(this.value)" size="10"/>
			<button class="btn btn-success" type="submit">Return Product</button><br><br>
		</form>
		<form method="POST" id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<input type="hidden" name="form_type" value="form2">
			<strong id="writingsize2">Load Money:</strong>
			<input type="text" name="money" value="" placeholder="Enter Amount of Money" onchange="setMoney(this.value)" size="20"/>
			<button class="btn btn-primary" type="submit">Load</button>
		</form>
		</center>
		<script type="text/javascript">
        	function setMoney(y) {
        		document.cookie = "money = " + y;
        	}
        	function setId(x) {
        		document.cookie = "aaa = " + x;
        	}
        	function setQuantity(z) {
        		document.cookie = "bbb = " + z;
        	}
    	</script>
	</body>
</html>


