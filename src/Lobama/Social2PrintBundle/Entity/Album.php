<?php

namespace Lobama\Social2PrintBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lobama\Social2PrintBundle\Entity\Album
 */
class Album
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var bigint $object_id
     */
    private $object_id;

    /**
     * @var string $aid
     */
    private $aid;

    /**
     * @var bigint $cover_object_id
     */
    private $cover_object_id;

    /**
     * @var bigint $owner
     */
    private $owner;

    /**
     * @var datetime $modified_major
     */
    private $modified_major;

    /**
     * @var string $kind
     */
    private $kind;

    /**
     * @var Lobama\Social2PrintBundle\Entity\Photo
     */
    private $Photos;

    public function __construct()
    {
        $this->Photos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set object_id
     *
     * @param bigint $objectId
     */
    public function setObjectId($objectId)
    {
        $this->object_id = $objectId;
    }

    /**
     * Get object_id
     *
     * @return bigint 
     */
    public function getObjectId()
    {
        return $this->object_id;
    }

    /**
     * Set aid
     *
     * @param string $aid
     */
    public function setAid($aid)
    {
        $this->aid = $aid;
    }

    /**
     * Get aid
     *
     * @return string 
     */
    public function getAid()
    {
        return $this->aid;
    }

    /**
     * Set cover_object_id
     *
     * @param bigint $coverObjectId
     */
    public function setCoverObjectId($coverObjectId)
    {
        $this->cover_object_id = $coverObjectId;
    }

    /**
     * Get cover_object_id
     *
     * @return bigint 
     */
    public function getCoverObjectId()
    {
        return $this->cover_object_id;
    }

    /**
     * Set owner
     *
     * @param bigint $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * Get owner
     *
     * @return bigint 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set modified_major
     *
     * @param datetime $modifiedMajor
     */
    public function setModifiedMajor($modifiedMajor)
    {
        $this->modified_major = $modifiedMajor;
    }

    /**
     * Get modified_major
     *
     * @return datetime 
     */
    public function getModifiedMajor()
    {
        return $this->modified_major;
    }

    /**
     * Set kind
     *
     * @param string $kind
     */
    public function setKind($kind)
    {
        $this->kind = $kind;
    }

    /**
     * Get kind
     *
     * @return string 
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * Add Photos
     *
     * @param Lobama\Social2PrintBundle\Entity\Photo $photos
     */
    public function addPhoto(\Lobama\Social2PrintBundle\Entity\Photo $photos)
    {
        $this->Photos[] = $photos;
    }

    /**
     * Get Photos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPhotos()
    {
        return $this->Photos;
    }
}