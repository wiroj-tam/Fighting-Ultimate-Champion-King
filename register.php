<?php
	include("config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<link rel="stylesheet" href="s.css">
	<script src="js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#registerBtn").click(function(){
				var fname = $("#fname").val();
				var lname = $("#lname").val();
				var phone = $("#phone").val();
				var address = $("#address").val();
				var email = $("#email").val();
				var date = 
				{
					"day":$("#myDd").val(),
					"month":$("#myMm").val(),
					"year":$("#myYy").val()
				};
				var dob = date.day + "/" + date.month + "/" + date.year;
				var gender = $("input[name=gender]:checked").val();
				var username = $("#username").val();
				var password = $("#password").val();
				var rePassword = $("#retype-password").val();

				

				function validateForm(){
				// /*Not mandatory*/
				// if(fname == "") return [false, "Please fill first name."];
				// if(lname == "") return [false, "Please fill last name."];
				// else if($("#phone").val() == "") return [false, "Please fill phone number."];
				// else if($("#address").val() == "") return [false, "Please fill address."];
				// */
				if($("#email") !== null ){
					var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
					if( regex.test(email) == false ) return [false, "Please fill email correctly."];
				}
				// if(date.day == 0 || date.month == 0 || date.year == 0) return [false, "Please select birthdate."];

				if(username.length < 4) return [false, "Username must be at least 4 characters."];
				
				if(password.length < 8) return [false, "Password must be at least 8 characters."];

				if(rePassword == "" || rePassword != password) return [false, "Please fill matching password."];

				return [true, "Register Success."];
				}

				//validateForm()[0] = boolean
				//validateForm()[1] = string
				

				if(validateForm()[0]){
					var action = $("#registerBtn").val();

					var url = "./api/user-service.php";
					var json = 
					{
						"action": action,
						"fname": fname,
						"lname": lname,
						"phone": phone,
						"address": address,
						"email": email,
						"dob": dob,
						"gender": gender,
						"username": username,
						"password": password,
						"rePassword": rePassword
					};
					$.post(url, json, function(data, status){
						if(data.check == "exist"){
							$("#valText").text("Username is already exist.").hide().fadeIn(500);
						}
						else if(data.check == "success"){
							$("#valText").text("Registration Successful !").hide().fadeIn(500);
							setTimeout(function(){ window.location = "register.php"; }, 3000);
							window.location.href = "home.php";
						}
					});
				}
				else{
					$("#valText").text(validateForm()[1]).hide().fadeIn(500);
				}

				
				
			});
		});
	</script>
	<style type="text/css">
	:root {
		--w: 450px;
		--h: 600px;
		--wHf: -225px;
		--hHf: -300px;
	}
	#container{
		font-size: 18px;
		/*border: 5px solid black;*/
		background-color: rgba(255,255,255,0.6);
		border-radius: 5px;		
		position: absolute;
		width: var(--w);
		height: 95%;
		left: 50%;
		top: 45%;
		margin-left: var(--wHf);
		margin-top: var(--hHf);
		text-align: center;
		box-sizing: border-box;
		padding: 25px 0px 25px 0px;
		font-variant: small-caps;

	}
	#container > * {
		margin: 8px;

	}
	button:hover{
		opacity: 0.85;
		cursor: pointer;
	}

	#registerBtn{
		font-size: 20px;
		background-color: rgb(80,80,170);
		color: white;
		outline: none;
		border: none;
		border-radius: 15px;
		width: 200px;
		height: 40px;
	}
	.backBtn {
		font-size: 16px;
		border-radius: 15px;
		border: none;
		width: 100px;
		outline: none;
	}
	body{
		background: url("img/bgregis.jpg");
		height: 775px;
		background-size: cover;
		background-repeat: no-repeat;
		font-family: Monaco;
	}
	</style>
	<title></title>
</head>
		
<body>	
	
