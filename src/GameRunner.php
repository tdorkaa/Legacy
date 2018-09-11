<?php

namespace Game;

class GameRunner {

    /**
     * @var Game
     */
    private $game;

    public function __construct($players, CategoryCollection $categories, array $options = [])
    {
        $this->game = new Game($categories, $options);

        foreach ($players as $player) {
            $this->game->add(new Player($player));
        }
    }

    public function run()
    {
        $game = $this->game;

        do {
            $game->roll(rand(0,5) + 1);

            if (rand(0,9) == 7) {
                $notAWinner = $game->wrongAnswer();
            } else {
                $notAWinner = $game->wasCorrectlyAnswered();
            }
        } while ($notAWinner);
    }

}
