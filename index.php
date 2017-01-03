<?php
session_start();
    include_once 'scripts/database.class.php';

    $db = Database::getInstance();
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="js/jquery.min.js"></script>
<script src="js/jquery.mobile-1.4.5.min.js"></script>
<link rel="stylesheet" href="css/themes/default/jquery.mobile-1.4.5.min.css">

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
$( document ).ready(function() {


$(document).on('click', '#t1r5', function () {
    alert("here dawg");
    $("profilestats").append("<div class=\"profilestats_single\"><input type=\"text\" value=\"name\" id=\"name\" /><input type=\"text\" value=\"value\" id=\"value\" /><input type=\"text\" value=\"depend\" id=\"depend\" /><input type=\"text\" value=\"checker\" id=\"checker\" /></div>");
});


$(document).on('click', '#submit_joingame', init);
$(document).on('click', '#submit_sendmessage', send);
        
var socket;

function init() {
    var selPlayer = $("#jplayer");
    var selGame   = $("#jgame");

    if(selPlayer.selectedIndex == -1)
        return null;
    
    var player_name = $("#jplayer option:selected").text();
    var player_id = selPlayer.val();
    var game_id = selGame.val();
    var host = "ws://127.0.0.1:9000/"+player_id+"/"+game_id;
    try {
        socket = new WebSocket(host);
		$("#msgs").append('WebSocket - status '+socket.readyState);
		socket.onopen    = function(msg) {
            $("#msgs").append("Welcome  " + player_name + "</br>"); 
						   };
		socket.onmessage = function(msg) {
            $("#msgs").append(msg.data + "</br>");
        }
		socket.onclose   = function(msg) { 
            $("#msgs").append("Disconnected - status "+this.readyState + "</br>"); 
        };
	}
	catch(ex){ 
		$("#msgs").append(ex); 
	}
    $("#chatmessage").focus();
}

function send(){
 	var txt,msg;
	txt = $("#chatmessage");
	msg = txt.val();
	if(!msg) { 
		alert("chatmessage can not be empty"); 
		return; 
	}
	txt.value="";
	txt.focus();
	try { 
		socket.send(msg); 
		$("#msgs").append("Sent: " + msg); 
	} catch(ex) { 
		$("#msgs").append(ex); 
	}
}

function quit(){
	if (socket != null) {
		$("#msgs").append("Goodbye!");
		socket.close();
		socket=null;
	}
}

function reconnect() {
	quit();
	init();
}

// Utilities
    //function onkey(event){ if(event.keyCode==13){ send(); } }

function testsave() {
    var divs = $("profilestats").getElementsByClassName("profilestats_single");
    var input_name;
    var input_value;
    var input_depend;
    var input_checker;
    
    for(var i = 0; i < divs.length; i++) {
        var inner = divs[i].getElementsByTagName("input");
        for(var j = 0; j < inner.length; j++) {
            if(inner[j].id == "name")
                input_name = inner[j].value;
            else if(inner[j].id == "value")
                input_value = inner[j].value;
            else if(inner[j].id == "depend")
                input_depend = inner[j].value;
            else if(inner[j].id == "checker")
                input_checker = inner[j].value;
            else
                alert("Something goes wrong");
        }
    
        jQuery(function($) {
            $.ajax({ url: 'scripts/test.php',
             data: {name: input_name,
             value: input_value,
             depend: input_depend,
             checker: input_checker},
             type: 'post',
             success: function(output) {
                 alert(output);
             }
             });
        });
    }
}
    
});
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
      <a data-role="button" id="submit_joingame">Join Game</a>
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
      <input type="textbox" id="chatmessage" />
      <a id="submit_sendmessage" data-role="button">send</a>
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
                            
    <div class="profilestats"></div>
    <a data-role="button" id="t1r5">Add</a>
    <button onclick="testsave()">Testsave</button>                        
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
