<?php

use Lib\Entity\Stats;
use Lib\Service\Stats\StatsMerger;
use PHPUnit\Framework\TestCase;

class StatsMergerTest extends TestCase
{
    public function testMergeStats()
    {
        $stat_1 = new Stats(1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2);
        $stat_2 = new Stats(1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2);

        $expected = new Stats(2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4);

        $actual = StatsMerger::mergeStats([$stat_1, $stat_2]);
        $this->assertEquals($expected, $actual);
    }

    public function testMergeStatsWithOneStat()
    {
        $stat = new Stats(1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

        $expected = new Stats(1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

        $actual = StatsMerger::mergeStats([$stat]);
        $this->assertEquals($expected, $actual);
    }
}
