<?php

namespace Lobama\Social2PrintBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lobama\Social2PrintBundle\Entity\PosterOrderID
 */
class PosterOrderID
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $provider
     */
    private $provider;

    /**
     * @var string $orderid
     */
    private $orderid;

    /**
     * @var Lobama\Social2PrintBundle\Entity\PosterFormat
     */
    private $PosterFormat;


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
     * Set provider
     *
     * @param string $provider
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
    }

    /**
     * Get provider
     *
     * @return string 
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set orderid
     *
     * @param string $orderid
     */
    public function setOrderid($orderid)
    {
        $this->orderid = $orderid;
    }

    /**
     * Get orderid
     *
     * @return string 
     */
    public function getOrderid()
    {
        return $this->orderid;
    }

    /**
     * Set PosterFormat
     *
     * @param Lobama\Social2PrintBundle\Entity\PosterFormat $posterFormat
     */
    public function setPosterFormat(\Lobama\Social2PrintBundle\Entity\PosterFormat $posterFormat)
    {
        $this->PosterFormat = $posterFormat;
    }

    /**
     * Get PosterFormat
     *
     * @return Lobama\Social2PrintBundle\Entity\PosterFormat 
     */
    public function getPosterFormat()
    {
        return $this->PosterFormat;
    }
}