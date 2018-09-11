<?php

namespace Game;

class Category
{

    private $name;
    private $score;
    private $locations;
    private $questionNumber = 0;

    public function __construct($name, $score, $locations)
    {
        $this->name = $name;
        $this->score = $score;
        $this->locations = $locations;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return mixed
     */
    public function getLocations()
    {
        return $this->locations;
    }

    public function getNextQuestion()
    {
        $nextQuestion = "$this->name Question $this->questionNumber";
        $this->questionNumber++;
        return $nextQuestion;
    }

}