const cvs = document.getElementById("game");
const ctx = cvs.getContext("2d");
var ajax = new XMLHttpRequest();
		
		const box = 12;
		var gameplayInterval = 640;
		var pPosX = box*24;
		var ePosX = box*64;
		ajax.open("GET","data.php",true);
		ajax.send();
		var player = [];
		var enemy = [];
		var p_HP = 0;
		var e_HP = 0;
		let messages = "Console : <br>";
		let exp_msg = "";
		// document.getElementById("messages").innerHTML = messages;
		ajax.onload = function(){
			if(this.status == 200){
				var data = JSON.parse(this.responseText);
				console.log(data);
				var html="";

				for(var i = 0; i < 1; i++){

					var p_atk = data[i].Atk;
					var p_def = data[i].Def;
					var p_spd = data[i].Spd;
					var p_spatk = data[i].SpAtk;
					var p_spdef = data[i].SpDef;
					var p_hp = data[i].HP;
			
					player = {
						PlayerName : data[i].Username,
						PokemonID : data[i].PokemonID,
						PokemonItemID : data[i].PokemonItemID,
						Name : data[i].ItemName,
						Image : "img/"+data[i].Image,
						Element : data[i].Element,
						Level : data[i].Level,
						Atk : p_atk,
						Def : p_def,
						Spd : p_spd,
						SpAtk : p_spatk,
						SpDef : p_spdef,
						HP : p_hp,
						MaxHP : p_hp,
						Exp : data[i].Exp,
						NeedExp : data[i].NeedExp,
						EV : data[i].EV,
						posX : pPosX

					}
					var extension = data[i].Image.search(".png");
					player['Image'] = new Image();
					player['Image'].src = "img/"+data[i].Image.substring(0, extension)+"1.png";
					p_HP = player['HP'];

				
				}

				ajax.open('GET','enemyrandom.php',true);
				ajax.send();

				ajax.onload = function(){
					if(this.status == 200){
						var data = JSON.parse(this.responseText);

						var r = Math.floor(Math.random() * data.length);
						var r_stat = Math.floor(Math.random() * 3) + 1;
						
						var random_lvl = Math.abs( random(player['Level'] -3 , player['Level'] - -3) );
						
						if(random_lvl == 0)
							random_lvl = player['Level'];
						else if(player['Level'] <= 2)
							random_lvl = random(1,player['Level']);						
						
							alert("Hello");
						randomStat = (statP, statG) => {
							let randomWeight = Math.random() * (0.6 - 0.4) + 0.4; // random between 0.4(inclusive) and 0.6(exclusive)
							console.log(parseInt(statP));
							console.log(parseInt(statG));
							console.log("Random:" + randomWeight);
							return Math.floor( parseInt(statP) + (parseInt(statG) * random_lvl * randomWeight) );
						}
						
						


						var level = parseInt(data[r].LevelG * random_lvl);
						var atk = randomStat(data[r].AtkP, data[r].AtkG);
						var def = randomStat(data[r].DefP, data[r].DefG);
						var spd = randomStat(data[r].SpdP, data[r].SpdG);
						var spatk = randomStat(data[r].SpAtkP, data[r].SpAtkG);
						var spdef = randomStat(data[r].SpDefP, data[r].SpDefG);
						var hp = randomStat(data[r].HPP, data[r].HPG);
						
						// console.log("Random : " + r);

						

						enemy = {
						PokemonID : data[r].PokemonID,
						EnemyName : "Bot",
						Name : "Wild " + data[r].Name,
						Element : data[r].Element,
						Image : data[r].Image,
						ImageShow : data[r].Image,
						Level : level,
						Atk : atk,
						Def : def,
						Spd : spd,
						SpAtk : spatk,
						SpDef : spdef,
						HP : hp,
						MaxHP : hp,
						EV : data[r].EV,
						posX : ePosX
					}
					enemy['Image'] = new Image();
					enemy['Image'].src = "img/"+data[r].Image;
					e_HP = enemy['HP'];
					
				// document.getElementById("data").innerHTML = html;
				
			}

var p_name = document.getElementById("p_name");
p_name.innerHTML = player.PlayerName;
var p_n = document.getElementById("p_n");
p_n.innerHTML = player.Name;
var p_l = document.getElementById("p_l");
p_l.innerHTML = p_l.innerHTML+" "+player.Level;

var e_name = document.getElementById("e_name");
e_name.innerHTML = enemy.EnemyName;
var e_n = document.getElementById("e_n");
e_n.innerHTML = enemy.Name;
var e_l = document.getElementById("e_l");
e_l.innerHTML = e_l.innerHTML+" "+enemy.Level;

const W = ctx.canvas.width; //1280
const H = ctx.canvas.height; //576

const BGs = new Image();
BGs.src = "img/BGs.jpg";
const attack = new Image();
attack.src = "img/attack.png";
const spell = new Image();
spell.src = "img/spell.png";
const critical = new Image();
critical.src = "img/critical.png";





var state = 'start';



var p_hpbar = document.getElementById("p_hp");
var p_hpval = document.getElementById("p_hpv");
var p_mhpval = document.getElementById("p_mhpv");

var e_hpbar = document.getElementById("e_hp");
var e_hpval = document.getElementById("e_hpv");
var e_mhpval = document.getElementById("e_mhpv");

var sequence = 1;
var round = 1;
p_hpbar.value = player.HP;
p_hpbar.max = player.MaxHP;
p_hpval.innerHTML = player.HP;
p_mhpval.innerHTML = player.MaxHP;


e_hpbar.value = enemy.HP;
e_hpbar.max = enemy.MaxHP;
e_hpval.innerHTML = enemy.HP;
e_mhpval.innerHTML = enemy.MaxHP;

function draw(){

	ctx.drawImage(BGs,0,0,W,H);
	ctx.fillStyle = "black";
	
	var ground = 250;
	//1 stand
	//2 attack
	//3 react
	//4 stop
	ctx.font = "26px Ariel";
	ctx.fillText("Round " + round, box*49, box*5);

	ctx.font = "18px Ariel";
	//5 stand
	//6	attack
	//7 react
	//8 stop

	ctx.drawImage(player['Image'],pPosX,ground,128,128);
	// ctx.fillText(player['Name'],pPosX,350);
	
	ctx.drawImage(enemy['Image'],ePosX,ground,128,128);
	// ctx.fillText(enemy['Name'],ePosX,350);
	
	ctx.font = "40px Change one";

	if(state == 'start'){

		// console.log(round);

		if(sequence == 2){ //Player's Turn
			
			var currentHP = AttackTo(player,enemy);
    		if(currentHP <= 0)
				state = 'won';

			e_hpval.innerHTML = currentHP;
			e_hpbar.value = currentHP;
		}
		else if(sequence == 5){

			var currentHP = AttackTo(enemy,player);

    		if(currentHP <= 0)
				state = 'lost';
			
			p_hpval.innerHTML = currentHP;
			p_hpbar.value = currentHP;
		}

		if(sequence == 6){
			sequence = 1;
			round++;
		}
		else{
			sequence++;
		}
			
			
	}
	else if(state=='stop'){

	}
	else if(state=='won'){
		result(enemy, 1);
		state = 'stop';
	}
	else if(state=='lost'){
		result(player, 0);
		state = 'stop';
	}
	

document.getElementById("messages").innerHTML = messages;
}

let game = setInterval(draw, gameplayInterval);



// function setGameplayInterval() {
// 	var accelerateBtn = document.getElementById("accelerateBtn");

// 	var accelerate = document.getElementById("accelerate");

// 	if(accelerateBtn.value == "Accelerate On") {
// 		gameplayInterval = 10;
// 	}
// 	else {
// 		gameplayInterval = 500;
// 	}
	
// }

function botCheck() {
  	var x = document.getElementById("submit_exp");
  	x.style.display = "block";

 	var botBtn = document.getElementById("botBtn");
 	botBtn.style.display = "none";

 	var bot = document.getElementById("bot");

  	if(botBtn.value == "Bot On"){
  		bot.value = "On";
  		x.click();
  	}
  	else{
  		bot.value = "Off";
  	}
}

function AttackTo(attacker,target){
	var dodge = target.Spd - attacker.Spd;
	if(dodge <= 0)
		dodge = 0;
	var miss = random(1,(100+(dodge/2)));
	if(miss > 95){
		ctx.fillText("Dodge !",target.posX,225);
		messages = attacker.Name + " : Miss !" + "<br>";
		return target.HP;
	}

	var atkChance = random(1,100);

	if(atkChance > 50){

		var dmg = random(attacker.Atk*0.98, attacker.Atk*1.02);

		if(atkChance > 85){
			dmg = Math.floor(dmg * 1.35);
			dmg = Math.floor(dmg - (target.Def * 0.66));
			if(dmg <= 1)
				dmg = 1;
			ctx.fillStyle = "red";
			ctx.fillText(dmg,target.posX,225);	
			ctx.drawImage(critical,target.posX,255,128,128); 
			messages = attacker.Name +" : Critical " + dmg + " Damage <br>";
		}
		else{
			dmg = Math.floor(dmg - (target.Def * 0.66));
			if(dmg <= 1)
				dmg = 1;
			ctx.fillText(dmg,target.posX,225);	
			ctx.drawImage(attack,target.posX,255,128,128); 
			messages = attacker.Name +" : Attack " + dmg + " Damage <br>";
		}
	}
	else {

		var dmg = random(attacker.SpAtk*0.98, attacker.SpAtk*1.02);

		dmg = Math.floor(dmg * 1.2);
		dmg = Math.floor(dmg - (target.SpDef * 0.66));
		if(dmg <= 5)
			dmg = 5;
		ctx.fillStyle = "blue";
		ctx.fillText(dmg,target.posX,225);
		ctx.drawImage(spell,target.posX,255,128,128); 
		messages = attacker.Name +" : Spell " + dmg + " Damage <br>";
	}
	
	target.HP -= dmg;

	if(target.HP <= 0)
		target.HP = 0;

	return target.HP;
}

function result(loser, check) {
	loser['Image'].src = "img/dead.png";
	ctx.drawImage(loser['Image'],loser.posX,350,128,128);


			var exp = random(20,40) * enemy.Level;

			document.getElementById("exp").value = exp;
			document.getElementById("pkid").value = player['PokemonID'];
			document.getElementById("pkiid").value = player['PokemonItemID'];
			document.getElementById("lvl").value = player['Level'];
			document.getElementById("check").value = check;
			if(check == 1) {
				document.getElementById("coin").value = random(15,50);
				messages="<h4 style='color: green;'>Player won.</h4>";
			}
			else if(check == 0) {
				document.getElementById("coin").value = 0;
				messages="<h4 style='color: red;'>Player lost.</h4>";
			}
			document.getElementById("enemyPokemonID").value = enemy['PokemonID'];
			document.getElementById("enemyName").value = enemy['Name'];
			document.getElementById("enemyImage").value = enemy['ImageShow'];
			document.getElementById("enemyLevel").value = enemy['Level'];
			document.getElementById("enemyElement").value = enemy['Element'];
			document.getElementById("enemyAtk").value = enemy['Atk'];
			document.getElementById("enemyDef").value = enemy['Def'];
			document.getElementById("enemySpd").value = enemy['Spd'];
			document.getElementById("enemySpAtk").value = enemy['SpAtk'];
			document.getElementById("enemySpDef").value = enemy['SpDef'];
			document.getElementById("enemyHP").value = enemy['MaxHP'];
			document.getElementById("enemyEV").value = enemy['EV'];

			botCheck();
}

function random(min,max) {
	return Math.floor( Math.random() * (max-min) ) + min;
}

		}
	}
}
