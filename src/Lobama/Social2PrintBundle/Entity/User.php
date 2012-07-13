<?php

namespace Lobama\Social2PrintBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lobama\Social2PrintBundle\Entity\User
 */
class User
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $username
     */
    private $username;

    /**
     * @var bigint $facebookuid
     */
    private $facebookuid;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $locale
     */
    private $locale;

    /**
     * @var string $email
     */
    private $email;

    /**
     * @var string $third_party_id
     */
    private $third_party_id;


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
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set facebookuid
     *
     * @param bigint $facebookuid
     */
    public function setFacebookuid($facebookuid)
    {
        $this->facebookuid = $facebookuid;
    }

    /**
     * Get facebookuid
     *
     * @return bigint 
     */
    public function getFacebookuid()
    {
        return $this->facebookuid;
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
     * Set locale
     *
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Get locale
     *
     * @return string 
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set third_party_id
     *
     * @param string $thirdPartyId
     */
    public function setThirdPartyId($thirdPartyId)
    {
        $this->third_party_id = $thirdPartyId;
    }

    /**
     * Get third_party_id
     *
     * @return string 
     */
    public function getThirdPartyId()
    {
        return $this->third_party_id;
    }
}
