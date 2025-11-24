<?php
session_start();

if (!isset($_SESSION['board'])) {
    header("Location: index.php");
    exit;
}

$allUsed = true;
foreach ($_SESSION['board'] as $category => $values) {
    foreach ($values as $value => $q) {
        if (!($_SESSION['answered'][$category][$value] ?? false)) {
            $allUsed = false;
            break 2;
        }
    }
}

if ($allUsed) {   
    header("Location: final_jeopardy.php");
    exit;
}

$board = $_SESSION['board'];
$categories = array_keys($board);
$pointValues = [100, 250, 500, 1000];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Jeopardy Battle Arena</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>

<div class="top_bar">
    <h1>Jeopardy Battle Arena</h1>
</div>

<br><br>

<div style="width: 80%; margin: auto; display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">

    <?php foreach ($categories as $cat): ?>
        <div style="font-size: 1.5rem; font-weight: bold;">
            <?= htmlspecialchars($cat) ?>
            
            <?php
            if (isset($_SESSION['cat_streaks'])) {
                foreach ($_SESSION['cat_streaks'] as $team => $catData) {
                    if (isset($catData[$cat]) && $catData[$cat] >= 2) {
                        echo "<div style='font-size:0.8rem; color: orange;'>🔥 Team $team</div>";
                    }
                }
            }
            ?>
        </div>
    <?php endforeach; ?>

    <?php foreach ($pointValues as $value): ?>
        <?php foreach ($categories as $cat): ?>
            <?php $answered = $_SESSION['answered'][$cat][$value] ?? false; ?>
            <div>
                <?php if ($answered): ?>
                    <button disabled style="padding:20px;width:90%;background:#333;color:#999;border-radius:10px;">
                        USED
                    </button>
                <?php else: ?>
                    <form method="POST" action="question.php">
                        <input type="hidden" name="category" value="<?= $cat ?>">
                        <input type="hidden" name="value" value="<?= $value ?>">
                        <button type="submit" class="point_button">
                            <?= $value ?>
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>

</div>

<div class="team_display">
    <?php foreach ($_SESSION['team_names'] as $num => $name): ?>
        <div class="team_box">
            Team <?= $num ?>: <strong><?= htmlspecialchars($name) ?></strong>
            <br>
            Points: <strong><?= $_SESSION['scores'][$num] ?></strong>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>