<?php

namespace Tests\Unit;

use Game\Category;
use Game\CategoryCollection;
use PHPUnit\Framework\TestCase;

class CategoryCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function getByLocation_givenExistingLocation_returnsThatCategory()
    {
        $categories = new CategoryCollection(
            new Category('Pop', 1, [0,4,8]),
            new Category('Science', 1, [1,5,9]),
            new Category('Sports', 1, [2,6,10]),
            new Category('Rock', 1, [3,7,11])
        );

        $actual = $categories->getByLocation(6);

        $this->assertEquals('Sports', $actual->getName());
    }
}
