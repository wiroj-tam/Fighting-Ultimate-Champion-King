<?php
	session_start();
	include("config.php");
?>
<html>
<head>
	<meta name="viewport" content="initial-scale=1, maximum-scale=1" />
	<script src="js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		
		
		$("#login").click(function(){
			
			var username = $("#username").val();
			var password = $("#password").val();
			// username == "" ? $(".error-msg[title='username']").text("*Please fill out username.*") : $(".error-msg[title='username]'").text("");
			// password == "" ? $(".error-msg[title='password']").text("*Please fill out password.*") : $(".error-msg[title='password']").text("");

			if(username !== "" && password !== ""){
        		var action = $("#login").attr("id");
        		var url = "./api/user-service.php";
        		var json = 
        		{
        			"action": action,
        			"username": username,
        			"password": password
        		};

        		$.ajax({
				type: "POST",
				url: url,
				data: json,
				success: function(data) {
					if (data.check === "success") {
       					window.location.href = 'home.php';
       				}
       				else {
       					$(".error-msg[title='warning']").text("Invalid username or password.").show().fadeOut(750);
       				}				
       			}
				});

       			// $.post(url, json, function(data, status){
       			// 	alert("cat");
       				
       			// 	alert(data.check);
       			// });
			}
  		});

  		$(".center-form input").keyup(function(e){
			if(e.keyCode == 13){
				$("#login").click();
			}
		});
		

  		$("#registerLink").click(function(){
  			window.location.href = 'register.php';
  		});

  		$("#click").click(function(){
  			$("#loginForm").show();
  			$(".blink").hide();
  			$("#click").hide();
  		});

	});
	</script>
	<link rel = "stylesheet" href="s.css">
	
	<title>Login</title>
	<style type="text/css">
	:root {
		--w: 60%;
		--h: 40%;
		--wHf: -30%;
		--hHf: -20%;
	}
	body{
		background-image: url("img/bgregis.jpg");
		background-size: cover;
		max-width: 100%;
		max-height: auto;
		background-position: center;
		background-repeat: no-repeat;
		font-family: Monaco;
	}
	.center-form{
		position: relative;
		border-radius: 5px;
		position: absolute;
		top: 31.25%;
		left: 50%;
		width: 100%;
		height: 25%;
		margin-left: -50%;
		margin-top: -12.5%;
		text-align: center;
		box-sizing: border-box;
		padding: 5px;
	}
	.center-form > input{
		position: relative;
		background-color: rgba(255,255,255,.75);
		border-radius: 25px;
		max-width: 100%;
		outline: none;
		text-align: center;
		font-size: 18px;
		margin-left: 0;
		border: 1px solid gray;
		margin-bottom: 1.5%;
		padding: 8px 8px 8px 8px;
	}
	

	.center-form > input::-webkit-input-placeholder  {
  		-webkit-transition: opacity 0.75s linear; 
  		color: #6b7a85;
	}

	.center-form > input:focus::-webkit-input-placeholder{
  		opacity: 0.4;
  		color: #317db5;
	}
	#login{
		outline: none;
		font-size: 18px;
		width: 225px;
		margin-top: -15px;
		text-align: center;
		display: inline-block;
		cursor: pointer;
		padding: 8px;
		border: 0;
		border-radius: 10px;
		color: white;
		background-color: #E3242B;
	}
	#login:hover, #registerLink:hover, #forgotPassword:hover{
		opacity: 0.85;
		cursor: pointer;
	}
	#registerLink{
		outline: none;
		width: 225px;
		margin-top: 16px;
		border-radius: 5px;
		background-color: #5087b5;
		border: 0;
		padding: 8px;	
		font-size: 18px;
		text-decoration: none;
		color: white;
	}
	#forgotPassword{
		outline: none;
		width: 225px;
		border-radius: 5px;
		padding: 7px;
		border: 0;
		margin-right: 0px;
		font-size: 18px;
		color: black;
		text-decoration: none;
	}
	.error-msg{
		position: absolute;
		color:red; 
		font-size: 18px;
		display: inline-block;
	}
	#loginForm{
		display:none;
	}
	.blink{
		position: absolute;
		top:37.5%;
		left:50%;
		text-align: center;
		width: 100%;
		height: auto;
		margin-left: -50%;
		margin-top: -12.5%; 
		font-size: 45px;
		font-variant: small-caps;
	}
	.pressAny{
		font-size: 48px;
		margin-top: 2.5%;
		animation: blink 1s linear infinite;
	}

	@keyframes blink{
		0%{opacity: 0;}
		100%{opacity: 1;}
	}

	</style>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<div id="click" style="width: 100%; height: 100%; position: absolute; z-index: 2;"></div>
	<div class="blink">
	<img src="img/logoLogin.png" width=25% height=auto><br>
	<!-- <img src="img/startlogo2.png" width=25% height=auto> -->
	<div class="pressAny">CLICK TO START</div>
	</div>
	<div id="loginForm" class="center-form">
	<img src="img/logoLogin.png" width=10% style="margin: -8px;">
	<h1 style="color: black;">Fighting Ultimate Champion King</h1>
		<input type="text" name="username" placeholder="Username" id="username"><span class="error-msg" title="username"></span><br>
		<input type="password" name="password" placeholder="Password" id="password"><span class="error-msg" title="password"></span><br><br>
		<section>
			<button type="button" id="login">Login</button><br>
			<button id="registerLink" >Register Here</button><br><br>
			<span style="margin-left: -140px; font-size: 24px;" class="error-msg" title="warning"></span>
		</section>
	</div>
</body>
</html>