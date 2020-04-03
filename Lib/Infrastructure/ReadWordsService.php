<?php

namespace Lib\Infrastructure;

use Lib\Domain\Entity\Word;

class ReadWordsService
{
    const FILE_NAME = __DIR__ . '/../../resources/words.json';

    /**
     * @return Word[]
     */
    public function readWords(): array
    {
        if (!file_exists(self::FILE_NAME)) {
            return [];
        }

        $file_contents = file_get_contents(self::FILE_NAME);
        $file_array = json_decode($file_contents, true);

        // Map JSON to an array of Word objects
        return array_map(function ($word) {
            return Word::fromArray($word);
        }, $file_array);
    }
}
