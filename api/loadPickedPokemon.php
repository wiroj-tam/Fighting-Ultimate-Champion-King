<?php
session_start();
if(!isset($_SESSION['user_id'])) {
	echo "<script>window.location.href = 'home.php'</script>";
}
include('../config.php');

$sql = "SELECT * FROM pokemonitems pki
					INNER JOIN pokemons p ON pki.PokemonID = p.PokemonID
					INNER JOIN levels l ON pki.PokemonItemID = l.PokemonItemID
					WHERE pki.ItemStatus = 2 AND pki.UserID = ".$_SESSION['user_id'];
$res = mysqli_query($con, $sql) or die ("can't query show");

if($res){

	if(mysqli_num_rows($res) > 0) {
		while($rows = mysqli_fetch_array($res)) {
			$outp[] = $rows;
		}
		echo json_encode($outp);
	}
}
else {
	echo "cat";
}
?>