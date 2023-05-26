<?php

session_start();
if(!isset($_SESSION['user_id'])){
	echo "<script>window.location.href='../login.php'</script>";
}
$product_id = json_decode(file_get_contents("php://input"));
if(isset($product_id)):
foreach ($_SESSION["shopping_cart"] as $keys => $values) 
{
	if($values["product_id"] == $product_id)
	{
		unset($_SESSION["shopping_cart"][$keys]);
		
	}
}
endif;
?>