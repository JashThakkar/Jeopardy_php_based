<?php
$selectedPlayers = isset($_POST['playerCount']) ? intval($_POST['playerCount']) : null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="styles.css" />
  <title>Jeopardy Battle Arena</title>
</head>

<body>

  <div class="top_bar">
    <h1>Welcome to Jeopardy Battle Arena!</h1>
    <p>Get ready to test your knowledge and battle it out in the ultimate quiz showdown!</p>
  </div><br />

  <!-- Added rules section so players know about the new features -->
  <div style="width: 60%; margin: auto; background: #eee; padding: 20px; border-radius: 10px; border: 4px solid #000080; text-align: center;">
      <h3 style="margin-top:0;">⚠ NEW GAME RULES ⚠</h3>
      <ul style="text-align: left; display: inline-block;">
          <li><strong>Daily Double:</strong> One random question allows you to wager your points!</li>
          <li><strong>Category Mastery:</strong> Answer 3 in a row correctly in a category for a <strong>1000pt BONUS</strong>.</li>
          <li><strong>Final Jeopardy:</strong> A high-stakes betting round ends the game.</li>
      </ul>
  </div>
  <br />

  <div class="game_setup">
    <form method="POST" action="index.php">
      <div class="players_count">
        <p>Choose player count:</p>
        <select name="playerCount" id="playerCountSelect" onchange="this.form.submit()">
          <option value="">-- Select --</option>
          <option value="2" <?= ($selectedPlayers == 2 ? "selected" : "") ?>>2 Players</option>
          <option value="3" <?= ($selectedPlayers == 3 ? "selected" : "") ?>>3 Players</option>
          <option value="4" <?= ($selectedPlayers == 4 ? "selected" : "") ?>>4 Players</option>
        </select>
      </div>
    </form><br>

    <?php if ($selectedPlayers): ?>
      <form action="start_game.php" method="POST">
        <input type="hidden" name="playerCount" value="<?= $selectedPlayers ?>">
        <div class="players_count">
          <p>Enter Team Names:</p>
          <?php for ($i = 1; $i <= $selectedPlayers; $i++): ?>
            <input type="text" name="team_name_<?= $i ?>" placeholder="Team <?= $i ?>"
              style="padding:10px; width:80%; margin-bottom:10px; border-radius:8px;" required>
          <?php endfor; ?>
        </div><br>

        <div class="start_button">
          <button id="startGameButton" type="submit">Start Game</button>
        </div>
      </form>
    <?php endif; ?>
  </div>

</body>
</html>