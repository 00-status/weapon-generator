<?php

namespace Lib\Service;

use Lib\Infrastructure\ReadWordsService;
use Lib\Infrastructure\ReadEffectsService;
use Lib\Domain\Entity\Word;
use Lib\Domain\Entity\Effect;
use Lib\Domain\Entity\Stats;
use Lib\Domain\Service\SortWordsService;
use Lib\Domain\Service\Stats\StatsMerger;

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

    private $read_words_service;
    private $read_effects_service;

    public function __construct(
        ReadWordsService $read_words_service,
        ReadEffectsService $read_effects_service
    ) {
        $this->read_words_service = $read_words_service;
        $this->read_effects_service = $read_effects_service;    
    }
    
    public function generateWeapon(): array
    {
        $words = $this->read_words_service->readWords();
        $effects = $this->read_effects_service->readEffects();

        // Sort words into prefix, noun, and suffix
        $sorted_words = SortWordsService::sortWords($words);

        $prefix = $this->pickRandomWord($sorted_words[Word::PREFIX]);
        $noun = $this->pickRandomWord($sorted_words[Word::NOUN]);
        $suffix = $this->pickRandomWord($sorted_words[Word::SUFFIX]);

        $name = $prefix->getName() . ' ' . $noun->getName() . ' ' . $suffix->getName();

        $stats_total = StatsMerger::mergeStats(
            [$prefix->getStats(), $suffix->getStats()]
        );

        $greatest_physical_stat = $noun->getGreatestPhysicalStat();
        [$damage_die, $damage_die_amount] = $this->determineDamage(
            $greatest_physical_stat->getPoints()
        );
        $rarity = $this->determineRarity($stats_total);
        $effects = $this->determineEffect(
            $stats_total,
            $effects
        );

        return [
            'name' => $name,
            'rarity' => $rarity,
            'damage_type' => $greatest_physical_stat->getName(),
            'damage_die' => $damage_die,
            'damage_die_amount' => $damage_die_amount,
            'effects' => $effects,
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
     * @param Effect[] $effects
     *
     * @return string[]
     */
    private function determineEffect(Stats $stats, array $effects): array
    {
        $greatest_stats = $stats->getGreatestStats();

        $chosen_effects = [];
        foreach ($greatest_stats as $greatest_stat) {
            $name = $greatest_stat->getName();
            $points = $greatest_stat->getPoints();

            $filtererd_effects = array_filter(
                $effects,
                function (Effect $effect) use ($name, $points) {
                    return $effect->hasSufficientPoints($name, $points);
                }
            );
            $filtererd_effects = array_values($filtererd_effects);

            $effects_count = count($filtererd_effects);
            if ($effects_count >= 1) {
                $chosen_effect = rand(0, $effects_count - 1);
                $chosen_effects[] = $filtererd_effects[$chosen_effect]->getDescription();
            }
        }

        return $chosen_effects;
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
