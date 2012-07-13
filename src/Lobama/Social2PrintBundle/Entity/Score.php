<?php

namespace Lobama\Social2PrintBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lobama\Social2PrintBundle\Entity\Score
 */
class Score
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $origin_object_id
     */
    private $origin_object_id;

    /**
     * @var Lobama\Social2PrintBundle\Entity\ScoreType
     */
    private $ScoreType;

    /**
     * @var Lobama\Social2PrintBundle\Entity\Photo
     */
    private $Photo;


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
     * Set origin_object_id
     *
     * @param string $originObjectId
     */
    public function setOriginObjectId($originObjectId)
    {
        $this->origin_object_id = $originObjectId;
    }

    /**
     * Get origin_object_id
     *
     * @return string 
     */
    public function getOriginObjectId()
    {
        return $this->origin_object_id;
    }

    /**
     * Set ScoreType
     *
     * @param Lobama\Social2PrintBundle\Entity\ScoreType $scoreType
     */
    public function setScoreType(\Lobama\Social2PrintBundle\Entity\ScoreType $scoreType)
    {
        $this->ScoreType = $scoreType;
    }

    /**
     * Get ScoreType
     *
     * @return Lobama\Social2PrintBundle\Entity\ScoreType 
     */
    public function getScoreType()
    {
        return $this->ScoreType;
    }

    /**
     * Set Photo
     *
     * @param Lobama\Social2PrintBundle\Entity\Photo $photo
     */
    public function setPhoto(\Lobama\Social2PrintBundle\Entity\Photo $photo)
    {
        $this->Photo = $photo;
    }

    /**
     * Get Photo
     *
     * @return Lobama\Social2PrintBundle\Entity\Photo 
     */
    public function getPhoto()
    {
        return $this->Photo;
    }
}