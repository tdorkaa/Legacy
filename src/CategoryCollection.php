<?php

namespace Game;

class CategoryCollection
{
    /**
     * @var Category[]
     */
    private $categories;

    public function __construct(Category ...$categories)
    {
        $this->categories = $categories;
    }

    public function getByLocation($location): ?Category
    {
        foreach ($this->categories as $category) {
            if (in_array($location, $category->getLocations())) {
                return $category;
            }
        }

        return null;
    }
}