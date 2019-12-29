<?php

namespace Lib\Service;

use Lib\Entity\Word;

class WeaponEffectsService
{
    public function generateEffects(Word $prefix, Word $noun, Word $suffix)
    {
        // Get the highest stat
        $highest_stat = $this->getGreatestStat($prefix, $noun, $suffix);

        // Determine primary damage type
        // Determine Primary damage die.
        // Determine number of damage dice

        return [];
    }

    private function getGreatestStat(Word $prefix, Word $noun, Word $suffix): array
    {
        $stats_array = array_reduce([$prefix, $noun, $suffix], function (array $carry, Word $word) {
            $carry[Word::BLUDGEONING] += $word->getBludgeoning();
            $carry[Word::SLASHING] += $word->getSlashing();
            $carry[Word::PIERCING] += $word->getPiercing();
            $carry[Word::FIRE] += $word->getFire();
            $carry[Word::COLD] += $word->getCold();
            $carry[Word::POISON] += $word->getPoison();
            $carry[Word::ACID] += $word->getAcid();
            $carry[Word::PSYCHIC] += $word->getPsychic();
            $carry[Word::NECROTIC] += $word->getNecrotic();
            $carry[Word::RADIANT] += $word->getRadiant();
            $carry[Word::LIGHTNING] += $word->getLightning();
            $carry[Word::THUNDER] += $word->getThunder();
            $carry[Word::FORCE] += $word->getForce();
            return $carry;
        }, []);

        // Get the greatest stat
        arsort($stats_array);
        $first = array_key_first($stats_array);

        return $stats_array[$first];
    }
}