<?php 
include('config.php');
session_start();
if(!isset($_SESSION['user_id'])){
	echo "<script>window.location.href='login.php'</script>";
}
$msg = "";
?>

<?php

	$msg_cp = "";
	//Change User's password.
	if(isset($_POST['change-password'])){
		$old_password = $_POST['old-password'];
		$new_password = $_POST['new-password'];
		$confirm_new_password = $_POST['confirm-new-password'];
		if($old_password == $_SESSION['user_password'] && $new_password == $confirm_new_password){
			$sql_cp = "UPDATE users SET Password = '$new_password' WHERE UserID = ".$_SESSION['user_id']."";
			$_SESSION['user_password'] = $new_password;
			mysqli_query($con,$sql_cp) or die("Can't query sql_cp");
			header('location:user.php');

		} else {
			$msg_cp ="Password doesn't match.";
		}
	}
	//pokemon status = 0(sold), 1(normal), 2(in team)
		
 ?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" href="s.css">
<link rel="shortcut icon" type="image/x-icon" href="./img/logoLogin.png" />
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>
	<style type="text/css">
		body{
			margin: 0px;
			background-image: url("img/bggame.jpg");
		}
		#nav{
			position: fixed;
			display: none;
			background-color: red;
			width: 170px;
			height: 100%;
			top: 0%;
			left: 87%;
			z-index: 2;
		}
		#nav a{
			color: white;
			text-decoration: none;
			font-size: 16px;
			float: left;
			padding: 25px;
			width: 120px;
		}
		#nav span{
			color: white;
			background-color: rgb(200,5,0);
			text-decoration: none;
			font-size: 18px;
			float: left;
			padding: 25px;
			width: 120px;
		}
		#nav span:hover{
			cursor: pointer;
			opacity: 0.8;
		}
		#nav a:hover{
			opacity: 0.8;
			background-color: rgb(200,0,0);
		}
		#content{
			position: relative;

		}
		#menu{
			font-size: 20px;
			width: 100px;
			background-color: red;
			color: white;
			outline: none;
			border: none;
			border-radius: 15px;
		}
		#menu:hover{
			cursor: pointer;
			opacity: 0.8;
		}
		#top-nav{
			top: 0%;
			z-index: 1;
			position: fixed;
			padding: 5px;
			height: 20px;
		}
		#content{
			background-color: rgba(255,255,255,0.35);
		}
		.pokemon-container {
			position: relative;
		}
		.pokemon-content {
			text-align: center;
			margin: 1.75%;
			display: inline-block;
			position: relative;
		}
	</style>
	<script src="./js/angular.min.js"></script>
<script type="text/javascript">
	var app = angular.module("App", []);
	app.controller("Ctrl", function($scope, $http){

		$scope.loadPokemon = function() {
			$http.get("./api/loadPokemon.php").then(function(response) {
				$scope.pokemons = response.data;
			});
		}

		$scope.loadPickedPokemon = function() {
			$http.get("./api/loadPickedPokemon.php").then(function(response) {
				$scope.pickedPokemon = response.data;
			});
		}

		$scope.changeName = function(pokemonItemID, name) {
			$http({
				method: "POST",
				url: "./api/manageUserService.php",
				data: {"pokemonItemID": pokemonItemID, "name": name, "action": "changeName"}
			});
		}

		$scope.pick = function(pokemonItemID) {
			$http({
				method: "POST",
				url: "./api/manageUserService.php",
				data: {"pokemonItemID": pokemonItemID, "action": "pick"}
			}).then(function(response) {
				$scope.loadPickedPokemon();
				$scope.loadPokemon();
			});
		}

		$scope.abandon = function(pokemonItemID) {

			check = confirm("Are you sure to abandon this pokemon?")

        	if(check){
            	$http({
					method: "POST",
					url: "./api/manageUserService.php",
					data: {"pokemonItemID": pokemonItemID, "action": "abandon"}
				}).then(function(response) {
					$scope.loadPickedPokemon();
					$scope.loadPokemon();
				});
        	}

			
		}

		$scope.lists = [];
		$scope.loadFinance = function(){
			$http.get("./api/finance.php").then(function(response){
				$scope.lists = response.data;
			});
		};

		$scope.orderBy = function(x){
			$scope.orderItem = x;
		};

		$scope.openMenu = function(){
			var nav = document.getElementById('nav');
			nav.style.display = "block";
		}; 
		$scope.closeMenu = function(){
			var nav = document.getElementById('nav');
			nav.style.display = "none";
		}; 

		$scope.search = function() {
			var x = document.getElementById("searchVal").value;
			$http({
				method: "POST",
				url: "./api/search_finance.php",
				data: x
			}).then(function(response){
				$scope.lists = response.data;
			});
		};

		// $scope.sortType = ["Newest", "Oldest", "Name", "Level"];
		// $scope.sortPokemon = function() {
		// 	var sort = $scope.selectedItem;
		// 	$http({
		// 		method: "POST",
		// 		url: "./api/sort_pokemon.php",
		// 		data: sort
		// 	}).then(function(response) {

		// 	});
		// };

	});
		
		
	
</script>	
</head>


