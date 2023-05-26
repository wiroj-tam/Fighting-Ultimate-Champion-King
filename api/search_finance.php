<?php
include('../config.php');
session_start();
if(!isset($_SESSION['user_id'])){
	echo "<script>window.location.href='../login.php'</script>";
} 
$data = file_get_contents("php://input");
$userid = $_SESSION['user_id'];
$sql = "SELECT * FROM moneys WHERE 
MoneyID LIKE '%$data%' OR
ImpExp LIKE '%$data%' OR
Amount LIKE '%$data%' OR
Detail LIKE '%$data%' OR
Time LIKE '%$data%'AND UserID = '$userid'
";
$res = mysqli_query($con, $sql) or die("[ERROR]: $sql");
if($res):
	if(mysqli_num_rows($res) > 0):
		while($rows = mysqli_fetch_assoc($res)):
			$outp[] = $rows;
		endwhile;
		echo json_encode($outp);
	endif;
endif;
?>