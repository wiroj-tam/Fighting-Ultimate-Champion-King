<?php
session_start();
if(isset($_SESSION['shopping_cart'])){
	echo count($_SESSION['shopping_cart']);
}
else{
	echo "";
}

?>