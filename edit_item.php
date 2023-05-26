<?php
session_start();

if($_SESSION['user_status'] != 2){
	echo "<script>window.location.href='login.php'</script>";
}
include('./config.php');
if(isset($_GET['id'])){
	$id = $_GET['id'];
}
else{
	$id = $_POST['pid'];
}
$sql = "SELECT * FROM pokemons p
		INNER JOIN parameters pmt ON p.PokemonID = pmt.PokemonID
		INNER JOIN gains g ON p.PokemonID = g.PokemonID
		WHERE p.PokemonID = '$id'";
$res = mysqli_query($con, $sql) or die("$sql");
$rows = mysqli_fetch_array($res);
?>

<?php
if(isset($_POST['editBtn'])){
	$pid = $_POST['pid'];
	$code = $_POST['code'];
	$name = $_POST['name'];
	$price = $_POST['price'];
	$detail = $_POST['detail'];
	$image = $_POST['image'];
	$ev = $_POST['ev'];
	$ev_lvl = $_POST['ev_lvl'];
	$ev_id = $_POST['ev_id'];
	$element = $_POST['element'];

    $atkp = $_POST['atkp'];
    $defp = $_POST['defp'];
    $spdp = $_POST['spdp'];
    $spatkp = $_POST['spatkp'];
    $spdefp = $_POST['spdefp'];
    $hpp = $_POST['hpp'];

    $atkg = $_POST['atkg'];
    $defg = $_POST['defg'];
    $spdg = $_POST['spdg'];
    $spatkg = $_POST['spatkg'];
    $spdefg = $_POST['spdefg'];
    $hpg = $_POST['hpg'];



	$sql1 = "UPDATE pokemons p, parameters pmt, gains g
	SET p.Code = '$code',
	p.Name = '$name',
	p.Price = '$price',
	p.Detail = '$detail',
	p.Image = '$image',
	p.EV = '$ev',
	p.EV_LVL = '$ev_lvl',
	p.EV_ID = '$ev_id',
	p.Element = '$element',
	pmt.AtkP = '$atkp',
	pmt.DefP = '$defp',
	pmt.SpdP = '$spdp',
	pmt.SpAtkP = '$spatkp',
	pmt.SpDefP = '$spdefp',
	pmt.HPP = '$hpp',
	g.AtkG = '$atkg',
	g.DefG = '$defg',
	g.SpdG = '$spdg',
	g.SpAtkG = '$spatkg',
	g.SpDefG = '$spdefg',
	g.HPG = '$hpg'
	WHERE p.PokemonID = pmt.PokemonID
	AND   p.PokemonID = g.PokemonID
	AND   pmt.PokemonID = g.PokemonID
	AND   p.PokemonID = '$id'";
	mysqli_query($con, $sql1)or die("$sql1");

	echo "<script>";
	echo "alert('Pokemon updated successfully.');";
	echo "window.location.href='admin.php';";
	echo "</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
			margin-bottom: 35px;
		}
	</style>
	<title>Edit a character</title>
</head>
<body>
<button onclick="window.location.href='admin.php'">Back</button>
<h1>Edit character</h1>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="editForm">
		<h2>Common Detail</h2>
		<h4>ID: <?= $rows['PokemonID']; ?></h4>
		<input type="hidden" name="pid" value="<?= $rows['PokemonID']; ?>"> 
		Code: <input type="text" value="<?= $rows['Code'];?>" name="code"><br>
		Name: <input type="text" value="<?= $rows['Name'];?>" name="name"><br>
		Price: <input type="number" value="<?= $rows['Price']; ?>" name="price" ><br>
		Detail:<br><textarea cols="36" rows="6" name="detail"><?= $rows['Detail'];?></textarea>><br>
		<img src="./img/<?= $rows['Image']; ?>" class = img-resonsive width=128px height=128px/ id="img"><br>
		<input type="file" id="imgs" name="imgs" accept="image/*" onchange="readURL(this)" name ="imgs" value="<?= $rows['Image'];?>"><br><?= $rows['Image'];?>
		<input type="hidden" name="image" value="<?= $rows['Image'];?>" id="image">
		EV: <input type="text" value="<?= $rows['EV']; ?>" name="ev"><br>
		EV_LVL: <input type="text" value="<?= $rows['EV_LVL']; ?>" name="ev_lvl"><br>
		EV_ID: <input type="text" value="<?= $rows['EV_ID']; ?>" name="ev_id"><br>
		Element: <input type="text" value="<?= $rows['Element']; ?>" name="element"><br>
 		<br>
 		<h2>Parameters</h2>
 		 Attack: <input type="number" name="atkp" value="<?= $rows['AtkP'] ;?>">(แก้ไขค่าพลังโจมตีเริ่มต้นของตัวละคร)<br>
         Defense: <input type="number" name="defp" value="<?= $rows['DefP'] ;?>">(แก้ไขค่าพลังป้องกันเริ่มต้นของตัวละคร)<br>
         Speed: <input type="number" name="spdp" value="<?= $rows['SpdP'] ;?>">(แก้ไขค่าพลังความเร็วเริ่มต้นของตัวละคร)<br>
         Special Attack: <input type="number" name="spatkp" value="<?= $rows['SpAtkP'] ;?>">(แก้ไขค่าพลังโจมตีพิเศษเริ่มต้นของตัวละคร)<br>
         Special Defense: <input type="number" name="spdefp" value="<?= $rows['SpDefP'] ;?>">(แก้ไขค่าพลังป้องกันพิเศษเริ่มต้นของตัวละคร)<br>
         Hit Point: <input type="number" name="hpp" value="<?= $rows['HPP'] ;?>">(แก้ไขค่าพลังชีวิตเริ่มต้นของตัวละคร)
         <h2>Parameters Gain</h2>
         Attack Gain: <input type="number" name="atkg" value="<?= $rows['AtkG'];?>">(กรอกค่าพลังโจมตีเพิ่มขึ้นของตัวละคร)<br>
         Defense Gain: <input type="number" name="defg" value="<?= $rows['DefG'];?>">(กรอกค่าพลังป้องกันเพิ่มขึ้นของตัวละคร)<br>
         Speed Gain: <input type="number" name="spdg" value="<?= $rows['SpdG'];?>">(กรอกค่าพลังความเร็วเพิ่มขึ้นของตัวละคร)<br>
         Special Attack Gain: <input type="number" name="spatkg" value="<?= $rows['SpAtkG'];?>">(กรอกค่าพลังโจมตีพิเศษเพิ่มขึ้นของตัวละคร)<br>
         Special Defense Gain: <input type="number" name="spdefg" value="<?= $rows['SpDefG'];?>">(กรอกค่าพลังป้องกันพิเศษเพิ่มขึ้นของตัวละคร)<br>
         Hit Point Gain: <input type="number" name="hpg" value="<?= $rows['HPG'];?>">(กรอกค่าพลังชีวิตเพิ่มขึ้นของตัวละคร)<br>
         <br>
 		<button type="submit" name="editBtn" style="margin-bottom: 35px; font-size: 22px; color: white; background-color: green;">Edit</button>
 	</form>
</body>
</html>