<?php

namespace Lobama\Social2PrintBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lobama\Social2PrintBundle\Entity\ScoreType
 */
class ScoreType
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $origin
     */
    private $origin;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var integer $factor
     */
    private $factor;

    /**
     * @var Lobama\Social2PrintBundle\Entity\Score
     */
    private $Scores;

    public function __construct()
    {
        $this->Scores = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set origin
     *
     * @param string $origin
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;
    }

    /**
     * Get origin
     *
     * @return string 
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set factor
     *
     * @param integer $factor
     */
    public function setFactor($factor)
    {
        $this->factor = $factor;
    }

    /**
     * Get factor
     *
     * @return integer 
     */
    public function getFactor()
    {
        return $this->factor;
    }

    /**
     * Add Scores
     *
     * @param Lobama\Social2PrintBundle\Entity\Score $scores
     */
    public function addScore(\Lobama\Social2PrintBundle\Entity\Score $scores)
    {
        $this->Scores[] = $scores;
    }

    /**
     * Get Scores
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getScores()
    {
        return $this->Scores;
    }
}