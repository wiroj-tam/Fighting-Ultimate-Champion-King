<?php
include('config.php');
session_start();
if(!isset($_SESSION['user_id'])){
	echo "<script>window.location.href='login.php'</script>";
}

$userid = $_SESSION['user_id'];

$sql = "SELECT * FROM pokemonitems pki
		INNER JOIN pokemons p
		ON pki.PokemonID = p.PokemonID
		INNER JOIN levels l
		ON l.PokemonItemID = pki.PokemonItemID
        INNER JOIN users u
        ON u.UserID = pki.UserID
        WHERE pki.ItemStatus = 2 AND NOT pki.UserID = 1";
$res = mysqli_query($con, $sql);
while($rows = mysqli_fetch_array($res)){
	$data['players'][] = $rows;
}
echo json_encode($data);
?>