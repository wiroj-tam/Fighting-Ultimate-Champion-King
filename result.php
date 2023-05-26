<?php 
include('config.php');
session_start();
if(!isset($_SESSION['user_id'])) {
	echo "<script>window.location.href='login.php'</script>";
} 
?>

<?php

	function fetch_pokeball($pokeballType) {
		global $con;
		//pokeball
		$select_pokeball = "SELECT * FROM pokeballitems pkbi 
							INNER JOIN pokeballs pkb ON pkbi.PokeballID = pkb.PokeballID
							WHERE pkbi.PokeballID = '$pokeballType' AND pkbi.UserID = ".$_SESSION['user_id'];
		$query_pokeball = mysqli_query($con, $select_pokeball) or die("$select_pokeball");
		$invent_pokeball = mysqli_fetch_array($query_pokeball);
		$_SESSION['pokeball_image'] = $invent_pokeball['PokeballImage'];
		$_SESSION['pokeball_quantity'] = 1; //drop
		//test
	}
	
	function drop_pokeball() {
		global $con;
		$checkHasPokeball = "SELECT * FROM pokeballitems WHERE UserID = ".$_SESSION['user_id'];
		$res_pokeball = mysqli_query($con, $checkHasPokeball) or die("$checkHasPokeball");
		$row_pokeball = mysqli_fetch_array($res_pokeball);

		$random_ball = rand(1,100);
			if($random_ball <= 60) {

				$pokeball_quantity = $row_pokeball['PokeballQuantity'] + 1;
				$update_pokeball = "UPDATE pokeballitems SET PokeballQuantity = '$pokeball_quantity' WHERE UserID = ".
				$_SESSION['user_id']." AND PokeballID = ".$row_pokeball['PokeballID'];
				fetch_pokeball(1);
			}
			else if($random_ball > 60 && $random_ball <= 90) {

				$row_pokeball = mysqli_fetch_array($res_pokeball);

				$pokeball_quantity = $row_pokeball['PokeballQuantity'] + 1;
				$update_pokeball = "UPDATE pokeballitems SET PokeballQuantity = '$pokeball_quantity' WHERE UserID = ".
				$_SESSION['user_id']." AND PokeballID = ".$row_pokeball['PokeballID'];

				fetch_pokeball(2);
			}
			else {
				$row_pokeball = mysqli_fetch_array($res_pokeball);
				$row_pokeball = mysqli_fetch_array($res_pokeball);

				$pokeball_quantity = $row_pokeball['PokeballQuantity'] + 1;
				$update_pokeball = "UPDATE pokeballitems SET PokeballQuantity = '$pokeball_quantity' WHERE UserID = ".
				$_SESSION['user_id']." AND PokeballID = ".$row_pokeball['PokeballID'];

				fetch_pokeball(3);
			}

			mysqli_query($con, $update_pokeball);
	}
?>

<?php

$isLvlUp = false;

