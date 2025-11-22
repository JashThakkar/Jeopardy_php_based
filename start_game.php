<?php
session_start();

include 'game_questions.php';

$_SESSION['board'] = [];
$_SESSION['scores'] = [];
$_SESSION['answered'] = [];
$_SESSION['player_count'] = intval($_POST['playerCount']);
$_SESSION['team_names'] = [];

for ($i = 1; $i <= $_SESSION['player_count']; $i++) {
    $_SESSION['team_names'][$i] = $_POST["team_name_$i"];
}
for ($i = 1; $i <= $_SESSION['player_count']; $i++) {
    $_SESSION['scores'][$i] = 0;
}

$pointValues = [100, 250, 500, 1000];

foreach ($categories as $category) {
    $catQuestions = $questions[$category];
    shuffle($catQuestions);
    foreach ($pointValues as $i => $value) {
        $_SESSION['board'][$category][$value] = $catQuestions[$i];
    }
}

header("Location: game_page.php");
exit;
