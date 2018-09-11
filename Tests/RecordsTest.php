<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class RecordsTest extends TestCase
{
    /**
     * @test
     */
    public function recordsEquality()
    {
        for ($seed = 4; $seed < 12; $seed++) {
            $content = shell_exec('php -r "require \'vendor/autoload.php\'; srand(' . $seed . '); require \'src/play_legacy_game.php\';"');
            $this->assertEquals(file_get_contents('./Records/Legacy/Seed_' . $seed), $content);
            $content = shell_exec('php -r "require \'vendor/autoload.php\'; srand(' . $seed . '); require \'src/play_legacy_game_can_leave_penalty_box.php\';"');
            $this->assertEquals(file_get_contents('./Records/CanLeavePenaltyBox/Seed_' . $seed), $content);
        }
    }
}