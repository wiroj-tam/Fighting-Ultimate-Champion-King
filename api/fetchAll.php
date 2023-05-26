<?php
session_start();
if($_SESSION['user_status'] != 2){
	echo "<script>window.location.href='../login.php'</script>";
}
include("../config.php");
$sql = "SELECT * FROM pokemons ORDER BY PokemonID ASC";
$result = mysqli_query($con, $sql) or die("[ERROR] : $sql");
if($result):
	if(mysqli_num_rows($result) > 0):
		while($rows = mysqli_fetch_assoc($result)):
			$outp[] = $rows;
		endwhile;
		echo json_encode($outp);
	endif;

endif;


?>

