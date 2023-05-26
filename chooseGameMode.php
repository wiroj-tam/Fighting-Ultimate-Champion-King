<?php
session_start();
if(!isset($_SESSION['user_id'])){
	echo "<script>window.location.href='login.php'</script>";
}
include('config.php');
?>
<!DOCTYPE html>
<html>
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="./s.css">
	<link rel="shortcut icon" type="image/x-icon" href="./img/logoLogin.png" />
	<script src="./js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){


			$(".AMbtn").click(function(){

        		var url = "./api/checkPokemon.php";

       			$.get(url, function(data, status){
       				if(data.check == "accept"){
       					window.location.href = 'game.php';
       				}
       				else if(data.check == "reject"){
       					$("#msg").text("You don't have any Pokemon in Pocket, Go to INDEX page and pick pokemon. If don't have any pokemon go to SHOP page and purchase pokemons.").show().fadeOut(10000);
       				}
       			});
			});

			$(".BMbtn").click(function(){

        		var url = "./api/checkPokemon.php";

       			$.get(url, function(data, status){
       				if(data.check == "accept"){
       					window.location.href = 'battle.php';
       				}
       				else if(data.check == "reject"){
       					$("#msg").text("You don't have any Pokemon in Pocket, Go to INDEX page and pick pokemon. If don't have any pokemon go to SHOP page and purchase pokemons.").show().fadeOut(15000);
       				}
       			});
			});

			$("#loadPlayers").load("./api/loadPlayers.php");
		});
	</script>
	<title>GameMode</title>
	<style type="text/css">

	#loadPlayers {
		font-size: 20px;
		position: relative;
		margin-left: -32.5%;
		margin-bottom: 5%;
		left: 50%;
	}
	:root {
		--w: 720px;
		--h: 380px;
		--wHf: -360px;
		--hHf: -190px;
	}
	body{
		/*background-image: url("img/Gamebg.png");*/
		background-size: cover;
		background-position: center;
		background-repeat: no-repeat;
		font-family: Monaco;
		background: url("img/bggame.jpg");

	}
	.center{
		border-radius: 5px;		
		position: relative;
		width: var(--w);
		height: var(--h);
		left: 50%;
		top: 60%;
		margin-left: var(--wHf);
		margin-top: var(--hHf);
		text-align: center;
		box-sizing: border-box;
		padding: 30px 0px 15px 0px;
	}
	button{
		outline: none;
		font-weight: 900;
		color: white;
		font-size: 30px;
		margin: 20px;
		border-radius: 25px;
		display: inline;
		width: 300px;
		height: 150px;
		text-shadow: 3px 3px 3px black;
		font-variant: small-caps;
	}
	.AMbtn{
		background: url("img/AMbg.jpg");
		background-size: cover;
	}
	.BMbtn{
		background: url("img/BMbg.jpg");
		background-size: cover;
	}
	.AMbtn:hover ,.BMbtn:hover{
		opacity: 0.85;
		cursor: pointer;
		animation: shake 0.6s infinite;
	}
	@keyframes shake {
  		0% { transform: translate(1px, 1px) rotate(0deg); }
  		10% { transform: translate(-1px, -2px) rotate(-1deg); }
  		20% { transform: translate(-3px, 0px) rotate(1deg); }
  		30% { transform: translate(3px, 2px) rotate(0deg); }
  		40% { transform: translate(1px, -1px) rotate(1deg); }
  		50% { transform: translate(-1px, 2px) rotate(-1deg); }
  		60% { transform: translate(-3px, 1px) rotate(0deg); }
  		70% { transform: translate(3px, 1px) rotate(-1deg); }
  		80% { transform: translate(-1px, -1px) rotate(1deg); }
  		90% { transform: translate(1px, 2px) rotate(0deg); }
  		100% { transform: translate(1px, -2px) rotate(-1deg); }
	}
	.desc{
		font-size: 20px;
		position: absolute;
		font-weight: 700;
		font-variant: small-caps; 
	}
	.backBtn{
		background-color: black;
		font-variant: normal;
		font-weight: 700;
		font-size: 22px;
		width: 25%;
		height: 20%;
	}
	.backBtn:hover{
		opacity: 0.85;
		cursor: pointer;
	}
	</style>
</head>
<body>
	<div id="msg" style="
	: rgb(10,140,255); font-size: 22px; padding: 1%; display: none;"></div>
 	<div style="text-align:center;"><img src="./img/logoLogin.png" width=7.5% height=7.5%><h2 style="font-variant: small-caps;">Fighting Ultimate Champion King</h2></div>
          <marquee direction="left" class="marquee">Welcome to Fighting Ultimate Champion King. Hope you enjoy my browser game. Get out COVID-19. The weather changes frequently, Don't forget to cover the cloth. by Wiroj Tamboonlertchai</marquee>
	
<nav>
	<div class = "menu">
		
		<?php if($_SESSION['user_status'] == 2) echo '<a href="admin.php" class="adminstrator">Admin</a>'; ?>
		
		<a href="user.php">Home</a>
		<a href="home.php">SHOP</a>
		<a href="chooseGameMode.php" class="active">START GAME</a>
		<a href="deck.php">Deck</a>
		<!-- <a href="dailyRewards.php"><img src="./img/gift.jpg" width="16px" height="16px"><span> Daily Rewards</span></a> -->
	
		

		<a href="Logout.php" style="float: right">Log out</a>
		<a href="register.php" style="float: right">Create an Account</a>
		
	</ul>
	</div>
</nav>

<br><br><br><br><br><br><br><br><br><br>
	<div class="center">
	<button class="AMbtn">Adventure Mode</button>
	<button class="BMbtn">Battle Mode</button><br>
	<span style="left: 5%;" class="desc">Fighting with bots.<br> Gains your Level, Money And Exp <br>for your pokemon.</span>
	<span style="left: 60%;" class="desc">Fighting with players.</span>
	<br><br><br><button onclick="window.location = 'home.php';" class="backBtn">Back to Home</button>
	</div>

<div id="loadPlayers">
	
</div>

</body>
</html>