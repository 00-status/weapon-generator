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
    /** @var int */
    private $bludgeoning;
    /** @var int */
    private $slashing;
    /** @var int */
    private $piercing;
    /** @var int */
    private $fire;
    /** @var int */
    private $cold;
    /** @var int */
    private $poison;
    /** @var int */
    private $acid;
    /** @var int */
    private $psychic;
    /** @var int */
    private $necrotic;
    /** @var int */
    private $radiant;
    /** @var int */
    private $lightning;
    /** @var int */
    private $thunder;
    /** @var int */
    private $force;

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

    public static function fromArray(array $word_array): self
    {
        $stats = [];
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

    public function getBludgeoning()
    {
        return $this->bludgeoning;
    }

    public function getSlashing()
    {
        return $this->slashing;
    }

    public function getPiercing()
    {
        return $this->piercing;
    }

    public function getFire()
    {
        return $this->fire;
    }

    public function getCold()
    {
        return $this->cold;
    }

    public function getPoison()
    {
        $this->poison;
    }

    public function getAcid()
    {
        $this->acid;
    }

    public function getPsychic()
    {
        $this->psychic;
    }

    public function getNecrotic()
    {
        $this->necrotic;
    }

    public function getRadiant()
    {
        $this->radiant;
    }

    public function getLightning()
    {
        $this->lightning;
    }

    public function getThunder()
    {
        return $this->thunder;
    }

    public function getForce()
    {
        return $this->force;
    }

}
