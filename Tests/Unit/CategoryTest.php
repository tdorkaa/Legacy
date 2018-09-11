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

    /**
     * @test
     */
    public function staticCreateBulk_givenCategoryParams_returnsArrayOfCategories()
    {
        $categories = Category::createBulk([
            ['Pop', 1, [1, 2, 3]],
            ['Science', 2, [4, 5, 6]],
        ]);
        $this->assertEquals([
            new Category('Pop', 1, [1, 2, 3]),
            new Category('Science', 2, [4, 5, 6]),
        ], $categories);
    }

}