if($_SESSION['check'] >= 0):

	//Pokeball
	
	$checkHasPokeball = "SELECT * FROM pokeballitems WHERE UserID = ".$_SESSION['user_id'];
	$res_pokeball = mysqli_query($con, $checkHasPokeball) or die("$checkHasPokeball");
	$row_pokeball = mysqli_fetch_array($res_pokeball);

	if($res_pokeball) {
		if(mysqli_num_rows($res_pokeball) == 3) {
			drop_pokeball();
		}
		else {
			$userid = $_SESSION['user_id'];
			$insert_pokeball = "INSERT INTO pokeballitems VALUES(NULL, 1, '$userid', 0)";
			$insert_greatball = "INSERT INTO pokeballitems VALUES(NULL, 2, '$userid', 0)";
			$insert_ultraball = "INSERT INTO pokeballitems VALUES(NULL, 3, '$userid', 0)";
			mysqli_query($con, $insert_pokeball);
			mysqli_query($con, $insert_greatball);
			mysqli_query($con, $insert_ultraball);
			drop_pokeball();
		}

	}


	//Update moneys
	$impexp = $_SESSION['coin'];
	$amount = $_SESSION['user_money'] + $impexp;
	$enemyName = $_SESSION['enemyName'];
	$enemyLevel = $_SESSION['enemyLevel'];
	if($_SESSION['check'] == 1){
		$detail = "Eliminate ".$enemyName." (Level ".$enemyLevel.")";
	} //endif($_SESSION['check'] == 1)
	else if($_SESSION['check'] == 0){
		$detail = "Lose to ".$enemyName." (Level ".$enemyLevel.")";
	}

	
	$userid = $_SESSION['user_id'];
	$sql = "INSERT INTO moneys VALUES(NULL, '$impexp', '$amount', '$detail', NULL, '$userid')";
	$res = mysqli_query($con, $sql) or die("$sql");

	$_SESSION['user_money'] = $amount;


	//Update exp
	$sql_exp = "SELECT Exp FROM pokemonitems WHERE PokemonItemID = ".$_SESSION['pkiid'];
	$res_exp = mysqli_query($con, $sql_exp) or die("$sql_exp");
	$row_exp = mysqli_fetch_assoc($res_exp);
	$expGain = $row_exp['Exp'] + $_SESSION['exp'];

	$update = "UPDATE pokemonitems SET Exp = ".$expGain." WHERE PokemonItemID = ".$_SESSION['pkiid']."";
	$res_update = mysqli_query($con, $update) or die("[ERROR]: $update");


	//check lvl up
	$sql_up = "SELECT * FROM pokemonitems pi
				INNER JOIN levels l ON l.PokemonItemID = pi.PokemonItemID
				INNER JOIN pokemons p ON p.PokemonID = pi.PokemonID
				WHERE pi.PokemonItemID = ".$_SESSION['pkiid']."";
	$res_up = mysqli_query($con, $sql_up) or die("$sql_up");
	$row_up = mysqli_fetch_assoc($res_up);


	$diff = $row_up['NeedExp'] / $row_up['Level'];
	$i = 0;
	$exp = $row_up['Exp'];
	$maxExp = $row_up['NeedExp'];

	while($exp >= $maxExp){
		$i++;
		$exp -= $maxExp;
		$maxExp += $diff;
	}



	if($i > 0){

		$sql_gains = "SELECT * FROM gains WHERE PokemonID = ".$_SESSION['pkid'];
		$res_gains = mysqli_query($con, $sql_gains) or die("[ERROR] $sql_gains");
		$row_gains = mysqli_fetch_array($res_gains);

		$isLvlUp = true;
		while ($i > 0) {
			$sql_fetchlvl = "SELECT * FROM levels WHERE PokemonItemID = ".$_SESSION['pkiid'];
			$res_fetchlvl = mysqli_query($con, $sql_fetchlvl) or die("[ERROR] $sql_fetchlvl");
			$row_fetchlvl = mysqli_fetch_array($res_fetchlvl);

			$lvl = $row_fetchlvl['Level'] + 1;
			$atkgain = rand( ($row_gains['AtkG'] * 0.9), ($row_gains['AtkG'] * 1.2) );
			$defgain = rand( ($row_gains['DefG'] * 0.9), ($row_gains['DefG'] * 1.2) );
			$spdgain = rand( ($row_gains['SpdG'] * 0.9), ($row_gains['SpdG'] * 1.2) );
			$spatkgain = rand( ($row_gains['SpAtkG'] * 0.9), ($row_gains['SpAtkG'] * 1.2) );
			$spdefgain = rand( ($row_gains['SpDefG'] * 0.9), ($row_gains['SpDefG'] * 1.2) );
			$hpgain = rand( ($row_gains['HPG'] * 0.9), ($row_gains['HPG'] * 1.2) );
?>
<div class="result">
	<table align="center">
	<tr>
		<td>
			<img src="img/<?= $row_up['Image']; ?>" width="160" height="160"><br>
		</td>
		<td>
			<h1>LVL UP !</h1>
			<span><?= "Name: ".$row_up['ItemName']; ?></span><br>
			<span><?= "Level: ".$row_fetchlvl['Level']." --> ".$lvl; ?></span><br>
			<span><?= "Atk: ".$row_fetchlvl['Atk']." (+".$atkgain.")"; ?></span><br>
			<span><?= "Def: ".$row_fetchlvl['Def']." (+".$defgain.")"; ?></span><br>
			<span><?= "Spd: ".$row_fetchlvl['Spd']." (+".$spdgain.")"; ?></span><br>
			<span><?= "SpAtk: ".$row_fetchlvl['SpAtk']." (+".$spatkgain.")"; ?></span><br>
			<span><?= "SpDef: ".$row_fetchlvl['SpDef']." (+".$spdefgain.")"; ?></span><br>
			<span><?= "HP: ".$row_fetchlvl['HP']." (+".$hpgain.")"; ?></span><br>
		</td>
	</tr>
	</table>
</div>
			
<?php
			$atk = $row_fetchlvl['Atk'] + $atkgain;
			$def = $row_fetchlvl['Def'] + $defgain;
			$spd = $row_fetchlvl['Spd'] + $spdgain;
			$spatk = $row_fetchlvl['SpAtk'] + $spatkgain;
			$spdef = $row_fetchlvl['SpDef'] + $spdefgain;
			$hp = $row_fetchlvl['HP'] + $hpgain;

			$sql_updatelvl = "UPDATE levels
			SET Level = '$lvl',
				Atk = '$atk',
				Def = '$def',
				Spd = '$spd',
				SpAtk = '$spatk',
				SpDef = '$spdef',
				HP = '$hp'
			WHERE PokemonItemID = ".$_SESSION['pkiid']."
			";
			$res_updatelvl = mysqli_query($con, $sql_updatelvl) or die("[ERROR] $sql_updatelvl");


			$sql_updateExp = "UPDATE pokemonitems
			SET Exp = '$exp', NeedExp = '$maxExp'
			WHERE PokemonItemID = ".$_SESSION['pkiid']."";
			$res_updateExp = mysqli_query($con, $sql_updateExp) or die("[ERROR] $sql_updateExp");


			$i--;
		} //end while ($i > 0)

		$check_evol = "SELECT EV_LVL FROM pokemons WHERE PokemonID = ".$_SESSION['pkid'];
		$res_evol = mysqli_query($con, $check_evol) or die("[ERROR]: $check_evol");
		$row_evol = mysqli_fetch_array($res_evol);

		if($row_evol['EV_LVL'] > 0 && $lvl >= $row_evol['EV_LVL']) {
				$sql = "SELECT A.Name AS PokemonName, B.Name AS EvolutionName, A.Image AS PokemonImage, B.Image AS EvolutionImage
						FROM pokemons A, pokemons B
						WHERE A.EV_ID = B.PokemonID AND A.PokemonID = ".$_SESSION['pkid'];
				$res = mysqli_query($con, $sql);
				if($res) {
					$row = mysqli_fetch_array($res);
			?>

					<div class="result">
						<table align="center">
							<tr>
								<td>
									<img src="img/<?= $row['PokemonImage']; ?>" width="160" height="160"><br>
									<span><?= $row['PokemonName']; ?></span><br>
									<input type="hidden" id="PokemonItemID" value="<?= $_SESSION['pkiid']; ?>"><br>
								</td>
								<td>
									<img src="img/arrow_right.png" width="130" height="80"><br>
								</td>
								<td>
									<img src="img/<?= $row['EvolutionImage']; ?>" width="160" height="160"><br>
									<span><?= $row['EvolutionName']; ?></span><br>
								</td>
							</tr>
							<tr align="center">
								<td colspan="3">
									<button id="evolutionBtn">Evolve</button><br>
								</td>
							</tr>

						</table>
					</div>

			<?php
				}
			} //end if ($lvl >= $ev_id)
	} //end if ($i > 0)

	
