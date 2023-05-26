<?php
session_start();
if($_SESSION['user_status'] != 2){
   echo "<script>window.location.href='login.php'</script>";
}
   include("config.php");
      if(isset($_POST["addBtn"])){

         $code = $_POST['code'];
         $name = $_POST['name'];
         $price = $_POST['price'];
         $detail = $_POST['detail'];
         $imgs = $_POST['imgs'];
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

         $sql = "INSERT INTO pokemons VALUES(NULL, '$code', '$name', '$price', '$detail', '$imgs', '$ev', '$ev_lvl', '$ev_id', '$element')";
         mysqli_query($con, $sql)or die("[ERROR]: $sql");

         $slt = "SELECT PokemonID FROM pokemons ORDER BY PokemonID DESC LIMIT 1";
         $res = mysqli_query($con, $slt)or die("[ERROR]: $slt");
         $row = mysqli_fetch_array($res);

         $pid = $row['PokemonID'];

         echo $pid;
         $insp = "INSERT INTO parameters VALUES('$pid', 1, '$atkp', '$defp', '$spdp', '$spatkp', '$spdefp', '$hpp')";
         mysqli_query($con, $insp)or die("[ERROR]: $insp");

         $insg = "INSERT INTO gains VALUES('$pid', 1, '$atkg', '$defg', '$spdg', '$spatkg', '$spdefg', '$hpg')";
         mysqli_query($con, $insg)or die("[ERROR]: $insg");

         echo "<script>alert('New Pokemon added successfully !');";
         echo "window.location.href='admin.php'";
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
            alert("You browse file name: "+imgName);
        }
    }
   </script>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="s.css">
	<title>Add a character</title>
</head>
		
<body>
<button onclick="window.location.href='admin.php'">Back</button>
<h1>Add a new character</h1>             
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
         <h2>Common Detail</h2>
         Code: <input type="text" name="code" required>(กรอกรหัสประจำตัวตัวละคร)<br>
         Name: <input type="text" name="name" required>(กรอกชื่อตัวละคร)<br>
         Price: <input type="number" name="price"  required>(กรอกราคาขายตัวละคร)<br>
         Detail: <input type="text" name="detail"  required>(กรอกรายละเอียดของตัวละคร)<br>
         <img class = img-resonsive width=128px height=128px id="img"><br>
         <input type="file" id="imgs" name="imgs" accept="image/*" onchange="readURL(this)" name ="imgs" required>(เลือกรูปภาพสำหรับตัวละคร)<br>
         EV: <input type="number" name="ev" required>(ระดับวิวัฒนาการของตัวละคร ** หมายเลข 0 หมายถึง ไม่มีร่างวิวัฒนาการ, หมายเลข 1 หมายถึง ร่างวิวัฒนาการที่ 1, หมายเลข 2 หมายถึงร่างวิวัฒนาการที่ 2 เป็นต้น **)<br>
         EV_LVL: <input type="number" name="ev_lvl">(กรอกระดับเลเวลสำหรับการวิวัฒนาการ **ถ้าไม่มีร่างวิวัฒนาการ ให้กรอกเลข 0**)<br>
         EV_ID: <input type="number" name="ev_id">(กรอก ID ของร่างวิวัฒนาการ สามารถดู ID ได้ที่หน้า Admin)<br>
         Element: <input type="text" name="element" required>(กรอกธาตุประจำตัวตัวละคร สามารถกรอกได้มากกว่า 1 ธาตุ กรณีที่ตัวละครมีธาตุมากกว่า 1 ธาตุ ให้พิมพ์ธาตุแรกแล้ว เว้นวรรค 1 เคาะ จากนั้นพิมพ์ธาตุถัดไป แล้วเว้นวรรค 1 เคาะ แบบนี้ไปเรื่อย ๆ ตัวอย่างของกรณีที่ตัวละครมี 3 ธาตุ เช่น Electric Flying Grass ให้ใช้รูปแบบการกรอกนี้)<br>
         <h2>Parameters</h2>
         Attack: <input type="number" name="atkp" required>(กรอกค่าพลังโจมตีเริ่มต้นของตัวละคร)<br>
         Defense: <input type="number" name="defp" required>(กรอกค่าพลังป้องกันเริ่มต้นของตัวละคร)<br>
         Speed: <input type="number" name="spdp" required>(กรอกค่าพลังความเร็วเริ่มต้นของตัวละคร)<br>
         Special Attack: <input type="number" name="spatkp" required>(กรอกค่าพลังโจมตีพิเศษเริ่มต้นของตัวละคร)<br>
         Special Defense: <input type="number" name="spdefp" required>(กรอกค่าพลังป้องกันพิเศษเริ่มต้นของตัวละคร)<br>
         Hit Point: <input type="number" name="hpp" required>(กรอกค่าพลังชีวิตเริ่มต้นของตัวละคร)
         <h2>Parameters Gain</h2>
         Attack Gain: <input type="number" name="atkg" required>(กรอกค่าพลังโจมตีเพิ่มขึ้นของตัวละคร)<br>
         Defense Gain: <input type="number" name="defg" required>(กรอกค่าพลังป้องกันเพิ่มขึ้นของตัวละคร)<br>
         Speed Gain: <input type="number" name="spdg" required>(กรอกค่าพลังความเร็วเพิ่มขึ้นของตัวละคร)<br>
         Special Attack Gain: <input type="number" name="spatkg" required>(กรอกค่าพลังโจมตีพิเศษเพิ่มขึ้นของตัวละคร)<br>
         Special Defense Gain: <input type="number" name="spdefg" required>(กรอกค่าพลังป้องกันพิเศษเพิ่มขึ้นของตัวละคร)<br>
         Hit Point Gain: <input type="number" name="hpg" required>(กรอกค่าพลังชีวิตเพิ่มขึ้นของตัวละคร)<br>
         <br>
         <button type="submit" name="addBtn" style="margin-bottom: 35px; font-size: 22px; color: white; background-color: red;">Add a new character</button>
      </form>



</body>

</html>