<?php

namespace Lib\Domain\Entity;

class StatPoints
{
    /** @var string */
    private $name;
    /** @var int */
    private $points;

    /**
     * @param string $name
     * @param int $points
     */
    public function __construct(string $name, int $points)
    {
        $this->name = $name;
        $this->points = $points;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPoints(): int
    {
        return $this->points;
    }
}
