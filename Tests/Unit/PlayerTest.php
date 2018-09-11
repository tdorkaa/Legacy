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

    /**
     * @test
     */
    public function setters_givenValues_gettersReturnThoseValues()
    {
        $player = new Player('name');

        $player->setScore(10);
        $player->setLocation(6);
        $player->setPenalty(true);
        $player->setCanComeOutOfPenalty(true);

        $this->assertEquals(10, $player->getScore());
        $this->assertEquals(6, $player->getLocation());
        $this->assertEquals(true, $player->isInPenalty());
        $this->assertEquals(true, $player->isGettingOutOfPenalty());
    }

}