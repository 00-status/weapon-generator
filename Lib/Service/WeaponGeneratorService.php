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

    private const DIE = 'die';
    private const NUMBER_OF_DIE = 'number_of_die';
    
    public function generateWeapon(): array
    {
        // Get a list of words
        $words = ReadWordsService::readWords();
        // Sort words into prefix, noun, and suffic
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

        return [
            'name' => $name,
            'rarity' => $rarity,
            'damage_type' => $damage_type,
            'damage_die' => $damage[self::DIE],
            'damage_die_amount' => $damage[self::NUMBER_OF_DIE],
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

    private function getDamageType(Word $prefix, Word $noun, Word $suffix): string
    {
        $initial = [
            Word::BLUDGEONING => 0,
            Word::SLASHING => 0,
            Word::PIERCING => 0,
            Word::FIRE => 0,
            Word::COLD => 0,
            Word::POISON => 0,
            Word::ACID => 0,
            Word::PSYCHIC => 0,
            Word::NECROTIC => 0,
            Word::RADIANT => 0,
            Word::LIGHTNING => 0,
            Word::THUNDER => 0,
            Word::FORCE => 0,
        ];

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
        }, $initial);

        // Get the greatest damage type
        $greatest_key = array_search(max($stats_array), $stats_array);
        return $greatest_key;
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
