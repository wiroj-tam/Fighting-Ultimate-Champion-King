<?php
	session_start();
	if(!isset($_SESSION['user_id'])){
		echo "<script>window.location.href='login.php'</script>";
	} 
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="./js/jquery-3.5.1.min.js"></script>
	
	<title>Game</title>
	<script type="text/javascript">
		$(document).ready(function(){

			if($("#botBtn").val() == "Bot On"){
				$("#botBtn").css("border", "3px solid teal");
			}

			$("#botBtn").click(function(){

				if($("#botBtn").text() == "Bot On"){
					$("#botBtn").text("Bot Off");
					$("#botBtn").css("border", "3px solid blue");
					$("#botBtn").val("Bot On");
				}
				else if($("#botBtn").text() == "Bot Off"){
					$("#botBtn").text("Bot On");
					$("#botBtn").css("border", "1px solid black");
					$("#botBtn").val("Bot Off");
				}	
			});

			$("#accelerateBtn").click(function(){
				
				if($("#accelerateBtn").val() == "Accelerate Off") {
					$("#accelerateBtn").css("border", "3px solid red");
					$("#accelerateBtn").val("Accelerate On");
				}
				else {
					$("#accelerateBtn").css("border", "1px solid black");
					$("#accelerateBtn").val("Accelerate Off");
				}
					
			});

		});
	</script>
	<style>
	body {
	}
	#p_name {
		position: absolute;
		top: 25%;
		left: 8.75%;
		color: white;
		font-weight: 800;
		font-size: 25px;
		-webkit-text-stroke: 1.75px black;
	}
	#e_name {
		position: absolute;
		top: 25%;
		left: 80%;
		color: white;
		font-weight: 800;
		font-size: 25px;
		-webkit-text-stroke: 1.75px black;
	}
	#p_bg {
		position: absolute;
		background-color: white;
		border: 1px solid black;
		border-radius: 15px;
		width: 200px;
		height: 85px;
		top: 30%;
		left: 7.5%;
		box-sizing: border-box;
	}
	#p_n {
		position: absolute;
		margin-top: 5%;
		margin-left: 5%;
	}
	#p_l {
		margin-top: 5%;
		float: right;
		margin-right: 5%;
	}
	#pHP {
		position: absolute;
		margin-top: 6.25%;
		margin-left: 6.75%;
	}
	#p_hp {
		width: 75%;
		position: relative;
		height: 25px;
		margin-left: 20%;
		margin-top: 5%;
	}
	#p_hpcon {
		float: right;
		margin-right: 5%;
	}

	#e_bg {
		position: absolute;
		background-color: white;
		border: 1px solid black;
		border-radius: 15px;
		width: 200px;
		height: 85px;
		top: 30%;
		left: 78.75%;
		box-sizing: border-box;
	}
	#e_n {
		position: absolute;
		margin-top: 5%;
		margin-left: 5%;
	}
	#e_l {
		margin-top: 5%;
		float: right;
		margin-right: 5%;
	}
	#eHP {
		position: absolute;
		margin-top: 6.25%;
		margin-left: 6.75%;
	}
	#e_hp {
		width: 75%;
		position: relative;
		height: 25px;
		margin-left: 20%;
		margin-top: 5%;
	}
	#e_hpcon {
		float: right;
		margin-right: 5%;
	}

	#game {
		width: 90%; height: auto;
		z-index: -1;
		position: absolute;
		top: 50%;
		left: 50%;
		margin-left: -44.5%;
		margin-top: -17.5%;
	}
	#botBtn, #accelerateBtn{
		font-size: 20px;
		border-radius: 15px;
		outline: none;
		border: 1px solid black;
		position: relative;
		top: 10%;
		left: 46.125%;
		width: 100px;
		height: 40px;
		margin-top: -5%;
	}
	#botBtn:hover, #accelerateBtn{
		cursor: pointer;
		opacity: 0.8;
	}

	#console{
		text-align: center;
		position: absolute;
		top: 50%;
		left: 50%;
		width: 90%;
		margin-left: -44.5%;
		margin-top: 12.75%;
		font-size: 28px;
		font-weight: 700;
	}

	#submit_exp{
		z-index: 3;
		font-size: 38px;
		border-radius: 25px;
		outline: none;
		border: none;
		position: absolute;
		left: 50%;
		width: 320px;
		height: 80px;
		margin-left: -160px;
		margin-top: -40px;
		top: -175%;
		background-color: rgb(50,225,50);
		color: white;
	}
	#submit_exp:hover{
		background-color: rgb(50,255,50);
		cursor: pointer;
	}
	</style>
	<script src="./js/jquery-3.5.1.min.js"></script>
	
</head>
<link rel="stylesheet" href="s.css">
	
