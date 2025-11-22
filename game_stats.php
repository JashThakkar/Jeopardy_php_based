<?php
session_start();

$teams = $_SESSION['team_names'];
$correct = $_SESSION['correct'] ?? [];
$wrong   = $_SESSION['wrong'] ?? [];
$selectedTeam = $_POST['selected_team'] ?? null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Game Stats</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="top_bar">
    <h1>Game Stats</h1>
</div>

<br><br>

<form action="game_stats.php" method="POST">
    <select name="selected_team" class="submit_button" onchange="this.form.submit()">
        <option value="">Select a Team</option>

        <?php foreach ($teams as $teamNum => $teamName): ?>
            <option value="<?= $teamNum ?>" 
                <?= ($selectedTeam == $teamNum ? "selected" : "") ?>>
                Team <?= $teamNum ?> — <?= htmlspecialchars($teamName) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<br><br>

<?php if ($selectedTeam): ?>

    <?php
    $c = $correct[$selectedTeam] ?? 0;
    $w = $wrong[$selectedTeam] ?? 0;
    $total = $c + $w;
    $acc = ($total > 0) ? round(($c / $total) * 100, 2) : 0;

    if ($acc < 50) {
        $statement = "You need to study up buddy!";
    } elseif ($acc < 80) {
        $statement = "Getting better but still not perfect LOCK IN!";
    } else {
        $statement = "You are a great player!";
    }
    ?>

    <div style="font-size: 1.5rem;">
        <p><strong>Team Name:</strong> <?= htmlspecialchars($teams[$selectedTeam]) ?></p>
        <p><strong>Correct Answers:</strong> <?= $c ?></p>
        <p><strong>Wrong Answers:</strong> <?= $w ?></p>
        <p><strong>Accuracy:</strong> <?= $acc ?>%</p>
        <br>
        <p><strong>Improvement Statement:</strong> <?= $statement ?></p>
    </div>

<?php endif; ?>

<br><br>

<form action="index.php">
    <button class="submit_button">Back to Start</button>
</form>

</body>
</html>
