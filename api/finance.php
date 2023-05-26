<?php
session_start();
if(!isset($_SESSION['user_id'])){
	echo "<script>window.location.href='../login.php'</script>";
}
$userid = $_SESSION['user_id'];
include('../config.php');
$sql = "SELECT * FROM moneys WHERE UserID = '$userid' ORDER BY MoneyID DESC";
$res = mysqli_query($con, $sql);
if($res){
	if(mysqli_num_rows($res) > 0){
		while ($rows = mysqli_fetch_array($res)) {
			$outp[] = $rows;
		}
	echo json_encode($outp);
	}
}



?>