<?php

namespace Lib\Entity;

class Word
{
    public const PREFIX = 'prefix';
    public const NOUN = 'noun';
    public const SUFFIX = 'suffix';

    /** @var string */
    private $name;
    /** @var string */
    private $type;
    /** @var array */
    private $stats;

    /**
     * @param string $name
     * @param string $type
     * @param int $bludgeoning
     * @param int $slashing
     * @param int $piercing
     * @param int $fire
     * @param int $cold
     * @param int $poison
     * @param int $acid
     * @param int $psychic
     * @param int $necrotic
     * @param int $radiant
     * @param int $lightning
     * @param int $thunder
     * @param int $force
     */
    public function __construct(
        string $name,
        string $type,
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
        $this->name = $name;
        $this->type = $type;

        $this->stats['bludgeoning'] = $bludgeoning;
        $this->stats['slashing'] = $slashing;
        $this->stats['piercing'] = $piercing;
        $this->stats['fire'] = $fire;
        $this->stats['cold'] = $cold;
        $this->stats['poison'] = $poison;
        $this->stats['acid'] = $acid;
        $this->stats['psyhic'] = $psychic;
        $this->stats['necrotic'] = $necrotic;
        $this->stats['radiant'] = $radiant;
        $this->stats['lightning'] = $lightning;
        $this->stats['thunder'] = $thunder;
        $this->stats['force'] = $force;
    }

    public static function fromArray(array $word_array): self
    {
        return new self(
            $word_array['word'],
            $word_array['type'],
            $word_array['bludgeoning'],
            $word_array['slashing'],
            $word_array['piercing'],
            $word_array['fire'],
            $word_array['cold'],
            $word_array['poison'],
            $word_array['acid'],
            $word_array['psychic'],
            $word_array['necrotic'],
            $word_array['radiant'],
            $word_array['lightning'],
            $word_array['thunder'],
            $word_array['force']
        );
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

    public function calculateTotalPoints()
    {
        return array_reduce($this->stats, function ($sum, $stat) {
            return $sum += isset($stat) ? $stat : 0;
        }, 0);
    }

    public function getBludgeoning()
    {
        return $this->stats['bludgeoning'] ?? null;
    }

    public function getSlashing()
    {
        return $this->stats['slashing'] ?? null;
    }

    public function getPiercing()
    {
        return $this->stats['piercing'] ?? null;
    }

    public function getFire()
    {
        return $this->stats['fire'] ?? null;
    }

    public function getCold()
    {
        return $this->stats['cold'] ?? null;
    }

    public function getPoison()
    {
        $this->stats['poison'] ?? null;
    }

    public function getAcid()
    {
        $this->stats['acid'] ?? null;
    }

    public function getPsychic()
    {
        $this->stats['psychic'] ?? null;
    }

    public function getNecrotic()
    {
        $this->stats['necrotic'] ?? null;
    }

    public function getRadiant()
    {
        $this->stats['radiant'] ?? null;
    }

    public function getLightning()
    {
        $this->stats['lightning'] ?? null;
    }

    public function getThunder()
    {
        return $this->stats['thunder'] ?? null;
    }

    public function getForce()
    {
        return $this->stats['force'] ?? null;
    }
}