<div id = "container">
	<h1>Registration</h1>
	<p>Fill up 	the form with correct values.</p>

	<label>First Name</label>
	<input type="text" name="firstname"  id="fname">
	<br>
	<label>Last Name</label>
	<input type="text" name="lastname"  id="lname">
	<br>
	<label>Phone Number</label>
	<input type="text" name="phone"  id="phone">
	<br>
    <label>Address</label>
   	<textarea  name="address"  rows="2" cols="50" id="address"></textarea>	
   	<br>		
	<label>Email Address</label>
	<input type="text" name="email" id="email"><span style="color: red;">*</span>

	<div id="birthdate">
	<label>Birthdate:</label>
	<select id="myDd" name="myDd"><span style="color: red;">*</span><br>
		<option value="0" selected>Day</option>
		<option value="01">01</option>
		<option value="02">02</option>
		<option value="03">03</option>
		<option value="04">04</option>
		<option value="05">05</option>
		<option value="06">06</option>
		<option value="07">07</option>
		<option value="08">08</option>
		<option value="09">09</option>
		<option value="10">10</option>
		<option value="11">11</option>
		<option value="12">12</option>
		<option value="13">13</option>
		<option value="14">14</option>
		<option value="15">15</option>
		<option value="16">16</option>
		<option value="17">17</option>
		<option value="18">18</option>
		<option value="19">19</option>
		<option value="20">20</option>
		<option value="21">21</option>
		<option value="22">22</option>
		<option value="23">23</option>
		<option value="24">24</option>
		<option value="25">25</option>
		<option value="26">26</option>
		<option value="27">27</option>
		<option value="28">28</option>
		<option value="29">29</option>
		<option value="30">30</option>
		<option value="31">31</option>
	</select>
	<select id="myMm" name="myMm"><br>
		<option value="0" selected>Month</option>
		<option value="01">Jan</option>
		<option value="02">Feb</option>
		<option value="03">Mar</option>
		<option value="04">Apr</option>
		<option value="05">May</option>
		<option value="06">Jun</option>
		<option value="07">Jul</option>
		<option value="08">Aug</option>
		<option value="09">Sep</option>
		<option value="10">Oct</option>
		<option value="11">Nov</option>
		<option value="12">Dec</option>
	</select>
	<select id="myYy" name="myYy"><br>
		<option value="0" selected>Year</option>
	<option value="2019">2019</option>
	<option value="2018">2018</option>
    <option value="2017">2017</option>
    <option value="2016">2016</option>
    <option value="2015">2015</option>
    <option value="2014">2014</option>
    <option value="2013">2013</option>
    <option value="2012">2012</option>
    <option value="2011">2011</option>
    <option value="2010">2010</option>
    <option value="2009">2009</option>
    <option value="2008">2008</option>
    <option value="2007">2007</option>
    <option value="2006">2006</option>
    <option value="2005">2005</option>
    <option value="2004">2004</option>
    <option value="2003">2003</option>
    <option value="2002">2002</option>
    <option value="2001">2001</option>
    <option value="2000">2000</option>
    <option value="1999">1999</option>
    <option value="1998">1998</option>
    <option value="1997">1997</option>
    <option value="1996">1996</option>
    <option value="1995">1995</option>
    <option value="1994">1994</option>
    <option value="1993">1993</option>
    <option value="1992">1992</option>
    <option value="1991">1991</option>
    <option value="1990">1990</option>
    <option value="1989">1989</option>
    <option value="1988">1988</option>
    <option value="1987">1987</option>
    <option value="1986">1986</option>
    <option value="1985">1985</option>
    <option value="1984">1984</option>
    <option value="1983">1983</option>
    <option value="1982">1982</option>
    <option value="1981">1981</option>
    <option value="1980">1980</option>
    <option value="1979">1979</option>
    <option value="1978">1978</option>
    <option value="1977">1977</option>
    <option value="1976">1976</option>
    <option value="1975">1975</option>
    <option value="1974">1974</option>
    <option value="1973">1973</option>
    <option value="1972">1972</option>
    <option value="1971">1971</option>
    <option value="1970">1970</option>
    <option value="1969">1969</option>
    <option value="1968">1968</option>
    <option value="1967">1967</option>
    <option value="1966">1966</option>
    <option value="1965">1965</option>
    <option value="1964">1964</option>
    <option value="1963">1963</option>
    <option value="1962">1962</option>
    <option value="1961">1961</option>
    <option value="1960">1960</option>
    <option value="1959">1959</option>
    <option value="1958">1958</option>
    <option value="1957">1957</option>
    <option value="1956">1956</option>
    <option value="1955">1955</option>
    <option value="1954">1954</option>
    <option value="1953">1953</option>
    <option value="1952">1952</option>
    <option value="1951">1951</option>
    <option value="1950">1950</option>
    <option value="1949">1949</option>
    <option value="1948">1948</option>
    <option value="1947">1947</option>
    <option value="1946">1946</option>
    <option value="1945">1945</option>
    <option value="1944">1944</option>
    <option value="1943">1943</option>
    <option value="1942">1942</option>
    <option value="1941">1941</option>
    <option value="1940">1940</option>
    <option value="1939">1939</option>
    <option value="1938">1938</option>
    <option value="1937">1937</option>
    <option value="1936">1936</option>
    <option value="1935">1935</option>
    <option value="1934">1934</option>
    <option value="1933">1933</option>
    <option value="1932">1932</option>
    <option value="1931">1931</option>
    <option value="1930">1930</option>
    <option value="1929">1929</option>
    <option value="1928">1928</option>
    <option value="1927">1927</option>
    <option value="1926">1926</option>
    <option value="1925">1925</option>
    <option value="1924">1924</option>
    <option value="1923">1923</option>
    <option value="1922">1922</option>
    <option value="1921">1921</option>
    <option value="1920">1920</option>
    <option value="1919">1919</option>
    <option value="1918">1918</option>
    <option value="1917">1917</option>
    <option value="1916">1916</option>
    <option value="1915">1915</option>
    <option value="1914">1914</option>
    <option value="1913">1913</option>
    <option value="1912">1912</option>
    <option value="1911">1911</option>
    <option value="1910">1910</option>
    <option value="1909">1909</option>
    <option value="1908">1908</option>
    <option value="1907">1907</option>
    <option value="1906">1906</option>
    <option value="1905">1905</option>
	</select>
	</div>

	<label>Gender:</label>
	<input type="radio" name="gender" value="N" checked>N/A
	<input type="radio" name="gender" value="M">Male
	<input type="radio" name="gender" value="F">Female
	<br>
	

	<label>Username</label>
	<input type="text" name="username" id="username"><span style="color: red;">*</span>
	<br>

	<label>Password</label>
	<input type="password" name="password" id="password"><span style="color: red;">*</span><br>

	<label>Retype Password</label>
	<input type="password" name="retype-password" id="retype-password"><span style="color: red;">*</span>
	<br><br>

	<button name='register' id="registerBtn" value='register'>Register</button><br>
	<button onclick="window.history.back();" class="backBtn">Back</button>
	<br>
	<h3 id="valText"></h3>
</div>
</body>

</html>

