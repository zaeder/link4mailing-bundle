<?php

namespace Zaeder\Link4MailingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class Link4Mailing
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;
    
    /**
     * @var string $routeName
     *
     * @ORM\Column(name="route_name", type="string", nullable=false)
     */
    protected $routeName;
    
    /**
     * @var string $routeParams
     *
     * @ORM\Column(name="route_params", type="string", nullable=false)
     */
    protected $routeParams;
    
    /**
     * @var string $token
     *
     * @ORM\Column(name="token", type="string", nullable=false)
     */
    protected $token;
    
    /**
     * @var integer $userId
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true, options={"default":0})
     */
    protected $userId;
    
    /**
     * @var \DateTime $expirationDate
     *
     * @ORM\Column(name="expiration_date", type="datetime", nullable=true)
     */
    private $expirationDate;
    
    /**
     * @var boolean $isActive
     *
     * @ORM\Column(name="isActive", type="boolean", nullable=true, options={"default":0})
     */
    private $isActive;

    /**
     * Get id
     *
     * @return guid
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set routeName
     *
     * @param string $routeName
     *
     * @return Link4Mailing
     */
    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;

        return $this;
    }

    /**
     * Get routeName
     *
     * @return string
     */
    public function getRouteName()
    {
        return $this->routeName;
    }

    /**
     * Set routeParams
     *
     * @param string $routeParams
     *
     * @return Link4Mailing
     */
    public function setRouteParams($routeParams)
    {
        $this->routeParams = $routeParams;

        return $this;
    }

    /**
     * Get routeParams
     *
     * @return string
     */
    public function getRouteParams()
    {
        return $this->routeParams;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return Link4Mailing
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Link4Mailing
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set expirationDate
     *
     * @param \DateTime $expirationDate
     *
     * @return Link4Mailing
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * Get expirationDate
     *
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Link4Mailing
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}
