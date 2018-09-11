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
            $content = shell_exec('php -r "srand(' . $seed . '); require \'src/GameRunner.php\';"');
            $this->assertEquals(file_get_contents('./Records/Seed_' . $seed), $content);
        }
    }
}