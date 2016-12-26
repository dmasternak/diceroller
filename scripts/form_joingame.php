<?php
  if(isset($_POST['submitjoin'])) {
      if($result = $db->query("SELECT * FROM tbl_gameplayer WHERE player_id = " . $_POST['jplayer'] . " AND game_id = " . $_POST['jgame'])) {
          if($result->num_rows == 1) {
              $row = $result->fetch_assoc();
              $_SESSION['game_id']   = $row['game_id'];
              $_SESSION['player_id'] = $row['player_id'];
              /*echo '<input type="hidden" name="player_id" value="' . $_SESSION['game_id'] . '" />';
                $_SESSION['player_id'] = $row['player_id'];
                echo '<input type="hidden" name="player_id" value="' . $_SESSION['player_id'] . '" />';*/
              echo '<script>init()</script>';
          }
      }
  }

  if(isset($_SESSION['game_id']) && isset($_SESSION['player_id'])) {
    echo '<script>init()</script>';
  }
  print_r($_SESSION);

?>