<?php

namespace Lib\Entity;

use Lib\Entity\Stats;

class Word
{
    public const PREFIX = 'prefix';
    public const NOUN = 'noun';
    public const SUFFIX = 'suffix';

    /** @var string */
    private $name;
    /** @var string */
    private $type;
    /** @var Stats */
    private $stats;

    /**
     * @param string $name
     * @param string $type
     * @param Stats $stats
     */
    public function __construct(string $name, string $type, Stats $stats)
    {
        $this->name = $name;
        $this->type = $type;
        $this->stats = $stats;
    }

    public static function fromArray(array $words): self
    {
        return new self(
            $words['word'],
            $words['type'],
            Stats::fromArray($words)
        );
    }

    /**
     * @return array [name, points]
     */
    public function getGreatestPhysicalStat(): array
    {
        return $this->stats->getGreatestPhysicalStat();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    public function getStats(): Stats
    {
        return $this->stats;
    }
}
