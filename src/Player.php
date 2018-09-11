<?php

namespace Game;

class Player
{
    private $name;
    private $score = 0;
    private $location = 0;
    private $isInPenalty = false;
    private $isGettingOutOfPenalty = false;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setScore($score)
    {
        $this->score = $score;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function setPenalty($isInPenalty)
    {
        $this->isInPenalty = $isInPenalty;
    }

    public function setCanComeOutOfPenalty($isGettingOutOfPenalty)
    {
        $this->isGettingOutOfPenalty = $isGettingOutOfPenalty;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return int
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @return bool
     */
    public function isInPenalty()
    {
        return $this->isInPenalty;
    }

    /**
     * @return bool
     */
    public function isGettingOutOfPenalty()
    {
        return $this->isGettingOutOfPenalty;
    }

}