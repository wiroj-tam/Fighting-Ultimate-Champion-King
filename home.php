<?php
	include('config.php');
	session_start();
	if(!isset($_SESSION['user_id'])) {
		echo '<script>window.location.href="Login.php"</script>';
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="s.css">
	<link rel="shortcut icon" type="image/x-icon" href="./img/logoLogin.png" />
	<script src="./js/angular.min.js"></script>
	<title>Fighting Ultimate Champion King</title>
	<style type="text/css">
		button{
			outline: none;
			border: solid 1px gray;
		}
		button:hover{
			cursor: pointer;
			opacity: 0.88;
		}
		.shoppingTable{
			width: 100%;
			position: sticky;
			top: 70%;
			opacity: 0.5;
		}
		body{
			background-image: url("img/bggame.jpg");
		}
	</style>
</head>
		
<body ng-app = "shoppingCart" ng-controller = "myCtrl" ng-init="loadProduct()">
    <div style="text-align:center;"><img src="./img/logoLogin.png" width=7.5% height=7.5%><h2 style="font-variant: small-caps;">Fighting Ultimate Champion King</h2></div>
    <marquee direction="left" class="marquee">Welcome to Fighting Ultimate Champion King. Hope you enjoy my browser game. Get out COVID-19. The weather changes frequently, Don't forget to cover the cloth. by Wiroj Tamboonlertchai</marquee>
	<nav>
	<div class = "menu">
		
		<?php if($_SESSION['user_status'] == 2) echo '<a href="admin.php" class="adminstrator">Admin</a>'; ?>
		
		<a href="user.php">Home</a>
		<a href="home.php" class="active">SHOP</a>
		<a href="chooseGameMode.php">START GAME</a>
		<a href="deck.php">Deck</a>
		<!-- <a href="dailyRewards.php"><img src="./img/gift.jpg" width="16px" height="16px"><span> Daily Rewards</span></a> -->
		
		<a href="Logout.php" style="float: right">Log out</a>
		<a id="sc" ng-click="appearShoppingCart()"><img src="./img/shopping_cart.png" width="25" height="25" /><span id="countItem">{{listCount}}</span></a>
		
		
		
	</ul>
	</div>
</nav>

<header>
<table width="100%" class="moneyBar">

	<tr>
		<td width="80%">
			<input style="border-radius: 6px; font-size: 16px; outline: none; border: 1px solid gray; margin: 0px;" type="text" name="tf_search" ng-model="search" placeholder="Search for characters">
		</td>
		<td align="right">
		    <div>
		    <img src="./img/money.png" width=20% height=20%>
			<span style="color: black; font-size: 25px;"><?= ": ".$_SESSION['user_money']; ?> pix</span>
			</div>
		</td>
	</tr>
</table>		

</header>


<div ng-repeat = "p in products | filter: search" class="product-form">
 	<div class="product-content">
 		<img ng-src="img/{{p.Image}}" class = img-resonsive width=96px height=96px/>
 		<input type="hidden" name ="image" value="{{p.Image}}">
 		<h4 class="text-info" style="color:teal">{{p.Name}}</h4>
 		<h5>Element: {{p.Element}}</h5>
 		<h5>{{p.Price}}</h5>
 		<input type="number" value="1" id="{{'pokemonQuantity'+$index}}"/>
 		<input type="hidden" name="name" value="{{p.Name}}"/>
 		<input type="hidden" name="price" value="{{p.Price}}"/>
 		<button ng-click="addToCart(p,'pokemonQuantity'+$index)" style="margin-bottom: 5%;">Add to Cart</button>
 	</div>
</div>


<aside>
	
<div>
<table class="table" ng-init="fetchCart()" id="shopping_cart">
	<tr>
		<td colspan="4"></td>
		<td style="float: right; cursor: pointer;" ng-click="appearShoppingCart()">Exit</td>
	</tr>
	<tr align="center" style="background-color: rgba(155,155,200,0.8); font-size: 18px;">
		<th colspan="5" width="100%">Shopping Cart</th>
	</tr>
	<tr>
		<th width="15%">Name</th>
		<th width="7.5%">Price</th>
		<th width="7.5%">Quantity</th>
		<th width="10%">Total</th>
		<th width="10%">Action</th>
	</tr>
	<tr ng-repeat="cart in carts" align="center">
		<td><img src="img/{{cart.product_image}}" width=64px height=64px><br>{{cart.product_name}}</td>
		<td>{{cart.product_price}}</td>
		<td><input type="number" ng-value="{{cart.product_quantity}}" ng-model="quantity[$index]" ng-change="changeQtt(quantity[$index], cart.product_id)"></td>
		<td>{{cart.product_price * cart.product_quantity}}</td>
		<td><button ng-click="removeProduct(cart.product_id)" name="remove_product" class="btn-danger" >Remove</button></td>
	</tr>
	<tr align="center">
		<td><button ng-click="checkout(total)" class="btn-checkout" >Checkout</button></td>
		<td></td>
		<td></td>
		<td>{{total}}</td>
		<td><button ng-click="clear()" class="btn-clear" >Clear</button></td>
	</tr>
</div>
</aside>
<!-- 
<div class="footer">
Copyright &copy: 2020 Wiroj Tamboonlertchai.
</div> -->
<script type="text/javascript">
	var app = angular.module("shoppingCart", []);
	app.controller("myCtrl", function($scope, $http){
		$scope.loadProduct = function(){
			$http.get("./api/fetch.php").then(function(response){
				$scope.products = response.data.pokemons;
			});
		};

		$scope.carts = [];

		$scope.fetchCart = function(){
			$http.get("./api/fetch_cart.php").then(function(response){

				$scope.carts = response.data;

				$http.get("./api/total_price.php").then(function(response){
					$scope.total = response.data;
				});
				$scope.countItem();
			});
		};


		$scope.addToCart = function(product, quantity){
			var qttVal = document.getElementById(quantity).value;
			product.Quantity = qttVal;
			$http({
				method: "POST",
				url: "./api/add_item.php",
				data: product
			}).then(function(response){
				$scope.fetchCart();
				$scope.countItem();
			});
		};

		$scope.removeProduct = function(id){
			$http({
				method: "POST",
				url: "./api/remove_item.php",
				data: id
			}).then(function(response){
				$scope.fetchCart();
				$scope.countItem();
			});
		}

		$scope.checkout = function(total){
			if(total == 0) return;
			$http({
				method: "POST",
				url: "./api/checkout.php",
				data: total
			}).then(function(response){
				if(response.data == "accept"){
                    $scope.fetchCart();
                    window.location.href="home.php";
				}
				else if(response.data == "reject"){
					alert("Don't have enough money");
					$scope.fetchCart();
					$scope.countItem();
				}
				
			});
		};

		$scope.clear = function() {
			$http.get("./api/clear.php").then(function(response) {
				$scope.fetchCart();
				$scope.countItem();
			});
		};

		$scope.appearShoppingCart = function() {
			var sc = document.getElementById("shopping_cart");
			if(sc.style.display == "block")
				sc.style.display = "none";
			else
				sc.style.display = "block";
		};

		$scope.changeQtt = function(quantity, id) {
			if(quantity <= 0){
				alert("Only positive numbers are allow to be set.");
			}
			var data = {"id":id, "quantity":quantity};
			$http({
				method: "POST",
				url: "./api/change_quantity.php",
				data: data
			}).then(function(response) {
				$scope.fetchCart();
			});
		};

		$scope.countItem = function(){
			$http.get("./api/count_item.php").then(function(response){
				$scope.listCount = response.data;
				if($scope.listCount > 0) {
					var sc = document.getElementById("sc");
					sc.style.border = "3px solid gray";
					$scope.listCount = "("+$scope.listCount+")";
				}
				else {
					var sc = document.getElementById("sc");
					sc.style.border = "1px solid black";
					$scope.listCount = "";
				}
			});
		};

	});
</script> 
</body>
</html>
