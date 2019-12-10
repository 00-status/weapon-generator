<?php

namespace Lib\Service;

use Lib\Service\Words\ReadWordsService;
use Lib\Service\Words\SortWordsService;
use Lib\Entity\Word;

class WeaponGeneratorService
{
    public function generateWeapon()
    {
        $words = ReadWordsService::readWords();
        $sorted_words = SortWordsService::sortWords($words);

        $prefix = $this->pickRandomWord($sorted_words[Word::PREFIX]);
        $noun = $this->pickRandomWord($sorted_words[Word::NOUN]);
        $suffix = $this->pickRandomWord($sorted_words[Word::SUFFIX]);

        return $prefix->getName() . ' ' . $noun->getName() . ' ' . $suffix->getName();
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
