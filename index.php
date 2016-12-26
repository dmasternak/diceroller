<?php
session_start();
    include_once 'scripts/database.class.php';

    $db = Database::getInstance();
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/themes/default/jquery.mobile-1.4.5.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/jquery.mobile-1.4.5.min.js"></script>

<style type="text/css">
html,body {
	font:normal 0.9em arial,helvetica;
}
#msgs {
	width:auto; 
	height:auto; 
	border:1px; 
	overflow:auto;
}
#message1 {
	width:auto;
}
</style>

<script type="text/javascript">
var socket;

function receive(msg) {
    log("Received: " + msg.data);
}

function init() {
    var selPlayer = $("jplayer");
    var selGame   = $("jgame");

    if(selPlayer.selectedIndex == -1)
        return null;
    
    var player_name = selPlayer.options[selPlayer.selectedIndex].text;
    var player_id = selPlayer.value;
    var game_id = selGame.value;
    var host = "ws://127.0.0.1:9000/"+player_id+"/"+game_id; // SET THIS TO YOUR SERVER
    alert(host);
    try {
        socket = new WebSocket(host);
		log('WebSocket - status '+socket.readyState);
		socket.onopen    = function(msg) { 
							   log("Welcome  " + player_name); 
						   };
		socket.onmessage = function(msg) {
            log(msg.data);
        }
		socket.onclose   = function(msg) { 
							   log("Disconnected - status "+this.readyState); 
						   };
	}
	catch(ex){ 
		log(ex); 
	}
    $("message").focus();
}

function send(){
 	var txt,msg;
	txt = $("message1");
	msg = txt.value;
	if(!msg) { 
		alert("message1 can not be empty"); 
		return; 
	}
	txt.value="";
	txt.focus();
	try { 
		socket.send(msg); 
		log('Sent: '+msg); 
	} catch(ex) { 
		log(ex); 
	}
}
function quit(){
	if (socket != null) {
		log("Goodbye!");
		socket.close();
		socket=null;
	}
}

function reconnect() {
	quit();
	init();
}

// Utilities
function $(id){ return document.getElementById(id); }
function log(msg){ $("msgs").innerHTML+="<br>"+msg; }
function onkey(event){ if(event.keyCode==13){ send(); } }
</script>

</head>
      
<body>


<div data-role="page" id="joingame">
  <div data-role="panel" id="myPanel" data-display="overlay"> 
    <h2>Menu</h2>
    <div data-role="navbar">
      <a href="#chat">Chat</a>
      <a href="#profile">Profile</a>
      <a href="#custom">Custom</a>
      <a href="scripts/form_creategame.php">Start Game</a>
      <a href="#joingame" class="ui-btn-active ui-state-persist">Join Game</a>
      <a href="scripts/form_createacc.php">Create Acc</a>
      <a href="scripts/form_playertogame.php">Player2Game</a>
    </div>
  </div>
  
  <div data-role="header">
    <a href="#myPanel" data-icon="grid" data-iconpos="notext"></a>
    <h1>Diceroller-Join Game</h1>
  </div>

  <div data-role="main" class="ui-content">
      <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
      <div class="ui-field-contain">
        <label for="jgame" class="select">Select Game:</label>
        <select name="jgame" id="jgame" data-native-menu="false">
          <option>Game</option>
          <?php
            if($result = $db->query("SELECT * FROM tbl_game")) {
                while($row = $result->fetch_assoc()) {
                    echo '<option value="'.$row['id_game'].'">'.$row['name'].'</option>';
                }
            }   
          ?>
        </select>
        <label for="player" class="select">Select Player:</label>
        <select name="jplayer" id="jplayer" data-native-menu="false">
          <option>Player</option>
          <?php
            if($result = $db->query("SELECT * FROM tbl_player")) {
                while($row = $result->fetch_assoc()) {
                    echo '<option value="'.$row['id_player'].'">'.$row['name'].'</option>';
                }
            }   
          ?>
        </select>
      </div>
      <input type="submit" data-inline="true" name="submitjoin" onClick="init()" value="Join Game">
    </form>
  </div>
</div>

<div data-role="page" id="chat">
    <div data-role="panel" id="myPanel" data-display="overlay"> 
      <h2>Menu</h2>
      <div data-role="navbar">
	<a href="#chat" class="ui-btn-active ui-state-persist">Chat</a>
	<a href="#profile">Profile</a>
	<a href="#custom">Custom</a>
	<a href="scripts/form_creategame.php">Start Game</a>
	<a href="#joingame">Join Game</a>
	<a href="scripts/form_createaccount.php">Create Acc</a>
      <a href="scripts/form_playertogame.php">Player2Game</a>
      </div>
    </div>
  <div data-role="header">
    <a href="#myPanel" data-icon="grid" data-iconpos="notext"></a>
     <h1>Diceroller-Chat</h1>
  </div>

  <div data-role="main" class="ui-content">
    <div id="msgs"></div>
  </div>
  <div data-role="footer" data-position="fixed">
      <input type="textbox" onkeypress="onkey(event)" id="message1" />
      <button onclick="send()">Send</button>
  </div>
</div> 

<div data-role="page" id="profile">
  <div data-role="panel" id="myPanel" data-display="overlay"> 
    <h2>Menu</h2>
    <div data-role="navbar">
      <a href="#chat">Chat</a>
      <a href="#profile" class="ui-btn-active ui-state-persist">Profile</a>
      <a href="#custom">Custom</a>
      <a href="#startgame">Start Game</a>
      <a href="#joingame">Join Game</a>
      <a href="#createacc">Create Acc</a>
    </div>
  </div>
  
  <div data-role="header">
    <a href="#myPanel" data-icon="grid" data-iconpos="notext"></a>
    <h1>Diceroller-Profile</h1>
  </div>

  <div data-role="main" class="ui-content">
    Here is the profile
  </div>
</div> 

<div data-role="page" id="custom">
  <div data-role="panel" id="myPanel" data-display="overlay"> 
    <h2>Menu</h2>
    <div data-role="navbar">
      <a href="#chat">Chat</a>
      <a href="#profile">Profile</a>
      <a href="#custom" class="ui-btn-active ui-state-persist">Custom</a>
      <a href="#startgame">Start Game</a>
      <a href="#joingame">Join Game</a>
      <a href="#createacc">Create Acc</a>
    </div>
  </div>
  
  <div data-role="header">
    <a href="#myPanel" data-icon="grid" data-iconpos="notext"></a>
    <h1>Diceroller-Custom</h1>
  </div>

  <div data-role="main" class="ui-content">
    Here are custom dice rolles
  </div>
</div>
<?php
  include 'scripts/form_creategame.php';
?>

<?php include 'scripts/form_createaccount.php';  ?>

<?php include 'scripts/form_playertogame.php';  ?>
<?php
//session_destroy(); 
?>
</body>
</html>
