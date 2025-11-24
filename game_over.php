<?php
session_start();

$highestScore = max($_SESSION['scores']);
$winningTeam = array_search($highestScore, $_SESSION['scores']);
$winnerName = $_SESSION['team_names'][$winningTeam];


$mostCorrect = 0;
$masterTeam = null;
if (isset($_SESSION['correct'])) {
    foreach ($_SESSION['correct'] as $teamId => $count) {
        if ($count > $mostCorrect) {
            $mostCorrect = $count;
            $masterTeam = $teamId;
        }
    }
}
$masterName = $masterTeam !== null ? $_SESSION['team_names'][$masterTeam] : "None";
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

<div class="feature-summary">
    <h3> Category Master </h3>
    <p>Most Correct Answers: Team: <span class="mastery-badge"><?= htmlspecialchars($masterName) ?> With: <?= $mostCorrect ?></span></p>
    <div class="final-j-note">
        * Final Jeopardy Wagers have been deducted/added to final scores.
    </div>
</div>

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