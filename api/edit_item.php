<?php
session_start();

if($_SESSION['user_status'] != 2){
	echo "<script>window.location.href='../login.php'</script>";
}
include('../config.php');
if(isset($_GET['id'])){
	$id = $_GET['id'];
}
$sql = "SELECT * FROM pokemons WHERE PokemonID = '$id'";
$res = mysqli_query($con, $sql) or die("$sql");
$rows = mysqli_fetch_array($res);
?>

<?php
if(isset($_POST['editBtn'])){
	$pid = $_POST['pid'];
	$name = $_POST['name'];
	$price = $_POST['price'];
	$detail = $_POST['detail'];
	$image = $_POST['image'];
	$ev = $_POST['ev'];
	$element = $_POST['element'];	

	$sql1 = "UPDATE pokemons 
	SET Name = '$name',
	Price = '$price',
	Detail = '$detail',
	Image = '$image',
	EV = '$ev',
	Element = '$element'
	WHERE PokemonID = '$pid'";
	$res1 = mysqli_query($con, $sql1)or die("$sql1");

	echo "<script>";
	echo "window.location.href='admin.php'";
	echo "</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
	<script src="./js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript">
	
	function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);

            };

            reader.readAsDataURL(input.files[0]);
            var imgs = $("#imgs").val();
            var imgName = imgs.substr(12);

            $("#image").attr('value', imgName);
            alert(imgName);
        }
    }
	
	</script>
	<style type="text/css">
		.editForm{
			text-align: center;
			position: absolute;
			top: 50%;
			left: 50%;
			width: 300px;
			height: 400px;
			margin-left: -150px;
			margin-top: -200px;
		}
	</style>
	<title>Edit_Pokemon</title>
</head>
<body>
<button onclick="window.location.href='admin.php'">Back</button>	
<h1>Edit Pokemon</h1>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<h4>PokemonID: <?= $rows['PokemonID']; ?></h4>
		<input type="hidden" name="pid" value="<?= $rows['PokemonID']; ?>"> 
		<h4>Code: <?= $rows['Code']; ?></h4>
		Name: <input type="text" value="<?= $rows['Name'];?>" name="name"><br>
		Price: <input type="text" value="<?= $rows['Price']; ?>" name="price" ><br>
		Detail: <input type="text" value="<?= $rows['Detail']; ?>" name="detail" ><br>
		<img src="./img/<?= $rows['Image']; ?>" class = img-resonsive width=128px height=128px/ id="img"><br>
		<input type="file" id="imgs" name="imgs" accept="image/*" onchange="readURL(this)" name ="imgs" value="<?= $rows['Image'];?>"><br><?= $rows['Image'];?>
		<input type="hidden" name="image" value="<?= $rows['Image'];?>" id="image">
		EV: <input type="text" value="<?= $rows['EV']; ?>" name="ev"><br>
		Element: <input type="text" value="<?= $rows['Element']; ?>" name="element"><br>
 		<br>
 		<button type="submit" name="editBtn">Edit</button>
 		
 	</form>
</body>
</html>