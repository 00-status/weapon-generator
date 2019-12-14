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

        if ($weapon_total < 7) { // Uncommon
            return self::UNCOMMON;
        }
        if ($weapon_total >= 8 && $weapon_total <= 14) { // Rare
            return self::RARE;
        }
        if ($weapon_total >= 15 && $weapon_total <= 21) { // Very Rare
            return self::VERY_RARE;
        }
        if ($weapon_total >= 22 && $weapon_total <= 28) { // Legendary
            return self::LEGENDARY;
        }
        if ($weapon_total >= 29) { // Artifact
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
