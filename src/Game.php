<?php

namespace Game;

class Game {
    private $players;

    private $currentPlayerIndex = 0;
    /**
     * @var Player
     */
    private $currentPlayer;
    /**
     * @var CategoryCollection
     */
    private $categories;
    private $options;

    const DEFAULT_CONFIG = [
        'CAN_LEAVE_PENALTY_BOX' => false
    ];

    /**
     * Game constructor.
     * @param $categories CategoryCollection
     * @param array $options
     */
    public function  __construct($categories, $options = [])
    {
        $this->players = array();

        $this->categories = $categories;
        $this->options = array_merge(self::DEFAULT_CONFIG, $options);
    }


    private function echoln($string) {
        echo $string."\n";
    }

    public function add(Player $player) {
        array_push($this->players, $player);

        $this->echoln($player->getName() . " was added");
        $this->echoln("They are player number " . count($this->players));
        return true;
    }

    public function roll($roll) {
        if ($this->currentPlayer === null) {
            $this->currentPlayer = $this->players[0];
        }

        $this->echoln($this->currentPlayer->getName() . " is the current player");
        $this->echoln("They have rolled a " . $roll);

        if ($this->currentPlayer->isInPenalty()) {
            if ($roll % 2 != 0) {
                $this->currentPlayer->setCanComeOutOfPenalty(true);

                $this->echoln($this->currentPlayer->getName() . " is getting out of the penalty box");
                $this->movePlayer($roll);

                $this->announcePlayerLocation();
                $this->announceCurrentCategory();
                $this->askQuestion();
            } else {
                $this->echoln($this->currentPlayer->getName() . " is not getting out of the penalty box");
                $this->currentPlayer->setCanComeOutOfPenalty(false);
            }

        } else {

            $this->movePlayer($roll);

            $this->announcePlayerLocation();
            $this->announceCurrentCategory();
            $this->askQuestion();
        }

    }

    private function askQuestion() {
        $this->echoln($this->currentCategory()->getNextQuestion());
    }


    private function currentCategory() {
        return $this->categories->getByLocation($this->currentPlayer->getLocation());
    }

    public function wasCorrectlyAnswered() {
        if ($this->currentPlayer->isInPenalty()){
            if ($this->currentPlayer->isGettingOutOfPenalty()) {
                if ($this->options['CAN_LEAVE_PENALTY_BOX']) {
                    $this->currentPlayer->setPenalty(false);
                }

                $this->announceAnswerIsCorrect();
                $this->increasePlayersScore();
                $this->announcePlayerScore();

                $winner = $this->didPlayerWin();
                $this->setNextPlayer();

                return $winner;
            } else {
                $this->setNextPlayer();
                return true;
            }



        } else {

            $this->announceAnswerIsCorrect();
            $this->increasePlayersScore();
            $this->announcePlayerScore();

            $winner = $this->didPlayerWin();
            $this->setNextPlayer();

            return $winner;
        }
    }

    public function wrongAnswer(){
        $this->echoln("Question was incorrectly answered");
        $this->echoln($this->currentPlayer->getName() . " was sent to the penalty box");
        $this->currentPlayer->setPenalty(true);

        $this->setNextPlayer();
        return true;
    }

    private function didPlayerWin() {
        return !($this->currentPlayer->getScore() >= 6);
    }

    private function movePlayer($roll)
    {
        $this->currentPlayer->setLocation(
            $this->currentPlayer->getLocation() + $roll
        );

        if ($this->currentPlayer->getLocation() > 11) {
            $this->currentPlayer->setLocation(
                $this->currentPlayer->getLocation() - 12
            );
        }
    }

    private function announcePlayerLocation()
    {
        $this->echoln($this->currentPlayer->getName()
            . "'s new location is "
            . $this->currentPlayer->getLocation());
    }

    private function announceCurrentCategory()
    {
        $this->echoln("The category is " . $this->currentCategory()->getName());
    }

    private function announceAnswerIsCorrect()
    {
        $this->echoln("Answer was correct!!!!");
    }

    private function increasePlayersScore()
    {
        $this->currentPlayer->setScore(
            $this->currentPlayer->getScore() + $this->currentCategory()->getScore()
        );
    }

    private function announcePlayerScore()
    {
        $this->echoln($this->currentPlayer->getName()
            . " now has "
            . $this->currentPlayer->getScore()
            . " Gold Coins.");
    }

    private function setNextPlayer()
    {
        $this->currentPlayerIndex++;
        if ($this->currentPlayerIndex == count($this->players)) $this->currentPlayerIndex = 0;
        $this->currentPlayer = $this->players[$this->currentPlayerIndex];
    }
}