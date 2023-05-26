<?php
	include('./config.php');
	session_start();


?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="s.css">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>user</title>
	<style type="text/css">
		body{
			margin: 0px;
			background-image: url("img/bggame.png");
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
		$scope.myTest = function() {
			check = confirm("Are you sure to delete this plot?")
        	if(check){
            alert("true");
        	}else{
            alert("false");

        	}
			
		}
	});

		
		
	
</script>	
</head>


<body ng-app="App" ng-controller="Ctrl">
	<a confirmed-click="myTest()" >Un-Favourite</a>
<button ng-click="myTest()">CLICK FOR TEST</button>
</body>
</html>