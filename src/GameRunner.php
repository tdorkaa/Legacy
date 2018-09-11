<?php

namespace Game;

include __DIR__ . '/Game.php';

$aGame = new Game([
    new Category('Pop', 1, [0,4,8]),
    new Category('Science', 1, [1,5,9]),
    new Category('Sports', 1, [2,6,10]),
    new Category('Rock', 1, [3,7,11])
]);

$aGame->add("Chet");
$aGame->add("Pat");
$aGame->add("Sue");


do {

    $aGame->roll(rand(0,5) + 1);

    if (rand(0,9) == 7) {
        $notAWinner = $aGame->wrongAnswer();
    } else {
        $notAWinner = $aGame->wasCorrectlyAnswered();
    }



} while ($notAWinner);
