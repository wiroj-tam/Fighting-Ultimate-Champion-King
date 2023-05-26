<?php
session_start();
if(!isset($_SESSION['user_id'])){
	echo "<script>window.location.href='../login.php'</script>";
}
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include('../config.php');
$sql = "SELECT PokemonItemID FROM pokemonitems WHERE UserID = ".$_SESSION['user_id']." AND ItemStatus > 0";
$res = mysqli_query($con, $sql) or die("can't query $sql");
$count = mysqli_num_rows($res);

if($count > 0){ //Have pokemons in the pocket.
	$sql = "SELECT PokemonItemID FROM pokemonitems WHERE UserID = ".$_SESSION['user_id']." AND ItemStatus = 2 ORDER BY PokemonItemID ASC";
	$res = mysqli_query($con,$sql) or die("can't query $sql");
	$count = mysqli_num_rows($res);
		
	if($count > 0){ //Have pokemon in team ?
		echo "{\"check\":\"accept\"}";
	}
	else{
		echo "{\"check\":\"reject\"}";
	}
}
else{
	echo "{\"check\":\"reject\"}";
}
?>