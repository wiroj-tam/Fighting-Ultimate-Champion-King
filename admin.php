<?php 

  	include("config.php");
  	session_start();
	error_reporting(0);
?>

<?php
	if($_SESSION['user_status'] != 2){
   		echo "<script>window.location.href='login.php'</script>";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="s.css">
	<link rel="shortcut icon" type="image/x-icon" href="./img/logoLogin.png" />
	<meta name="viewport" content="initial-scale=1" />
	<meta charset="UTF-8">
	<style type="text/css">
	body{
		padding-bottom: 5%;
	}
	.product-content{
	text-align: center;
	border: 1px solid #333;
	background-color: #f1f1f1;
	border-radius: 5px;
	padding: 8px;
	width: 200px;
	height: 440px;
	margin-bottom: 4px;
	margin: 5%;
	}
	</style>
	<script src="./js/angular.min.js"></script>
	<title>Admin</title>
</head>
<header>
	<h2>Everything Management As Adminstrator</h2>
</header>
<body style="background-image : url('img/bggame.jpg');">

<nav>
	<div class = "menu">
		
		<?php if($_SESSION['user_status'] == 2) echo '<a href="admin.php" class="adminstrator active">Admin</a>'; ?>
		
		<a href="user.php">Home</a>
		<a href="home.php">SHOP</a>
		<a href="chooseGameMode.php">START GAME</a>
		<a href="deck.php">Deck</a>
		<!-- <a href="dailyRewards.php"><img src="./img/gift.jpg" width="16px" height="16px"><span> Daily Rewards</span></a> -->
	
		

		<a href="Logout.php" style="float: right">Log out</a>
		<a href="register.php" style="float: right">Create an Account</a>
		
	</ul>
	</div>
</nav>

<div ng-app="editPokemon" ng-controller="myCtrl" ng-init=loadProduct()>
<article>
<button onclick="window.location.href='addCharacter.php'">Add New Monster</button>    
<input style="border-radius: 12px; outline: none; border: 1px solid gray;" type="text" name="tf_search" ng-model="search" placeholder="Search for monsters"><br>

<div ng-repeat = "p in products | filter: search" class="product-form">
	<form method="post" action="{{'edit_item.php?id=' + p.PokemonID}}"> 
 	<div class="product-content">
 		<script type="text/javascript">
 		</script>
 		ID: <input type="text" value="{{p.PokemonID}}" name="id" readonly>
 		<h5>Code: {{p.Code}}</h5>
 		<!-- <h5>Detail: {{p.Detail}}</h5> -->
 		<img ng-src="img/{{p.Image}}" class = img-resonsive width=64px height=64px/>
 		<input type="hidden" name ="image" value="{{p.Image}}">
 		<h4 class="text-info" style="color:teal">{{p.Name}}</h4>
 		<h5>{{p.Price}}</h5>
 		<!-- <input type="text" name="quantity" class="form-control" value="1"/> -->
 		<input type="hidden" name="name" value="{{p.Name}}"/>
 		<input type="hidden" name="price" value="{{p.Price}}"/>
 		<h5>EV: {{p.EV}}</h5>
 		<h5>Element: {{p.Element}}</h5>
 		<button type="submit" style="font-size: 20px;">Edit</button>
 	</div>
 	</form>
</div>


<table border="1" style="border-collapse: collapse;" width="100%" id="userTable">
	<tr><td colspan="11"><b>Manage Users</b></td>
		<td><button ng-click="loadUsers();">Show all users</button></td>
	</tr>
	<tr style="background-color: rgba(155,165,225,0.75);">
		<th width="3.33%">UserID</th>
		<th width="8.33%">FName</th>
		<th width="8.33%">LName</th>
		<th width="8.33%">Phone</th>
		<th width="16.66%">Address</th>
		<th width="8.33%">Email</th>
		<th width="8.33%">DOB</th>
		<th width="4.33%">Gender</th>
		<th width="8.33%">Username</th>
		<th width="4.33%">Status</th>
		<th width="12.33%">Register Date</th>
		<th width="1.33%">Action</th>
	</tr>
	<tr ng-repeat="u in users" style="text-align: center;">
		<td>{{u.UserID}}</td>
		<td>{{u.FName}}</td>
		<td>{{u.LName}}</td>
		<td>{{u.Phone}}</td>
		<td>{{u.Address}}</td>
		<td>{{u.Email}}</td>
		<td>{{u.DOB}}</td>
		<td>{{u.Gender}}</td>
		<td>{{u.Username}}</td>
		<td>{{u.Status}}</td>
		<td>{{u.Date}}</td>
		<td><button ng-click="ban(u.UserID, u.Status)">{{u.Status > 0 ? "Ban" : "Unban" }}</button>
		</td>
	</tr>
	
</table>
</article>
</div> <!-- ng-app -->
<script type="text/javascript">
	var app = angular.module("editPokemon", []);
	app.controller("myCtrl", function($scope, $http){

		$scope.ban = function(id, status){
			
			$http({
				method: "POST",
				url: "./api/ban.php",
				data: id
			}).then(function(response){
				$scope.loadUsers();
			});
		};

		$scope.loadUsers = function(){
			$http.get("./api/fetchUsers.php").then(function(response){
				$scope.users = response.data;
			});
		};

		$scope.loadProduct = function(){
			$http.get("./api/fetchAll.php").then(function(response){
				$scope.products = response.data;
			});
		};

		$scope.carts = [];

		$scope.fetchCart = function(){
			$http.get("./api/fetch_cart.php").then(function(response){

				$scope.carts = response.data;

				$http.get("./api/total_price.php").then(function(response){
					$scope.total = response.data;
				});
			});
		};


		$scope.addToCart = function(product){
			$http({
				method: "POST",
				url: "./api/add_item.php",
				data: product
			}).then(function(response){
				$scope.fetchCart();
			});
		};

		$scope.removeProduct = function(id){
			$http({
				method: "POST",
				url: "./api/remove_item.php",
				data: id
			}).then(function(response){
				$scope.fetchCart();
			});
		}

		$scope.checkout = function(total){
			$http({
				method: "POST",
				url: "./api/checkout.php",
				data: total
			}).then(function(response){
				if(response.data == "accept"){
                    $scope.fetchCart();
				}
				else if(response.data == "reject"){
					alert("Don't have enough money");
					$scope.fetchCart();
				}
				
			});
		};
	});
</script> 


</body>

</html>