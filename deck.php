<?php
session_start();
if(!isset($_SESSION['user_id'])){
	echo "<script>window.location.href='login.php'</script>";
} 
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="s.css">
<link rel="shortcut icon" type="image/x-icon" href="./img/logoLogin.png" />
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Deck</title>
	<style>
		.div{
			margin-top: -7.5%;
			width: 100%;
			padding: 90px;

		}
		.content{
			text-align: center;
			border: 1px solid #333;
			background-color: #f1f1f1;
			border-radius: 5px;
			padding: 8px;
			width: 200px;
			height: 360px;
			display: block;
			margin: 5px;
			background-color: rgba(255, 255, 255, 0.75);
			float: left;

		}
	</style>
</head>
<header>
	<div style="text-align:center;"><img src="./img/logoLogin.png" width=7.5% height=7.5%><h2 style="font-variant: small-caps;">Fighting Ultimate Champion King</h2></div>
    <marquee direction="left" class="marquee">Welcome to Fighting Ultimate Champion King. Hope you enjoy my browser game. Get out COVID-19. The weather changes frequently, Don't forget to cover the cloth. by Wiroj Tamboonlertchai</marquee>
<nav>
	<div class = "menu">
		
		<?php if($_SESSION['user_status'] == 2) echo '<a href="admin.php" class="adminstrator">Admin</a>'; ?>
		
		<a href="user.php">Home</a>
		<a href="home.php">SHOP</a>
		<a href="chooseGameMode.php">START GAME</a>
		<a href="deck.php" class="active">Deck</a>
		<!-- <a href="dailyRewards.php"><img src="./img/gift.jpg" width="16px" height="16px"><span> Daily Rewards</span></a> -->
	
		

		<a href="Logout.php" style="float: right">Log out</a>
		<a href="register.php" style="float: right">Create an Account</a>
		
	</ul>
	</div>
</nav>
</header>
<body style="background-image : url('img/bggame.jpg');">
	<div class="div">
	<h1>Deck</h1>
	<?php 
	include('config.php');

	$sql = "SELECT * FROM pokemons p
		INNER JOIN parameters pmt ON p.PokemonID = pmt.PokemonID
		INNER JOIN gains g ON p.PokemonID = g.PokemonID";
	$res = mysqli_query($con,$sql); 
	while($rows = mysqli_fetch_array($res)){
	?>
	
		<div class="content">
		<img src="img/<?php echo $rows['Image']; ?>" width=128px height=128px><br>
		<span><?php echo $rows['Name'] ?></span><br>
		<?php echo "Atk: ".$rows['AtkP'] ?><br>
		<?php echo "Def: ".$rows['DefP'] ?><br>
		<?php echo "Spd: ".$rows['SpdP'] ?><br>
		<?php echo "SpAtk: ".$rows['SpAtkP'] ?><br>
		<?php echo "SpDef: ".$rows['SpDefP'] ?><br>
		<?php echo "HP: ".$rows['HPP'] ?>
		</div>


<?php

	}



	?>
		</div>
</body>
</html>