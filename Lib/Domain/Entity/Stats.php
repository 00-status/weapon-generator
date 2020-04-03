<?php

namespace Lib\Domain\Entity;

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
     *
     * @return StatPoints
     */
    public function getGreatestPhysicalStat(): StatPoints
    {
        $greatest_value = $this->piercing;
        $name = self::PIERCING;

        if ($this->piercing < $this->slashing) {
            $greatest_value = $this->slashing;
            $name = self::SLASHING;
        } elseif ($greatest_value < $this->bludgeoning) {
            $greatest_value = $this->bludgeoning;
            $name = self::BLUDGEONING;
        }

        return new StatPoints($name, $greatest_value);
    }

    /**
     * Returns the two greatest stats
     *
     * @return StatPoints[]
     */
    public function getGreatestStats(): array
    {
        $greatest_stats = [];

        $current_greatest_value = 0;
        foreach ($this as $name => $property_value) {
            if ( $property_value > 0 && $property_value >= $current_greatest_value) {
                $current_greatest_value = $property_value;

                $stat_points = new StatPoints($name, $current_greatest_value);

                if (count($greatest_stats) > 1) {
                    // pop the lowest stat
                    array_pop($greatest_stats);
                    // Prepend the new greatest stat
                    array_unshift($greatest_stats, $stat_points);
                } else {
                    array_unshift($greatest_stats, $stat_points);
                }
            }
        }

        return $greatest_stats;
    }

    /**
     * Returns true if the passed in stat is equal to or greater than
     * the associated stat in this class.
     *
     * @param string $name
     * @param int $points
     *
     * @return bool
     */
    public function hasSufficientPoints(string $name, int $points): bool
    {
        return $this->$name !== 0 && $this->$name <= $points;
    }

    public function getBludgeoning(): int
    {
        return $this->bludgeoning;
    }

    public function getSlashing(): int
    {
        return $this->slashing;
    }

    public function getPiercing(): int
    {
        return $this->piercing;
    }

    public function getFire(): int
    {
        return $this->fire;
    }

    public function getCold(): int
    {
        return $this->cold;
    }

    public function getPoison(): int
    {
        return $this->poison;
    }

    public function getAcid(): int
    {
        return $this->acid;
    }

    public function getPsychic(): int
    {
        return $this->psychic;
    }

    public function getNecrotic(): int
    {
        return $this->necrotic;
    }

    public function getRadiant(): int
    {
        return $this->radiant;
    }

    public function getLightning(): int
    {
        return $this->lightning;
    }

    public function getThunder(): int
    {
        return $this->thunder;
    }

    public function getForce(): int
    {
        return $this->force;
    }
}
