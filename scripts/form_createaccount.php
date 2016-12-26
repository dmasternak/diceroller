<?php
    include_once 'database.class.php';

    $db = Database::getInstance();
?>

<div data-role="page" id="createacc">
  <div data-role="panel" id="myPanel" data-display="overlay"> 
    <h2>Menu</h2>
    <div data-role="navbar">
      <a href="#chat">Chat</a>
      <a href="#profile">Profile</a>
      <a href="#custom">Custom</a>
      <a href="scripts/form_creategame.php">Start Game</a>
      <a href="#joingame">Join Game</a>
      <a href="scripts/form_createaccount.php" class="ui-btn-active ui-state-persist">Create Acc</a>
      <a href="scripts/form_playertogame.php">Player2Game</a>
    </div>
  </div>
  
  <div data-role="header">
    <a href="#myPanel" data-icon="grid" data-iconpos="notext"></a>
    <h1>Diceroller-Create Account</h1>
  </div>

  <div data-role="main" class="ui-content">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
      <div class="ui-field-contain">
        <label for="newaccname">Account Name:</label>
        <input type="text" name="newaccname" id="newaccname">
      </div>
      <input type="submit" data-inline="true" name="submitcreateacc" value="Create Acc">
    </form>
    <?php
        if(isset($_POST['submitcreateacc'])) {
            echo $_POST['submitcreateacc'];
            $db->query("INSERT INTO tbl_player(name) VALUES('". $_POST['newaccname'] ."')");
        }
    ?>
  </div>
</div>