<?php
session_start();
if(!isset($_SESSION['user_id'])){
	echo "<script>window.location.href='login.php'</script>";
} 
$userid = $_SESSION['user_id'];
include('config.php');
$slt = "SELECT Level FROM levels l
		INNER JOIN pokemonitems pki ON pki.PokemonItemID = l.PokemonItemID
		WHERE pki.ItemStatus = 2 AND pki.UserID = '$userid'";
$res = mysqli_query($con, $slt) or die("[ERROR]: $slt");
$row = mysqli_fetch_array($res);
if($row['Level'] < 16){
	$sql = "SELECT * FROM pokemons p
		INNER JOIN parameters pmt
		ON pmt.PokemonID = p.PokemonID
		INNER JOIN gains g
		ON g.PokemonID = p.PokemonID WHERE p.EV < 2";
}
else if($row['Level'] >= 16 && $row['Level'] <= 35){
	$sql = "SELECT * FROM pokemons p
		INNER JOIN parameters pmt
		ON pmt.PokemonID = p.PokemonID
		INNER JOIN gains g
		ON g.PokemonID = p.PokemonID WHERE p.EV < 3";
}
else{
	$sql = "SELECT * FROM pokemons p
		INNER JOIN parameters pmt
		ON pmt.PokemonID = p.PokemonID
		INNER JOIN gains g
		ON g.PokemonID = p.PokemonID";
}

$res = mysqli_query($con, $sql);
while($rows = mysqli_fetch_assoc($res)){
	$data[] = $rows;
}
echo json_encode($data);
?>