<?php
    include_once 'database.class.php';

    $db = Database::getInstance();
?>

<div data-role="page" id="playertogame">
  <div data-role="panel" id="myPanel" data-display="overlay"> 
    <h2>Menu</h2>
    <div data-role="navbar">
      <a href="scripts/form_chat.php">Chat</a>
      <a href="#profile">Profile</a>
      <a href="#custom">Custom</a>
      <a href="scripts/form_creategame.php">Start Game</a>
      <a href="#joingame">Join Game</a>
      <a href="scripts/form_createaccount.php">Create Acc</a>
      <a href="scripts/form_playertogame.php" class="ui-btn-active ui-state-persist">Player2Game</a>
    </div>
  </div>
  
  <div data-role="header">
    <a href="#myPanel" data-icon="grid" data-iconpos="notext"></a>
    <h1>Diceroller-Player to Game</h1>
  </div>

  <div data-role="main" class="ui-content">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
      <div class="ui-field-contain">
        <label for="game" class="select">Select Game:</label>
        <select name="game" id="game" data-native-menu="false">
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
        <select name="player" id="player" data-native-menu="false">
          <option>Player</option>
          <?php
            if($result = $db->query("SELECT * FROM tbl_player")) {
                while($row = $result->fetch_assoc()) {
                    echo '<option value="'.$row['id_player'].'">'.$row['name'].'</option>';
                }
            }   
          ?>
        </select>
        <label for="isGM">Is GM:</label>
        <select name="isGM" id="isGM" data-role="slider" data-mini="true">
          <option value="0" selected="">No</option>
          <option value="1">Yes</option>
        </select>
      </div>
      <input type="submit" data-inline="true" name="submitplayergame" value="Add Player">
    </form>
    <?php
        if(isset($_POST['submitplayergame'])) {
            $db->query("INSERT INTO tbl_gameplayer(game_id, player_id, isGM) VALUES(". $_POST['game'] .", ". $_POST['player'] .", ". $_POST['isGM'] .")");
            echo "Query: " . "INSERT INTO tbl_gameplayer(game_id, player_id, isGM) VALUES(". $_POST['player'] .", ". $_POST['game'] .", ". $_POST['isGM'] .")";
        }
    ?>
  </div>
</div>