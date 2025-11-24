<?php
// filename: award_points.php
session_start();

$cat = $_POST['category'];
$val = $_POST['value'];
$team = intval($_POST['team']);
$award = $_POST['award'];

// Wager overrides value logic
$wager = isset($_POST['wager']) ? intval($_POST['wager']) : 0;
if ($wager > 0) {
    $val = $wager;
}

if (!isset($_SESSION['correct'])) $_SESSION['correct'] = [];
if (!isset($_SESSION['wrong']))   $_SESSION['wrong'] = [];
if (!isset($_SESSION['cat_streaks'])) $_SESSION['cat_streaks'] = [];

if ($award === "yes") {
    $_SESSION['scores'][$team] += $val;
    $_SESSION['correct'][$team] = ($_SESSION['correct'][$team] ?? 0) + 1;
    
    // Category Mastery Logic
    if ($cat !== 'Final Jeopardy') {
        if (!isset($_SESSION['cat_streaks'][$team][$cat])) {
            $_SESSION['cat_streaks'][$team][$cat] = 0;
        }
        $_SESSION['cat_streaks'][$team][$cat]++;

        if ($_SESSION['cat_streaks'][$team][$cat] >= 3) {
            $bonus = 1000;
            $_SESSION['scores'][$team] += $bonus;
            $_SESSION['last_message'] = "Team $team awarded +$val points plus Category Mastery Bonus!";
            $_SESSION['cat_streaks'][$team][$cat] = 0; 
        } else {
            $_SESSION['last_message'] = "Team $team awarded +$val points!";
        }
    } else {
        $_SESSION['last_message'] = "Team $team Final Jeopardy Correct!";
    }

} else {
    $_SESSION['wrong'][$team] = ($_SESSION['wrong'][$team] ?? 0) + 1;
    if ($cat !== 'Final Jeopardy') {
        $_SESSION['cat_streaks'][$team][$cat] = 0;
    }

    // Risk Management (Deduct if Wager)
    if ($wager > 0) {
        $_SESSION['scores'][$team] -= $val;
        $_SESSION['last_message'] = "Wager lost! Team $team deducted $val points.";
    } else {
        $_SESSION['last_message'] = "No points awarded.";
    }
}


if ($cat === 'Final Jeopardy') {

    if (!isset($_SESSION['fj_graded'])) {
        $_SESSION['fj_graded'] = [];
    }
    $_SESSION['fj_graded'][$team] = true;
    
    s
    header("Location: final_jeopardy.php");
} else {

    header("Location: game_page.php");
}
exit;