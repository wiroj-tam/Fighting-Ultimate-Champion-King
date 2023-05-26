<?php

session_start();
if(!isset($_SESSION['user_id'])){
	echo "<script>window.location.href='../login.php'</script>";
}
include("../config.php");
if($_SESSION["total"] > 0){
	if($_SESSION["user_money"] >= $_SESSION["total"]){
		foreach($_SESSION["shopping_cart"] as $key => $value) {
			$detail = "";
			$detail .= $_SESSION["shopping_cart"][$key]['product_name']." (".$_SESSION["shopping_cart"][$key]['product_price'].") ".
			"x".$value['product_quantity'];

			//Insert into table_pokemonitems.
			$pokemonid = $value['product_id'];
			$userid = $_SESSION['user_id'];
			$name = $value['product_name'];
			
			$sql = "SELECT p.EV FROM pokemons p WHERE p.PokemonID = '$pokemonid'";
			$res = mysqli_query($con, $sql) or die("can't query $sql");
			$rows = mysqli_fetch_assoc($res);

			$ev = $rows['EV'];

			if($ev == 1){
			    $needexp = 100;
			}
				
			else if($ev == 0){
			    $needexp = 125;
			}
				
			$i = 1;
			while($i <= $value['product_quantity']){
				$sql = "INSERT INTO pokemonitems VALUES(NULL,'$pokemonid','$userid','$name',1,0,'$needexp')";

				$res = mysqli_query($con, $sql) or die("Can't query $sql");

			//Select PokemonItemID from table_pokemonitems.
			$sql = 	"SELECT * FROM pokemonitems pki
								INNER JOIN parameters pmt
								ON pki.PokemonID = pmt.PokemonID
								ORDER BY PokemonItemID DESC LIMIT 1";
			$res = mysqli_query($con, $sql) or die("Can't query $sql");
			$rows = mysqli_fetch_array($res);
			$atk = $rows['AtkP'];
			$def = $rows['DefP'];
			$spd = $rows['SpdP'];
			$spatk = $rows['SpAtkP'];
			$spdef = $rows['SpDefP'];
			$hp = $rows['HPP'];
			$pokemonitemid = $rows['PokemonItemID'];

			//insert into table_levels.
			$sql = "INSERT INTO levels(Level,Atk,Def,Spd,SpAtk,SpDef,HP,PokemonItemID)
							VALUES(1,'$atk','$def','$spd','$spatk','$spdef','$hp','$pokemonitemid')";
			mysqli_query($con, $sql) or die("can't query $sql");
			$i++;
			}//while

			$impexp = -($value['product_price'] * ($i-1) );
			$_SESSION['user_money'] = $_SESSION['user_money'] + $impexp;
			$amount = $_SESSION['user_money'];
			$detail .= "<br>"."Total: ".$impexp;
			$sql = "INSERT INTO moneys VALUES(NULL,'$impexp','$amount','$detail', NULL, '$userid')";
			mysqli_query($con, $sql) or die("Can't query $sql.");


		}//foreach
		
		unset($_SESSION['shopping_cart']);
		$_SESSION["total"] = 0;
		echo "accept";
	}//if
	else{
		echo "reject";
	}
}

?>