endif;
?>
<!DOCTYPE html>
<html>
<head>
	<script src="js/jquery-3.5.1.min.js"></script>
	<script>
		$(document).ready(function() {

			$("#evolutionBtn").click(function() {

				var PokemonItemID = $("#PokemonItemID").val();

				$.ajax({

				type: "POST",
				url: "./api/evolution.php",
				data: {"PokemonItemID": PokemonItemID},
				success: function(data) {
					window.location.href="result.php";
       			}

				});
			});

		});
	</script>
	<style type="text/css">
		#capture {
			text-align: center;
			position: relative;
			left: 50%;
			width: 51.5%;
			max-height: 75%;
			margin-left: -25%;
			margin-top: 5%;
			border: 1px solid black;
			padding-bottom: 2.5%;
		}
		.result{
			text-align: center;
			position: relative;
			left: 50%;
			width: 50%;
			max-height: 92.5%;
			margin-left: -25%;
			margin-top: 5%;
			border: 1px solid black;
			padding: 0.75%;
		}
		.btn{
			text-align: center;
			position: relative;
			margin-top: 1.25%;
			left: 50%;
			width: 15%;
			margin-left: -7.5%;
		}
		.btn button{
			outline: none;
			width: 80px;
			height: 30px;
			border-radius: 50px;
			border: 1px solid black;
		}
		.btn button:hover{
			opacity: 0.88;
			cursor: pointer;
		}
		.btn h2{
			font-size: 50px;
		}
		.result span{
			margin: 15px;
			font-weight: 700;
			font-variant: small-caps;
			font-size: 20px;
		}
		#evolutionBtn {
			font-size: 25px;
			outline: none;
			width: 170px;
			height: 30px;
			border-radius: 50px;
			border: 1px solid black;
		}
		#evolutionBtn {
			cursor: pointer;
			color: white;
			background-color: #6396c9;
			opacity: 0.8;
		}
		.drop{
			text-align: left;
		}
		#captureText {
			text-align: center;
			font-size: 32px;
			-webkit-text-stroke: 1px black;
			color: white;
			font-weight: 900;
		}
	</style>
	<title>Result</title>
	<script src="./js/angular.min.js"></script>
	<script>
		var app = angular.module("app", []);
		app.controller("ctrl", function($scope, $http){

			$scope.loadPokeball = function() {
				$http.get("./api/fetch.php").then(function(response){
					$scope.pokeballs = response.data.pokeballs;
				});
			};

			$scope.capture = function(ballType) {
				
				$http({
					method: "POST",
					url: "./api/capture.php",
					data: ballType
				}).then(function(response) {
					$scope.loadPokeball();
					var captureText = document.getElementById("captureText");
					if(response.data == "Accept") {
						var cap = document.getElementById("capture");
						captureText.style.color = "yellow";
						captureText.innerHTML = "Monster was caught !";
						captureText.style.display = "block";
						cap.style.display = "none";

					}
					else {
						captureText.style.color = "gray";
						captureText.innerHTML = "Monster broke free ! Try again.";
						captureText.style.display = "block";
					}
				})
			}

		});
	</script>
