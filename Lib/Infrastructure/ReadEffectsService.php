<?php

namespace Lib\Infrastructure;

use Lib\Domain\Entity\Effect;

class ReadEffectsService
{
    const FILE_PATH = __DIR__ . '/../../resources/effects.json';

    /**
     * @return Effect[]
     */
    public function readEffects(): array
    {
        if (!file_exists(self::FILE_PATH)) {
            return [];
        }

        $file_contents = file_get_contents(self::FILE_PATH);
        $file_array = json_decode($file_contents, true);

        return array_map(function($effect) {
            return Effect::fromArray($effect);
        }, $file_array);
    }
}
