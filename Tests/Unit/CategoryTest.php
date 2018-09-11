<?php

namespace Tests\Unit;

use Game\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{

    /**
     * @test
     */
    public function constructor_givenCategoryParameters_setsProperFields()
    {
        $category = new Category('Pop', 1, [1, 2, 3]);

        $this->assertEquals('Pop', $category->getName());
        $this->assertEquals(1, $category->getScore());
        $this->assertEquals([1, 2, 3], $category->getLocations());
    }

    /**
     * @test
     */
    public function getNextQuestion_returnsNextQuestion()
    {
        $category = new Category('Pop', 1, [1, 2, 3]);
        $nextQuestion = $category->getNextQuestion();
        $this->assertEquals('Pop Question 0', $nextQuestion);
    }

    /**
     * @test
     */
    public function getNextQuestion_firstQuestionAlreadyAsked_returnsNextQuestion()
    {
        $category = new Category('Pop', 1, [1, 2, 3]);
        $category->getNextQuestion();
        $nextQuestion = $category->getNextQuestion();
        $this->assertEquals('Pop Question 1', $nextQuestion);
    }

}