<?php
session_start();
if($_SESSION['user_status'] != 2){
	echo "<script>window.location.href='../login.php'</script>";
}  
include('../config.php');
$id = file_get_contents("php://input");
if(isset($id)):
$sql = "SELECT Status FROM users WHERE UserID = '$id' AND Status > 0";
$res = mysqli_query($con, $sql)or die("[ERROR]: $sql");
$row = mysqli_fetch_array($res);
$count = mysqli_num_rows($res);

$sql = "UPDATE users SET Status = (Status*-1) WHERE UserID = '$id'";
mysqli_query($con, $sql) or die("[ERROR]: $sql");

endif;
?>