<?php

session_start();
if(!isset($_SESSION['user_id'])){
	echo "<script>window.location.href='../login.php'</script>";
}
if(isset($_SESSION["shopping_cart"]))
{
	echo json_encode($_SESSION["shopping_cart"]);
}

?>