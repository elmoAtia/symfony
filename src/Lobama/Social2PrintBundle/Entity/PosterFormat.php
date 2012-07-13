<?php

namespace Lobama\Social2PrintBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lobama\Social2PrintBundle\Entity\PosterFormat
 */
class PosterFormat
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $pid
     */
    private $pid;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $herotag
     */
    private $herotag;

    /**
     * @var string $ksp1
     */
    private $ksp1;

    /**
     * @var string $ksp2
     */
    private $ksp2;

    /**
     * @var string $ksp3
     */
    private $ksp3;

    /**
     * @var string $ksp4
     */
    private $ksp4;

    /**
     * @var string $ksp5
     */
    private $ksp5;

    /**
     * @var decimal $price
     */
    private $price;

    /**
     * @var Lobama\Social2PrintBundle\Entity\PosterOrderID
     */
    private $PosterOrderIDs;

    public function __construct()
    {
        $this->PosterOrderIDs = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set herotag
     *
     * @param string $herotag
     */
    public function setHerotag($herotag)
    {
        $this->herotag = $herotag;
    }

    /**
     * Get herotag
     *
     * @return string 
     */
    public function getHerotag()
    {
        return $this->herotag;
    }

    /**
     * Set ksp1
     *
     * @param string $ksp1
     */
    public function setKsp1($ksp1)
    {
        $this->ksp1 = $ksp1;
    }

    /**
     * Get ksp1
     *
     * @return string 
     */
    public function getKsp1()
    {
        return $this->ksp1;
    }

    /**
     * Set ksp2
     *
     * @param string $ksp2
     */
    public function setKsp2($ksp2)
    {
        $this->ksp2 = $ksp2;
    }

    /**
     * Get ksp2
     *
     * @return string 
     */
    public function getKsp2()
    {
        return $this->ksp2;
    }

    /**
     * Set ksp3
     *
     * @param string $ksp3
     */
    public function setKsp3($ksp3)
    {
        $this->ksp3 = $ksp3;
    }

    /**
     * Get ksp3
     *
     * @return string 
     */
    public function getKsp3()
    {
        return $this->ksp3;
    }

    /**
     * Set ksp4
     *
     * @param string $ksp4
     */
    public function setKsp4($ksp4)
    {
        $this->ksp4 = $ksp4;
    }

    /**
     * Get ksp4
     *
     * @return string 
     */
    public function getKsp4()
    {
        return $this->ksp4;
    }

    /**
     * Set ksp5
     *
     * @param string $ksp5
     */
    public function setKsp5($ksp5)
    {
        $this->ksp5 = $ksp5;
    }

    /**
     * Get ksp5
     *
     * @return string 
     */
    public function getKsp5()
    {
        return $this->ksp5;
    }

    /**
     * Set price
     *
     * @param decimal $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get price
     *
     * @return decimal 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Add PosterOrderIDs
     *
     * @param Lobama\Social2PrintBundle\Entity\PosterOrderID $posterOrderIDs
     */
    public function addPosterOrderID(\Lobama\Social2PrintBundle\Entity\PosterOrderID $posterOrderIDs)
    {
        $this->PosterOrderIDs[] = $posterOrderIDs;
    }

    /**
     * Get PosterOrderIDs
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPosterOrderIDs()
    {
        return $this->PosterOrderIDs;
    }
}