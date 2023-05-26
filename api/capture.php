<?php
include('../config.php');
session_start();

$ballType = file_get_contents("php://input");


function catchingRate($pokeball_id) {
	global $con;
	$sql = "SELECT * FROM pokeballs pkb, pokeballitems pkbi WHERE pkb.PokeballID = pkbi.PokeballID
			AND pkb.PokeballID = '$pokeball_id' AND pkbi.UserID = ".$_SESSION['user_id'];
	$res = mysqli_query($con, $sql) or die("[ERROR]: $sql");
	$rows = mysqli_fetch_array($res);

	$levelAlpha = $_SESSION['enemyLevel'];
	$evAlpha = $_SESSION['enemyEV'] * 25;
	$sampleSpace = $levelAlpha + $evAlpha + $rows['CatchingRate'];
	$rate = rand(1,$sampleSpace);

	$currentQuantity = $rows['PokeballQuantity'] - 1;
	$reducePokeball = "UPDATE pokeballitems SET PokeballQuantity = '$currentQuantity' WHERE PokeballID = '$pokeball_id' AND UserID = ".$_SESSION['user_id'];
	mysqli_query($con, $reducePokeball) or die("error $reducePokeball");
	if($rate <= $rows['CatchingRate']) {
		$pokemonid = $_SESSION['enemyPokemonID'];
		$userid = $_SESSION['user_id'];
		$name = $_SESSION['enemyName'];
		$needexp = $_SESSION['enemyLevel'] * 100;
		$lvl = $_SESSION['enemyLevel'];
		$atk = $_SESSION['enemyAtk'];
		$def = $_SESSION['enemyDef'];
		$spd = $_SESSION['enemySpd'];
		$spatk = $_SESSION['enemySpAtk'];
		$spdef = $_SESSION['enemySpDef'];
		$hp = $_SESSION['enemyHP'];

		//insert new pokemon.
		$insertPokemonItem = "INSERT INTO pokemonitems VALUES(NULL,'$pokemonid','$userid','$name',1,0,'$needexp')";
		mysqli_query($con, $insertPokemonItem) or die("$insertPokemonItem");

		//select pokemonitemid
		$select = "SELECT PokemonItemID FROM pokemonitems WHERE UserID = ".$_SESSION['user_id']." ORDER BY PokemonItemID DESC LIMIT 1";
		$res_select = mysqli_query($con, $select) or die("$select");
		$row_select = mysqli_fetch_array($res_select);

		$pokemonitemid = $row_select['PokemonItemID'];
		
		// insert stats of pokemon
		$insertLevel = "INSERT INTO levels VALUES('$lvl','$atk','$def','$spd','$spatk','$spdef','$hp','$pokemonitemid')";
		mysqli_query($con, $insertLevel);
		echo "Accept";
	}
	else {
		echo "Reject";
	}
}
switch ($ballType) {
	case 'Red Ball':
		catchingRate(1);
		break;
	case 'Blue Ball':
		catchingRate(2);
		break;
	case 'Yellow Ball':
		catchingRate(3);
		break;
	default:
		echo "It's Bug";
		break;
}
?>