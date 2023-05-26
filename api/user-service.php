<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include("../config.php");

if(isset($_POST['action'])){
  switch ($_POST['action']){
    case 'login':
      login();
      break;
    case 'register':
      register();
      break;
  }
}

function login(){
    global $con;
    $username = $_POST['username'];
		$password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE Username = '$username' AND Password = '$password'";
    $result = mysqli_query($con, $sql) or die("[ERROR]: $sql");
    $rows = mysqli_fetch_array($result);

    if(mysqli_num_rows($result) > 0) {
      $sql = "SELECT * FROM users u 
            INNER JOIN moneys m
            ON u.UserID = m.UserID
            AND u.Username = '$username'
            ORDER BY m.MoneyID DESC LIMIT 1";
      $result = mysqli_query($con, $sql) or die("[ERROR]: $sql");
      $rows = mysqli_fetch_array($result);

      $_SESSION['user_id'] = $rows['UserID'];
      $_SESSION['user_fname'] = $rows['FName'];
      $_SESSION['user_lname'] = $rows['LName'];
      $_SESSION['user_phone'] = $rows['Phone'];
      $_SESSION['user_address'] = $rows['Address'];
      $_SESSION['user_email'] = $rows['Email'];
      $_SESSION['user_dob'] = $rows['DOB'];
      $_SESSION['user_gender'] = $rows['Gender'];
      $_SESSION['user_username'] = $rows['Username'];
      $_SESSION['user_password'] = $rows['Password'];
      $_SESSION['user_status'] = $rows['Status'];
      $_SESSION['user_money'] = $rows['Amount'];

      if($rows['Status'] >= 1){
        echo "{\"check\":\"success\"}";
      }

    }
    else {
      echo "{\"check\":\"\"}";
    }
  exit();
  }
function register(){
  global $con;
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $email = $_POST['email'];
  $dob = $_POST['dob'];
  $gender = $_POST['gender'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $rePassword = $_POST['rePassword'];

  $sql = "SELECT * FROM users WHERE Username = '$username'";
  $result = mysqli_query($con,$sql) or die ("[ERROR] $sql");
  $rows_cnt = mysqli_num_rows($result);
  if($rows_cnt > 0){
    echo "{\"check\":\"exist\"}";
    exit;
  }
  else{
    /*register time*/
    $hour = date("h");
    $my_date = date("Y-M-D-d $hour:i:s");
    // /*-------------*/
    $sql = "INSERT INTO users (UserID,FName,LName,Phone,Address,Email,DOB,Gender,Username,Password,Status,Date) VALUES ('','$fname', '$lname', '$phone', '$address', '$email', '$dob', '$gender', '$username', '$password', 1, '$my_date')";
    $result = mysqli_query($con, $sql) or die ("[ERROR] $sql");


    $sql = "SELECT * FROM users WHERE Username = '$username'";
    $result = mysqli_query($con, $sql) or die ("[ERROR] $sql");
    $rows = mysqli_fetch_array($result);
    $userid = $rows['UserID'];
    $regis_msg = "New Registration.";
    $sql = "INSERT INTO moneys VALUES('',250,250,'$regis_msg', NULL, '$userid')";
    $result = mysqli_query($con, $sql) or die ("[ERROR] $sql");

    //insert score for battle mode.
    $insert_score = "INSERT INTO score VALUES ('$userid', 0)";
    mysqli_query($con, $insert_score);

    echo "{\"check\":\"success\"}";
  }

  exit;
}
?>