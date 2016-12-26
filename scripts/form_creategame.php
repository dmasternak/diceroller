<?php
    include_once 'database.class.php';

    $db = Database::getInstance();
?>

<div data-role="page" id="startgame">
  <div data-role="panel" id="myPanel" data-display="overlay"> 
    <h2>Menu</h2>
    <div data-role="navbar">
      <a href="#chat">Chat</a>
      <a href="#profile">Profile</a>
      <a href="#custom">Custom</a>
      <a href="scripts/form_creategame.php" class="ui-btn-active ui-state-persist">Start Game</a>
      <a href="#joingame">Join Game</a>
      <a href="scripts/form_createaccount.php">Create Acc</a>
      <a href="scripts/form_playertogame.php">Player2Game</a>
    </div>
  </div>
  
  <div data-role="header">
    <a href="#myPanel" data-icon="grid" data-iconpos="notext"></a>
    <h1>Diceroller-Start Game</h1>
  </div>

  <div data-role="main" class="ui-content">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
      <div class="ui-field-contain">
        <label for="name">Name:</label>
        <input type="text" name="newgamename" id="newgamename">
      </div>
      <input type="submit" data-inline="true" name="submitnewgame" value="Create Game">
    </form>
    <?php //echo $_POST['submit']
        if(isset($_POST['submitnewgame'])) {
            echo $_POST['submitnewgame'];
            $db->query("INSERT INTO tbl_game(name) VALUES('". $_POST['newgamename'] ."')");
        }
        ?>
  </div>
</div>