<body>
	<?php
		if(isset($_POST['submit_exp'])){

			$exp = $_POST['exp'];
			$pkid = $_POST['pkid'];
			$pkiid = $_POST['pkiid'];
			$lvl = $_POST['lvl'];
			$check = $_POST['check'];
			$coin = $_POST['coin'];
			$bot = $_POST['bot'];
			$enemyPokemonID = $_POST['enemyPokemonID'];
			$enemyImage = $_POST['enemyImage'];
			$enemyName = $_POST['enemyName'];
			$enemyLevel = $_POST['enemyLevel'];
			$enemyElement = $_POST['enemyElement'];
			$enemyAtk = $_POST['enemyAtk'];
			$enemyDef = $_POST['enemyDef'];
			$enemySpd = $_POST['enemySpd'];
			$enemySpAtk = $_POST['enemySpAtk'];
			$enemySpDef = $_POST['enemySpDef'];
			$enemyHP = $_POST['enemyHP'];
			$enemyEV = $_POST['enemyEV'];
			

			$_SESSION['exp'] = $exp;
			$_SESSION['pkid'] = $pkid;
			$_SESSION['pkiid'] = $pkiid;
			$_SESSION['lvl'] = $lvl;
			$_SESSION['check'] = $check;
			$_SESSION['coin'] = $coin;
			$_SESSION['bot'] = $bot;
			$_SESSION['enemyPokemonID'] = $enemyPokemonID;
			$_SESSION['enemyName'] = $enemyName;
			$_SESSION['enemyImage'] = $enemyImage;
			$_SESSION['enemyLevel'] = $enemyLevel;
			$_SESSION['enemyElement'] = $enemyElement;
			$_SESSION['enemyAtk'] = $enemyAtk;
			$_SESSION['enemyDef'] = $enemyDef;
			$_SESSION['enemySpd'] = $enemySpd;
			$_SESSION['enemySpAtk'] = $enemySpAtk;
			$_SESSION['enemySpDef'] = $enemySpDef;
			$_SESSION['enemyHP'] = $enemyHP;
			$_SESSION['enemyEV'] = $enemyEV;


			echo '<script type="text/javascript">';
            echo 'window.location.href="result.php";';
            echo '</script>';
		}
	
	 ?>
	  <marquee behavior=scroll direction="left" scrollamount="8" style="background-color: #ebfaec;">You can press "Bot On" button to turn bot on for automatically gameplay but, it's already automatically game play, It's just help you automatically press "accept" button when the battle is end. Hope you enjoy my browser game. Get out COVID-19. The weather changes frequently, Don't forget to cover the cloth. by Wiroj Tamboonlertchai</marquee><br><br>
	
	<div id="p_name"></div>
	<div id="e_name"></div>

	<div id="p_bg"><span id="p_n"></span><span id="p_l">Lv</span><span id="pHP">HP</span><progress id="p_hp" value="100" max="100"></progress><div id="p_hpcon"><span id="p_hpv">20</span>/<span id="p_mhpv">500</span></div></div>
	<div id="e_bg"><span id="e_n"></span><span id="e_l">Lv</span><span id="eHP">HP</span><progress id="e_hp" value="100" max="100"></progress><div id="e_hpcon"><span id="e_hpv">20</span>/<span id="e_mhpv">500</span></div></div>
	<!-- <progress id="e_hp" value="100" max="100" style="float:right;"></progress> -->
	<?php
		if(isset($_SESSION['bot']) && $_SESSION['bot'] == "On"){
	?>
		<button id="botBtn" type="button" name="botBtn" value="Bot On">Bot Off</button>
	<?php
		}
		else{
	?>
		<button id="botBtn" type="button" name="botBtn" value="Bot Off">Bot On</button>
	<?php
		} //endif
	?>

	<button id="accelerateBtn" value="Accelerate Off" style="display: none;">X2</button>
	
	
	<canvas id="game" width="1280" height="432"></canvas> <!-- Game on here -->
	
	<img src="img/charmander.png" id="image" width = "64px" height="64px" style="display:none">
	<script src="game.js"></script>
	<form method="post" action="game.php">
	<div id="console">

	<!-- player information -->
	<input type="hidden" value="" id="pkid" name = "pkid">
	<input type="hidden" value="" id="pkiid" name = "pkiid">
	<input type="hidden" value="" id="exp" name = "exp">
	<input type="hidden" value="" id="lvl" name = "lvl">
	<input type="hidden" value="" id="check" name = "check">
	<input type="hidden" value="" id="coin" name="coin">
	<input type="hidden" value="" id="bot" name="bot">

	<!-- enemy information -->
	<input type="hidden" value="" id="enemyPokemonID" name = "enemyPokemonID">
	<input type="hidden" value="" id="enemyImage" name="enemyImage">
	<input type="hidden" value="" id="enemyName" name="enemyName">
	<input type="hidden" value="" id="enemyLevel" name="enemyLevel">
	<input type="hidden" value="" id="enemyElement" name="enemyElement">
	<input type="hidden" value="" id="enemyAtk" name="enemyAtk">
	<input type="hidden" value="" id="enemyDef" name="enemyDef">
	<input type="hidden" value="" id="enemySpd" name="enemySpd">
	<input type="hidden" value="" id="enemySpAtk" name="enemySpAtk">
	<input type="hidden" value="" id="enemySpDef" name="enemySpDef">
	<input type="hidden" value="" id="enemyHP" name="enemyHP">
	<input type="hidden" value="" id="enemyEV" name="enemyEV">

	<input type ="submit" id ="submit_exp" style="display:none" value="Accept" name="submit_exp">
	<table width="100%" height="100%" border="1" style="border: 2.5px solid red;background-color: #c46404;" align="center">
		<tr><td>
	<pre id = "messages" style="color: white; -webkit-text-stroke: 1px black;" ></pre>
		</td></tr>
	</table>
	</div>
	</form>
	



	</script>

	
</body>
<article>





</article>
</html>