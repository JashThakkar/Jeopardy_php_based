<?php
session_start();

include 'game_questions.php';

$_SESSION = []; 
$_SESSION['player_count'] = intval($_POST['playerCount']);
$_SESSION['team_names'] = [];
$_SESSION['scores'] = [];

for ($i = 1; $i <= $_SESSION['player_count']; $i++) {
    $_SESSION['team_names'][$i] = $_POST["team_name_$i"];
    $_SESSION['scores'][$i] = 0;
}

$_SESSION['board'] = [];
$_SESSION['answered'] = [];
$pointValues = [100, 250, 500, 1000];

foreach ($categories as $category) {
    $catQuestions = $questions[$category];
    shuffle($catQuestions);
    foreach ($pointValues as $i => $value) {
        $_SESSION['board'][$category][$value] = $catQuestions[$i];
    }
}

<<<<<<< HEAD
=======



>>>>>>> 11cb8c9e8a80a8e2919b1c1bdc9552f42ac3d34f
$_SESSION['correct'] = [];
$_SESSION['wrong'] = [];
$_SESSION['cat_streaks'] = []; 

$randCat = $categories[array_rand($categories)];
$randVal = $pointValues[array_rand($pointValues)];

$_SESSION['daily_double'] = [
    'category' => $randCat,
    'value' => $randVal
];

header("Location: game_page.php");
exit;