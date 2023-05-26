<?php

session_start();
if(!isset($_SESSION['user_id'])){
	echo "<script>window.location.href='../login.php'</script>";
}  
$product_data = json_decode(file_get_contents("php://input"));

if(isset($product_data)):


$product_id = $product_data->PokemonID;
$product_name = $product_data->Name;
$product_price = $product_data->Price;
$product_quantity = $product_data->Quantity;
$product_image = $product_data->Image;

if(isset($_SESSION["shopping_cart"]))
{

	$is_available = true;
	foreach($_SESSION["shopping_cart"] as $keys => $values)
	{
		if($_SESSION["shopping_cart"][$keys]['product_id'] == $product_id)	
		{
			$_SESSION["shopping_cart"][$keys]['product_quantity'] += $product_quantity;
			$is_available = false;
			break;
		}
	}
	if($is_available)
	{
		$item_array = array(
		'product_id'		=>	$product_id,
		'product_name'		=>	$product_name,
		'product_price'		=>	$product_price,
		'product_quantity'	=>	$product_quantity,
		'product_image' 	=>	$product_image
		);
		$_SESSION["shopping_cart"][] = $item_array;
	}
}
else
{
	$item_array = array(
		'product_id'		=>	$product_id,
		'product_name'		=>	$product_name,
		'product_price'		=>	$product_price,
		'product_quantity'	=>	$product_quantity,
		'product_image' 	=>	$product_image
	);
	$_SESSION["shopping_cart"][] = $item_array;
}	
endif;
?>