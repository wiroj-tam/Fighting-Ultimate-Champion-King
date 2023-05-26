<?php

session_start(); 

$product_data = json_decode(file_get_contents("php://input"));
$product_id = $product_data->id;
$product_quantity = $product_data->quantity;

if(isset($_SESSION["shopping_cart"]))
{
	foreach($_SESSION["shopping_cart"] as $keys => $values)
	{
		if($_SESSION["shopping_cart"][$keys]['product_id'] == $product_id)	
		{
			if($product_quantity <= 0){
				return;
			}
			$_SESSION["shopping_cart"][$keys]['product_quantity'] = $product_quantity;
			break;
		}
	}
}
?>