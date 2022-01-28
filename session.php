<?php
include "config.php";
$user_check = $_SESSION['login_user'];
$query = "select cname from customer where cname = '$user_check'";
$result = $conn->query($query);
$row = $result->fetch_array(MYSQLI_ASSOC);
$login_session = $row['cname'];

if (!isset($_SESSION['login_user'])) {
	header("location: index.php");
}
?>