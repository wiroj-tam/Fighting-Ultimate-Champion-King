<?php
session_start();
if(!isset($_SESSION['user_id'])){
	echo "<script>window.location.href='../login.php'</script>";
}
include("../config.php");

//fetch pokemons
$sql = "SELECT * FROM pokemons WHERE EV IN (0,1) ORDER BY PokemonID ASC";
$result = mysqli_query($con, $sql) or die("[ERROR] : $sql");
if($result):
	if(mysqli_num_rows($result) > 0):
		while($rows = mysqli_fetch_assoc($result)):
			$outp['pokemons'][] = $rows;
		endwhile;

	endif;
endif;

//fetch pokeballs
$sql = "SELECT * FROM pokeballs pkb, pokeballitems pkbi WHERE pkb.PokeballID = pkbi.PokeballID AND pkbi.UserID = ".$_SESSION['user_id'];
$result = mysqli_query($con, $sql) or die("[ERROR] : $sql");
if($result):
	if(mysqli_num_rows($result) > 0):
		while($rows = mysqli_fetch_assoc($result)):
			$outp['pokeballs'][] = $rows;
		endwhile;
	endif;

endif;

echo json_encode($outp);


?>

