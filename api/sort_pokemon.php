<?php
session_start();
include('../config.php');
if(!isset($_SESSION['user_id'])){
	echo "<script>window.location.href='../login.php'</script>";
}

$sort = file_get_contents("php://input");
switch($sort) {
	case "Newest":
		$sort = "pki.PokemonItemID DESC";
		break;
	case "Oldest":
		$sort = "pki.PokemonItemID DESC";
		break;
	case "Name":
		$sort = "pki.PokemonItemID ASC";
		break;
	case "Level":
		$sort = "PokemonItemID DESC";
		break;
	default:
		$sort = "PokemonItemID ASC";
}

$sql = "SELECT * FROM pokemonitems pki 
				INNER JOIN pokemons p
				ON p.PokemonID = pki.PokemonID
				INNER JOIN levels l
				ON l.PokemonItemID = pki.PokemonItemID
				WHERE pki.UserID = ".$_SESSION['user_id']." AND pki.ItemStatus = 1
				ORDER BY pki.PokemonItemID DESC"
?>