<?php
session_start();
include('../config.php');
if(!isset($_SESSION['user_id'])) {
	echo "<script>window.location.href='home.php'</script>";
}

$data = json_decode(file_get_contents("php://input"));

if(isset($data)):

$data_pkiid = $data->pokemonItemID;
$data_action = $data->action;

if($data_action == "changeName") {
	$data_name = $data->name;
	$sql = "UPDATE pokemonitems SET ItemName = '$data_name' WHERE PokemonItemID = '$data_pkiid' ";
	$res = mysqli_query($con, $sql) or die("[ERROR]: $sql");
	echo "changeName";
}
else if($data_action == "pick") {
	$sql1 = "UPDATE pokemonitems SET ItemStatus = 1 WHERE ItemStatus = 2 AND UserID = ".$_SESSION['user_id'];
	$sql2 = "UPDATE pokemonitems SET ItemStatus = 2 WHERE PokemonItemID = '$data_pkiid' AND UserID = ".$_SESSION['user_id'];
	mysqli_query($con, $sql1) or die("[ERROR]: $sql1");
	mysqli_query($con, $sql2) or die("[ERROR]: $sql2");
	
	echo $sql2;
}
else if($data_action == "abandon") {
	$sql_block = "UPDATE pokemonitems SET ItemStatus = 0 WHERE PokemonItemID = '$data_pkiid' ";
	mysqli_query($con, $sql_block) or die("Can't query $sql_block");
}


endif;
?>