<?php
session_start();

$cat = $_POST['category'];
$val = $_POST['value'];
$team = intval($_POST['team']);
$award = $_POST['award'];

if (!isset($_SESSION['correct'])) $_SESSION['correct'] = [];
if (!isset($_SESSION['wrong']))   $_SESSION['wrong'] = [];

if ($award === "yes") {
    $_SESSION['scores'][$team] += $val;
    $_SESSION['correct'][$team] = ($_SESSION['correct'][$team] ?? 0) + 1;
    $_SESSION['last_message'] = "Team $team awarded +$val points!";
} else {
    $_SESSION['wrong'][$team] = ($_SESSION['wrong'][$team] ?? 0) + 1;
    $_SESSION['last_message'] = "No points awarded.";
}

header("Location: game_page.php");
exit;
