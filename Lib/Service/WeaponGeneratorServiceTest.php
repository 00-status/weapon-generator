<?php

use PHPUnit\Framework\TestCase;

use Lib\Infrastructure\ReadWordsService;
use Lib\Infrastructure\ReadEffectsService;
use Lib\Domain\Entity\Effect;
use Lib\Domain\Entity\Stats;
use Lib\Domain\Entity\Word;
use Lib\Service\WeaponGeneratorService;


class WeaponGeneratorServiceTest extends TestCase
{
    private $read_words_service;
    private $read_effects_service;

    public function setUp(): void
    {
        $this->read_words_service = $this->createMock(ReadWordsService::class);
        $this->read_effects_service = $this->createMock(ReadEffectsService::class);

        parent::setUp();
    }

    public function testGenerateWeapon()
    {
        $this->read_words_service
            ->method('readWords')
            ->willReturn($this->createWords());
        $this->read_effects_service
            ->method('readEffects')
            ->willReturn($this->createEffects());
        
        $service = new WeaponGeneratorService(
            $this->read_words_service,
            $this->read_effects_service
        );
        $actual = $service->generateWeapon();

        $expected = [
            'name' => 'prefix noun suffix',
            'rarity' => 'Rare',
            'damage_type' => 'bludgeoning',
            'damage_die' => 4,
            'damage_die_amount' => 1,
            'effects' => ['primary effect', 'secondary effect'],
        ];

        // Test result
        $this->assertEquals($expected, $actual);
    }

    private function createWords(): array
    {
        $stats = new Stats(1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2);
        return [
            new Word('prefix', 'prefix', $stats),
            new Word('noun', 'noun', $stats),
            new Word('suffix', 'suffix', $stats),
        ];
    }

    private function createEffects(): array
    {
        return [
            new Effect('', 'primary effect - not selected', new Stats(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 7)),
            new Effect('', 'primary effect', new Stats(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 6)),
            new Effect('', 'secondary effect - not selected', new Stats(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, 0)),
            new Effect('', 'secondary effect', new Stats(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 0)),
        ];
    }
}
