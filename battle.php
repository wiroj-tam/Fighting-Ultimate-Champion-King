<?php
	include("./config.php");
	session_start();
	if(!isset($_SESSION['user_id'])){
   		echo "<script>window.location.href='login.php'</script>";
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Battle</title>
	<style>
		#battle	{
		position: absolute;
		top: 50%;
		left: 50%;
		margin-left: -640px;
		margin-top: -256px;
	}
	#console{
		text-align: center;
		position: absolute;
		top: 45%;
		left: 50%;
		width: 100%;
		height: 10%;
		margin-left: -50%;
		margin-top: 20%;
		font-size: 25px;
		font-variant: small-caps;
		background-color: white;
	}

	#submit_exp{
		font-size: 25px;
		border-radius: 25px;
		outline: none;
		border: none;
		position: absolute;
		left: 50%;
		width: 320px;
		height: 80px;
		margin-left: -160px;
		margin-top: -40px;
		top: 20%;
		background-color: #75c73a;
		color: white;
	}
	#submit_exp:hover{
		opacity: 0.8;
		cursor: pointer;
	}
		

	</style>
</head>
<link rel="stylesheet" href="s.css">
	
<body>
      <marquee behavior=scroll direction="left" scrollamount="8" style="background-color: #ebfaec;">This is a Battle Mode, You are going to fight with other players if you win, you just win. if you lose, you just lose. no money drop and no exp gain. Get out COVID-19. The weather changes frequently, Don't forget to cover the cloth. by Wiroj Tamboonlertchai</marquee>
	<?php
		if(isset($_POST['submit_exp'])){

			if($_POST['res'] == "won") {

				$sql = "SELECT Score FROM score WHERE UserID = ".$_SESSION['user_id'];
				$res = mysqli_query($con, $sql);
				$row = mysqli_fetch_array($res);

				$currentScore = $row['Score'] + 25;

				$update = "UPDATE score SET Score = '$currentScore' WHERE UserID = ".$_SESSION['user_id'];
				mysqli_query($con, $update);
			}
			else {
				$sql = "SELECT Score FROM score WHERE UserID = ".$_SESSION['user_id'];
				$res = mysqli_query($con, $sql);
				$row = mysqli_fetch_array($res);

				$currentScore = $row['Score'] + -1;

				$update = "UPDATE score SET Score = '$currentScore' WHERE UserID = ".$_SESSION['user_id'];
				mysqli_query($con, $update);
			}

			

			echo '<script type="text/javascript">';
            echo 'window.location.href="chooseGameMode.php";';
            echo '</script>';
		}
		
	 ?>
	
	<table id ="data">
	</table>
	<progress id="p_hp" value="100" max="100"></progress>
	<progress id="e_hp" value="100" max="100" style="float:right;"></progress>
	<canvas id="battle" width="1280" height="512"></canvas> <!-- Game on here -->

	<script src="battle.js"></script>
	<form method="post" action="battle.php">
	<input type="hidden" value="" id="res" name = "res">
	<input type ="submit" id ="submit_exp" style="display:none" value="Accept" name="submit_exp">
	</form>
	<article>
<table style="z-index: 2;" id="console" width="100%" height="100%" border="1" style="background-color: #e6e070;" align="center">
		<tr><td>
	<pre id = "messages" ></pre>
		</td></tr>
	</table>




</article>
</body>

</html>