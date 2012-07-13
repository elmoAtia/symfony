<?php

namespace Lobama\Social2PrintBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lobama\Social2PrintBundle\Entity\Photo
 */
class Photo
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
     * @var string $pid
     */
    private $pid;

    /**
     * @var string $aid
     */
    private $aid;

    /**
     * @var bigint $album_object_id
     */
    private $album_object_id;

    /**
     * @var string $owner
     */
    private $owner;

    /**
     * @var datetime $created
     */
    private $created;

    /**
     * @var datetime $modified_last
     */
    private $modified_last;

    /**
     * @var array $images
     */
    private $images;

    /**
     * @var string $local_preview_image
     */
    private $local_preview_image;

    /**
     * @var Lobama\Social2PrintBundle\Entity\Score
     */
    private $Scores;

    /**
     * @var Lobama\Social2PrintBundle\Entity\Album
     */
    private $Album;

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
     * Set pid
     *
     * @param string $pid
     */
    public function setPid($pid)
    {
        $this->pid = $pid;
    }

    /**
     * Get pid
     *
     * @return string 
     */
    public function getPid()
    {
        return $this->pid;
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
     * Set album_object_id
     *
     * @param bigint $albumObjectId
     */
    public function setAlbumObjectId($albumObjectId)
    {
        $this->album_object_id = $albumObjectId;
    }

    /**
     * Get album_object_id
     *
     * @return bigint 
     */
    public function getAlbumObjectId()
    {
        return $this->album_object_id;
    }

    /**
     * Set owner
     *
     * @param string $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * Get owner
     *
     * @return string 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return datetime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set modified_last
     *
     * @param datetime $modifiedLast
     */
    public function setModifiedLast($modifiedLast)
    {
        $this->modified_last = $modifiedLast;
    }

    /**
     * Get modified_last
     *
     * @return datetime 
     */
    public function getModifiedLast()
    {
        return $this->modified_last;
    }

    /**
     * Set images
     *
     * @param array $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * Get images
     *
     * @return array 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set local_preview_image
     *
     * @param string $localPreviewImage
     */
    public function setLocalPreviewImage($localPreviewImage)
    {
        $this->local_preview_image = $localPreviewImage;
    }

    /**
     * Get local_preview_image
     *
     * @return string 
     */
    public function getLocalPreviewImage()
    {
        return $this->local_preview_image;
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

    /**
     * Set Album
     *
     * @param Lobama\Social2PrintBundle\Entity\Album $album
     */
    public function setAlbum(\Lobama\Social2PrintBundle\Entity\Album $album)
    {
        $this->Album = $album;
    }

    /**
     * Get Album
     *
     * @return Lobama\Social2PrintBundle\Entity\Album 
     */
    public function getAlbum()
    {
        return $this->Album;
    }
}