<?php

session_start();
if(!isset($_SESSION['user_id'])){
	echo "<script>window.location.href='../login.php'</script>";
}
$_SESSION["total"] = 0;
if(isset($_SESSION["shopping_cart"]))
{

	foreach ($_SESSION["shopping_cart"] as $keys => $values) 
	{
		$_SESSION["total"] = $_SESSION["total"] + ($_SESSION["shopping_cart"][$keys]["product_price"] * $_SESSION["shopping_cart"][$keys]["product_quantity"]);
	}
}
if($_SESSION["total"] == 0)
	echo "";
else
	echo $_SESSION["total"];

?>