const cvs = document.getElementById("battle");
const ctx = cvs.getContext("2d");
var ajax = new XMLHttpRequest();
	
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
						EV : data[i].EV

					}
					player['Image'] = new Image();
					player['Image'].src = "img/"+data[i].Image.substring(0,data[i].Image.length-4)+"1.png";
					p_HP = player['HP'];

				
				}

				
				ajax.open('GET','playerrandom.php',true);

				
				ajax.send();

				ajax.onload = function(){
					if(this.status == 200){
						var data = JSON.parse(this.responseText);
						console.log(JSON.stringify(data));
						var lastData = data['players'].length-1;
						var r = Math.floor(Math.random() * lastData);
						
						var level = parseInt(data['players'][r].Level);
						var atk = data['players'][r].Atk;
						var def = data['players'][r].Def;
						var spd = data['players'][r].Spd;
						var spatk = data['players'][r].SpAtk;
						var spdef = data['players'][r].SpDef;
						var hp = data['players'][r].HP;
						
						// console.log("Random : " + r);
						

						enemy = {
						EnemyName : data['players'][r].Username,
						Name : data['players'][r].ItemName,
						Element : data['players'][r].Element,
						Image : "img/"+data['players'][r].Image,
						Level : level,
						Atk : atk,
						Def : def,
						Spd : spd,
						SpAtk : spatk,
						SpDef : spdef,
						HP : hp,
						MaxHP : hp,
						EV : data['players'][r].EV
					}
					enemy['Image'] = new Image();
					enemy['Image'].src = "img/"+data['players'][r].Image;
					e_HP = enemy['HP'];
					
				// document.getElementById("data").innerHTML = html;
				
			}
	
const W = ctx.canvas.width; //1280
const H = ctx.canvas.height; //576

const BG = new Image();
BG.src = "img/BGs.jpg";
const attack = new Image();
attack.src = "img/attack.png";
const spell = new Image();
spell.src = "img/spell.png";
const critical = new Image();
critical.src = "img/critical.png";


const box = 12;



const states = {
    START : 'start',
    T1 : 't1',
    T2 : 't2',
    END : 'end',
    WON : 'won',
    LOST : 'lost',
    STOP : 'stop'
}


var state = states.START;



var p_hpbar = document.getElementById("p_hp");
var e_hpbar = document.getElementById("e_hp");
var round = 1;
p_hpbar.value = player.HP;
p_hpbar.max = player.MaxHP;
e_hpbar.value = enemy.HP;
e_hpbar.max = enemy.MaxHP;

function draw(){

	ctx.drawImage(BG,0,0,W,H);
	ctx.fillStyle = "black";
	ctx.font = "18px Ariel";

	var pPosX = box*24;
	var ePosX = box*64;

	//1 stand
	//2 attack
	//3 react
	//4 stop

	//5 stand
	//6	attack
	//7 react
	//8 stop

	//Player
	ctx.fillStyle = "black";
	ctx.fillText(player['PlayerName'],box*7,box*3);
	ctx.drawImage(player['Image'],box*4,box*4,box*8,box*8);
	ctx.fillText("Level : " + player['Level'],box*6,box*14);
	ctx.fillText("Element : " + player['Element'],box*6,box*16);
    ctx.fillText("Atk : " + player['Atk'],box*6,box*18);
    ctx.fillText("Def : " + player['Def'],box*6,box*20);
    ctx.fillText("Spd : " + player['Spd'],box*6,box*22);
    ctx.fillText("SpAtk : " + player['SpAtk'],box*6,box*24);
    ctx.fillText("SpDef : " + player['SpDef'],box*6,box*26);
    ctx.fillText("HP : "+player.HP+"/"+player.MaxHP,box*6,box*28);
	ctx.drawImage(player['Image'],pPosX,350,128,128);
	ctx.fillText(player['Name'],pPosX,350);
	
	//Enemy
	ctx.fillText(enemy['EnemyName'],box*93,box*3);
	ctx.drawImage(enemy['Image'],box*91,box*4,box*8,box*8);
	ctx.fillText("Level : " + enemy['Level'],box*91,box*14);
	ctx.fillText("Element : " + enemy['Element'],box*91,box*16);
    ctx.fillText("Atk : " + enemy['Atk'],box*91,box*18);
    ctx.fillText("Def : " + enemy['Def'],box*91,box*20);
    ctx.fillText("Spd : " + enemy['Spd'],box*91,box*22);
    ctx.fillText("SpAtk : " + enemy['SpAtk'],box*91,box*24);
    ctx.fillText("SpDef : " + enemy['SpDef'],box*91,box*26);
    ctx.fillText("HP : "+enemy.HP+"/"+enemy.MaxHP,box*91,box*28);
	ctx.drawImage(enemy['Image'],ePosX,350,128,128);
	ctx.fillText(enemy['Name'],ePosX,350);
	
	ctx.font = "40px Change one";

	if(state == states.START){

		// console.log(round);

		if(round == 2){ //Player's Turn
			
			var currentHP = AttackTo(player,enemy,ePosX);

    		if(currentHP == 0)
				state = states.END;
			
			e_hpbar.value = currentHP;
		}
		else if(round == 5){

			var currentHP = AttackTo(enemy,player,pPosX);

    		if(currentHP == 0)
				state = states.END;
			
			p_hpbar.value = currentHP;
		}

		if(round == 6){
			round = 1;
		}
		else{
			round++;
		}
			
			
	}

	if(state==states.STOP){

	}

	if(state==states.WON){

		enemy['Image'].src = "img/dead.png";
		ctx.drawImage(enemy['Image'],ePosX,350,128,128);


			var exp = random(15,35) * enemy.Level;

			document.getElementById("res").value = "won";
			
			result();

		state = states.STOP;

	}
	else if(state==states.LOST){

		player['Image'].src = "img/dead.png";
		ctx.drawImage(player['Image'],pPosX,350,128,128);

			var exp = random(15,35) * enemy.Level;

			var legacy = 0;

			document.getElementById("res").value = "lost";
			

			result();

	

		state = states.STOP;
	}


	if(state==states.END){
		if(enemy.HP <= 0){
			messages="<h4>Player won.</h4>";
			state=states.WON;
		}
		else if(player.HP <= 0){
			messages="<h4>Enemy won.</h4>";
			state=states.LOST;
		}
	}
	

document.getElementById("messages").innerHTML = messages;
}
let game = setInterval(draw,640);

function result() {
  var x = document.getElementById("submit_exp");
 	x.style.display = "block";

 	// var botBtn = document.getElementById("botBtn");
 	// botBtn.style.display = "none";
 	// var bot = document.getElementById("bot");
  // 	if(botBtn.value == "Bot On"){
  // 		bot.value = "On";
  // 		x.click();
  // 	}
  // 	else{
  // 		bot.value = "Off";
  // 	}
}

function AttackTo(attacker,target,pos){

	var dodge = target.Spd - attacker.Spd;
	if(dodge <= 0)
		dodge = 0;
	var miss = random(1,(100+dodge));
	if(miss > 80){
		ctx.fillText("Dodge !",pos,325);
		messages = attacker.Name + " : Miss !" + "<br>";
		return target.HP;
	}

	var atkChance = random(1,100);

	if(atkChance > 50){

		var dmg = random(attacker.Atk*0.95, attacker.Atk*1.05);

		if(atkChance > 85){
			dmg = Math.floor(dmg * 1.35);
			dmg = Math.floor(dmg - (target.Def * 0.66));
			if(dmg <= 1)
				dmg = 1;
			ctx.fillStyle = "red";
			ctx.fillText(dmg,pos,325);	
			ctx.drawImage(critical,pos,350,128,128); 
			messages = attacker.Name +" : Critical " + dmg + " Damage <br>";
		}
		else{
			dmg = Math.floor(dmg - (target.Def * 0.66));
			if(dmg <= 1)
				dmg = 1;
			ctx.fillText(dmg,pos,325);	
			ctx.drawImage(attack,pos,350,128,128); 
			messages = attacker.Name +" : Attack " + dmg + " Damage <br>";
		}
	}
	else {

		var dmg = random(attacker.SpAtk*0.95, attacker.SpAtk*1.05);

		dmg = Math.floor(dmg * 1.2);
		dmg = Math.floor(dmg - (target.SpDef * 0.44));
		if(dmg <= 5)
			dmg = 5;
		ctx.fillStyle = "blue";
		ctx.fillText(dmg,pos,325);	
		ctx.drawImage(spell,pos,350,128,128); 
		messages = attacker.Name +" : Spell " + dmg + " Damage <br>";
	}
	
	target.HP -= dmg;

	if(target.HP <= 0)
		target.HP = 0;

	return target.HP;
}

function random(min,max){
	return Math.floor( Math.random() * (max-min) ) + min;
}

		}
	}
}