</head>

<body ng-app="app" ng-controller="ctrl" ng-init="loadPokeball()">
<?php


	$sql = "SELECT * FROM levels l
			INNER JOIN pokemonitems pi ON l.PokemonItemID = pi.PokemonItemID
			INNER JOIN pokemons p ON pi.PokemonID = p.PokemonID
			WHERE l.PokemonItemID = ".$_SESSION['pkiid']." AND p.PokemonID = ".$_SESSION['pkid']."";
	$res = mysqli_query($con, $sql) or die("$sql");
	$row = mysqli_fetch_assoc($res);
	

?>
<div class="result">
	<table align="center">
	<tr>
		<td>
			<img src="img/<?php echo $row['Image'];?>" width="160" height="160"><br>
		</td>
		<td>
			<span><?php echo "Name: ".$row['ItemName']; ?></span><br>
			<span><?php echo "Level: ".$row['Level']; ?></span><br>
			<span><?php echo "Atk: ".$row['Atk']; ?></span><br>
			<span><?php echo "Def: ".$row['Def']; ?></span><br>
			<span><?php echo "Spd: ".$row['Spd']; ?></span><br>
			<span><?php echo "SpAtk: ".$row['SpAtk']; ?></span><br>
			<span><?php echo "SpDef: ".$row['SpDef']; ?></span><br>
			<span><?php echo "HP: ".$row['HP']; ?></span><br>
			<span><?php echo "EXP: ".$row['Exp']."/".$row['NeedExp']; ?></span>
			<progress value="<?php echo $row['Exp']; ?>" max="<?php echo $row['NeedExp']; ?>"></progress><br>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div class="drop">
			<span>Drop:</span><br>
			<span><img src="./img/<?= $_SESSION['pokeball_image']; ?>" width="32" height="32">x<?= $_SESSION['pokeball_quantity'] ?></span><br>
			<span><?php echo "Money Gain: ".$_SESSION['coin']." pix"; ?></span><br>
			<span><?php echo "Exp Gain: ".$_SESSION['exp']; ?></span><br>
			</div>
			<span>Money: <?php echo $_SESSION['user_money']." pix"; ?></span><br>
		</td>
	</tr>
	<tr>
		<td colspan="2" >
			<span>Pokeballs:</span><br><br>
			<table width="100%">
				<tr>
					<td ng-repeat = "p in pokeballs">
						<img ng-src="./img/{{p.PokeballImage}}" width="40" height="40"><div>{{p.PokeballName}}<br>{{'x' + p.PokeballQuantity}}</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2"><hr></td>
	</tr>

	</table>
