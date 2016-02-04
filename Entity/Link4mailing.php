<?php

namespace Zaeder\Link4mailingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="links4mailing")
 */
class Link4mailing
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;
    
    /**
     * @var string $routeNameOrUri
     *
     * @ORM\Column(name="route_name_or_uri", type="string", nullable=false)
     */
    protected $routeNameOrUri;
    
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
     * @var boolean $isExternalLink
     *
     * @ORM\Column(name="is_external_link", type="boolean", nullable=true, options={"default":0})
     */
    private $isExternalLink;
    
    /**
     * @var boolean $isActive
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true, options={"default":0})
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
     * Set routeNameOrUri
     *
     * @param string $routeNameOrUri
     *
     * @return Link4mailing
     */
    public function setRouteNameOrUri($routeNameOrUri)
    {
        $this->routeNameOrUri = $routeNameOrUri;

        return $this;
    }

    /**
     * Get routeNameOrUri
     *
     * @return string
     */
    public function getRouteNameOrUri()
    {
        return $this->routeNameOrUri;
    }

    /**
     * Set routeParams
     *
     * @param string $routeParams
     *
     * @return Link4mailing
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
     * @return Link4mailing
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
     * @return Link4mailing
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
     * @return Link4mailing
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
     * @return Link4mailing
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
