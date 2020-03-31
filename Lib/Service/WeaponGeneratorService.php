<?php

namespace Lib\Service;

use Lib\Entity\Effect;
use Lib\Entity\Stats;
use Lib\Service\Words\ReadWordsService;
use Lib\Service\Words\SortWordsService;
use Lib\Service\Effects\ReadEffectsService;
use Lib\Service\Stats\StatsMerger;
use Lib\Entity\Word;

class WeaponGeneratorService
{
    private const UNCOMMON = 'Uncommon';
    private const RARE = 'Rare';
    private const VERY_RARE = 'Very Rare';
    private const LEGENDARY = 'Legendary';
    private const ARTIFACT = 'Artifact';

    private const RARE_THRESHOLD = 9;
    private const VERY_RARE_THRESHOLD = 15;
    private const LEGENDARY_THRESHOLD = 22;
    private const ARTIFACT_THRESHOLD = 29;
    
    public function generateWeapon(): array
    {
        // Get the effects
        $effects = ReadEffectsService::readEffects();
        // Get a list of words
        $words = ReadWordsService::readWords();
        // Sort words into prefix, noun, and suffix
        $sorted_words = SortWordsService::sortWords($words);

        // Pick some random words
        $prefix = $this->pickRandomWord($sorted_words[Word::PREFIX]);
        $noun = $this->pickRandomWord($sorted_words[Word::NOUN]);
        $suffix = $this->pickRandomWord($sorted_words[Word::SUFFIX]);

        $name = $prefix->getName() . ' ' . $noun->getName() . ' ' . $suffix->getName();

        $stats_total = StatsMerger::mergeStats(
            [$prefix->getStats(), $noun->getStats(), $suffix->getStats()]
        );

        [$damage_type, $points] = $noun->getGreatestPhysicalStat();
        [$damage_die, $damage_die_amount] = $this->determineDamage($points);
        $rarity = $this->determineRarity($stats_total);
        $effect = $this->determineEffect($stats_total, $effects);

        return [
            'name' => $name,
            'rarity' => $rarity,
            'damage_type' => $damage_type,
            'damage_die' => $damage_die,
            'damage_die_amount' => $damage_die_amount,
            'effect' => $effect,
        ];
    }

    /**
     * @param Word[] $words
     *
     * @return Word
     */
    private function pickRandomWord(array $words): Word
    {
        $word_count = count($words);
        $chosen_word = rand(0, $word_count - 1);
        return $words[$chosen_word];
    }

    /**
     * @param Stats $stats
     * @param array $effects
     *
     * @return string
     */
    private function determineEffect(Stats $stats, array $effects): string
    {
        [$name, $points] = $stats->getGreatestStat();
        $filtererd_effects = array_filter($effects, function (Effect $effect) use ($name, $points) {
            return $effect->hasSufficientPointsInStat($name, $points);
        });

        if (empty($filtererd_effects)) {
            return '';
        }

        return array_pop($filtererd_effects)->getDescription();
    }

    private function determineRarity(Stats $stats): string
    {
        $points = $stats->getTotalPoints();
        
        if ($points < self::RARE_THRESHOLD) { // Uncommon
            return self::UNCOMMON;
        }
        if ($points < self::VERY_RARE_THRESHOLD) { // Rare
            return self::RARE;
        }
        if ($points < self::LEGENDARY_THRESHOLD) { // Very Rare
            return self::VERY_RARE;
        }
        if ($points < self::ARTIFACT_THRESHOLD) { // Legendary
            return self::LEGENDARY;
        }
        if ($points >= self::ARTIFACT_THRESHOLD) { // Artifact
            return self::ARTIFACT;
        }
        return '';
    }

    /**
     * @param int $points
     *
     * @return array ['die' => 4, 'number_of_die' => 2]
     */
    private function determineDamage(int $points): array
    {
        $die_type = 6;
        $number_of_dice = 1;
        switch ($points) {
            case 1:
                $die_type = 4;
                $number_of_dice = 1;
                break;
            case 2:
                $die_type = 6;
                $number_of_dice = 1;
                break;
            case 3:
                $die_type = 8;
                $number_of_dice = 1;
                break;
            case 4:
                $die_type = 10;
                $number_of_dice = 1;
                break;
            case 5:
                $die_type = 12;
                $number_of_dice = 1;
                break;
            case 6:
                $die_type = 6;
                $number_of_dice = 2;
                break;
            case 7:
                $die_type = 6;
                $number_of_dice = 3;
                break;
            case 8:
                $die_type = 8;
                $number_of_dice = 3;
                break;
            case 8:
                $die_type = 8;
                $number_of_dice = 4;
                break;
        }

        return [$die_type, $number_of_dice];
    }
}
