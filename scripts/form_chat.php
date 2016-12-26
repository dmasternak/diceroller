<?php
//session_start();
include_once 'database.class.php';

    $db = Database::getInstance();
?>

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
    <?php
        /*if($result = $db->query("SELECT name, message FROM tbl_chat INNER JOIN tbl_player ON tbl_chat.player_id = tbl_player.id_player WHERE game_id = ". $_SESSION['game_id'] . " ORDER BY date LIMIT 100")) {
          while($row = $result->fetch_assoc()) {
              echo $row['name'] . ' wrote: ' . $row['message'] . " <br/>";
          }
          }*/
    ?>
    <div id="msgs"></div>
  </div>
  <div data-role="footer" data-position="fixed">
      <input type="textbox" onkeypress="onkey(event)" id="message1" />
      <button onclick="send()">Send</button>
  </div>

  <?php
    if(isset($_POST['submitmessage'])) {
        $msg = $_POST['message'];
        $substring = explode(" ", $msg);

        if($substring[0] == "/r") {
            echo "lets do some regex";
        }
        else if($substring[0] == "/gm") {
            echo "lets do some regex and send result to gm";
        }
        else {
            //echo "INSERT INTO tbl_chat(message, game_id, player_id, date) VALUES('" . $_POST['message'] . "', ". $_SESSION['game_id'] .", ". $_SESSION['player_id'] .", now())";
        }
        //$db->query("INSERT INTO tbl_chat(message, game_id, player_id, date) VALUES('" . $_POST['message'] . "', ". $_SESSION['game_id'] .", ". $_SESSION['player_id'] .", now())");
    }
  ?>
</div> 



