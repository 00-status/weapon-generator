<?php

namespace Lib\Service;

use Lib\Service\Words\ReadWordsService;
use Lib\Service\Words\SortWordsService;
use Lib\Service\Effects\ReadEffectsService;
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

    private const DIE = 'die';
    private const NUMBER_OF_DIE = 'number_of_die';
    
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

        // Determine name
        $name = $prefix->getName() . ' ' . $noun->getName() . ' ' . $suffix->getName();
        // Determine rarity
        $rarity = $this->selectRarity($prefix, $noun, $suffix);

        [$damage_type, $points] = $noun->getGreatestPhysicalStat();
        // Determine damage die and number of dice
        $damage = $this->determineDamage($points);

        $effect = $effects[0] ?? null;

        return [
            'name' => $name,
            'rarity' => $rarity,
            'damage_type' => $damage_type,
            'damage_die' => $damage[self::DIE],
            'damage_die_amount' => $damage[self::NUMBER_OF_DIE],
            'effect' => $effect->getDescription(),
        ];
    }

    /**
     * @param Word[] $words
     *
     * @return string
     */
    private function pickRandomWord(array $words): Word
    {
        $word_count = count($words);
        $chosen_word = rand(0, $word_count - 1);
        return $words[$chosen_word];
    }

    private function getEffect(Word $prefix, Word $noun, Word $suffix, array $effects): string
    {
        return '';
    }

    private function selectRarity(Word $prefix, Word $noun, Word $suffix): string
    {
        $weapon_total = $prefix->calculateTotalPoints() +
            $noun->calculateTotalPoints() +
            $suffix->calculateTotalPoints();
        
        if ($weapon_total < self::RARE_THRESHOLD) { // Uncommon
            return self::UNCOMMON;
        }
        if ($weapon_total < self::VERY_RARE_THRESHOLD) { // Rare
            return self::RARE;
        }
        if ($weapon_total < self::LEGENDARY_THRESHOLD) { // Very Rare
            return self::VERY_RARE;
        }
        if ($weapon_total < self::ARTIFACT_THRESHOLD) { // Legendary
            return self::LEGENDARY;
        }
        if ($weapon_total >= self::ARTIFACT_THRESHOLD) { // Artifact
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
        switch ($points) {
            case 1:
                return [self::DIE => 4, self::NUMBER_OF_DIE => 1];
                break;
            case 2:
                return [self::DIE => 6, self::NUMBER_OF_DIE => 1];
                break;
            case 3:
                return [self::DIE => 8, self::NUMBER_OF_DIE => 1];
                break;
            case 4:
                return [self::DIE => 10, self::NUMBER_OF_DIE => 1];
                break;
            case 5:
                return [self::DIE => 12, self::NUMBER_OF_DIE => 1];
                break;
            case 6:
                return [self::DIE => 6, self::NUMBER_OF_DIE => 2];
                break;
            case 7:
                return [self::DIE => 6, self::NUMBER_OF_DIE => 3];
                break;
            case 8:
                return [self::DIE => 8, self::NUMBER_OF_DIE => 3];
                break;
            case 8:
                return [self::DIE => 8, self::NUMBER_OF_DIE => 4];
                break;
            default:
                return [self::DIE => 6, self::NUMBER_OF_DIE => 1];
                break;
        }
    }
}
