<?php
include('../config.php');
session_start();

$sql = "SELECT DISTINCT u.Username, s.Score, (select ItemName from pokemonitems where ItemStatus = 2 and UserID = u.UserID limit 1) AS PokemonName, (select Level from levels inner join pokemonitems on levels.PokemonItemID = pokemonitems.PokemonItemID WHERE pokemonitems.UserID = u.UserID and pokemonitems.ItemStatus = 2 LIMIT 1) AS Level  FROM users u
		LEFT OUTER JOIN score s ON u.UserID = s.UserID
		LEFT OUTER JOIN pokemonitems pki ON u.UserID = pki.UserID
		LEFT OUTER JOIN levels l ON l.PokemonItemID = pki.PokemonItemID ORDER BY s.Score DESC";
$res = mysqli_query($con, $sql);
$i = 1;
echo "<table border=1 style='background-color: white; border-collapse: collapse;' width=50%>";
echo "<tr style='background-color: rgb(80,80,170);'>";
echo "<th style='color: white;'>Rank</th>";
echo "<th style='color: white;'>Username</th>";
echo "<th style='color: white;'>Monster Name</th>";
echo "<th style='color: white;'>Level</th>";
echo "<th style='color: white;'>Score</th>";
echo "</tr>";

while($rows = mysqli_fetch_array($res)) {
	
	echo "<tr>";
	echo "<td>".$i."</td>";
	echo "<td>".$rows['Username']."</td>";
	if($rows['PokemonName'] == NULL) echo "<td>-</td>";
	else echo "<td>".$rows['PokemonName']."</td>";
	echo "<td>".$rows['Level']."</td>";
	echo "<td>".$rows['Score']."</td>";
	echo "</tr>";

	$i++;
	
}
echo "</table>";
?>