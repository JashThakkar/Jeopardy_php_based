<?php
session_start();

$cat = $_POST['category'];
$val = $_POST['value'];
$team = intval($_POST['team']);
$answer = trim($_POST['answer']);


$wager = isset($_POST['wager']) ? intval($_POST['wager']) : 0;

$correct = $_SESSION['board'][$cat][$val]['answer'];

$_SESSION['answered'][$cat][$val] = true;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Award Points?</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="top_bar">
    <h1>Award Points?</h1>
</div>

<br><br>

<div style="font-size: 1.5rem;">
    <p><strong>Team <?= $team ?>'s Answer:</strong> <?= htmlspecialchars($answer) ?></p>
    <p><strong>Correct Answer:</strong> <?= htmlspecialchars($correct) ?></p>
    
    <!-- Show the wager if it exists so the host knows the stakes -->
    <?php if ($wager > 0): ?>
        <p style="color: gold;"><strong>Wager:</strong> $<?= $wager ?></p>
    <?php endif; ?>
</div>

<br><br>

<form action="award_points.php" method="POST">
    <input type="hidden" name="category" value="<?= $cat ?>">
    <input type="hidden" name="value" value="<?= $val ?>">
    <input type="hidden" name="team" value="<?= $team ?>">
    <input type="hidden" name="answer" value="<?= htmlspecialchars($answer) ?>">
    
    <!-- Pass the wager to the scoring page -->
    <input type="hidden" name="wager" value="<?= $wager ?>">

    <button type="submit" name="award" value="yes" class="award_yes">YES</button>
    <button type="submit" name="award" value="no" class="award_no">NO</button>

</form>

</body>
</html>