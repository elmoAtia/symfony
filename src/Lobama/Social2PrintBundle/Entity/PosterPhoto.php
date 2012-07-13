<?php

namespace Lobama\Social2PrintBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lobama\Social2PrintBundle\Entity\PosterPhoto
 */
class PosterPhoto
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var array $TileCoords
     */
    private $TileCoords;

    /**
     * @var array $TileDim
     */
    private $TileDim;

    /**
     * @var float $PhotoScale
     */
    private $PhotoScale;

    /**
     * @var string $PhotoOrientation
     */
    private $PhotoOrientation;

    /**
     * @var array $PhotoOffset
     */
    private $PhotoOffset;

    /**
     * @var Lobama\Social2PrintBundle\Entity\Poster
     */
    private $Poster;

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
     * Set TileCoords
     *
     * @param array $tileCoords
     */
    public function setTileCoords($tileCoords)
    {
        $this->TileCoords = $tileCoords;
    }

    /**
     * Get TileCoords
     *
     * @return array 
     */
    public function getTileCoords()
    {
        return $this->TileCoords;
    }

    /**
     * Set TileDim
     *
     * @param array $tileDim
     */
    public function setTileDim($tileDim)
    {
        $this->TileDim = $tileDim;
    }

    /**
     * Get TileDim
     *
     * @return array 
     */
    public function getTileDim()
    {
        return $this->TileDim;
    }

    /**
     * Set PhotoScale
     *
     * @param float $photoScale
     */
    public function setPhotoScale($photoScale)
    {
        $this->PhotoScale = $photoScale;
    }

    /**
     * Get PhotoScale
     *
     * @return float 
     */
    public function getPhotoScale()
    {
        return $this->PhotoScale;
    }

    /**
     * Set PhotoOrientation
     *
     * @param string $photoOrientation
     */
    public function setPhotoOrientation($photoOrientation)
    {
        $this->PhotoOrientation = $photoOrientation;
    }

    /**
     * Get PhotoOrientation
     *
     * @return string 
     */
    public function getPhotoOrientation()
    {
        return $this->PhotoOrientation;
    }

    /**
     * Set PhotoOffset
     *
     * @param array $photoOffset
     */
    public function setPhotoOffset($photoOffset)
    {
        $this->PhotoOffset = $photoOffset;
    }

    /**
     * Get PhotoOffset
     *
     * @return array 
     */
    public function getPhotoOffset()
    {
        return $this->PhotoOffset;
    }

    /**
     * Set Poster
     *
     * @param Lobama\Social2PrintBundle\Entity\Poster $poster
     */
    public function setPoster(\Lobama\Social2PrintBundle\Entity\Poster $poster)
    {
        $this->Poster = $poster;
    }

    /**
     * Get Poster
     *
     * @return Lobama\Social2PrintBundle\Entity\Poster 
     */
    public function getPoster()
    {
        return $this->Poster;
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