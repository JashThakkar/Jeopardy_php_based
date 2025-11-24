<?php
session_start();

$category = $_POST['category'];
$value = $_POST['value'];


$question = $_SESSION['board'][$category][$value];


$isDD = false;
if (isset($_SESSION['daily_double']) && 
    $_SESSION['daily_double']['category'] === $category && 
    $_SESSION['daily_double']['value'] == $value) {
    $isDD = true;
}

<<<<<<< HEAD
=======

>>>>>>> 11cb8c9e8a80a8e2919b1c1bdc9552f42ac3d34f
$wager = isset($_POST['wager_amount']) ? intval($_POST['wager_amount']) : 0;
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

<<<<<<< HEAD
=======


>>>>>>> 11cb8c9e8a80a8e2919b1c1bdc9552f42ac3d34f
<?php if ($isDD && $wager === 0): ?>
    
    <div style="text-align: center; border: 4px dashed gold; padding: 20px; width: 60%; margin: auto;">
        <h2 style="color: gold; font-size: 3rem; animation: blink 1s infinite;">DAILY DOUBLE!</h2>
        <p>Make your wager (Max: 1000 or Highest Score)</p>
        
<<<<<<< HEAD
=======
       
>>>>>>> 11cb8c9e8a80a8e2919b1c1bdc9552f42ac3d34f
        <form method="POST" action="question.php">
            <input type="hidden" name="category" value="<?= $category ?>">
            <input type="hidden" name="value" value="<?= $value ?>">
            <input type="number" name="wager_amount" min="1" required class="answer_input">
            <br><br>
            <button class="submit_button">Set Wager</button>
        </form>
    </div>

<?php else: ?>
   
    <h2><?= htmlspecialchars($question['text']); ?></h2>

    <br>

    <form method="POST" action="submit_answer.php">
        <input type="hidden" name="category" value="<?= $category ?>">
        <input type="hidden" name="value" value="<?= $value ?>">
        
<<<<<<< HEAD
=======
        
>>>>>>> 11cb8c9e8a80a8e2919b1c1bdc9552f42ac3d34f
        <input type="hidden" name="wager" value="<?= $wager ?>">

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
    
<?php endif; ?>

<style>

@keyframes blink { 50% { opacity: 0.5; } }
</style>

</body>
</html>