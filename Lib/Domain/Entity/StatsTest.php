<?php

use Lib\Domain\Entity\StatPoints;
use Lib\Domain\Entity\Stats;
use PHPUnit\Framework\TestCase;

class StatsTest extends TestCase
{
    public function testGetTotalPoints()
    {
        $stats = new Stats(1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 3);

        $actual = $stats->getTotalPoints();

        $this->assertEquals(5, $actual);
    }

    public function testGetGreatestStats()
    {
        $stats = new Stats(1, 1, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 3);

        $expected = [
            new StatPoints('force', 3),
            new StatPoints('fire', 2)
        ];

        $actual = $stats->getGreatestStats();

        $this->assertCount(2, $actual);
        $this->assertEquals($expected, $actual);
    }

    public function testGetGreatestStatsWithOnlyOneStat()
    {
        $stats = new Stats(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3);
        
        $expected = [new StatPoints('force', 3)];

        $actual = $stats->getGreatestStats();

        $this->assertCount(1, $actual);
        $this->assertEquals($expected, $actual);
    }

    public function testGetGreatestStatsWithNoStats()
    {
        $stats = new Stats(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

        $actual = $stats->getGreatestStats();

        $this->assertCount(0, $actual);
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
