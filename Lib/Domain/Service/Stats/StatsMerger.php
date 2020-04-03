<?php

namespace Lib\Domain\Service\Stats;

use InvalidArgumentException;
use Lib\Domain\Entity\Stats;

class StatsMerger
{
    /**
     * @param Stats[] $stats
     *
     * @return Stats|null
     */
    public static function mergeStats(array $stats_array): ?Stats
    {
        if (empty($stats_array)) {
            throw new InvalidArgumentException('must have at least one element in $stats_array');
        }

        $combined_stats = array_reduce($stats_array, function (array $carry, Stats $stats) {
            $carry['bludgeoning'] += $stats->getBludgeoning();
            $carry['slashing'] += $stats->getSlashing();
            $carry['piercing'] += $stats->getPiercing();
            $carry['fire'] += $stats->getFire();
            $carry['cold'] += $stats->getCold();
            $carry['poison'] += $stats->getPoison();
            $carry['acid'] += $stats->getAcid();
            $carry['psychic'] += $stats->getPsychic();
            $carry['necrotic'] += $stats->getNecrotic();
            $carry['radiant'] += $stats->getRadiant();
            $carry['lightning'] += $stats->getLightning();
            $carry['thunder'] += $stats->getThunder();
            $carry['force'] += $stats->getForce();

            return $carry;
        }, [
            'bludgeoning' => 0,
            'slashing' => 0,
            'piercing' => 0,
            'fire' => 0,
            'cold' => 0,
            'poison' => 0,
            'acid' => 0,
            'psychic' => 0,
            'necrotic' => 0,
            'radiant' => 0,
            'lightning' => 0,
            'thunder' => 0,
            'force' => 0
        ]);

        return Stats::fromArray($combined_stats);
    }
}
