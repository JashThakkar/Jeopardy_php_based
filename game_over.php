<?php
session_start();

$highestScore = max($_SESSION['scores']);
$winningTeam = array_search($highestScore, $_SESSION['scores']);
$winnerName = $_SESSION['team_names'][$winningTeam];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Game Over</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>

<div class="top_bar">
    <h1>Game Over</h1>
</div>

<br><br>

<h2>Winner: <?= htmlspecialchars($winnerName) ?> — <?= $highestScore ?> points</h2>

<br><br>

<div style="display:flex; justify-content:center; gap:40px;">

    <form action="game_stats.php" method="POST">
        <button class="submit_button">Game Stats</button>
    </form>

    <form action="index.php" method="POST">
        <button class="submit_button">Back to Start Screen</button>
    </form>

</div>

</body>
</html>
