<?php

namespace Lib\Entity;

use Lib\Entity\Stats;

class Effect
{
    /** @var string $name */
    private $name;
    /** @var string description */
    private $description;
    /** @var Stats $stats */
    private $stats;

    public function __construct(string $name, string $description, Stats $stats)
    {
        $this->name = $name;
        $this->description = $description;
        $this->stats = $stats;
    }

    /**
     * @param $array description
     *
     * @return self
     */
    public static function fromArray(array $effect): self
    {
        return new self(
            $effect['name'],
            $effect['effect'],
            Stats::fromArray($effect)
        );
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
