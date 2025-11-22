<?php
session_start();

$category = $_POST['category'];
$value = $_POST['value'];

$question = $_SESSION['board'][$category][$value];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Question</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="top_bar">
    <h1><?= htmlspecialchars($category) ?> - <?= $value ?></h1>
</div>

<br>

<h2><?= htmlspecialchars($question['text']); ?></h2>

<br>

<form method="POST" action="submit_answer.php">
    <input type="hidden" name="category" value="<?= $category ?>">
    <input type="hidden" name="value" value="<?= $value ?>">

    <p>Select team answering:</p>

    <select name="team" required>
        <?php foreach ($_SESSION['team_names'] as $teamNum => $teamName): ?>
            <option value="<?= $teamNum ?>">Team <?= $teamNum ?> (<?= htmlspecialchars($teamName) ?>)</option>
        <?php endforeach; ?>
    </select>

    <br><br>

    <input type="text" name="answer" placeholder="Your answer..." required>

    <br><br>

    <button type="submit" class="submit_button">Submit Answer</button>
</form>

</body>
</html>
