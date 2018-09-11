<?php

namespace Game;

class Game {
    private $players;
    private $places;
    private $purses ;
    private $inPenaltyBox ;

    private $currentPlayer = 0;
    private $isGettingOutOfPenaltyBox;
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
        $this->places = array(0);
        $this->purses  = array(0);
        $this->inPenaltyBox  = array(0);

        $this->categories = $categories;
        $this->options = array_merge(self::DEFAULT_CONFIG, $options);
    }


    private function echoln($string) {
        echo $string."\n";
    }

    public function add($playerName) {
        array_push($this->players, $playerName);
        $this->places[$this->howManyPlayers()] = 0;
        $this->purses[$this->howManyPlayers()] = 0;
        $this->inPenaltyBox[$this->howManyPlayers()] = false;

        $this->echoln($playerName . " was added");
        $this->echoln("They are player number " . count($this->players));
        return true;
    }

    private function howManyPlayers() {
        return count($this->players);
    }

    public function roll($roll) {
        $this->echoln($this->players[$this->currentPlayer] . " is the current player");
        $this->echoln("They have rolled a " . $roll);

        if ($this->inPenaltyBox[$this->currentPlayer]) {
            if ($roll % 2 != 0) {
                $this->isGettingOutOfPenaltyBox = true;

                $this->echoln($this->players[$this->currentPlayer] . " is getting out of the penalty box");
                $this->movePlayer($roll);

                $this->announcePlayerLocation();
                $this->announceCurrentCategory();
                $this->askQuestion();
            } else {
                $this->echoln($this->players[$this->currentPlayer] . " is not getting out of the penalty box");
                $this->isGettingOutOfPenaltyBox = false;
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
        return $this->categories->getByLocation($this->places[$this->currentPlayer]);
    }

    public function wasCorrectlyAnswered() {
        if ($this->inPenaltyBox[$this->currentPlayer]){
            if ($this->isGettingOutOfPenaltyBox) {
                if ($this->options['CAN_LEAVE_PENALTY_BOX']) {
                    $this->inPenaltyBox[$this->currentPlayer] = false;
                }

                $this->announceAnswerIsCorrect();
                $this->increasePlayersScore();
                $this->announcePlayerScore();

                $winner = $this->didPlayerWin();
                $this->currentPlayer++;
                if ($this->currentPlayer == count($this->players)) $this->currentPlayer = 0;

                return $winner;
            } else {
                $this->currentPlayer++;
                if ($this->currentPlayer == count($this->players)) $this->currentPlayer = 0;
                return true;
            }



        } else {

            $this->announceAnswerIsCorrect();
            $this->increasePlayersScore();
            $this->announcePlayerScore();

            $winner = $this->didPlayerWin();
            $this->currentPlayer++;
            if ($this->currentPlayer == count($this->players)) $this->currentPlayer = 0;

            return $winner;
        }
    }

    public function wrongAnswer(){
        $this->echoln("Question was incorrectly answered");
        $this->echoln($this->players[$this->currentPlayer] . " was sent to the penalty box");
        $this->inPenaltyBox[$this->currentPlayer] = true;

        $this->currentPlayer++;
        if ($this->currentPlayer == count($this->players)) $this->currentPlayer = 0;
        return true;
    }

    private function didPlayerWin() {
        return !($this->purses[$this->currentPlayer] == 6);
    }

    private function movePlayer($roll)
    {
        $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] + $roll;
        if ($this->places[$this->currentPlayer] > 11) $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] - 12;
    }

    private function announcePlayerLocation()
    {
        $this->echoln($this->players[$this->currentPlayer]
            . "'s new location is "
            . $this->places[$this->currentPlayer]);
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
        $this->purses[$this->currentPlayer] += $this->currentCategory()->getScore();
    }

    private function announcePlayerScore()
    {
        $this->echoln($this->players[$this->currentPlayer]
            . " now has "
            . $this->purses[$this->currentPlayer]
            . " Gold Coins.");
    }
}