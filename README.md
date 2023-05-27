# Fighting-Ultimate-Champion-King
This project is a browser game inspired from Pokemon franchise and shopping cart concepts using PHP(Backend) and Database(MySQL). 

In this website you can Create account, Login, Purchase monsters, Bring your monster to battle with bots to gain your monster's EXP and receive coins for purchasing monster in shop (Adventure mode) or battle with other users to gain your Rank (Battle mode). And also if you're loggin as an admin account, you can ban users (user can't login), add new monster(NAME,ATK,DEF,SPD,...) or edit monsters in this game.

## Adventure Mode
- Bring your monster to battle with bots to gain exp and receive coins.
- You can press the 'Bot on' button to make your game auto runs to the next battle after finish the battle.
- You only get coins from winning battle.
- Whenever you win the battle, you can catch the monster that you battle with by using ball items that can be dropped from monster.
- Your monster can evolve if it reach the specific level or has more level than the specific level of that monster. You can accept or reject the evolution of monster.

## Battle Mode
- Bring your monster to battle with other users to gain your rank.

## Details
1. login.php
![image](https://github.com/wiroj-tam/Fighting-Ultimate-Champion-King/assets/134731702/02d410f8-5284-4849-b29d-671f75d34819)
![image](https://github.com/wiroj-tam/Fighting-Ultimate-Champion-King/assets/134731702/57c51ed3-bc82-4886-8378-06524bc2d376)

2. home.php
![image](https://github.com/wiroj-tam/Fighting-Ultimate-Champion-King/assets/134731702/9d408b2a-a2fe-4fd9-bd37-99ba1b822332)
![image](https://github.com/wiroj-tam/Fighting-Ultimate-Champion-King/assets/134731702/7162358b-31e1-4839-8545-1fd4332a3821)

3. chooseGameMode.php / game.php
![image](https://github.com/wiroj-tam/Fighting-Ultimate-Champion-King/assets/134731702/f7c065f1-f09b-4aaf-a681-95e784c4ab88)
![image](https://github.com/wiroj-tam/Fighting-Ultimate-Champion-King/assets/134731702/10016f1f-6c6b-4c92-8d3e-84e291a1f7a7)

4. result.php (After you finish the battle)
![image](https://github.com/wiroj-tam/Fighting-Ultimate-Champion-King/assets/134731702/713bf12f-d7a5-4606-a429-29b98f8db16c)
![image](https://github.com/wiroj-tam/Fighting-Ultimate-Champion-King/assets/134731702/2fb609c8-7727-489f-abb0-79ffa5674021)
![image](https://github.com/wiroj-tam/Fighting-Ultimate-Champion-King/assets/134731702/b22af14e-2f6f-45b1-b836-0be7ccca1f79)

## Installation
Guide for XAMPP or WAMPP.
1. Install XAMPP or WAMPP.
2. Open XAMPP Control panal and start [apache] and [mysql].
3. Download this project and extract files in <your drive>:\xampp\htdocs for example: C:\xampp\htdocs.
4. open link in url " localhost/phpmyadmin "
5. Create database name ' pokemon_fighting '
6. Import sql file to database. The file path is db/pokemon_fighting.sql

If you want to change database name, follow this:
6.1 ( After the import is complete you can change database name )
6.2 ( If you change database name, you have to go to file ' config.php ' in line 6  ' define("db", "pokemon_fighting"); ' change "pokemon_fighting" to your new database name )
  

7. Open any browser and type http://localhost:/Fighting-Ultimate-Champion-King/login.php 
  
Have fun! :) 
  
## Contact
If you have any question, please comment or email wiroj.tam@gmail.com
 
