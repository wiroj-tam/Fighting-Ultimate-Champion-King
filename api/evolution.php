<?php
session_start();
include("../config.php");
if(!isset($_SESSION['user_id'])) {
		echo '<script>window.location.href="Login.php"</script>';
}

	if(isset($_POST['PokemonItemID'])) {

		$stat = "SELECT p.EV_ID, l.Atk, l.Def, l.Spd, l.SpAtk, l.SpDef, l.HP, pmt.AtkP, pmt.DefP, pmt.SpdP, pmt.SpAtkP, pmt.SpDefP, pmt.HPP FROM pokemonitems pki 
INNER JOIN levels l ON pki.PokemonItemID = l.PokemonItemID
INNER JOIN parameters pmt ON pki.PokemonID = pmt.PokemonID
INNER JOIN pokemons p ON pki.PokemonID = p.PokemonID
WHERE pki.PokemonItemID = ".$_POST['PokemonItemID'];
		$res = mysqli_query($con, $stat) or die("[ERROR]: $stat " );
		$row = mysqli_fetch_array($res);

		$parameter_evol = "SELECT AtkP, DefP, SpdP, SpAtkP, SpDefP, HPP FROM parameters WHERE PokemonID = ".$row['EV_ID'];
		$res_parameter_evol = mysqli_query($con, $parameter_evol) or die("[ERROR]: $parameter_evol");
		$row_parameter_evol = mysqli_fetch_array($res_parameter_evol);



		$atk = ($row['Atk'] - $row['AtkP']) + $row_parameter_evol['AtkP'];
		$def = ($row['Def'] - $row['DefP']) + $row_parameter_evol['DefP'];
		$spd = ($row['Spd'] - $row['SpdP']) + $row_parameter_evol['SpdP'];
		$spatk = ($row['SpAtk'] - $row['SpAtkP']) + $row_parameter_evol['SpAtkP'];
		$spdef = ($row['SpDef'] - $row['SpDefP']) + $row_parameter_evol['SpDefP'];
		$hp = ($row['HP'] - $row['HPP']) + $row_parameter_evol['HPP'];

		$update = "UPDATE pokemonitems pki
					INNER JOIN levels l ON pki.PokemonItemID = l.PokemonItemID
					SET pki.PokemonID = ".$row['EV_ID'].", 
					l.Atk = '$atk',
					l.Def = '$def',
					l.Spd = '$spd',
					l.SpAtk = '$spatk',
					l.SpDef = '$spdef',
					l.HP = '$hp'
					WHERE  pki.PokemonItemID = ".$_POST['PokemonItemID'];
		$res = mysqli_query($con, $update) or die("[ERROR]: $update " );
		$_SESSION['pkid'] = $row['EV_ID'];
	}
?>