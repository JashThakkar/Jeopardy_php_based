<?php

session_start();


include 'game_questions.php';


if (!isset($final_jeopardy)) {
    die("ERROR: Final Jeopardy question data not found!");
}


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    
    if (!isset($_SESSION['fj_wagers']) && !isset($_SESSION['fj_graded'])) {
        unset($_SESSION['fj_wagers']);
        unset($_SESSION['fj_graded']);
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $temp_wagers = [];
    
    
    foreach ($_SESSION['team_names'] as $num => $name) {
        if (isset($_POST["wager_$num"])) {
            $temp_wagers[$num] = intval($_POST["wager_$num"]);
        } else {
            $temp_wagers[$num] = 0;
        }
    }
    
    if (!empty($temp_wagers)) {
        $_SESSION['fj_wagers'] = $temp_wagers;
    }
}

$showQuestion = isset($_SESSION['fj_wagers']);
$wagers = $_SESSION['fj_wagers'] ?? [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Final Jeopardy</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        .fj-category {
            font-size: 2rem;
            color: #ffca3a;
            margin: 30px 0;
            text-shadow: 2px 2px 4px #000;
        }
        .fj-question {
            font-size: 2.5rem;
            line-height: 1.5;
            padding: 40px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            margin: 20px auto;
            max-width: 800px;
            border: 3px solid #ffca3a;
        }
        .wager-box {
            margin: 20px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            display: inline-block;
            border-radius: 10px;
            backdrop-filter: blur(5px);
            min-width: 250px;
        }
        .grading-box {
            border: 2px solid #ccc;
            padding: 20px;
            margin: 15px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            display: inline-block;
            min-width: 280px;
        }
        .wager-amount {
            color: gold;
            font-size: 1.3rem;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="top_bar">
    <h1>Final Jeopardy<?= $showQuestion ? "" : ": Betting Round" ?></h1>
</div>

<br><br>

<div style="text-align:center; width: 85%; margin: auto;">
    
  
    <?php if (!$showQuestion): ?>
        
        <div class="fj-category">
            <strong>Category:</strong> <?= htmlspecialchars($final_jeopardy['category']) ?>
        </div>
        
        <p style="font-size: 1.3rem; margin: 20px 0;">
            Teams, place your wagers! You can bet up to your current score (or $1000 minimum).
        </p>
        
        <form action="final_jeopardy.php" method="POST">
            <?php foreach ($_SESSION['team_names'] as $num => $name): ?>
                <div class="wager-box">
                    <h3 style="margin-top: 0;">Team <?= $num ?>: <?= htmlspecialchars($name) ?></h3>
                    <p style="font-size: 1.2rem;">Current Score: <strong>$<?= $_SESSION['scores'][$num] ?></strong></p>
                    
                    <?php 
                    
                    $maxWager = max(1000, $_SESSION['scores'][$num]); 
                    ?>
                    
                    <label style="font-size: 1.1rem;">Wager Amount:</label><br>
                    <input type="number" 
                           name="wager_<?= $num ?>" 
                           max="<?= $maxWager ?>" 
                           min="0" 
                           value="0" 
                           style="padding: 10px; font-size: 1.1rem; width: 150px; margin-top: 10px;"
                           required>
                    <p style="font-size: 0.9rem; color: #aaa; margin-top: 5px;">
                        (Max: $<?= number_format($maxWager) ?>)
                    </p>
                </div>
            <?php endforeach; ?>
            
            <br><br>
            <button class="submit_button" style="font-size: 1.5rem; padding: 18px 40px;">
                Reveal Question
            </button>
        </form>

    <?php else: ?>

        <div class="fj-category">
            Category: <?= htmlspecialchars($final_jeopardy['category']) ?>
        </div>

        <div class="fj-question">
            <?= htmlspecialchars($final_jeopardy['text']) ?>
        </div>
        
        <br>
        <h3 style="font-size: 1.8rem;">Grading Phase</h3>
        <p style="font-size: 1.2rem;">Mark each team's answer as Correct or Wrong.</p>

        <div style="display:flex; flex-wrap:wrap; justify-content:center; margin-top: 30px;">
            <?php foreach ($_SESSION['team_names'] as $num => $name): ?>
                <div class="grading-box">
                    <h4 style="font-size: 1.3rem; margin-top: 0;">
                        Team <?= $num ?>: <?= htmlspecialchars($name) ?>
                    </h4>
                    <p style="font-size: 1.1rem;">
                        Current Score: <strong>$<?= number_format($_SESSION['scores'][$num]) ?></strong>
                    </p>
                    <p class="wager-amount">
                        Wagered: $<?= number_format($wagers[$num]) ?>
                    </p>
                    
                    <form method="POST" action="award_points.php" style="margin-top: 15px;">
                        <input type="hidden" name="category" value="Final Jeopardy">
                        <input type="hidden" name="value" value="0">
                        <input type="hidden" name="wager" value="<?= $wagers[$num] ?>">
                        <input type="hidden" name="team" value="<?= $num ?>">
                        
                        <button name="award" 
                                value="yes" 
                                class="submit_button" 
                                style="background:#28a745; margin: 5px; padding: 12px 25px; font-size: 1rem;">
                            Correct
                        </button>
                        <button name="award" 
                                value="no" 
                                class="submit_button" 
                                style="background:#dc3545; margin: 5px; padding: 12px 25px; font-size: 1rem;">
                            Wrong
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

        <br><br>
        
        <div style="margin: 30px auto; max-width: 600px;">
            <button 
                id="revealAnswerBtn" 
                class="submit_button" 
                onclick="document.getElementById('correctAnswer').style.display='block'; this.style.display='none';"
                style="background: #ffca3a; color: black; font-size: 1.2rem; padding: 15px 35px;">
                Reveal Correct Answer
            </button>
            
            <div id="correctAnswer" style="display: none; padding: 20px; background: rgba(0,0,0,0.3); border-radius: 10px; border: 2px solid #ffca3a; margin-top: 15px;">
                <h4 style="color: #ffca3a; margin-top: 0;">Correct Answer:</h4>
                <p style="font-size: 1.3rem; color: #fff;">
                    <?= htmlspecialchars($final_jeopardy['answer']) ?>
                </p>
            </div>
        </div>

        <br>
        <form action="game_over.php" method="POST">
            <button class="submit_button" style="background:gold; color:black; font-size: 1.8rem; padding: 20px 50px; box-shadow: 0 0 20px rgba(255, 215, 0, 0.5);">
                FINISH GAME
            </button>
        </form>

    <?php endif; ?>

</div>

</body>
</html>