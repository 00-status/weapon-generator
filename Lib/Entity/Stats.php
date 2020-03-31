<?php

namespace Lib\Entity;

class Stats
{
    public const BLUDGEONING = 'bludgeoning';
    public const SLASHING = 'slashing';
    public const PIERCING = 'piercing';
    public const FIRE = 'fire';
    public const COLD = 'cold';
    public const POISON = 'poison';
    public const ACID = 'acid';
    public const PSYCHIC = 'psyhic';
    public const NECROTIC = 'necrotic';
    public const RADIANT = 'radiant' ;
    public const LIGHTNING = 'lightning';
    public const THUNDER = 'thunder';
    public const FORCE = 'force';

    private $bludgeoning;
    private $slashing;
    private $piercing;
    private $fire;
    private $cold;
    private $poison;
    private $acid;
    private $psychic;
    private $necrotic;
    private $radiant;
    private $lightning;
    private $thunder;
    private $force;

    public function __construct(
        int $bludgeoning,
        int $slashing,
        int $piercing,
        int $fire,
        int $cold,
        int $poison,
        int $acid,
        int $psychic,
        int $necrotic,
        int $radiant,
        int $lightning,
        int $thunder,
        int $force
    ) {
        $this->bludgeoning = $bludgeoning;
        $this->slashing = $slashing;
        $this->piercing = $piercing;
        $this->fire = $fire;
        $this->cold = $cold;
        $this->poison = $poison;
        $this->acid = $acid;
        $this->psychic = $psychic;
        $this->necrotic = $necrotic;
        $this->radiant = $radiant;
        $this->lightning = $lightning;
        $this->thunder = $thunder;
        $this->force = $force;
    }

    public static function fromArray(array $stats)
    {
        return new self(
            $stats['bludgeoning'],
            $stats['slashing'],
            $stats['piercing'],
            $stats['fire'],
            $stats['cold'],
            $stats['poison'],
            $stats['acid'],
            $stats['psychic'],
            $stats['necrotic'],
            $stats['radiant'],
            $stats['lightning'],
            $stats['thunder'],
            $stats['force']
        );
    }

    public function getTotalPoints(): int
    {
        $total_points = 0;
        foreach ($this as $property => $points) {
            $total_points += $points;
        }

        return $total_points;
    }

    /**
     * @return array
     */
    public function getGreatestPhysicalStat(): array
    {
        $greatest_value = $this->piercing;
        $name = 'piercing';

        if ($this->piercing < $this->slashing) {
            $greatest_value = $this->slashing;
            $name = 'slashing';
        } elseif ($greatest_value < $this->bludgeoning) {
            $greatest_value = $this->bludgeoning;
            $name = 'bludgeoning';
        }

        return [$name, $greatest_value];
    }
}
