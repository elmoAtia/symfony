<?php

namespace Lobama\Social2PrintBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lobama\Social2PrintBundle\Entity\Poster
 */
class Poster
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var array $config
     */
    private $config;

    /**
     * @var array $labels
     */
    private $labels;

    /**
     * @var string $image
     */
    private $image;

    /**
     * @var string $pdf
     */
    private $pdf;

    /**
     * @var string $status
     */
    private $status;

    /**
     * @var Lobama\Social2PrintBundle\Entity\PosterPhoto
     */
    private $PosterPhotos;

    /**
     * @var Lobama\Social2PrintBundle\Entity\User
     */
    private $User;

    public function __construct()
    {
        $this->PosterPhotos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set config
     *
     * @param array $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * Get config
     *
     * @return array 
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set labels
     *
     * @param array $labels
     */
    public function setLabels($labels)
    {
        $this->labels = $labels;
    }

    /**
     * Get labels
     *
     * @return array 
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set pdf
     *
     * @param string $pdf
     */
    public function setPdf($pdf)
    {
        $this->pdf = $pdf;
    }

    /**
     * Get pdf
     *
     * @return string 
     */
    public function getPdf()
    {
        return $this->pdf;
    }

    /**
     * Set status
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add PosterPhotos
     *
     * @param Lobama\Social2PrintBundle\Entity\PosterPhoto $posterPhotos
     */
    public function addPosterPhoto(\Lobama\Social2PrintBundle\Entity\PosterPhoto $posterPhotos)
    {
        $this->PosterPhotos[] = $posterPhotos;
    }

    /**
     * Get PosterPhotos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPosterPhotos()
    {
        return $this->PosterPhotos;
    }

    /**
     * Set User
     *
     * @param Lobama\Social2PrintBundle\Entity\User $user
     */
    public function setUser(\Lobama\Social2PrintBundle\Entity\User $user)
    {
        $this->User = $user;
    }

    /**
     * Get User
     *
     * @return Lobama\Social2PrintBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->User;
    }
}