<?php

namespace Game;

class Game {
    var $players;
    var $places;
    var $purses ;
    var $inPenaltyBox ;

    var $currentPlayer = 0;
    var $isGettingOutOfPenaltyBox;
    /**
     * @var Category[]
     */
    private $categories;

    /**
     * Game constructor.
     * @param $categories Category[]
     */
    function  __construct($categories){
        $this->players = array();
        $this->places = array(0);
        $this->purses  = array(0);
        $this->inPenaltyBox  = array(0);

        $this->categories = $categories;
    }


    function echoln($string) {
        echo $string."\n";
    }

    function isPlayable() {
        return ($this->howManyPlayers() >= 2);
    }

    function add($playerName) {
        array_push($this->players, $playerName);
        $this->places[$this->howManyPlayers()] = 0;
        $this->purses[$this->howManyPlayers()] = 0;
        $this->inPenaltyBox[$this->howManyPlayers()] = false;

        $this->echoln($playerName . " was added");
        $this->echoln("They are player number " . count($this->players));
        return true;
    }

    function howManyPlayers() {
        return count($this->players);
    }

    function  roll($roll) {
        $this->echoln($this->players[$this->currentPlayer] . " is the current player");
        $this->echoln("They have rolled a " . $roll);

        if ($this->inPenaltyBox[$this->currentPlayer]) {
            if ($roll % 2 != 0) {
                $this->isGettingOutOfPenaltyBox = true;

                $this->echoln($this->players[$this->currentPlayer] . " is getting out of the penalty box");
                $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] + $roll;
                if ($this->places[$this->currentPlayer] > 11) $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] - 12;

                $this->echoln($this->players[$this->currentPlayer]
                    . "'s new location is "
                    .$this->places[$this->currentPlayer]);
                $this->echoln("The category is " . $this->currentCategory()->getName());
                $this->askQuestion();
            } else {
                $this->echoln($this->players[$this->currentPlayer] . " is not getting out of the penalty box");
                $this->isGettingOutOfPenaltyBox = false;
            }

        } else {

            $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] + $roll;
            if ($this->places[$this->currentPlayer] > 11) $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] - 12;

            $this->echoln($this->players[$this->currentPlayer]
                . "'s new location is "
                .$this->places[$this->currentPlayer]);
            $this->echoln("The category is " . $this->currentCategory()->getName());
            $this->askQuestion();
        }

    }

    function  askQuestion() {
        $this->echoln($this->currentCategory()->getNextQuestion());
    }


    function currentCategory() {
        $playerPlace = $this->places[$this->currentPlayer];

        foreach ($this->categories as $category) {
            if (in_array($playerPlace, $category->getLocations())) {
                return $category;
            }
        }

        return null;
    }

    function wasCorrectlyAnswered() {
        if ($this->inPenaltyBox[$this->currentPlayer]){
            if ($this->isGettingOutOfPenaltyBox) {
                $this->echoln("Answer was correct!!!!");
                $this->purses[$this->currentPlayer] += $this->currentCategory()->getScore();
                $this->echoln($this->players[$this->currentPlayer]
                    . " now has "
                    .$this->purses[$this->currentPlayer]
                    . " Gold Coins.");

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

            $this->echoln("Answer was corrent!!!!");
            $this->purses[$this->currentPlayer] += $this->currentCategory()->getScore();
            $this->echoln($this->players[$this->currentPlayer]
                . " now has "
                .$this->purses[$this->currentPlayer]
                . " Gold Coins.");

            $winner = $this->didPlayerWin();
            $this->currentPlayer++;
            if ($this->currentPlayer == count($this->players)) $this->currentPlayer = 0;

            return $winner;
        }
    }

    function wrongAnswer(){
        $this->echoln("Question was incorrectly answered");
        $this->echoln($this->players[$this->currentPlayer] . " was sent to the penalty box");
        $this->inPenaltyBox[$this->currentPlayer] = true;

        $this->currentPlayer++;
        if ($this->currentPlayer == count($this->players)) $this->currentPlayer = 0;
        return true;
    }


    function didPlayerWin() {
        return !($this->purses[$this->currentPlayer] == 6);
    }
}