<?php

use Lib\Entity\Effect;
use Lib\Entity\Stats;
use Lib\Entity\Word;
use Lib\Service\Effects\ReadEffectsService;
use Lib\Service\WeaponGeneratorService;
use Lib\Service\Words\ReadWordsService;
use PHPUnit\Framework\TestCase;

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
            'effect' => 'selected',
        ];

        // Test result
        $this->assertEquals($expected, $actual);
    }

    private function createWords(): array
    {
        $stats = new Stats(1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2);
        return [
            new Word('prefix', 'prefix', $stats),
            new Word('noun', 'noun', $stats),
            new Word('suffix', 'suffix', $stats),
        ];
    }

    private function createEffects(): array
    {
        return [
            new Effect('', 'filtered out', new Stats(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 7)),
            new Effect('', 'selected', new Stats(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 6)),
        ];
    }
}
