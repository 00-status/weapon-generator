<?php

namespace Lib\Service\Words;

use Lib\Entity\Word;

class SortWordsService
{
     /**
      * @param Word[] $words
      *
      * @return array [prefix => Word[], noun => Word[], suffix => Word[]]
      */
    public static function sortWords(array $words): array
    {
        $sorted_words = [];
        /** @var Word $word */
        foreach ($words as $word) {
            switch ($word->getType()) {
                case Word::PREFIX:
                    $sorted_words[Word::PREFIX][] = $word;
                break;
                case Word::NOUN:
                    $sorted_words[Word::NOUN][] = $word;
                break;
                case Word::SUFFIX:
                    $sorted_words[Word::SUFFIX][] = $word;
                break;
                default:
            }
        }
        return $sorted_words;
    }
}
