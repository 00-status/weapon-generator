<?php

namespace Lib\Service;

use Lib\Service\Words\ReadWordsService;
use Lib\Service\Words\SortWordsService;
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
        $words = ReadWordsService::readWords();
        $sorted_words = SortWordsService::sortWords($words);

        $prefix = $this->pickRandomWord($sorted_words[Word::PREFIX]);
        $noun = $this->pickRandomWord($sorted_words[Word::NOUN]);
        $suffix = $this->pickRandomWord($sorted_words[Word::SUFFIX]);

        $rarity = $this->selectRarity($prefix, $noun, $suffix);
        $name = $prefix->getName() . ' ' . $noun->getName() . ' ' . $suffix->getName();

        return [
            'name' => $name,
            'rarity' => $rarity
        ];
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
}