</div>

<?php
if($_SESSION['check'] == 1) {
?>
	<div id="capture">
		<h1>Capture This Monster ?</h1>
		<table align="center">
			<tr>
				<td>
					<img src="img/<?= $_SESSION['enemyImage']; ?>" width="160" height="160"><br>
				</td>
				<td>
			<span><?= "Name: ".$_SESSION['enemyName']; ?></span><br>
			<span><?= "Level: ".$_SESSION['enemyLevel']; ?></span><br>
			<span><?= "Atk: ".$_SESSION['enemyAtk']; ?></span><br>
			<span><?= "Def: ".$_SESSION['enemyDef']; ?></span><br>
			<span><?= "Spd: ".$_SESSION['enemySpd']; ?></span><br>
			<span><?= "SpAtk: ".$_SESSION['enemySpAtk']; ?></span><br>
			<span><?= "SpDef: ".$_SESSION['enemySpDef']; ?></span><br>
			<span><?= "HP: ".$_SESSION['enemyHP']; ?></span><br>
				</td>
			</tr>

		</table>
		
		<table width="75%" style="margin: 0 12.5% 0 12.5%">
				<tr>
					<td ng-repeat = "p in pokeballs">
						<img ng-src="./img/{{p.PokeballImage}}" width="40" height="40"><div>{{p.PokeballName}}<br>{{'x' + p.PokeballQuantity}}</div>
						<button ng-click="capture(p.PokeballName)">Capture</button>
					</td>
				</tr>
			</table>
	</div>
	<div id="captureText"></div>
<?php
}
?>
<div class="btn">
	<a href="game.php"><button>Continue</button></a>
	<a href="home.php"><button>Home</button></a>
</div><br>
</body>
</html>


<?php 
$_SESSION['check'] = -1;

if(isset($_SESSION['bot']) && $_SESSION['bot'] == "On"){
		echo '<script type="text/javascript">';
        echo 'window.location.href="game.php";';
        echo '</script>';
}
?>
