<?php
session_start();
if(!isset($_SESSION['user_id'])){
	echo "<script>window.location.href='login.php'</script>";
}
include('config.php');
$userid = $_SESSION['user_id'];
$sql = "SELECT * FROM pokemonitems pki
		INNER JOIN users u
		ON pki.UserID = u.UserID
		INNER JOIN pokemons p
		ON pki.PokemonID = p.PokemonID
		INNER JOIN levels l
		ON pki.PokemonItemID = l.PokemonItemID
		WHERE pki.UserID = '$userid' AND pki.ItemStatus = 2
		ORDER BY l.Level DESC LIMIT 1";
$res = mysqli_query($con, $sql) or die("[ERROR]");
while($rows = mysqli_fetch_assoc($res)){
	$data[] = $rows;
}
echo json_encode($data);
?>