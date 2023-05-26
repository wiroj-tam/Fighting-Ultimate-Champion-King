<?php
session_start();
include('../config.php');
if(!isset($_SESSION['user_id'])) {
	echo "<script>window.location.href='home.php'</script>";
}

$sql = "SELECT pki.PokemonItemID, pki.ItemName, pki.ItemStatus, pki.Exp, pki.NeedExp, p.Image, p.EV, p.Element FROM pokemonitems pki
		INNER JOIN pokemons p ON pki.PokemonID = p.PokemonID
		INNER JOIN levels l ON pki.PokemonItemID = l.PokemonItemID
		WHERE pki.ItemStatus = 1 AND pki.UserID = ".$_SESSION['user_id'];
$res = mysqli_query($con, $sql) or die("[ERROR]: $sql");

if($res) {
	if(mysqli_num_rows($res) > 0) {
		while($rows = mysqli_fetch_array($res)) {
			$outp[] = $rows;
		}
		echo json_encode($outp);
	}
	
}




?>