<body ng-app="App" ng-controller="Ctrl" ng-init="loadPokemon()">
	
	<header>
	<div style="text-align:center;"><img src="./img/logoLogin.png" width=7.5% height=7.5%><h2 style="font-variant: small-caps;">Fighting Ultimate Champion King</h2></div>
    <marquee direction="left" class="marquee">Welcome to Fighting Ultimate Champion King. Hope you enjoy my browser game. Get out COVID-19. The weather changes frequently, Don't forget to cover the cloth. by Wiroj Tamboonlertchai</marquee>
	<nav>
	<div class = "menu">
		
		<?php if($_SESSION['user_status'] == 2) echo '<a href="admin.php" class="adminstrator">Admin</a>'; ?>
		
		<a href="user.php" class="active">Home</a>
		<a href="home.php">SHOP</a>
		<a href="chooseGameMode.php">START GAME</a>
		<a href="deck.php">Deck</a>
		<!-- <a href="dailyRewards.php"><img src="./img/gift.jpg" width="16px" height="16px"><span> Daily Rewards</span></a> -->
	
		

		<a href="Logout.php" style="float: right">Log out</a>
		<a href="register.php" style="float: right">Create an Account</a>
		
	</ul>
	</div>
</nav>
</header>
<div id="content">
	<table id="top-nav">
		<tr>
			<td width="96%"></td>
			<td width="4%"><button id="menu" ng-click="openMenu()">Menu</button></td>
		</tr>
	</table>
	<div id="nav">
		<span ng-click="closeMenu()">Close Menu</span>
		<a href="#monsterPossesion">Monster Possession</a><br>
		<a href="#personalHistory">Personal History</a><br>
		<a href="#changePassword">Change Password</a><br>
		<a href="#finance">Finance</a><br>
		<a href="home.php">Back</a>
	</div>
<div id="content">
	<h2 id="monsterPossesion">Monster Possesion</h2>
	<div ng-init="loadPickedPokemon()" class="pickedPokemon-container" style="text-align: center;">		
		<div ng-repeat="p in pickedPokemon">
			<table style="text-align: center;">
			<tr>
			<td>
			<input type="text" minlength="1" maxlength="12" ng-value="p.ItemName" ng-model="name[$index]" size="12" ng-change="changeName(p.PokemonItemID, name[$index])"/><br>	
			<img ng-src="./img/{{p.Image}}" width="96" height="96">
			</td>
			<td>
				{{"Lvl: " + p.Level}}<br>
				{{"Atk: " + p.Atk}}<br>
				{{"Def: " + p.Def}}<br>
				{{"Spd: " + p.Spd}}<br>
				{{"SpAtk: " + p.SpAtk}}<br>
				{{"SpDef: " + p.SpDef}}<br>
				{{"HP: " + p.HP}}<br>
				{{"EXP: " + p.Exp + "/" + p.NeedExp}}<br>
			</td>
			</tr>
			</table>
		</div>
	</div>
	
	<div class="pokemon-container">
		<div ng-repeat="p in pokemons" class="pokemon-content">
			<input type="text" minlength="1" maxlength="12" ng-value="p.ItemName" ng-model="name[$index]" size="12" ng-change="changeName(p.PokemonItemID, name[$index])"/><br>
			<img ng-src="./img/{{p.Image}}" width="64" height="64" /><br>
			<button ng-click="pick(p.PokemonItemID)" style="cursor: pointer;">Pick</button>
			<button ng-click="abandon(p.PokemonItemID)" style="cursor: pointer;">Abandon</button>
		</div>
	</div>
	
		
		<h3 id="personalHistory">Personal History</h3>
		<ul>
		<li><a>Username : <?php echo $_SESSION['user_username']; ?></a></li>
		<li><a>First Name : <?php echo $_SESSION['user_fname']; ?></a></li>
		<li><a>Last Name : <?php echo $_SESSION['user_lname']; ?></a></li>
		<li><a>Address : <?php echo $_SESSION['user_address']; ?></a></li>
		<li><a>Phone : <?php echo $_SESSION['user_phone']; ?></a></li>
		<li><a>Email : <?php echo $_SESSION['user_email']; ?></a></li>
		<li><a>Money : <?php echo $_SESSION['user_money']; ?> pix</a></li>
</ul>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="background-color: red;">
		<h3 id="changePassword">Change Password</h3><br>
		Old Password: <input type="Password" name="old-password" required><br>
		New Password: <input type="Password" name="new-password"><br>
		Confirm New Password <input type="Password" name="confirm-new-password" required><br>
		<input type="submit" value="Change Password" name="change-password" required><br>
		<p style="color:red"><?php echo $msg_cp; ?></p>
		</form>
	<h3 id="finance">Finance</h3>
	<input type="text" id="searchVal" ng-model="searchVal">
	<button id="search" ng-click="search()">Search</button>
	<table ng-init="loadFinance()" class="financeTable" width="100%" style="font-size: 20px; border-collapse: collapse;" border="1">
		<tr>
		<th ng-click="orderBy('Time')">Time</th>
		<th ng-click="orderBy('ImpExp')">Income</th>
		<th ng-click="orderBy('Amount')">Balance</th>
		<th ng-click="orderBy('Detail')">Detail</th>
		</tr>
		<tr ng-repeat="l in lists | orderBy: orderItem">
			<td align="center" width="40%">{{l.Time}}</td>
			<td align="center" width="10%">{{l.ImpExp}}</td>
			<td align="center" width="10%">{{l.Amount}}</td>
			<td align="center" width="40%">{{l.Detail}}</td>
		</tr>
	</table>
</div>
</div> <!-- content -->
</body>
</html>