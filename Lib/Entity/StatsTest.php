<?php

use Lib\Entity\Stats;
use PHPUnit\Framework\TestCase;

class StatsTest extends TestCase
{
    public function testGetTotalPoints()
    {
        $stats = new Stats(1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 3);

        $actual = $stats->getTotalPoints();

        $this->assertEquals(5, $actual);
    }

    public function testGetGreatestStat()
    {
        $stats = new Stats(1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 3);

        [$name, $points] = $stats->getGreatestStat();

        $this->assertEquals('force', $name);
        $this->assertEquals(3, $points);
    }

    public function testHasSufficientPoints()
    {
        $stats = new Stats(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3);

        $hasSufficientPoints = $stats->hasSufficientPoints('force', 4);

        $this->assertTrue($hasSufficientPoints);
    }
    public function testHasSufficientPointsNotEnoughPoints()
    {
        $stats = new Stats(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5);

        $hasSufficientPoints = $stats->hasSufficientPoints('force', 4);

        $this->assertFalse($hasSufficientPoints);
    }

    public function testHasSufficientPointsStatIsZero()
    {
        $stats = new Stats(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

        $hasSufficientPoints = $stats->hasSufficientPoints('force', 4);

        $this->assertFalse($hasSufficientPoints);  
    }
}
