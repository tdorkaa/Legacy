<?php

namespace Tests\Unit;

use Game\Player;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    /**
     * @test
     */
    public function constructor_givenPlayerParameters_setsProperFields()
    {
        $player = new Player('name');
        $this->assertEquals('name', $player->getName());
    }

}